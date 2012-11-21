<?php
 
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini",APPLICATION_ENV);
        Zend_Registry::set("config",$config);
        //arquivo de paginação | \pinho\application\modules\default\views\scripts\paginator.phtml
        Zend_View_Helper_PaginationControl::setDefaultViewPartial ('paginator.phtml' );        
    }
    
    public function _initAutoLoader()
    {
        Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);        
    }
    
    public static function _initSessao(){
        
         Zend_Session::start();
         
         Zend_Registry::set("session", new Zend_Session_Namespace());
        
    }

}

