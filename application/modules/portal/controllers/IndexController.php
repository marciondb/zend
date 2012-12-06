<?php

class Portal_IndexController extends Controller_Action
{
    protected $_usuario;
    
    public function init()
    {
        /* Initialize action controller here */
        parent::init();
        
        //*******************************************************************
        //  INICIO Instanciando os models, para poder utiliza os metodos relacionado 
        // a banco de dados
        //*******************************************************************
        $this->_usuario = new Application_Model_Usuario();
        //*******************************************************************
        //  FIM Instanciando os models, para poder utiliza os metodos relacionado 
        // a banco de dados
        //*******************************************************************
        
        //utilizado no layout.phtml
        $linkAtivo = $this->getRequest()->getActionName();
        $this->view->linkAtivo = $linkAtivo;
    }

    public function indexAction()
    {
        
    }
    
    public function quemsomosAction()
    {
        
    }
    
    public function solucoesAction()
    {
        
    }
    
    public function servicosAction()
    {
        
    }
    
    public function contatoAction()
    {
        
    }
    
    public function extrasAction()
    {
        
    }
    
    public function recuperarsenhaAction()
    {
        
        $parametrosForm = $this->getRequest()->getParams();
        
        if(isset($parametrosForm['emailRecuperar']))
        {
                $this->view->teste = $parametrosForm['emailRecuperar'];
        }
        
    }
    
    public function chaveAction() {
        $chave = $this->_request->getParam('chave', false);
        
        $this->view->usuario = $this->_usuario->validaChave($chave);
            
    }


}

