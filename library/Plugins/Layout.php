<?php
//Permite que cada modulo tenha um layout diferente
class Plugins_Layout extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        if ($request->getModuleName() <> "api") {
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout("layout")
                    ->setLayoutPath(APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/views/layouts');
        }
    }

}
