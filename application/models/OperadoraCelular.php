<?php

class Application_Model_OperadoraCelular extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_OperadoraCelular();
    }

    
    
    
    protected function _validarDados(array $data) {
        
    }


}

