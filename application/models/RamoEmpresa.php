<?php

class Application_Model_RamoEmpresa extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_RamoEmpresa();
    }

    
    
    
    protected function _validarDados(array $data) {
        
    }


}

