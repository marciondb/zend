<?php

class Application_Model_Empresa extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Empresa();
    }
    
    /***
     * Atualiza caso o parametro $update seja diferente de false.
     * @param array $parametros Array com os dados a serem gravados
     * @param Model $_endereco Model do endereco
     */
    public function gravar($parametros,$_endereco, $update = FALSE,$where=FALSE)
    {
        //ZendUtils::transmissorMsg('entrou!',  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);

        
        $dataEmpresa = array("id_matriz" => $parametros['id_matriz'],
                        "nome_fantasia" => $parametros['nome_fantasia'],
                        "razao_social" => $parametros['razao_social'],
                        "apelido" => $parametros['apelido'],
                        "id_ramo_empresa" => $parametros['id_ramo_empresa'],
                        "cnpj" => $parametros['cnpj'],
                        "inscricao_estadual" => $parametros['inscricao_estadual'],
                        "telefone_1" => $parametros['dddTel1'].$parametros['telefone_1'],
                        "telefone_2" => $parametros['dddTel2'].$parametros['telefone_2'],
                        "celular_1" => $parametros['dddCel1'].$parametros['celular_1'],
                        "id_operadora_celular" => $parametros['id_operadora_celular'],
                        "celular_2" => $parametros['dddCel2'].$parametros['celular_2'],
                        "id_operadora_celular2" => $parametros['id_operadora_celular2'],
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
                        "email_contato_2" => $parametros['email_contato_2'],
                        "tels_contato_2" => $parametros['dddTelTemp2'].$parametros['tels_contato_2'],
                        "cel_contato_2" => $parametros['dddCelTemp2'].$parametros['cel_contato_2'],
                        "id_operadora_celular_contato_2" => $parametros['id_operadora_celular_contato_2'],
                        "numero_de_funcionario" => $parametros['numero_de_funcionario'],
                        "ativo" => $parametros['ativo']
                        );            
            if(!$update)
            {    
                try
                {
                    $id_empresa = $this->save($dataEmpresa);

                    $dataEndereco = array("id_empresa" => $id_empresa,
                                "cep" => $parametros['cep'],
                                "tipo_logradouro" => $parametros['tipo_logradouro'],
                                "numero" => $parametros['numero'],
                                "complemento" => $parametros['complemento'],
                                "bairro" => $parametros['bairro'],
                                "cidade" => $parametros['cidade'],
                                "estado" => $parametros['estado'],
                                "referencia" => $parametros['referencia']);

                    $_endereco->save($dataEndereco);   

                    return $id_empresa;
                }
                catch(Exception $e)
                {
                    ZendUtils::transmissorMsg('Erro ao cadastrar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                }
            }
            else
            {
                try
                {
                    $id_empresa = (int)$parametros['idEmpresa'];
                    $this->save($dataEmpresa,$update,$where);

                    $dataEndereco = array("id_empresa" => $id_empresa,
                                "cep" => $parametros['cep'],
                                "tipo_logradouro" => $parametros['tipo_logradouro'],
                                "numero" => $parametros['numero'],
                                "complemento" => $parametros['complemento'],
                                "bairro" => $parametros['bairro'],
                                "cidade" => $parametros['cidade'],
                                "estado" => $parametros['estado'],
                                "referencia" => $parametros['referencia']);

                    $_endereco->save($dataEndereco,$update,$where);   

                    return $id_empresa;
                }
                catch(Exception $e)
                {
                    ZendUtils::transmissorMsg('Erro ao atualizar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                }
            }
        
    }
    
    /**
       * Exibe tds as empresas visiveis.      
       * @return Array retorna query()->fetchAll()
       * @param  Boolean $selecionar  : coloca um elemento checkbox para selecionar a empresa
       * @param  Boolean $editar : coloca um elemento um "botao" para pode editar
       * @param  Boolean $deletar : coloca um elemento um "botao" para pode deletar
       * @version 1.0
       * @author Márcio
     */
    public function exibir($pagina,$cnpj,$listaIdEmpresasEscolhidas,$remover,$tipoEmpresa)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('empresa',array('id_empresa','razao_social','nome_fantasia','apelido','cnpj','telefone_1','telefone_2'))->
                    join('usuario_empresa_visivel', 'empresa.id_empresa = usuario_empresa_visivel.id_empresa',null)->
                    where('usuario_empresa_visivel.id_usuario = ?', $arrayIdentity->id_usuario);
            
            // Filtrar por tipo de empresa ou exibir todas
            if($tipoEmpresa!=2){
                if($tipoEmpresa)
                    $select->where('empresa.id_matriz <> 0');
                else
                    $select->where('empresa.id_matriz = 0');
            }
            
            if($cnpj)
            {
                $cnpj = str_replace(".","",$cnpj);
		$cnpj = str_replace("-","",$cnpj);
		$cnpj = str_replace("/","",$cnpj);
                $select->where('empresa.cnpj = ? ',$cnpj);
            }
            
            if(!$remover)
            {
                if ($listaIdEmpresasEscolhidas)
                    $select->where('empresa.id_empresa not in (' . $listaIdEmpresasEscolhidas . ')');
            }
            else
                $select->where('empresa.id_empresa in (' . $listaIdEmpresasEscolhidas . ')');
            
            $select->group('empresa.id_empresa');
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            if(!$remover)
                $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }
    
    public function validaCnpj($nomeCampo,$valorCampo) {
        
        $select = $this->_dbTable->
                select()->
                setIntegrityCheck(false)->
                from('empresa')->
                where($nomeCampo.' = ?',$valorCampo);

        if(count($select->query()->fetchAll()))
            return 'Já existe uma empresa cadastrada para este '.strtoupper($nomeCampo).'!';
        else
            return "";
    }


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

