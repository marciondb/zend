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
        $this->_grupo_funcionalidade = new Application_Model_GrupoFuncionalidade();
        $this->_usuario_funcionalidade = new Application_Model_UsuarioFuncionalidade();
        $this->_funcionario = new Application_Model_Funcionario();
        $this->_funcionario_tipo = new Application_Model_FuncionarioTipo();
        $this->_setor = new Application_Model_Setor();
        $this->_cargo = new Application_Model_Cargo();
        
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
        
        $this->view->adicionar  = $this->_request->getParam('adicionar', false);
        $this->view->remover    = $this->_request->getParam('remover', false);
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        $this->view->liberar    = $this->_request->getParam('liberar', false);
        
        $this->view->arrayEmpresa = $this->_empresa->exibir($this->_request->getParam('pagina', 1),
                                                            $this->_request->getParam('cnpj', 0),
                                                            $this->_request->getParam('listaIdEmpresasEscolhidas', 0),
                                                            $this->_request->getParam('remover', 0));
    }
    
    public function ajaxtimeAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        $this->view->adicionar  = $this->_request->getParam('adicionar', false);
        $this->view->remover    = $this->_request->getParam('remover', false);
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        
        $this->view->arrayTime = $this->_time->exibir($this->_request->getParam('pagina', 1),
                                                $this->_request->getParam('listaIdEmpresa', 0),
                                                $this->_request->getParam('listaIdTimesEscolhidos', 0),
                                                $this->_request->getParam('remover', 0));
    }
    
    public function ajaxfuncionarioAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->adicionar  = $this->_request->getParam('adicionar', false);
        $this->view->remover    = $this->_request->getParam('remover', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        $this->view->liberar    = $this->_request->getParam('liberar', false);
        
        $this->view->arrayFuncionario = $this->_funcionario->exibir($this->_request->getParam('pagina', 1),
                                                $this->_request->getParam('listaIdEmpresa', 0),
                                                $this->_request->getParam('listaIdFuncionario', 0),
                                                $this->_request->getParam('listaIdTime', 0),
                                                $this->_request->getParam('idSetor', 0),
                                                $this->_request->getParam('idCargo', 0),
                                                $this->_request->getParam('idFuncionario_tipo', 0),
                                                $this->_request->getParam('listaIdFuncionarioEscolhido', 0),
                                                $this->_request->getParam('remover', 0));
    }
    
    public function ajaxusuariogrupoAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        if($this->_request->getParam('idGrupo'))
            $this->view->arrayIdFuncionalidade= $this->_grupo_funcionalidade->getIdFuncionalidade($this->_request->getParam('idGrupo', false));
        else
        {
            $this->view->selecionar = $this->_request->getParam('selecionar', false);
            $this->view->editar     = $this->_request->getParam('editar', false);
            $this->view->deletar    = $this->_request->getParam('deletar', false);

            $this->view->arrayUsuarioGrupo = $this->_usuario_grupo->exibir($this->_id_usuario);
        }
    }
    
    public function ajaxcarregamenutreeAction()
    {
       $this->_helper->layout->disableLayout();
    }
    
    public function ajaxgravacontroleacessoAction()
    {
        $this->_helper->layout->disableLayout();
        
        $parametros = $this->_getAllParams();
            
        $listaIdTempFuncionarioEscolhido = substr($parametros['arrayIdTempFuncionarioEscolhido'], 1,-1); 
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($listaIdTempFuncionarioEscolhido);            

        if(isset($parametros['arrayIdTempTimeEscolhido']) && ($parametros['arrayIdTempTimeEscolhido']!=","))
        {
            //$this->_usuario_time_visivel->gravar($arrayIdUsuario, substr($parametros['arrayIdTempTimeEscolhido'],1,-1));
        }

        if(isset($parametros['arrayIdTempEmpresaEscolhida']) && ($parametros['arrayIdTempEmpresaEscolhida']!=","))
        {
            //$this->_usuario_empresa_visivel->gravar($arrayIdUsuario, substr($parametros['arrayIdTempEmpresaEscolhida'],1,-1));
        }

        //Verifica se um grupo foi escolhido
        if(!isset($parametros['idGrupoTmp']))
        {   
            // Inserir em usuario_funcionalidade
            //$this->_usuario_funcionalidade->gravar($arrayIdUsuario, $parametros['id_funcionalidades'],$parametros['funcionalidade_editar'],$parametros['funcionalidade_deletar'],$parametros['funcionalidade_liberar'],$parametros['idPai']);
        } 
        else 
        {
            // Inserir em usuario_grupo
            //$this->_usuario_grupo->gravar($arrayIdUsuario, $parametros['idGrupoTmp']);
        }
    }
    
    public function cadastrarcontroleacessoAction()
    {
        /*$this->view->arrayEmpresaLED     = $this->getLED('ajaxempresa');
        $this->view->arrayTimeLED        = $this->getLED('ajaxtime');
        $this->view->arrayFuncionarioLED = $this->getLED('ajaxfuncionario');*/
        $this->view->arraySetor = $this->_setor->fetchAll(null,'setor.titulo ASC');
        $this->view->arrayCargo = $this->_cargo->fetchAll(null,'cargo.titulo ASC');
        $this->view->arrayFuncionario_tipo = $this->_funcionario_tipo->fetchAll(null,'funcionario_tipo.titulo ASC');
        
        if($this->_request->isPost())
        {
            
            
            ZendUtils::transmissorMsg(' Salvo com sucesso',  ZendUtils::MENSAGEM_ACERTO,  2000);
        }
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



