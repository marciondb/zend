<?php

class Application_Model_UsuarioGrupo extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioGrupo();
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

                    $this->save(array('id_usuario'=>$usuario['id_usuario'],'id_grupo_de_acesso'=>$idGrupo));
                }
            }
        
        }
        catch(Exception $e)
        {
            //echo "<script>setMsg('ERRO','Erro ao retirar as funcionalidades dos usuários, favor contactar Criweb<br>".$e->getMessage()."',1)</script>";    
            //ZendUtils::transmissorMsg('Erro ao cadastrar o controle de acesso, Usuario Grupo, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
    }
    
    public function deletar($array_id_usuario)
    {
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                 $this->delete('id_usuario='.(int)$value['id_usuario']);
            }
        }
        catch(Exception $e)
        {
            //ZendUtils::transmissorMsg('Erro ao retirar os usuarios dos grupos, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }   
   
       
}

