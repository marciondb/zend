<?php

class Sistema_LogadoController extends Controller_Action
{

    protected $_empresa;
    
    protected $_endereco;
    
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
            $parametros = $this->_getAllParams();
            
            $dataEmpresa = array("id_matriz" => $parametros['id_matriz'],
                        "nome_fantasia" => $parametros['nome_fantasia'],
                        "razao_social" => $parametros['razao_social'],
                        "apelido" => $parametros['apelido'],
                        "cnpj" => $parametros['cnpj'],
                        "inscricao_estadual" => $parametros['inscricao_estadual'],
                        "telefone_1" => $parametros['dddTel1'].$parametros['telefone_1'],
                        "telefone_2" => $parametros['dddTel2'].$parametros['telefone_2'],
                        "celular_1" => $parametros['dddCel1'].$parametros['celular_1'],
                        "celular_2" => $parametros['dddCel2'].$parametros['celular_2'],
                        "fax_1" => $parametros['dddFax1'].$parametros['fax_1'],
                        "fax_2" => $parametros['dddFax2'].$parametros['fax_2'],
                        "email" => $parametros['email'],
                        "site" => $parametros['site'],
                        "orkut" => $parametros['orkut'],
                        "msn" => $parametros['msn'],
                        "twitter" => $parametros['twitter'],
                        "facebook" => $parametros['facebook'],
                        "skype" => $parametros['skype'],
                        "nome_contato_1" => $parametros['nome_contato_1'],
                        "tels_contato_1" => $parametros['dddTelTemp1'].$parametros['tels_contato_1'],
                        "cel_contato_1" => $parametros['dddCelTemp1'].$parametros['cel_contato_1'],
                        "id_operadora_celular_contato_1" => $parametros['id_operadora_celular_contato_1'],
                        "email_contato_1" => $parametros['email_contato_1'],
                        "nome_contato_2" => $parametros['nome_contato_2'],
                        "tels_contato_2" => $parametros['dddTelTemp2'].$parametros['tels_contato_2'],
                        "cel_contato_2" => $parametros['dddCelTemp2'].$parametros['cel_contato_2'],
                        "id_operadora_celular_contato_2" => $parametros['id_operadora_celular_contato_2'],
                        "email_contato_2" => $parametros['email_contato_2'],
                        "numero_de_funcionario" => $parametros['numero_de_funcionario'],
                        "ativo" => $parametros['ativo']
                        );
            
            try
            {
                $id_empresa = $this->_empresa->save($dataEmpresa);
            
            
                $dataEndereco = array("id_empresa" => $id_empresa,
                            "cep" => $parametros['cep'],
                            "rua_av" => $parametros['rua_av'],
                            "numero" => $parametros['numero'],
                            "complemento" => $parametros['complemento'],
                            "bairro" => $parametros['bairro'],
                            "cidade" => $parametros['cidade'],
                            "estado" => $parametros['estado'],
                            "referencia" => $parametros['referencia']);

                $this->_endereco->save($dataEndereco);   
                
                ZendUtils::transmissorMsg('Inserido com sucesso!',  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            //$this->_redirect("sistema/logado/index");
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            }
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



