<?php

/***
 * Contem todos os metodos para controlar as action de todos os módulos do programa e garantir seguranca ao mesmo.
 */
abstract class Controller_Action extends Zend_Controller_Action {
    
    //contem todas as permisses do usuario
    protected $_permissoes;
    //instancia da table usuario
    protected $_usuario;
    //id do user logado, que pode ser acessada por todos os controles
    protected $_id_usuario;
    //base da url (antes do nome do controller 
    //ex: baseUrl/controller/action/param/valor/.../paramN/valorN), 
    //que pode ser acessada por todos os controles
    // o metodo $this->baseUrl() so pode ser usado dentro de views, por isso
    //esse atributo foi criado
    protected $baseUrl;

    
    /***
     * Verifica se o usuario possui determinada action
     * @param string $action Nome da action/funcionalidade
     * @return boolean 
     */
    public function possuiPermissao($action)
    {
        $nomeDaAcao = $action;
      
        $flag=0;
        foreach ($this->_permissoes as $value) 
            if(($value['action']==$nomeDaAcao))
                $flag = 1;
            
       return (($flag==0)&&($nomeDaAcao != 'index'))?FALSE:TRUE;
    }
   
    public function init()
    {
       
        $this->_usuario = new Application_Model_Usuario();
        $this->baseUrl = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"));
         
        // Verifica em todas as páginas se o usuário está logado ou não, permitindo o acesso de acordo com a situação
        $redirect = $this->getRequest()->getModuleName();
                        
        //ATENCAO!!! Não colocar NADA dentro de NENHUMA controller index!!!!!
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
                $this->_permissoes = $this->_usuario->getPermissao($this->_id_usuario);
                $this->view->permissoes = $this->_permissoes;
                //print_r($this->_permissoes);
                
                if($this->_permissoes)
                {   
                    if(!$this->possuiPermissao($this->getRequest()->getActionName()))
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
    
    /***
     * Verifica se a ação possui liberar, editar ou deletar.
     * @param String $nomeDaAcao Nome da ação
     * @return array Array de LED
     */
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
        $this->_helper->layout->disableLayout();
        $senha = '';
        $userEmail = '';
        $this->view->erro = '';
        $userEmail = $this->getRequest()->getParam("login");
        $senha = $this->getRequest()->getParam("senha");

        if(!$this->_usuario->efetuarLogin($userEmail, $senha))
        {
            $this->view->erro = '0';
        }
        else
            $this->view->erro = '1';

    }

    /***
     * Deslogar o usuário do sistema para todos os módulos
     */
    public function logoutAction()
    {
        $redirect = $this->getRequest()->getModuleName();
        
        if($redirect == "ead") 
                $redirect = "portal";
        
        $this->_usuario->efetuarLogoff();
        
        $this->_redirect($redirect);
    }   
}