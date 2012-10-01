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


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }   
   
       
}

