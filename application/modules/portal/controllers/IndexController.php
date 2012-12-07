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
    
    public function ajaxgravasenhausuarioAction(){
        $this->_helper->layout->disableLayout();
        
        $id_usuario = $this->_request->getParam('id_usuario', false);
        $chave      = $this->_request->getParam('chave', false);
        $senha      = $this->_request->getParam('senha', false);
        
        try
        {
            $this->_usuario->save(array('senha'=>md5($senha)),true,'id_usuario='.$id_usuario." AND chave_controle='".$chave."'".' AND status=1',$id_usuario);
            $this->view->sucesso = 'Senha cadastrada com sucesso!';
        }
        catch(Exception $e)
        {            
             $this->view->sucesso = 'Erro ao cadastrar a senha!'.$e;
        }
        
       
    }


}

