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
    protected $_area;
    protected $_categoria_oferta;
    protected $_foco;
    protected $_oferta;
    protected $_estatistica_clique;
    
    
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
        $this->_familia = new Application_Model_Familia();
        $this->_usuario = new Application_Model_Usuario();
        $this->_ramo_empresa = new Application_Model_RamoEmpresa();
        $this->_operadora_celular = new Application_Model_OperadoraCelular();
        $this->_categoria = new Application_Model_CategoriaEmpresa();
        $this->_lotacao = new Application_Model_Lotacao();
        $this->_area = new Application_Model_Area();
        $this->_foco = new Application_Model_Foco();
        $this->_oferta = new Application_Model_Oferta();
        $this->_estatistica_clique = new Application_Model_EstatisticaClique();
        $this->_categoria_oferta = new Application_Model_CategoriaOferta();
        
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
        $this->view->temEvento  = $this->_request->getParam('temEvento', false); //evento + funcao; ex: onchange="setFiltroFuncionario();"
        $this->view->nomeSetor  = $this->_request->getParam('nomeSetor', false); //nome, q tb será o msm o da id, do campo
        
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
                                                            $this->_request->getParam('tipoEmpresa', false));
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
     * Toda vez que tiver a necessidade de exibir algum utilitario, esta action deverá
     * ser chamada
     * action generica!
     */
    public function ajaxutilitarioAction()
    {
        /*if(!$this->getRequest()->isXmlHttpRequest())
            $this->_redirect ("sistema/logado");*/
        $this->_helper->layout->disableLayout();
        
        
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        $this->view->idUtilitario    = $this->_request->getParam('idUtilitario', false);
        
        $parametros = $this->_getAllParams();
        
        $idUtilitario = (int)$parametros['idUtilitario'];
        
        if($idUtilitario==1){
            $this->view->arrayUtilitario = $this->_area->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'area';
        }    
        if($idUtilitario==2){
            $this->view->arrayUtilitario = $this->_cargo->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'cargo';
        }   
        if($idUtilitario==3){
            $this->view->arrayUtilitario = $this->_categoria->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'categoria_empresa';
        }   
        if($idUtilitario==4){
            $this->view->arrayUtilitario = $this->_familia->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'familia';
        }   
        if($idUtilitario==5){
            $this->view->arrayUtilitario = $this->_funcionario_tipo->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'funcionario_tipo';
        }   
        if($idUtilitario==6){
            $this->view->arrayUtilitario = $this->_ramo_empresa->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'ramo_empresa';
        }   
        if($idUtilitario==7){
            $this->view->arrayUtilitario = $this->_setor->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'setor';
        }   
        if($idUtilitario==8){
            $this->view->arrayUtilitario = $this->_foco->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'foco';
        }
        if($idUtilitario==9){
            $this->view->arrayUtilitario = $this->_operadora_celular->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'operadora_celular';
        }
        
        if($idUtilitario==10){
            $this->view->arrayUtilitario = $this->_categoria_oferta->exibir($this->_request->getParam('pagina', 1));
            $this->view->tabela = 'categoria_oferta';
        }
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
                                                $this->_request->getParam('remover', 0),
                                                $this->_request->getParam('ehCA', false));
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
     * Verifica se já exite um usuario com cpf e login fornecidos pelo formulario
     */
    public function ajaxvalidausuarioAction() {
        $this->_helper->layout->disableLayout();
        
        $cpf = $this->_request->getParam('cpf', false);
        $email = $this->_request->getParam('email', false);
        $this->view->erroCPF = "";
        $this->view->sucessoCPF = "";
        $this->view->erroEMAIL = "";
        $this->view->sucessoEMAIL = "";
        
        if($cpf){
            $this->view->erroCPF = $this->_usuario->validaCampoUnico('cpf',$cpf);
            if( $this->view->erroCPF == "")
                $this->view->sucessoCPF = "CPF disponível para cadastro.";    
        }
        
        if($email){
            $this->view->erroEMAIL = $this->_usuario->validaCampoUnico('login',$email);  
            if( $this->view->erroEMAIL == "")
                $this->view->sucessoEMAIL = "E-MAIL disponível para cadastro.";
        }
           
        
        
    }
    
    /***
     * Verifica se já exite uma empresa com mesmo cnpj
     */
    public function ajaxvalidaempresaAction() {
        $this->_helper->layout->disableLayout();
        
        $cnpj = $this->_request->getParam('cnpj', false);
        
        $this->view->erroCNPJ = "";
        $this->view->sucessoCNPJ = "";
                
        if($cnpj){
            $this->view->erroCNPJ = $this->_empresa->validaCnpj('cnpj',$cnpj);
            if( $this->view->erroCNPJ == "")
                $this->view->sucessoCNPJ = '<i class="icon-asterisk"></i>';    
        }
        else
            $this->view->sucessoCNPJ = '<i class="icon-asterisk"></i>';
        
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
        
        $segmd5 = date('His');
        
        if(!$this->possuiPermissao('cadastrarfuncionario'))
            $this->_redirect ("sistema/logado");
        
        $this->view->erros = '';
                
        $parametros = $this->_getAllParams();
        
        $id_funcionario = '';
        $id_funcionario = (int)$id_funcionario;
        
        //se for atualizar
        if(isset($parametros['idFuncionario']))
            $id_funcionario = $parametros['idFuncionario'];
        
        //salva ou atualiza o funcionario e pega a id
        $id_funcionario = $this->_funcionario->gravar($parametros, $this->_endereco,$this->_request->getParam('atualizar', false),'id_funcionario='.$id_funcionario,$id_funcionario);      
                
        //salva ou atualiza o usuario e pega o id
        $id_usuario = $this->_usuario->gravar($id_funcionario,$parametros['cpf'],$parametros['email_empresa'],$parametros['status'],$this->_request->getParam('atualizar', false),'id_funcionario='.$id_funcionario,$segmd5);
        
        if(!$this->_request->getParam('atualizar', false))
        {
            //atualiza o funcionario com a id do usuario
            $this->_funcionario->gravar(array('id_funcionario'=>$id_funcionario,'id_usuario'=>$id_usuario),'',true,'id_funcionario='.$id_funcionario);
        } 
        
        $id_lotacao = 0;        
        //salva a lotacao do funcionario 
        if( ($this->_request->getParam('flagLotacao', false) && $this->_request->getParam('atualizar', false)) || ( !$this->_request->getParam('atualizar', false) ) )
        {        
            //atualiza a lotacao e depois grava
            if($this->_request->getParam('atualizar', false))            
                $this->_lotacao->gravar(array('atual'=>'0'),true,'id_funcionario='.$id_funcionario);
            
            //grava uma nova lotacao
            $id_lotacao = $this->_lotacao->gravar(array('id_funcionario'=>$id_funcionario,
                                                    'id_empresa'=>$parametros['id_empresa'],
                                                    'id_cargo'=>$parametros['id_cargo'],
                                                    'id_setor'=>$parametros['id_setor'],
                                                    'id_funcionario_tipo'=>$parametros['id_funcionario_tipo'],
                                                    'data_hora'=>date('Y-m-d H:i:s'),
                                                    'atual'=>'1'));
        }
        
       $id_lotacao = (int)$id_lotacao;
       $flag = 1;
       
        //se houver erro, passa para a view.
        if(is_string($id_lotacao)){
            $this->view->erros .= " ".$id_lotacao;
            $flag = 0;
        }    
        if(is_string($id_funcionario)){
            $this->view->erros .= " ".$id_funcionario;
            $flag = 0;
        } 
        if(is_string($id_usuario)){
            $this->view->erros .= " ".$id_usuario;
            $flag = 0;
        } 
        
        if($flag){
            
            $msg = "Olá ".$parametros['nome'].", seja bem-vindo(a), agora você 
                já pode acessar o nosso sistema administrativo, basta clicar no link 
                <a href='http://177.71.184.187/sistema'>Acessar</a>
                <br>
                Sua senha temporária é: ".$segmd5.", para altera-la, basta ir no 
                menu utilitário, alterar senha.
                <br>( caso não consiga clicar no link, basta 
                copiar o seguinte endereço e colar na barra de endereço de seu 
                navegador: http://177.71.184.187/sistema)";
            
            $mail = new Zend_Mail(); 
            $mail->setBodyHtml($msg);
            $mail->setFrom('consultores@marciondb.com.br', 'PF Ofertas');
            $mail->addTo($parametros['email_empresa'], $parametros['nome']);
            $mail->setSubject('Bem-vindo ao Sistema Administrativo.');
            $mail->send();
        }
        
        
    }
    
    public function ajaxgravaempresaAction() {
        
        $this->_helper->layout->disableLayout();
        
        if(!$this->possuiPermissao('cadastrarempresa') || !$this->possuiPermissao('editarempresa'))
            $this->_redirect ("sistema/logado");
        
        $this->view->erros = '';
        $teste = '';
        
        $parametros = $this->_getAllParams();        

        //salva a empresa e pega o id
        if($this->_request->getParam('atualizar', false))
        {
            $this->_empresa->gravar($parametros,$this->_endereco,$this->_request->getParam('atualizar', false),'id_empresa='.$parametros['idEmpresa']);
        }    
        else
        {
            $array_id_empresa = array('id_empresa'=>$this->_empresa->gravar($parametros,$this->_endereco));
        
            //pega tds os id´s de td´s os usuarios que pertecem ao grupo dos administradores
            $id_grupo = 1; //Grupo dos administradores
            $array_id_usuario_admin = $this->_usuario_grupo->getArrayIdUsuarioGrupo($id_grupo);
            //para colocar a empresa salva na lista de empresas visiveis do grupo administrador
            $this->_usuario_empresa_visivel->gravar($array_id_usuario_admin,$array_id_empresa, false);
        }                
        
    }
    
    
    /***
     * grava as funcionalidades do grupo de aceso
     */
    public function ajaxgravagrupoAction()
    {
        $this->_helper->layout->disableLayout();
        
        if(!$this->possuiPermissao('cadastrargrupoacesso') || !$this->possuiPermissao('editargrupoacesso'))
            $this->_redirect ("sistema/logado");
        
        $this->view->erros = '';
        $teste = '';
                
        $parametros = $this->_getAllParams();
        
        //Se tiver idGrupo, significa q esta no editar, entao deve-se deletar
        if(isset($parametros['idGrupo'])){
            
            //deleta o grupo de acesso
            $teste = $this->_grupo_de_acesso->gravar(array('nome'=>$parametros['nome']),true,'id_grupo_de_acesso='.$parametros['idGrupo']);
            if(is_string($teste))
                $this->view->erros .= " ".$teste;

            $id_grupo = $parametros['idGrupo'];

            // deleta o usuario logado ao grupo criado
            $teste = $this->_usuario_grupo->deletarTodosGrupo(array('id_grupo_de_acesso=?'=>$id_grupo));

            if(is_string($teste))
                $this->view->erros .= " ".$teste;

            // deleta as funcionalidade ao grupo
            $teste = $this->_grupo_funcionalidade->deletar(array('id_grupo_de_acesso=?'=>$id_grupo));
            if(is_string($teste))
                $this->view->erros .= " ".$teste;/**/
            
        }
        else
        {
            //salva o grupo de acesso
            $teste = $this->_grupo_de_acesso->gravar(array('nome'=>$parametros['nome']));
            if(is_string($teste))
                $this->view->erros .= " ".$teste;

            $id_grupo = $teste;
        }
        
        
        // Inserir o usuario logado ao grupo criado
        $teste = $this->_usuario_grupo->gravarNovo(array('id_usuario'=>$this->_id_usuario,'id_usuario_pai'=>$this->_id_usuario,'id_grupo_de_acesso'=>$id_grupo));
        
        
        if(is_string($teste))
            $this->view->erros .= " ".$teste;
       
        // Inserir as funcionalidade ao grupo
        $teste = $this->_grupo_funcionalidade->gravar($id_grupo, $parametros['id_funcionalidades'],(isset($parametros['funcionalidade_editar']))?$parametros['funcionalidade_editar']:array('funcionalidade_editar'=>','),(isset($parametros['funcionalidade_deletar'])?$parametros['funcionalidade_deletar']:array('funcionalidade_deletar'=>',')),(isset($parametros['funcionalidade_liberar'])?$parametros['funcionalidade_liberar']:array('funcionalidade_liberar'=>',')),$parametros['idPai'],$this->_permissoes);
        if(is_string($teste))
            $this->view->erros .= " ".$teste;/**/
                
    }
    
    public function ajaxgravatimeAction() {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        $teste = "";
        //Se é editar
        if(isset($parametros['idTime']))
        {
            $id_time=$parametros['idTime'];
            $this->_time->gravar(array('id_funcionario_lider'=>$parametros['id_funcionario_lider'],
                                    'id_empresa'=>$parametros['id_empresa'],
                                    'id_setor'=>$parametros['id_setor_funcionario'],
                                    'titulo'=>$parametros['titulo'],
                                    'descricao'=>$parametros['descricao']), true, 'id_time='.$id_time);
            
            // Tira todos os usuários do time, para inserir os selecionados agora
            $this->_usuario_time_visivel->deletarPorTime($id_time);
            $this->_funcionario->gravar(array('id_time'=>'0'), false, true, 'id_time='.$id_time);
            $id_time=(int)$parametros['idTime'];
            
        } else
        {
            $id_time = $this->_time->gravar(array('id_funcionario_lider'=>$parametros['id_funcionario_lider'],
                                    'id_empresa'=>$parametros['id_empresa'],
                                    'id_setor'=>$parametros['id_setor_funcionario'],
                                    'titulo'=>$parametros['titulo'],
                                    'descricao'=>$parametros['descricao']));
        }

        //pega as ids de usuario dos funcionarios
        $arrayIdUsuario = $this->_funcionario->getIdUsuarioSF(substr($parametros['arrayIdTempFuncionarioEscolhido'],1,-1));           
        
        if(is_string($id_time))
            $this->view->erros .= " ".$id_time;
       
        $cont=0;
        foreach ($arrayIdUsuario as $value) 
        {
            if($value['id_usuario']==$this->_id_usuario){
                unset($arrayIdUsuario[$cont]);
                break;
            }
            $cont++;
        }
        //add o time ao times visiveis do usuario logado
        $this->_usuario_time_visivel->_insert(array('id_usuario'=>$this->_id_usuario,'id_usuario_pai'=>$this->_id_usuario,'id_time'=>$id_time));        
        
        //add o time ao times visiveis dos usuario escolhidos
        $teste = $this->_usuario_time_visivel->gravar($arrayIdUsuario, $id_time);
        
        //se houver erro, passa para a view.
        if(is_string($teste))
            $this->view->erros .= " ".$teste;
        
        $arrayFuncionario = $parametros['arrayIdTempFuncionarioEscolhido'];
        $arrayFuncionario = substr($arrayFuncionario, 1,-1);
        $arrayFuncionario = explode(',', $arrayFuncionario);
        
        foreach ($arrayFuncionario as $idFuncionario) {
            $this->_funcionario->gravar(array('id_time'=>$id_time),
                                        false,
                                        true,
                                        'id_funcionario ='.$idFuncionario);
        }
        
    }
    
    /***
     * grava o utilitario
     */
    public function ajaxgravautilitarioAction() {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        $teste = 0;
        
        $idUtilitario = (int)$parametros['idUtilitario'];
        
        $idTabela = '';
        if(isset($parametros['idTabela']))
            $idTabela = $parametros['idTabela'];
        
        if($idUtilitario==1)
            $teste = $this->_area->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_area='.$idTabela);
        if($idUtilitario==2)
            $teste = $this->_cargo->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_cargo='.$idTabela);
        if($idUtilitario==3)
            $teste = $this->_categoria->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_categoria_empresa='.$idTabela);
        if($idUtilitario==4)
            $teste = $this->_familia->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_familia='.$idTabela);
        if($idUtilitario==5)
            $teste = $this->_funcionario_tipo->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_funcionario_tipo='.$idTabela);
        if($idUtilitario==6)
            $teste = $this->_ramo_empresa->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_ramo_empresa='.$idTabela);
        if($idUtilitario==7)
            $teste = $this->_setor->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_setor='.$idTabela);
        if($idUtilitario==8)
            $teste = $this->_foco->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_foco='.$idTabela);
        if($idUtilitario==9)
            $teste = $this->_operadora_celular->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_operadora_celular='.$idTabela);
        if($idUtilitario==10)
            $teste = $this->_categoria_oferta->gravar(array('titulo'=>strtoupper($parametros['titulo'])),$this->_request->getParam('atualizar', false),'id_categoria_oferta='.$idTabela);
        
        //$teste = $this->_area->gravar(array('titulo'=>$parametros['titulo']));
        //se houver erro, passa para a view.
        //ZendUtils::transmissorMsg(print_r($parametros).var_dump($teste),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        if(is_string($teste))
            $this->view->erros .= " ".$teste;
        
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
     * Carrega a tela cadastro controle de acesso
     */
    public function cadastrarfuncionarioAction()
    {
        $this->view->operadoras = $this->_operadora_celular->fetchAll();
        $this->view->categorias = $this->_categoria->fetchAll();
          
    
    }
    
    /***
     * Carrega a tela editar funcionario
     */
    public function editarfuncionarioAction()
    {               
        $this->view->operadoras = $this->_operadora_celular->fetchAll();
        $this->view->categorias = $this->_categoria->fetchAll();
        $this->view->nomeFuncionario = $this->_request->getParam('nomeFuncionario', false);        
        $this->view->idFuncionario   = $this->_request->getParam('idFuncionario', false);
        
        $this->view->arrayFuncionario = $this->_funcionario->fetchAll(array('id_funcionario'=>$this->_request->getParam('idFuncionario')));
        $this->view->arrayEndereco    = $this->_endereco->fetchAll(array('id_endereco'=>$this->view->arrayFuncionario[0]['id_endereco']));
        $arrayUsuario                 = $this->_usuario->fetchAll(array('id_funcionario'=>$this->_request->getParam('idFuncionario')));
        $this->view->cpf              = $arrayUsuario[0]['cpf'];
        $this->view->status           = $arrayUsuario[0]['status'];
        $this->view->arrayLotacao     = $this->_lotacao->fetchAll(array('id_funcionario'=>$this->_request->getParam('idFuncionario'),'atual'=>'1'));
        $this->view->arrayEmpresa     = $this->_empresa->fetchAll(array('id_empresa'=>$this->view->arrayLotacao[0]['id_empresa']));
        $this->view->arrayTime        = $this->_time->fetchAll(array('id_time'=>$this->view->arrayFuncionario[0]['id_time']));
            
    }
    
    /***
     * Deleta todas as informacoes do funcionario
     */
    public function deletarfuncionarioAction() {
        $this->_helper->layout->disableLayout();
        $arrayIdUsuario = $this->_funcionario->getIdUsuario($this->_request->getParam('idFuncionario', false));
        
        $this->_usuario_time_visivel->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));        
        $this->_usuario_empresa_visivel->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));
        $this->_usuario_funcionalidade->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));
        $this->_usuario_grupo->delete(array('id_usuario=?'=>(int)$arrayIdUsuario['id_usuario']));
        
        $this->_lotacao->delete(array('id_funcionario=?'=>(int)$this->_request->getParam('idFuncionario')));
        
        $this->view->arrayFuncionario = $this->_funcionario->fetchAll(array('id_funcionario'=>$this->_request->getParam('idFuncionario')));
        $this->view->arrayEndereco    = $this->_endereco->fetchAll(array('id_endereco'=>$this->view->arrayFuncionario[0]['id_endereco']));
        
        $this->_endereco->delete(array('id_endereco=?'=>(int)$this->view->arrayEndereco[0]['id_endereco']));
        $this->_funcionario->delete(array('id_funcionario=?'=>(int)$this->_request->getParam('idFuncionario')));/**/
        
        /*********************************************/
        // deletar os demais dados a medida que
        // as novas ferramentas forem implementadas
        /*********************************************/
        
    }
    
    /***
     * Gerencia o funcionario
     */
    public function gerenciarfuncionarioAction() {
        
        $arrayCST = $this->filtroSetorCargoTipo();
        
        $this->view->arraySetor = $arrayCST['setor'];
        $this->view->arrayCargo = $arrayCST['cargo'];
        $this->view->arrayFuncionario_tipo = $arrayCST['tipo'];
        
        $arrayLED = $this->getLED('gerenciarfuncionario');
                
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
        
    }
    
    /***
     * Cadastra empresa
     */
    public function cadastrarempresaAction()
    {
        $this->view->ramosEmpresa = $this->_ramo_empresa->fetchAll();
        $this->view->operadoras = $this->_operadora_celular->fetchAll();
        $this->view->categorias = $this->_categoria->fetchAll();
    }
    
     /***
     * Gerencia a empresa
     */
    public function gerenciarempresaAction() {
        

        $arrayLED = $this->getLED('gerenciarempresa');
                
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
        
    }
    
    /***
     * Carrega a tela editar funcionario
     */
    public function editarempresaAction()
    {               
        $this->view->nomeEmpresa = $this->_request->getParam('nomeEmpresa', false);        
        $this->view->idEmpresa   = $this->_request->getParam('idEmpresa', false); 
        
        $this->view->arrayEmpresa = $this->_empresa->fetchAll(array('id_empresa'=>$this->_request->getParam('idEmpresa')));
        $this->view->arrayEndereco    = $this->_endereco->fetchAll(array('id_empresa'=>$this->_request->getParam('idEmpresa')));
        
        $this->view->nomeMatriz   = $this->_empresa->fetchAll(array('id_empresa'=>$this->view->arrayEmpresa[0]['id_matriz']));
        
        $this->view->ramosEmpresa = $this->_ramo_empresa->fetchAll();
        $this->view->operadoras = $this->_operadora_celular->fetchAll();
        $this->view->categorias = $this->_categoria->fetchAll();
        
    }
    
    /***
     * Deleta todas as informacoes da empresa
     */
    public function deletarempresaAction() {
        $this->_helper->layout->disableLayout();
        
        $this->_endereco->delete(array('id_empresa=?'=>(int)$this->_request->getParam('idEmpresa')));
        $arrayIdFuncionario = $this->_lotacao->getFuncionarios($this->_request->getParam('idEmpresa'));
               
        foreach ($arrayIdFuncionario as $funcionario){
            $arrayIdUsuario = $this->_funcionario->getIdUsuarioSF($funcionario['id_funcionario']);            
            $arrayFuncionario = $this->_funcionario->fetchAll(array('id_funcionario'=>$funcionario['id_funcionario']));            
            
            $this->_usuario_time_visivel->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));        
            $this->_usuario_empresa_visivel->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));
            $this->_usuario_funcionalidade->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));
            $this->_usuario_grupo->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));
            $this->_usuario->delete(array('id_usuario=?'=>(int)$arrayIdUsuario[0]['id_usuario']));

            $this->_lotacao->delete(array('id_funcionario=?'=>(int)$funcionario['id_funcionario']));
            $this->_endereco->delete(array('id_endereco=?'=>(int)$arrayFuncionario[0]['id_endereco']));
            $this->_funcionario->delete(array('id_funcionario=?'=>(int)$funcionario['id_funcionario']));
        }
        
        $this->_empresa->delete(array('id_empresa=?'=>(int)$this->_request->getParam('idEmpresa')));     
    }
    
    
    /***
     * Cadastrar grupo de acesso
     */
    public function cadastrargrupoacessoAction() {
        
        
        
    }
    
    /***
     * Editar grupo de acesso
     */
    public function editargrupoacessoAction() {
        
        $this->view->nomeGrupo = $this->_request->getParam('nomeGrupo', false);        
        $this->view->idGrupo   = $this->_request->getParam('idGrupo', false);
        
        $this->view->listaIdFuncionalidade = $this->_grupo_funcionalidade->getIdFuncionalidade($this->view->idGrupo);
        
    }
    
    /***
     * Gerenciar grupo de acesso
     */
    public function deletargrupoacessoAction() {
        
        $id_grupo = $this->_request->getParam('idGrupo', false);
        //deleta o grupo de acesso
        $teste = $this->_grupo_de_acesso->deletar(array('id_grupo_de_acesso=?'=>$id_grupo));
        if(is_string($teste))
            $this->view->erros .= " ".$teste;

        $id_grupo = $parametros['idGrupo'];

        // deleta o usuario logado ao grupo criado
        $teste = $this->_usuario_grupo->deletarTodosGrupo(array('id_grupo_de_acesso=?'=>$id_grupo));

        if(is_string($teste))
            $this->view->erros .= " ".$teste;

        // deleta as funcionalidade ao grupo
        $teste = $this->_grupo_funcionalidade->deletar(array('id_grupo_de_acesso=?'=>$id_grupo));
        if(is_string($teste))
            $this->view->erros .= " ".$teste;
        
    }
    
    /***
     * Gerenciar grupo de acesso
     */
    public function gerenciargrupoacessoAction() {
        
        $arrayLED = $this->getLED('gerenciargrupoacesso');
                
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
        
        
    }
    
    /***
     * Cadastrar time
     */
    public function cadastrartimeAction() {
        
        
        
    }
    
    /***
     * Cadastrar time
     */
    public function editartimeAction() {
        
        $this->view->nomeTime = $this->_request->getParam('nomeTime', false);        
        $this->view->idTime   = $this->_request->getParam('idTime', false);
        
        $this->view->arrayFuncionario = $this->_funcionario->fetchAll(array('id_time'=>$this->_request->getParam('idTime')));
        $this->view->arrayTime = $this->_time->fetchAll(array('id_time'=>$this->_request->getParam('idTime')));
        $this->view->arrayEmpresa     = $this->_empresa->fetchAll(array('id_empresa'=>$this->view->arrayTime[0]['id_empresa']));
    }
    
    /***
     * Gerenciar time
     */
    public function gerenciartimeAction() {
        $arrayLED = $this->getLED('gerenciartime');
                
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
        
        
    }
    
    /***
     * Deletar time
     */
    public function deletartimeAction() {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        
        $idTime = $parametros['idTime'];

        $this->_time->deletar($idTime);
        $this->_usuario_time_visivel->deletarPorTime($idTime);
        $this->_funcionario->gravar(array('id_time'=>0), false, true, 'id_time='.$idTime);
    }
    
    /***
     * Cadastrar Utilitarios: Area, cargo, categoria_empresa,familia, foco, funcionario_tipo,
     * ramo_empresa e setor
     */
    public function cadastrarutilitarioAction() {
        
        $parametros = $this->_getAllParams();
        
        $idUtilitario = $parametros['idUtilitario'];
        
        $this->view->idUtilitario = $idUtilitario;
        
        if($idUtilitario==1)
            $this->view->nomeUtilitario = 'Área';
        if($idUtilitario==2)
            $this->view->nomeUtilitario = 'Cargo';
        if($idUtilitario==3)
            $this->view->nomeUtilitario = 'Categoria';
        if($idUtilitario==4)
            $this->view->nomeUtilitario = 'Família';
        if($idUtilitario==5)
            $this->view->nomeUtilitario = 'Tipo';
        if($idUtilitario==6)
            $this->view->nomeUtilitario = 'Ramo';
        if($idUtilitario==7)
            $this->view->nomeUtilitario = 'Setor';
        if($idUtilitario==8)
            $this->view->nomeUtilitario = 'Foco';
        if($idUtilitario==9)
            $this->view->nomeUtilitario = 'Operadora';
        if($idUtilitario==10)
            $this->view->nomeUtilitario = 'Categoria Oferta';
        
    }
    
    /***
     * Cadastrar Utilitarios: Area, cargo, categoria_empresa,familia, foco, funcionario_tipo,
     * ramo_empresa e setor
     */
    public function editarutilitarioAction() {
        
        $parametros = $this->_getAllParams();
        
        $idUtilitario = $parametros['idUtilitario'];
        
        $this->view->idUtilitario = $idUtilitario;
        $this->view->idTabela = $parametros['idTabela'];
        $this->view->titulo = $parametros['titulo'];
        
        if($idUtilitario==1)
            $this->view->nomeUtilitario = 'Área';
        if($idUtilitario==2)
            $this->view->nomeUtilitario = 'Cargo';
        if($idUtilitario==3)
            $this->view->nomeUtilitario = 'Categoria';
        if($idUtilitario==4)
            $this->view->nomeUtilitario = 'Família';
        if($idUtilitario==5)
            $this->view->nomeUtilitario = 'Tipo';
        if($idUtilitario==6)
            $this->view->nomeUtilitario = 'Ramo';
        if($idUtilitario==7)
            $this->view->nomeUtilitario = 'Setor';
        if($idUtilitario==8)
            $this->view->nomeUtilitario = 'Foco';
        if($idUtilitario==9)
            $this->view->nomeUtilitario = 'Operadora';
        if($idUtilitario==10)
            $this->view->nomeUtilitario = 'Categoria Oferta';
        
    }
    
    /***
     * Gerenciar utilitario
     */
    public function gerenciarutilitarioAction() {
        $parametros = $this->_getAllParams();
        $idUtilitario = $parametros['idUtilitario'];
        $arrayLED = $this->getLED('gerenciarutilitario/idUtilitario/'.$idUtilitario);
        
        $this->view->idUtilitario = $idUtilitario;        
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
        
        if($idUtilitario==1)
            $this->view->nomeUtilitario = 'Área';
        if($idUtilitario==2)
            $this->view->nomeUtilitario = 'Cargo';
        if($idUtilitario==3)
            $this->view->nomeUtilitario = 'Categoria';
        if($idUtilitario==4)
            $this->view->nomeUtilitario = 'Família';
        if($idUtilitario==5)
            $this->view->nomeUtilitario = 'Tipo';
        if($idUtilitario==6)
            $this->view->nomeUtilitario = 'Ramo';
        if($idUtilitario==7)
            $this->view->nomeUtilitario = 'Setor';
        if($idUtilitario==8)
            $this->view->nomeUtilitario = 'Foco';
        if($idUtilitario==9)
            $this->view->nomeUtilitario = 'Operadora';
        if($idUtilitario==10)
            $this->view->nomeUtilitario = 'Categoria Oferta';
        
        
    }
    
    /***
     * Deletar utilitario
     */
    public function deletarutilitarioAction() {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        $idUtilitario = $parametros['idUtilitario'];
        $idTabela = $parametros['idTabela'];
        
        if($idUtilitario==1){
            $this->_area->deletar($idTabela);
            $this->view->tabela = 'area';
        }    
        if($idUtilitario==2){
            $this->_cargo->deletar($idTabela);
            $this->view->tabela = 'cargo';
        }   
        if($idUtilitario==3){
            $this->_categoria->deletar($idTabela);
            $this->view->tabela = 'categoria_empresa';
        }   
        if($idUtilitario==4){
            $this->_familia->deletar($idTabela);
            $this->view->tabela = 'familia';
        }   
        if($idUtilitario==5){
            $this->_funcionario_tipo->deletar($idTabela);
            $this->view->tabela = 'funcionario_tipo';
        }   
        if($idUtilitario==6){
            $this->_ramo_empresa->deletar($idTabela);
            $this->view->tabela = 'ramo_empresa';
        }   
        if($idUtilitario==7){
            $this->_setor->deletar($idTabela);
            $this->view->tabela = 'setor';
        }   
        if($idUtilitario==8){
            $this->_foco->deletar($idTabela);
            $this->view->tabela = 'foco';
        }        
        if($idUtilitario==9){
            $this->_operadora_celular->deletar($idTabela);
            $this->view->tabela = 'operadora_celular';
        }
        if($idUtilitario==10){
            $this->_categoria_oferta->deletar($idTabela);
            $this->view->tabela = 'categoria_oferta';
        }
    }
    
    public function ajaxgravaofertaAction() {
        
        $this->_helper->layout->disableLayout();
        
        if(!$this->possuiPermissao('cadastraroferta') || !$this->possuiPermissao('editaroferta'))
            $this->_redirect ("sistema/logado");
        
        $this->view->erros = '';
        $id_oferta = '';
        
        $parametros = $this->_getAllParams();        

        //salva a oferta
        if($this->_request->getParam('atualizar', false))
            $id_oferta = $this->_oferta->gravar($parametros,$parametros['atualizar'],'id_oferta='.$parametros['id_oferta']);
        else
            $id_oferta = $this->_oferta->gravar($parametros);
        
        if(is_string($id_oferta))
            $this->view->erros .= " ".$id_oferta;
                        
        
    }
    
    public function ajaxofertaAction() {
        
        $this->_helper->layout->disableLayout();        
             
        $parametros = $this->_getAllParams(); 
        
        $this->view->editar     = $this->_request->getParam('editar', false);
        $this->view->deletar    = $this->_request->getParam('deletar', false);
        
        $array_id_funcionario = $this->_usuario->getIdFuncionario($this->_id_usuario);
        $arrayLotacao     = $this->_lotacao->fetchAll(array('id_funcionario'=>$array_id_funcionario[0]['id_funcionario'],'atual'=>'1'));
        $id_empresa_user       = $arrayLotacao[0]['id_empresa'];
        
       $this->view->arrayOferta = $this->_oferta->exibir($this->_request->getParam('pagina', 1),
                                                        1);//$id_empresa_user); 
        
    }
    
    /***
     * Cadastrar ofertas no site
     */
    public function cadastrarofertaAction() {
                       
        $array_id_funcionario = $this->_usuario->getIdFuncionario($this->_id_usuario);
        $this->view->arrayLotacao     = $this->_lotacao->fetchAll(array('id_funcionario'=>$array_id_funcionario[0]['id_funcionario'],'atual'=>'1'));
        $this->view->id_empresa       = $this->view->arrayLotacao[0]['id_empresa'];
        $this->view->categoria_oferta = $this->_categoria_oferta->fetchAll();
                
    }
    
    public function gerenciarofertaAction() {
        $arrayLED = $this->getLED('gerenciaroferta');
                
        $this->view->editar     = isset($arrayLED['editar'])?$arrayLED['editar']:false;
        $this->view->deletar    = isset($arrayLED['deletar'])?$arrayLED['deletar']:false;
    }
    
    /***
     * Editar oferta
     */
    public function editarofertaAction() {
        
        $parametros = $this->_getAllParams();
        $this->view->categoria_oferta = $this->_categoria_oferta->fetchAll();
        $this->view->arrayOferta     = $this->_oferta->fetchAll(array('id_oferta'=>$parametros['idOferta']));
        
    }   
    
    public function deletarofertaAction() {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        
        $this->_oferta->deletar($parametros['idOferta']);
    }
    
    public function indexAction()
    {
        
    }
    
    public function ajaxestatisticaAction()
    {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        
        $array_id_funcionario = $this->_usuario->getIdFuncionario($this->_id_usuario);
        $arrayLotacao     = $this->_lotacao->fetchAll(array('id_funcionario'=>$array_id_funcionario[0]['id_funcionario'],'atual'=>'1'));
        $id_empresa_user  = $arrayLotacao[0]['id_empresa'];
        
        $this->view->arrayEstatistica = $this->_estatistica_clique->exibir($this->_request->getParam('pagina', 1),
                                                            $id_empresa_user,
                                                            $this->_request->getParam('listaIdEmpresasEscolhidas', 0));
        
    }
    
    public function relestatisticacliqueAction()
    {
        
    }
    
    public function alterarsenhaAction()
    {
        
    }
    
    public function ajaxalterarsenhaAction()
    {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        
        $teste = $this->_usuario->alterarSenha($parametros['senha'],$this->_id_usuario);
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