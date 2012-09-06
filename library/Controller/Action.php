<?php

abstract class Controller_Action extends Zend_Controller_Action {
    //protected $userEmail;
    protected $senha;
    protected $_usuario;

        public function init()
    {
            
        $this->_usuario = new Application_Model_Usuario();
    }

    public function logarAction()
    {
        if($this->getRequest()->isPost())
        {
            $this->userEmail = $this->getRequest()->getParam("login");
            $this->senha = $this->getRequest()->getParam("senha");
            
            if(!$this->_usuario->efetuarLogin($this->userEmail, $this->senha))
            {
                //ZendUtils::transmissorMsg("Login ou senha incorretos!",  ZendUtils::MENSAGEM_ERRO,0);
                echo $this->senha;
                die();
                
            }
            $this->_redirect("index");                
        }

    }

    public function logoutAction()
    {
        $this->_usuario->efetuarLogoff();
        $this->_redirect("index");
    }   
}