<?php

abstract class Controller_Action extends Zend_Controller_Action {
    //protected $userEmail;
    protected $senha;
    protected $_permissoes;
    protected $_usuario;
    protected $_id_usuario;
    protected $baseUrl;

    public function possuiPermissao()
    {
        $nomeDaAcao = $this->getRequest()->getActionName();
        
        $parametroEditar = $this->getRequest()->getParam('editar');
        $parametroDeletar = $this->getRequest()->getParam('deletar');
        $parametroLiberar = $this->getRequest()->getParam('liberar');
      
        $flag=0;
        foreach ($this->_permissoes as $value) 
            if(($value['action']==$nomeDaAcao))
            {
                $flag = 1;

                if(!(($value['editar']==$parametroEditar) || (!isset($parametroEditar))))
                    $flag = 0;
                if(!(($value['deletar']==$parametroEditar) || (!isset($parametroDeletar))))
                    $flag = 0;
                if(!(($value['liberar']==$parametroEditar) || (!isset($parametroLiberar))))
                    $flag = 0;
            }
            
       return (($flag==0)&&($nomeDaAcao != 'index'))?FALSE:TRUE;
    }
    public function init()
    {
       
        $this->_usuario = new Application_Model_Usuario();
        $this->baseUrl = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"));
         
        // Verifica em todas as páginas se o usuário está logado ou não, permitindo o acesso de acordo com a situação
        $redirect = $this->getRequest()->getModuleName();
                        
        if (!($this->getRequest()->getControllerName() == "index"))
        {
            if(!(Zend_Auth::getInstance()->hasIdentity()))
            {  
                ZendUtils::transmissorMsg(' VOCÊ DEVE EFETUAR O LOGIN!',  ZendUtils::MENSAGEM_ERRO,  2000);
                $this->_redirect($redirect);                
             }
            else
            {
                $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
                $this->_id_usuario = $arrayIdentity->id_usuario;
                $this->view->nome_usuario = $arrayIdentity->login;
                $this->view->id_usuario = $this->_id_usuario;
                $this->_permissoes = $this->_usuario->getPermissao();
                $this->view->permissoes = $this->_permissoes;
                //print_r($this->_permissoes);
                
                if($this->_permissoes)
                {   
                    if(!$this->possuiPermissao())
                    {  
                        if(strpos($this->getRequest()->getActionName(),"ajax")=== FALSE)
                        {
                            $this->_redirect($redirect);
                            //ZendUtils::transmissorMsg($this->getRequest()->getActionName().' | SEM PERMISSÃO!',  ZendUtils::MENSAGEM_ERRO,  2000);
                                                
                        }
                    }
                }
                else
                {
                    ZendUtils::transmissorMsg(' VOCÊ NÃO POSSUI NENHUMA PERMISSÃO!',  ZendUtils::MENSAGEM_ERRO,  2000);
                    $this->logoutAction();
                }
            }
        }
                
    }
    
    public function getLED($nomeDaAcao) 
    {   
        $returnArray = array();
        
        foreach ($this->_permissoes as $value) 
            if(($value['action']==$nomeDaAcao))
            {    
                if($value['liberar'])
                    $returnArray['liberar']=TRUE;
                if($value['editar'])
                    $returnArray['editar'] =TRUE;
                if($value['deletar'])
                    $returnArray['deletar']=TRUE;
            }
       return $returnArray;
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