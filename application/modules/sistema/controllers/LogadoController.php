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
    protected $_usuario_empresa_visivel;
    protected $_lotacao;
    protected $_setor;
    protected $_time;
    protected $_usuario_time_visivel;
    
    
    public function init()
    {
        /* Initialize action controller here */
        parent::init();
        
        //*******************************************************************
        //  INICIO Instanciando os models, para pode utilizar os metodos relacionado 
        // a banco de dados
        //*******************************************************************
        
        $this->_empresa = new Application_Model_Empresa();
        $this->_time = new Application_Model_Time();
        $this->_usuario_time_visivel = new Application_Model_UsuarioTimeVisivel();
        $this->_endereco = new Application_Model_Endereco();
        $this->_usuario_empresa_visivel = new Application_Model_UsuarioEmpresaVisivel();
        $this->_grupo_de_acesso = new Application_Model_GrupoDeAcesso();
        $this->_usuario_grupo = new Application_Model_UsuarioGrupo();
        $this->_funcionario = new Application_Model_Funcionario();
        
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
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        $this->view->liberar    = $this->_request->getParam('liberar', false);
        
        $this->view->arrayEmpresa = $this->_empresa->exibir($this->_request->getParam('pagina', 1));
    }
    
    public function ajaxtimeAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        
        $this->view->arrayTime = $this->_time->exibir($this->_request->getParam('pagina', 1),
                                                $this->_request->getParam('listaIdEmpresa', 0),
                                                $this->_request->getParam('listaIdSetor', 0),
                                                $this->_request->getParam('listaIdTime', 0),
                                                $this->_request->getParam('add', 0));
    }
    
    public function ajaxfuncionarioAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        $this->view->liberar    = $this->_request->getParam('liberar', false);
        
        $this->view->arrayFuncionario = $this->_funcionario->exibir($this->_request->getParam('pagina', 1),
                                                $this->_request->getParam('listaIdEmpresa', 0),
                                                $this->_request->getParam('listaIdFuncionario', 0),
                                                $this->_request->getParam('listaIdTime', 1),
                                                $this->_request->getParam('add', 0));
    }
    
    public function cadastrarcontroleacessoAction()
    {
        $this->view->arrayEmpresaLED     = $this->getLED('ajaxempresa');
        $this->view->arrayTimeLED        = $this->getLED('ajaxtime');
        $this->view->arrayFuncionarioLED = $this->getLED('ajaxfuncionario');
    }
     
    public function cadastrarempresaAction()
    {
        if($this->_request->isPost())
        {
            $parametros = $this->_getAllParams();
            
            //salva a empresa e pega o id
            $array_id_empresa = array($this->_empresa->gravar($parametros,$this->_endereco));
            
            //pega tds os id´s de td´s os usuarios que pertecem ao grupo dos administradores
            $id_grupo = 1; //Grupo dos administradores
            $array_id_usuario_admin = $this->_usuario_grupo->getArrayIdUsuarioGrupo($id_grupo);
            
            //para colocar a empresa salva na lista de empresas visiveis do grupo administrador
            $this->_usuario_empresa_visivel->gravar($array_id_usuario_admin,$array_id_empresa);
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



