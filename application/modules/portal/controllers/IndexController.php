<?php

class Portal_IndexController extends Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        parent::init();
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


}

