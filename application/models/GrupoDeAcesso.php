<?php

class Application_Model_GrupoDeAcesso extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_GrupoDeAcesso();
    }

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
   
       
}

