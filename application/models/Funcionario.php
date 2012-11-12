<?php

class Application_Model_Funcionario extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Funcionario();
    }
    
    /***
     * Atualiza caso o parametro $update seja diferente de false.
     * Recebe a PK do endereço inserido desta empresa.
     * @param array $parametros Array com os dados a serem gravados
     * @param Model $_endereco Model do endereco
     */
    public function gravar($parametros,$_endereco, $update = FALSE)
    {
        $dataFuncionario = array("id_matriz" => $parametros['id_matriz'],
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
                $id_empresa = $this->save($dataEmpresa);
            
                $dataEndereco = array("id_empresa" => $id_empresa,
                            "cep" => $parametros['cep'],
                            "rua_av" => $parametros['rua_av'],
                            "numero" => $parametros['numero'],
                            "complemento" => $parametros['complemento'],
                            "bairro" => $parametros['bairro'],
                            "cidade" => $parametros['cidade'],
                            "estado" => $parametros['estado'],
                            "referencia" => $parametros['referencia']);

                $_endereco->save($dataEndereco);   
                
                ZendUtils::transmissorMsg('Inserido com sucesso!',  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                
                return $id_empresa;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            }
        
    }
    
    /**
       * Exibe tds as funcionarios visiveis.      
       * @return Array retorna query()->fetchAll()
       * @version 1.0
       * @author Márcio & Marco
     */
    public function exibir($pagina,$listaIdEmpresa,$listaIdFuncionario,$listaIdTime,$idSetor,$idCargo,$idFuncionario_tipo,$listaIdFuncionarioEscolhido,$remover)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{           
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_funcionario','nome','apelido','cpf','tel_residencial_1','celular_1'))->
                    join('time','funcionario.id_time = time.id_time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',array('lotacao.data_hora'))->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',array('nome_fantasia'))->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1');
                    
            // Para melhor entendimento, vá em Controle de Acesso/Cadastrar tab Funcionário, 
            // na parte "Escolha os funcionários que receberão acessos".
            // Ao clicar em "+", o funcionário será removido da div atual e adicionado na div abaixo.
            // Atente para o "not in" no SQL
            if(!$remover)
            {
                if ($listaIdEmpresa)
                    $select->where('time.id_empresa in (' . $listaIdEmpresa . ')');
                if ($listaIdTime)
                    $select->where('funcionario.id_time in (' . $listaIdTime . ')');
                if ($idSetor)
                    $select->where('lotacao.id_setor in (' . $idSetor . ')');
                if ($idCargo)
                    $select->where('lotacao.id_cargo in (' . $idCargo . ')');
                if ($idFuncionario_tipo)
                    $select->where('lotacao.id_funcionario_tipo in (' . $idFuncionario_tipo . ')');
                
                if ($listaIdFuncionarioEscolhido && $remover==0)
                    $select->where('funcionario.id_funcionario not in (' . $listaIdFuncionarioEscolhido . ')');
            }
            else
                $select->where('funcionario.id_funcionario in (' . $listaIdFuncionarioEscolhido . ')');

            $select->order('funcionario.nome ASC');
            $select->group('funcionario.id_funcionario');
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            if(!$remover)
                $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            //setMsg('ERRO','Erro ao selecionar a Funcionário, favor contactar Criweb<br>'.$e->getMessage(),0);
            ZendUtils::transmissorMsg('Erro ao selecionar a Funcionário, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }
    
    /**
       * Exibe tds os funcionarios os quais o usuario logado deu acesso.      
       * @return Array retorna query()->fetchAll()
       * @version 1.0
       * @author Márcio & Marco
     */
    public function exibirca($pagina,$listaIdEmpresa,$listaIdTime,$idSetor,$idCargo,$idFuncionario_tipo)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{           
            $select1 = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_funcionario','nome','apelido','cpf','tel_residencial_1','celular_1'))->
                    join('time','funcionario.id_time = time.id_time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',array('lotacao.data_hora'))->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',array('nome_fantasia'))->
                    join('usuario_funcionalidade', 'usuario_funcionalidade.id_usuario = funcionario.id_usuario',null)->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('usuario_funcionalidade.id_usuario_pai = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1');
            if ($listaIdEmpresa)
                $select1->where('time.id_empresa in (' . $listaIdEmpresa . ')');
            if ($listaIdTime)
                $select1->where('funcionario.id_time in (' . $listaIdTime . ')');
            if ($idSetor)
                $select1->where('lotacao.id_setor in (' . $idSetor . ')');
            if ($idCargo)
                $select1->where('lotacao.id_cargo in (' . $idCargo . ')');
            if ($idFuncionario_tipo)
                $select1->where('lotacao.id_funcionario_tipo in (' . $idFuncionario_tipo . ')');
            
            $select2 = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_funcionario','nome','apelido','cpf','tel_residencial_1','celular_1'))->
                    join('time','funcionario.id_time = time.id_time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',array('lotacao.data_hora'))->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',array('nome_fantasia'))->
                    join('usuario_grupo', 'usuario_grupo.id_usuario = funcionario.id_usuario',null)->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('usuario_grupo.id_usuario_pai = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1');
            if ($listaIdEmpresa)
                $select2->where('time.id_empresa in (' . $listaIdEmpresa . ')');
            if ($listaIdTime)
                $select2->where('funcionario.id_time in (' . $listaIdTime . ')');
            if ($idSetor)
                $select2->where('lotacao.id_setor in (' . $idSetor . ')');
            if ($idCargo)
                $select2->where('lotacao.id_cargo in (' . $idCargo . ')');
            if ($idFuncionario_tipo)
                $select2->where('lotacao.id_funcionario_tipo in (' . $idFuncionario_tipo . ')');
            
            $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  union(array($select1,$select2));

            $select->order('nome ASC')->
                    group('funcionario.id_funcionario');
            
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Funcionário, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }
    
    /***
     * Pega a id do usuário passando a id do funcionário.
     * @param lista $listaIdFuncionario Lista com as ids dos funcionarios 
     * separadas por vírgulas.
     * @return array Array fetchAll com todas as ids dos usuários
     * @example getIdUsuario('1,3,6')
     */
    public function getIdUsuario($listaIdFuncionario)
    {
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_usuario'))->
                    join('time','funcionario.id_time = time.id_time',null)->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',null)->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',null)->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1')->
                    where('funcionario.id_funcionario in (' . $listaIdFuncionario . ')');
        return $select->query()->fetchAll(); 
    }

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

