<?php

class SON_Plugins_CheckAuth extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $module = $request->getModuleName();
        $resource = $request->getControllerName();
        $action = $request->getActionName();

        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session($module));
        
        if (!$auth->hasIdentity() and $module<>"api") {

            $request->setModuleName($module)
                        ->setControllerName('index')
                        ->setActionName('index');
        }
    }
}