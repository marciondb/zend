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
    protected $_ramo_empresa;
    protected $_operadora_celular;
    protected $_categoria;
    
    
    public function init()
    {
        /* Initialize action controller here */
        parent::init();
        
        //*******************************************************************
        //  INICIO Instanciando os models, para poder utiliza os metodos relacionado 
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
        $this->_ramo_empresa = new Application_Model_RamoEmpresa();
        $this->_operadora_celular = new Application_Model_OperadoraCelular();
        $this->_categoria = new Application_Model_CategoriaEmpresa();
        $this->_lotacao = new Application_Model_Lotacao();
        
        //*******************************************************************
        //  FIM Instanciando os models, para poder utilizar os metodos relacionado 
        // a banco de dados
        //*******************************************************************     
        
    }    
    
    /***
     * Pre action, contem uns dos principais filtros usado pelo sistema
     * @return array Array de array, ['setor'], ['cargo'] e ['tipo']
     */
    public function filtroSetorCargoTipo(){
        $arrayResult = array();
        $arrayResult['setor'] = $this->_setor->fetchAll(null,'setor.titulo ASC');
        $arrayResult['cargo'] = $this->_cargo->fetchAll(null,'cargo.titulo ASC');
        $arrayResult['tipo'] = $this->_funcionario_tipo->fetchAll(null,'funcionario_tipo.titulo ASC');
        
        return $arrayResult;
    }
        
    /***
     * Contem a modal de filtro de Setor, Cargo e Tipo
     */
    public function ajaxfiltrosctAction()
    {
        //Desabilita o layout
        $this->_helper->layout->disableLayout();
        $arrayCST = $this->filtroSetorCargoTipo();
                
        //pega os parametros, passados pela view que chamaou esta action
        $this->view->setor = $this->_request->getParam('setor', false);
        $this->view->cargo = $this->_request->getParam('cargo', false);
        $this->view->tipo  = $this->_request->getParam('tipo', false);
        
        if($this->view->setor)
            $this->view->arraySetor = $arrayCST['setor'];
        if($this->view->cargo)
            $this->view->arrayCargo = $arrayCST['cargo'];
        if($this->view->tipo)
            $this->view->arrayFuncionario_tipo = $arrayCST['tipo'];
        
        
    }
    
    /***
     * Toda vez que tiver a necessidade de exibir as empresas, esta action deverá
     * ser chamada
     * action generica!
     */
    public function ajaxempresaAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        //Desabilita o layout
        $this->_helper->layout->disableLayout();
                
        //pega os parametros, passados pela view que chamaou esta action
        $this->view->adicionar  = $this->_request->getParam('adicionar', false);
        $this->view->remover    = $this->_request->getParam('remover', false);
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->escolher   = $this->_request->getParam('escolher', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        $this->view->liberar    = $this->_request->getParam('liberar', false);
        
        //chama a model
        $this->view->arrayEmpresa = $this->_empresa->exibir($this->_request->getParam('pagina', 1),
                                                            $this->_request->getParam('cnpj', 0),
                                                            $this->_request->getParam('listaIdEmpresasEscolhidas', 0),
                                                            $this->_request->getParam('remover', 0),
                                                            $this->_request->getParam('tipoEmpresa', 0));
    }
    
    /***
     * Toda vez que tiver a necessidade de exibir as time, esta action deverá
     * ser chamada
     * action generica!
     */
    public function ajaxtimeAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        $this->view->adicionar  = $this->_request->getParam('adicionar', false);
        $this->view->remover    = $this->_request->getParam('remover', false);
        $this->view->selecionar = $this->_request->getParam('selecionar', false);
        $this->view->escolher   = $this->_request->getParam('escolher', false);
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        
        $this->view->arrayTime = $this->_time->exibir($this->_request->getParam('pagina', 1),
                                                $this->_request->getParam('listaIdEmpresa', 0),
                                                $this->_request->getParam('listaIdTimesEscolhidos', 0),
                                                $this->_request->getParam('remover', 0));
    }
    
    /***
     * Toda vez que tiver a necessidade de exibir as empresas, esta action deverá
     * ser chamada
     * action generica!
     */
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
                                                $this->_request->getParam('id_setor', 0),
                                                $this->_request->getParam('id_cargo', 0),
                                                $this->_request->getParam('id_funcionario_tipo', 0),
                                                $this->_request->getParam('listaIdFuncionarioEscolhido', 0),
                                                $this->_request->getParam('remover', 0));
    }
    
    /***
     * Exibe os funcionario que possuem permissoes conseditas pelo usuario logado
     * Usado no Gerenciar Controle de Acesso 
     */
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
                                                $this->_request->getParam('id_setor', 0),
                                                $this->_request->getParam('id_cargo', 0),
                                                $this->_request->getParam('id_funcionario_tipo', 0));
    }
    
    /***
     * Toda vez que tiver a necessidade de exibir os grupo, esta action deverá
     * ser chamada
     * action generica!
     */
    public function ajaxusuariogrupoAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        //Caso seja necessario ter todas os ids funcionalidade de um grupo na view
        if($this->_request->getParam('idGrupo'))
            $this->view->arrayIdFuncionalidade= $this->_grupo_funcionalidade->getIdFuncionalidade($this->_request->getParam('idGrupo', false));
        else
        {
            //Senao, exibe os grupos que o usuario logado tem acesso
            
            $this->view->selecionar = $this->_request->getParam('selecionar', false);
            $this->view->editar     = $this->_request->getParam('editar', false);
            $this->view->deletar    = $this->_request->getParam('deletar', false);

            $this->view->arrayUsuarioGrupo = $this->_usuario_grupo->exibir($this->_id_usuario);
        }
        
        //Para o editar o controle de acesso, tem que ter os grupos do usuario 
        //logado e os grupos do usuario a ser editado
        if($this->_request->getParam('editarCA',false))
        {
                $this->view->arrayIdGrupo = $this->_usuario_grupo->exibir($this->_request->getParam('id_usuario'));
        }
    }
    
    /***
     * carrega as funcionalidade para cadastrar ou editar as permissoes, no controle de acesso
     */
    public function ajaxcarregamenutreeAction()
    {
       $this->_helper->layout->disableLayout();
       
       
       //Para o editar o controle de acesso
       if($this->_request->getParam('editarCA',false))
       {
            $this->view->arrayIdFuncionalidades = $this->_usuario->getPermissao($this->_request->getParam('id_usuario'));
       }
    }
    
    /***
     * grava as permissoes de controle de aceso
     */
    public function ajaxgravacontroleacessoAction()
    {
        $this->_helper->layout->disableLayout();
        
        if(!$this->possuiPermissao('cadastrarcontroleacesso'))
            $this->_redirect ("sistema/logado");
        
        $this->view->erros = '';
        $teste = '';
                
        $parametros = $this->_getAllParams();
            
        $listaIdTempFuncionarioEscolhido = substr($parametros['arrayIdTempFuncionarioEscolhido'], 1,-1); 
        //pega as ids de usuario dos funcionarios
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($listaIdTempFuncionarioEscolhido);   
        
        $this->_usuario_time_visivel->deletar($arrayIdUsuario);        
        $this->_usuario_empresa_visivel->deletar($arrayIdUsuario);
        $this->_usuario_funcionalidade->deletar($arrayIdUsuario);
        $this->_usuario_grupo->deletar($arrayIdUsuario);
        
        //salva
        if(isset($parametros['arrayIdTempTimeEscolhido']) && ($parametros['arrayIdTempTimeEscolhido']!=","))
        {            
            $teste = $this->_usuario_time_visivel->gravar($arrayIdUsuario, substr($parametros['arrayIdTempTimeEscolhido'],1,-1));
            //se houver erro, passa para a view.
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
    
    /***
     * grava o funcionario
     */
    public function ajaxgravafuncionarioAction()
    {
        $this->_helper->layout->disableLayout();
        
        if(!$this->possuiPermissao('cadastrarfuncionario'))
            $this->_redirect ("sistema/logado");
        
        $this->view->erros = '';
                
        $parametros = $this->_getAllParams();
        
        //salva o funcionario e pega a id
        $id_funcionario = $this->_funcionario->gravar($parametros, $this->_endereco);      
                
        //salva o usuario e pega o id
        $id_usuario = $this->_usuario->gravar($id_funcionario,$parametros['cpf'],$parametros['email_empresa']);        
                
        //atualiza o funcionario com a id do usuario
        $this->_funcionario->gravar(array('id_funcionario'=>$id_funcionario,'id_usuario'=>$id_usuario),'',true,'id_funcionario='.$id_funcionario);
                
        //salva a lotacao do funcionario
        $id_lotacao = $this->_lotacao->gravar(array('id_funcionario'=>$id_funcionario,
                                                    'id_empresa'=>$parametros['id_empresa'],
                                                    'id_cargo'=>$parametros['id_cargo'],
                                                    'id_setor'=>$parametros['id_setor'],
                                                    'id_funcionario_tipo'=>$parametros['id_funcionario_tipo'],
                                                    'data_hora'=>date('Y-m-d H:i:s'),
                                                    'atual'=>'1'));
        
        //se houver erro, passa para a view.
        if(is_string($id_lotacao))
            $this->view->erros .= " ".$id_lotacao;
        if(is_string($id_funcionario))
            $this->view->erros .= " ".$id_funcionario; 
        if(is_string($id_usuario))
            $this->view->erros .= " ".$id_usuario;
        
    }
    
    /***
     * Carrega a tela cadastro controle de acesso
     */
    public function cadastrarcontroleacessoAction()
    {
        $arrayCST = $this->filtroSetorCargoTipo();
        
        $this->view->arraySetor = $arrayCST['setor'];
        $this->view->arrayCargo = $arrayCST['cargo'];
        $this->view->arrayFuncionario_tipo = $arrayCST['tipo'];
        
    }
    
    /***
     * Carrega a tela editar controle de acesso
     */
    public function editarcontroleacessoAction()
    {
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($this->_request->getParam('idFuncionario', false));
        $this->view->id_usuario = $arrayIdUsuario[0]['id_usuario'];
        
        $this->view->nomeFuncionario = $this->_request->getParam('nomeFuncionario', false);
        
        $this->view->arrayIdGrupo = $this->_usuario_grupo->exibir($this->view->id_usuario);
        
        $this->view->arrayIdEmpresa = $this->_usuario_empresa_visivel->exibir($this->view->id_usuario);
        
        $this->view->arrayIdTime = $this->_usuario_time_visivel->exibir($this->view->id_usuario);
        
        $this->view->idFuncionario = $this->_request->getParam('idFuncionario', false);
            
    }
    
    /***
     * Deleta todas as permissoes do usario, junto com as empresas e times visiveis
     */
    public function deletarcontroleacessoAction() {
        $this->_helper->layout->disableLayout();
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($this->_request->getParam('idFuncionario', false));
        
        $this->_usuario_time_visivel->deletar($arrayIdUsuario);        
        $this->_usuario_empresa_visivel->deletar($arrayIdUsuario);
        $this->_usuario_funcionalidade->deletar($arrayIdUsuario);
        $this->_usuario_grupo->deletar($arrayIdUsuario);
        
        
    }
    
    /***
     * Gerencia o controle de acesso
     */
    public function gerenciarcontroleacessoAction() {
        
        $arrayCST = $this->filtroSetorCargoTipo();
        
        $this->view->arraySetor = $arrayCST['setor'];
        $this->view->arrayCargo = $arrayCST['cargo'];
        $this->view->arrayFuncionario_tipo = $arrayCST['tipo'];
        
    }
    
    /***
     * Cadastra empresa
     */
    public function cadastrarempresaAction()
    {
        $this->view->ramosEmpresa = $this->_ramo_empresa->fetchAll();
        $this->view->operadoras = $this->_operadora_celular->fetchAll();
        $this->view->categorias = $this->_categoria->fetchAll();
        
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
    
    /***
     * Carrega a tela cadastro controle de acesso
     */
    public function cadastrarfuncionarioAction()
    {
        $this->view->operadoras = $this->_operadora_celular->fetchAll();
          
    
    }
    
    public function indexAction()
    {
        
    }
    
    public function ajaxtesteAction()
    {
        if($this->_request->isPost())
        {
            $this->view->parametros = $this->_getAllParams();
//$this->_redirect($this->url(array('module' => 'sistema', 'controller' => 'logado', 'action' => 'cadastrarfuncionario'), null, 1));
        }    
    
    }
}



