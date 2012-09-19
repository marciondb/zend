<?php

class Sistema_LogadoController extends Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        parent::init();
        
        /*http://blog.jtclark.ca/2010/03/zend-framework-and-ajax/*/       
        /*$ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('ajaxempresa', 'html')
            ->initContext();*/
        
        
    }
    

    public function indexAction()
    {
        
    }
        
    public function ajaxempresaAction()
    {
        $this->_helper->layout->disableLayout();
        $this->view->valor1 = 'deu certo';
    }
    
    public function cadastrarcontroleacessoAction()
    {
        
    }
     
    public function cadastrarempresaAction()
    {
        if($this->_request->isPost())
        {
            $this->_redirect($this->url(array('module' => 'sistema', 'controller' => 'logado', 'action' => 'cadastrarempresa'), null, 1));
        }    
    
    }
}



