<?php

class Application_Model_UsuarioGrupo extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioGrupo();
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->_id_usuario = $arrayIdentity->id_usuario;
    }

    /***
     * Retorna as ids de todos os usarios membros do grupo.
     * @param int $idGrupo Id do grupo de acesso
     * @return Array $select->query()->fetchAll();
     */
    public function getArrayIdUsuarioGrupo($idGrupo){
        
       $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('usuario_grupo', array('id_usuario'))->
                  where('usuario_grupo.id_grupo_de_acesso = ?', $idGrupo);
       
       return $select->query()->fetchAll();
    }            
    
    /***
     * Exibe tds os grupos visiveis do usuario
     * @param int $idUsuario Id do usario a ser pesquisado
     * @return Array $select->query()->fetchAll();
     */
    public function exibir($idUsuario){
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('usuario_grupo', array('id_grupo_de_acesso'))->
                  join('grupo_de_acesso','usuario_grupo.id_grupo_de_acesso = grupo_de_acesso.id_grupo_de_acesso',array('nome'))->
                  where('usuario_grupo.id_usuario = ?', $idUsuario);
       $select->group('usuario_grupo.id_grupo_de_acesso');
       return $select->query()->fetchAll();
    }
    
    /***
     * Salva os usarios em um ou mais grupos de acesso
     * @param array $arrayIdUsuario Array com os ids dos usuarios
     * @param array $grupos Array com os ids dos grupos
     */
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
            ZendUtils::transmissorMsg('Erro ao cadastrar o controle de acesso, Usuario Grupo. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            return $e->getMessage();
        }
        
    }
    
    /***
     * Salva o usario em um grupo de acesso recem criado
     * @param array $parametros array('id_usuario'=>$this->_id_usuario,'id_usuario_pai'=>$this->_id_usuario,'id_grupo_de_acesso'=>$id_grupo)
     */
    public function gravarNovo($parametros){
        
        try
        {            
            $this->_insert(array('id_usuario'=>$parametros['id_usuario'],'id_grupo_de_acesso'=>$parametros['id_grupo_de_acesso'],'id_usuario_pai'=>$parametros['id_usuario_pai']));
            
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao cadastrar o usuario ao grupo de acesso. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            return $e->getMessage();
        }
        
    }
    
    public function deletar($array_id_usuario)
    {
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                 $this->delete(array('id_usuario=?'=>(int)$value['id_usuario'],'id_usuario_pai=?'=>$this->_id_usuario)); 
            }
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao retirar os usuarios dos grupos. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        $erros = TRUE;        
        
        if(!isset($data['novo_grupo'])){
            $select = $this->_dbTable->
                        select()->
                        setIntegrityCheck(false)->
                        from('usuario_grupo', 'usuario_grupo.id_grupo_de_acesso')->
                        where('usuario_grupo.id_usuario = ?',$this->_id_usuario)->
                        where('usuario_grupo.id_grupo_de_acesso = ?', $data['id_grupo_de_acesso']);

            if(!$select->query()->rowCount())
                $erros = "ERRO 171 - Grupo";
        }
        
        return $erros;
    }   
   
       
}

