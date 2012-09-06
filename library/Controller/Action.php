<?php

abstract class Controller_Action extends Zend_Controller_Action {
    //protected $userEmail;
    protected $senha;
    protected $_usuario;

    public function init()
    {
        
        $this->_usuario = new Application_Model_Usuario();
        
        
        // Verifica em todas as páginas se o usuário está logado ou não, permitindo o acesso de acordo com a situação
        $redirect = $this->getRequest()->getModuleName();
        
        if (!($this->getRequest()->getControllerName() == "index"))
        {
            if(!(Zend_Auth::getInstance()->hasIdentity()))
                $this->_redirect($redirect);
        }  
    }

    /***
     * Funcao generica usada por todos os modulos para efetuar o login
     * 
     */
    public function logarAction()
    {
        if($this->getRequest()->isPost())
        {
            $this->userEmail = $this->getRequest()->getParam("login");
            $this->senha = $this->getRequest()->getParam("senha");
            $redirect = $this->getRequest()->getModuleName();
            
            if(!$this->_usuario->efetuarLogin($this->userEmail, $this->senha))
            {
                //ZendUtils::transmissorMsg("Login ou senha incorretos!",  ZendUtils::MENSAGEM_ERRO,0);
                
                ?>
                    <script>
                        if(alert('Login ou senha incorretos!')==undefined)
                        {
                            window.location.pathname = '/pinho/<?php echo $redirect; ?>';
                        }
                    </script>
                <?php
                die();
            }
            
            //Se o login der certo, sera redirecionado para a view "logado", view inical padrao, depois de logado, de TODOS os modulos
            //menos o portal
            if($redirect == "portal") 
                $redirect = "ead";
            
            $this->_redirect($redirect."/logado");                
        }

    }

    public function logoutAction()
    {
        $redirect = $this->getRequest()->getModuleName();
        
        if($redirect == "ead") 
                $redirect = "portal";
        
        $this->_usuario->efetuarLogoff();
        
        $this->_redirect($redirect);
    }   
}