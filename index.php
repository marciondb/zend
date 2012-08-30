<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));


    //para saber se esta em modo producao ou desenvolvimento
    //$ip_server_local_criweb = new Zend_Config_Xml('http://pinhonline.com.br/global.xml','ip_server_local_criweb');
    $estado = '';    
    if ($_SERVER['SERVER_ADDR']=='::1')//$ip_server_local_criweb->ip)//ip do servidor local da criweb
        $estado = 'development';
    else
        $estado = 'production';


// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : $estado));


/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();