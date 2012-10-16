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
       
       return Zend_Paginator::factory( $select );
    }

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }   
   
       
}

