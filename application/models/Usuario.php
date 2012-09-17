<?php

class Application_Model_Usuario extends Application_Model_Abstract
{

    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Usuario();
    }

    public function _insert(array $data) {
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data) {
        return $this->_dbTable->update($data, array('id=?'=>$data['id']));
    }
    
    public function efetuarLogin($login,$senha){
        if($login == "" || $senha == "")
            return false;
 
            $authAdapter = new Zend_Auth_Adapter_DbTable($this->_dbTable->getDefaultAdapter(), 'usuario', 'login', 'senha','MD5(?)');
            $authAdapter->setIdentity($login)->setCredential($senha);
            $result = $authAdapter->authenticate();
            
            if($result->isValid())
            {
               $auth = Zend_Auth::getInstance();
               $data = $authAdapter->getResultRowObject(null,'senha');
               
               $auth->getStorage()->write($data);
               return true;
            }
            else
            {
                return false;
            }
    }

    public function efetuarLogoff(){
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Session::forgetMe();
            Zend_Auth::getInstance()->clearIdentity();
        }

        if (!Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        }
    }
    
    public function getPermissao()
    {
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('ferramenta', array('nomeFerramenta'=>'nome','eh_ferramenta'))->
                  join('funcionalidade', 'ferramenta.id_ferramenta = funcionalidade.id_ferramenta',array('id_funcionalidade','id_funcionalidade_pai', 'titulo','action' =>'nome_action','idFerramenta'=>'id_ferramenta'))->
                  join('permissao','funcionalidade.id_funcionalidade = permissao.id_funcionalidade',null)->
                  join('usuario_permissao','permissao.id_permissao = usuario_permissao.id_permissao',null)->
                  join('usuario','usuario.id_usuario = usuario_permissao.id_usuario',null)->
                  where('usuario.id_usuario = ?', $arrayIdentity->id_usuario)->
                  order('ferramenta.eh_ferramenta ASC')->
                  order('ferramenta.nome ASC')->
                  order('funcionalidade.id_funcionalidade_pai ASC');
        
        return $select->query()->fetchAll();
    }

}

