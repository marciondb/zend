<?php

class Application_Model_UsuarioGrupo extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioGrupo();
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->_id_usuario = $arrayIdentity->id_usuario;
    }

    public function getArrayIdUsuarioGrupo($idGrupo){
        
       $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('usuario_grupo', array('id_usuario'))->
                  where('usuario_grupo.id_grupo_de_acesso = ?', $idGrupo);
       
       return $select->query()->fetchAll();
    }            
    
    public function exibir($idUsuario){
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('usuario_grupo', array('id_grupo_de_acesso'))->
                  join('grupo_de_acesso','usuario_grupo.id_grupo_de_acesso = grupo_de_acesso.id_grupo_de_acesso',array('nome'))->
                  where('usuario_grupo.id_usuario = ?', $idUsuario);
       
       return $select->query()->fetchAll();
    }
    
    public function gravar($arrayIdUsuario, $grupos){
        
        try
        {
            
            foreach ($arrayIdUsuario as $usuario) {

                foreach($grupos as $idGrupo){

                    $this->save(array('id_usuario'=>$usuario['id_usuario'],'id_grupo_de_acesso'=>$idGrupo,'id_usuario_pai'=>$this->_id_usuario));
                }
            }
        
        }
        catch(Exception $e)
        {
            //ZendUtils::transmissorMsg('Erro ao cadastrar o controle de acesso, Usuario Grupo, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            return $e->getMessage();
        }
        
    }
    
    public function deletar($array_id_usuario)
    {
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                 $this->delete(array('id_usuario'=>(int)$value['id_usuario'],'id_usuario_pai'=>$this->_id_usuario)); 
            }
        }
        catch(Exception $e)
        {
            //ZendUtils::transmissorMsg('Erro ao retirar os usuarios dos grupos, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        $erros = TRUE;        
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('usuario_grupo', 'usuario_grupo.id_grupo_de_acesso')->
                    where('usuario_grupo.id_usuario = ?',$this->_id_usuario)->
                    where('usuario_grupo.id_grupo_de_acesso = ?', $data['id_grupo_de_acesso']);
           
        if(!$select->query()->rowCount())
            $erros = "ERRO 171 - Grupo";
        
        return $erros;
    }   
   
       
}

