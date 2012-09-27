<?php

class Application_Model_Usuariogrupo extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioGrupo();
    }

    protected function getArrayIdUsuarioGrupo($idGrupo){
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('usuario_grupo', array('id_usuario'))->
                  where('usuario_grupo.id_grupo_de_acesso = ?', $idGrupo);
    }            


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
   
       
}

