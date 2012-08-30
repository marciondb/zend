<?php

abstract class SON_Controller_Action extends Zend_Controller_Action {

    protected $userId;
    protected $userNome;
    protected $userEmail;
    protected $data;
    protected $authStatus = false;

    public function init() {
        $this->flashMessenger = $this->_helper->FlashMessenger;
        $this->view->messages = $this->flashMessenger->getMessages();
        
        if ($this->_request->isPost()) {
            $this->data = $this->_request->getPost();
            if (isset($this->data['submit']))
                unset($this->data['submit']);
        }
        
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session($this->_request->getModuleName()));
        if ($auth->hasIdentity()) {
            $this->authStatus = true;
            $this->userId = $auth->getIdentity()->id;
            $this->userNome = $auth->getIdentity()->nome;
            $this->userEmail = $auth->getIdentity()->email;
        }

        $this->view->userNome = $this->userNome;
        $this->view->authStatus = $this->authStatus;
    }
}