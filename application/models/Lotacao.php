<?php

class Application_Model_Lotacao extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Lotacao();
    }
    
    /***
     * Salva usuario
     * @param int $id_funcionario Id do funcionario
     * @param string $cpf Cpf do funcionario
     * @param string $email Email do funcionario
     */
    public function gravar($parametros,$uptade= false){
        try{
            $id_lotacao = $this->save($parametros);
            return $id_lotacao;
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao cadastrar a Locatação do funcionário, tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }    
        
    }
    
    /**
       * Exibe tds as empresas visiveis.      
       * @return Array retorna query()->fetchAll()
       * @param  Boolean $selecionar  : coloca um elemento checkbox para selecionar a empresa
       * @param  Boolean $editar : coloca um elemento um "botao" para pode editar
       * @param  Boolean $deletar : coloca um elemento um "botao" para pode deletar
       * @version 1.0
       * @author Márcio & Marco
     */
    public function exibir($pagina)
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
            
            if($cnpj)
            {
                $cnpj = str_replace(".","",$cnpj);
		$cnpj = str_replace("-","",$cnpj);
		$cnpj = str_replace("/","",$cnpj);
                $select->where('empresa.cnpj = ? ',$cnpj);
            }
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

