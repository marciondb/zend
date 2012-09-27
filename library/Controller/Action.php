<?php

abstract class Controller_Action extends Zend_Controller_Action {
    //protected $userEmail;
    protected $senha;
    protected $permissoes;
    protected $_usuario;
    protected $baseUrl;

    public function init()
    {
        
        $this->_usuario = new Application_Model_Usuario();
        $this->baseUrl = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"));
        
        // Verifica em todas as páginas se o usuário está logado ou não, permitindo o acesso de acordo com a situação
        $redirect = $this->getRequest()->getModuleName();
                        
        if (!($this->getRequest()->getControllerName() == "index"))
        {
            if(!(Zend_Auth::getInstance()->hasIdentity()))
                $this->_redirect($redirect);
            else
            {
                $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
                $this->view->nome_usuario = $arrayIdentity->login;
                $this->view->id_usuario = $arrayIdentity->id_usuario;
                
                $nomeDaAcao = $this->getRequest()->getActionName();
                $permissoes = $this->_usuario->getPermissao();
                $this->view->resultado = $permissoes;
                //print_r($permissoes);
                
                if($permissoes)
                {    
                    $flag=0;
                    foreach ($permissoes as $value) 
                        if(($value['action']==$nomeDaAcao))
                            $flag = 1;
                    
                    if($flag==0 && $nomeDaAcao != 'index')
                        $this->_redirect($redirect);
                }
                else
                {
                    //echo "<script>alert('Consulte o seu PinhoNet, você não possui acesso.');</script>";
                    $this->logoutAction();
                }
            }
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
                ?>
                    <script>
                        if(alert('Login ou senha incorretos!')==undefined)
                        {
                            window.location.pathname = '<?php echo $this->baseUrl;?>/<?php echo $redirect; ?>';
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