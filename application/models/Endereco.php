<?php

class Application_Model_Endereco extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Endereco();
    }

    protected function _validarDados(array $data) {
        
    }


}

