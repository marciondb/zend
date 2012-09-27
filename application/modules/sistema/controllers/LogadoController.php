<?php

class Sistema_LogadoController extends Controller_Action
{

    protected $_empresa;    
    protected $_endereco; 
    protected $_funcionario;
    protected $_funcionario_tipo;
    protected $_funcionalidade;
    protected $_grupo_funcionalidade;
    protected $_grupo_de_acesso;
    protected $_usuario_funcionalidade;
    protected $_usuario_grupo;    
    protected $_cargo;
    protected $_cliente_empresa;
    protected $_empresa_visivel;
    protected $_lotacao;
    protected $_setor;
    protected $_time;
    
    
    public function init()
    {
        /* Initialize action controller here */
        parent::init();
        
        //*******************************************************************
        //  INICIO Instanciando os models, para pode utilizar os metodos relacionado 
        // a banco de dados
        //*******************************************************************
        
        $this->_empresa = new Application_Model_Empresa();
        $this->_endereco = new Application_Model_Endereco();
        $this->_empresa_visivel = new Application_Model_EmpresaVisivel();
        $this->_grupo_de_acesso = new Application_Model_GrupoDeAcesso();
        $this->_usuario_grupo = new Application_Model_Usuariogrupo();
        
        //*******************************************************************
        //  FIM Instanciando os models, para pode utilizar os metodos relacionado 
        // a banco de dados
        //*******************************************************************     
        
    }    

    public function indexAction()
    {
        
    }
        
    public function ajaxempresaAction()
    {
        if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");
        
        $this->_helper->layout->disableLayout();
        
        $this->view->arrayEmpresa = $this->_empresa->exibir();
    }
    
    public function cadastrarcontroleacessoAction()
    {
        
    }
     
    public function cadastrarempresaAction()
    {
        if($this->_request->isPost())
        {
            /*$parametros = $this->_getAllParams();
            
            $array_id_empresa = array($this->_empresa->gravar($parametros,$this->_endereco));
            $id_grupo = 1; //Grupo dos administradores
            $array_id_usuario_admin = $this->_usuario_grupo->getArrayIdUsuarioGrupo($idGrupo);
            $this->_empresa_visivel->gravar($array_id_usuario_admin,$array_id_empresa);*/
        }    
    
    }
    
    public function cadastrarfuncionarioAction()
    {
        if($this->_request->isPost())
        {
            //$this->_redirect($this->url(array('module' => 'sistema', 'controller' => 'logado', 'action' => 'cadastrarfuncionario'), null, 1));
        }    
    
    }
    
    public function testeAction()
    {
        if($this->_request->isPost())
        {
            //$this->_redirect($this->url(array('module' => 'sistema', 'controller' => 'logado', 'action' => 'cadastrarfuncionario'), null, 1));
        }    
    
    }
}



