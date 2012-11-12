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
    protected $_usuario;
    
    
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
        $this->_usuario = new Application_Model_Usuario();
        
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
    
    public function ajaxcafuncionarioAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        
        $arrayLED = $this->getLED('gerenciarcontroleacesso');
                
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
        $this->view->liberar    = isset($arrayLED['liberar'])?$arrayLED['liberar']:false;
        
        $this->view->arrayFuncionario = $this->_funcionario->exibirca($this->_request->getParam('pagina', 1),
                                                $this->_request->getParam('listaIdEmpresa', 0),
                                                $this->_request->getParam('listaIdTime', 0),
                                                $this->_request->getParam('idSetor', 0),
                                                $this->_request->getParam('idCargo', 0),
                                                $this->_request->getParam('idFuncionario_tipo', 0));
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
        
        if($this->_request->getParam('editarCA',false))
        {
                $this->view->arrayIdGrupo = $this->_usuario_grupo->exibir($this->_request->getParam('id_usuario'));
        }
    }
    
    public function ajaxcarregamenutreeAction()
    {
       $this->_helper->layout->disableLayout();
       
       
       if($this->_request->getParam('editarCA',false))
       {
            $this->view->arrayIdFuncionalidades = $this->_usuario->getPermissao($this->_request->getParam('id_usuario'));
       }
    }
    
    public function ajaxgravacontroleacessoAction()
    {
        
        if(!$this->possuiPermissao('cadastrarcontroleacesso'))
        {$this->_redirect ("sistema/logado");}
        
        $this->_helper->layout->disableLayout();
        $this->view->erros = '';
        $teste = '';
                
        $parametros = $this->_getAllParams();
            
        $listaIdTempFuncionarioEscolhido = substr($parametros['arrayIdTempFuncionarioEscolhido'], 1,-1); 
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($listaIdTempFuncionarioEscolhido);   
        
        $this->_usuario_time_visivel->deletar($arrayIdUsuario);        
        $this->_usuario_empresa_visivel->deletar($arrayIdUsuario);
        $this->_usuario_funcionalidade->deletar($arrayIdUsuario);
        $this->_usuario_grupo->deletar($arrayIdUsuario);
        
        if(isset($parametros['arrayIdTempTimeEscolhido']) && ($parametros['arrayIdTempTimeEscolhido']!=","))
        {            
            $teste = $this->_usuario_time_visivel->gravar($arrayIdUsuario, substr($parametros['arrayIdTempTimeEscolhido'],1,-1));
            if(is_string($teste))
                $this->view->erros .= " ".$teste;    
        }

        if(isset($parametros['arrayIdTempEmpresaEscolhida']) && ($parametros['arrayIdTempEmpresaEscolhida']!=","))
        {
            $teste = $this->_usuario_empresa_visivel->gravar($arrayIdUsuario, substr($parametros['arrayIdTempEmpresaEscolhida'],1,-1));
            if(is_string($teste))
                $this->view->erros .= " ".$teste;
        }

        //Verifica se um grupo foi escolhido
        if(!isset($parametros['idGrupoTmp']))
        {   
            // Inserir em usuario_funcionalidade
            $teste = $this->_usuario_funcionalidade->gravar($arrayIdUsuario, $parametros['id_funcionalidades'],(isset($parametros['funcionalidade_editar']))?$parametros['funcionalidade_editar']:array('funcionalidade_editar'=>','),(isset($parametros['funcionalidade_deletar'])?$parametros['funcionalidade_deletar']:array('funcionalidade_deletar'=>',')),(isset($parametros['funcionalidade_liberar'])?$parametros['funcionalidade_liberar']:array('funcionalidade_liberar'=>',')),$parametros['idPai'],$this->_permissoes);
            if(is_string($teste))
                $this->view->erros .= " ".$teste;
        } 
        else 
        {
            // Inserir em usuario_grupo
            $teste = $this->_usuario_grupo->gravar($arrayIdUsuario, $parametros['idGrupoTmp']);
            if(is_string($teste))
                $this->view->erros .= " ".$teste;
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
    
    public function editarcontroleacessoAction()
    {
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($this->_request->getParam('idFuncionario', false));
        $this->view->id_usuario = $arrayIdUsuario[0]['id_usuario'];
        
        $this->view->arrayIdGrupo = $this->_usuario_grupo->exibir($this->view->id_usuario);
        
        $this->view->arrayIdEmpresa = $this->_usuario_empresa_visivel->exibir($this->view->id_usuario);
        
        $this->view->arrayIdTime = $this->_usuario_time_visivel->exibir($this->view->id_usuario);
        
        $this->view->idFuncionario = $this->_request->getParam('idFuncionario', false);
        
        $this->view->arraySetor = $this->_setor->fetchAll(null,'setor.titulo ASC');
        $this->view->arrayCargo = $this->_cargo->fetchAll(null,'cargo.titulo ASC');
        $this->view->arrayFuncionario_tipo = $this->_funcionario_tipo->fetchAll(null,'funcionario_tipo.titulo ASC');
    
    }
    
    public function deletarcontroleacessoAction() {
        $this->_helper->layout->disableLayout();
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($this->_request->getParam('idFuncionario', false));
        
        $this->_usuario_time_visivel->deletar($arrayIdUsuario);        
        $this->_usuario_empresa_visivel->deletar($arrayIdUsuario);
        $this->_usuario_funcionalidade->deletar($arrayIdUsuario);
        $this->_usuario_grupo->deletar($arrayIdUsuario);
        
        
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
    
    public function gerenciarcontroleacessoAction() {
        
        $this->view->arrayControlAcessLED = $this->getLED('gerenciarcontroleacesso');
        
        $this->view->arraySetor = $this->_setor->fetchAll(null,'setor.titulo ASC');
        $this->view->arrayCargo = $this->_cargo->fetchAll(null,'cargo.titulo ASC');
        $this->view->arrayFuncionario_tipo = $this->_funcionario_tipo->fetchAll(null,'funcionario_tipo.titulo ASC');
        
    }
    
    public function testeAction()
    {
        if($this->_request->isPost())
        {
            //$this->_redirect($this->url(array('module' => 'sistema', 'controller' => 'logado', 'action' => 'cadastrarfuncionario'), null, 1));
        }    
    
    }
}



