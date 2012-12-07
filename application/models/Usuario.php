<?php

class Application_Model_Usuario extends Application_Model_Abstract
{

    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Usuario();
    }
 
    /***
     * Efetua o login do usuario. Metodo para todos os modulos
     * @param string $login Nome de usuario
     * @param string $senha Senha do usuario
     * @return Boolean
     */
    public function efetuarLogin($login,$senha){
        if($login == "" || $senha == "")
            return false;
 
            //Verifica os dados formnecidos e pesquisa no BD, pelo nome de usuario
            $authAdapter = new Zend_Auth_Adapter_DbTable($this->_dbTable->getDefaultAdapter(), 'usuario', 'login', 'senha','MD5(?)');
            $authAdapter->setIdentity($login)->setCredential($senha);
            $result = $authAdapter->authenticate();
            
            if($result->isValid())
            {
               $auth = Zend_Auth::getInstance();
               $data = $authAdapter->getResultRowObject(null,'senha');
               
               //registra o usuario
               $auth->getStorage()->write($data);
               return true;
            }
            else
            {
                //Verifica os dados formnecidos e pesquisa no BD, pelo cpf de usuario
                $authAdapter = new Zend_Auth_Adapter_DbTable($this->_dbTable->getDefaultAdapter(), 'usuario', 'cpf', 'senha','MD5(?)');
                $authAdapter->setIdentity($login)->setCredential($senha);
                $result = $authAdapter->authenticate();

                if($result->isValid())
                {
                    $auth = Zend_Auth::getInstance();
                    $data = $authAdapter->getResultRowObject(null,'senha');

                    //registra o usuario
                    $auth->getStorage()->write($data);
                    return true;
                }
                else
                {
                    return false;
                }

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
    
    /***
     * Pega todas os ids de funcionalidade, titulos, nome das actions do usuario logado
     * @param int $idUsuario Id do usuario
     * @return Array $select->query()->fetchAll();
     */
    public function getPermissao($idUsuario)
    {
        $select1 = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('ferramenta', array('nomeFerramenta'=>'nome','eh_ferramenta'))->
                  join('funcionalidade', 'ferramenta.id_ferramenta = funcionalidade.id_ferramenta',array('id_funcionalidade','id_funcionalidade_pai', 'titulo','action' =>'nome_action','idFerramenta'=>'id_ferramenta'))->
                  join('usuario_funcionalidade','funcionalidade.id_funcionalidade = usuario_funcionalidade.id_funcionalidade',array('editar','deletar','liberar'))->
                  join('usuario','usuario.id_usuario = usuario_funcionalidade.id_usuario',null)->
                  where('usuario.id_usuario = ?', $idUsuario)->
                  where('usuario.status = 1')->
                  group('funcionalidade.id_funcionalidade');
        $select2 = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('ferramenta', array('nomeFerramenta'=>'nome','eh_ferramenta'))->
                  join('funcionalidade', 'ferramenta.id_ferramenta = funcionalidade.id_ferramenta',array('id_funcionalidade','id_funcionalidade_pai', 'titulo','action' =>'nome_action','idFerramenta'=>'id_ferramenta'))->
                  join('grupo_funcionalidade', 'grupo_funcionalidade.id_funcionalidade = funcionalidade.id_funcionalidade', array('editar','deletar','liberar'))->
                  join('grupo_de_acesso', 'grupo_de_acesso.id_grupo_de_acesso = grupo_funcionalidade.id_grupo_de_acesso',null)->
                  join('usuario_grupo', 'usuario_grupo.id_grupo_de_acesso = grupo_de_acesso.id_grupo_de_acesso', null)->
                  join('usuario','usuario.id_usuario = usuario_grupo.id_usuario',null)->
                  where('usuario_grupo.id_usuario = ?', $idUsuario)->
                  where('usuario.status = 1')->
                  group('funcionalidade.id_funcionalidade');
                
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  union(array($select1,$select2))->
                  order('eh_ferramenta ASC')->
                  order('titulo ASC')->
                  order('id_funcionalidade_pai ASC');
       
        return $select->query()->fetchAll();
    }
    
    /***
     * Salva usuario
     * @param int $id_funcionario Id do funcionario
     * @param string $cpf Cpf do funcionario
     * @param string $email Email do funcionario
     * @paran md5 $segmd5 Chave de controle do usuario
     */
    public function gravar($id_funcionario,$cpf,$email,$status,$update=false,$where=false,$segmd5){
        if(!$update)
        {    
            try{
                $id_usuario = $this->save(array('id_funcionario'=>$id_funcionario,
                            'login'=>$email,
                            'cpf'=>$cpf,
                            'chave_controle'=>$segmd5,
                            'status'=>$status));
                return (int)$id_usuario;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar o Usuário, tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        else
        {
            try
            {
                //ZendUtils::transmissorMsg($email.' '.$status.' '.$update.$where,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                $id_usuario = $this->save(array('login'=>$email,'status'=>$status),$update,$where);
                return (int)$id_usuario;

            }
            catch(Exception $e)
            {
                //ZendUtils::transmissorMsg('Erro ao atualizar o Usuário. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
    }
    
    public function validaCampoUnico($nomeCampo,$valorCampo) {
        
        $select = $this->_dbTable->
                select()->
                setIntegrityCheck(false)->
                from('usuario')->
                where($nomeCampo.' = ?',$valorCampo);

        if(count($select->query()->fetchAll()))
            return 'Já existe um funcionário para este '.strtoupper($nomeCampo).'!';
    }
    
    public function validaChave($chave) {
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('usuario')->
                    where('chave_controle = ?',$chave)->
                    where('status = 1')->
                    where('ISNULL(senha)');
        //ZendUtils::transmissorMsg($select,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        if(count($select->query()->fetchAll()))
            return $select->query()->fetchAll();
        else
            return false;
    }

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";


        return true;
    }
    
    /***
     * Metodo específico da model usuário para salvar ou atualizar
     * @param array $data Array com os dados a serem salvos ou atualizados
     * @param boolean [$update] Se true, ira fazer update, caso contrario, salva
     * @param string [$where] String contendo a condicao do where para o update
     * @return array Array com as PK's
     */
    public function save(array $data, $update = FALSE, $where = FALSE,$id_usuario=false) {

        $validacao = $this->_validarDados($data);
        $retorno = array();
        
        if (is_string($validacao))
            throw new Exception($validacao);
        else {
            if ($update) {
                $retorno = $this->_update($data,$where);
            } else {
                $retorno = $this->_insert($data);
            }
        }
        
        $retornoAux = $retorno;
        //Se a tabela tiver uma PK
        if(!is_array($retorno))
            $retorno = array($retorno);
        
        //lembrar que tem q modificar o Zend
        $this->saveLog($retorno,$id_usuario);
        
        return $retornoAux;
    }
    
    
}

