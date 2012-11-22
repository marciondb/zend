<?php

class Application_Model_CategoriaEmpresa extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_CategoriaEmpresa();
    }

    
    
    
    protected function _validarDados(array $data) {
        
    }


}

