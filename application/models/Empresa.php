<?php

class Application_Model_Empresa extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Empresa();
    }

    public function _insert(array $data) {
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data) {
        return $this->_dbTable->update($data);
    }
    
    
    
    public function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
}

