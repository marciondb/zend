<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini",APPLICATION_ENV);
        Zend_Registry::set("config",$config);
        
    }

        }

    }

