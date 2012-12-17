<?php

class Application_Model_FuncionarioTipo extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_FuncionarioTipo();
    }
    
    /***
     * Atualiza caso o parametro $update seja diferente de false.
     * @param array $parametros Array com os dados a serem gravados
     */
    public function gravar($parametros, $update = FALSE,$where = false)
    {
        if(!$update)
        {
            try
            {                
                $id_funcionario_tipo = $this->save($parametros);    
                
                return (int)$id_funcionario_tipo;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar o tipo, tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            }
        } else
        {
            try
            {   
                //ZendUtils::transmissorMsg(print_r($parametros).$where,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                $this->save($parametros,true,$where);
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao atualizar o tipo. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
    }
    
    public function deletar($id_funcionario_tipo)
    {
        try 
        {       
            $this->delete(array('id_funcionario_tipo=?'=>$id_funcionario_tipo));
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao deletar o tipo, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    /**
       * Exibe tds os time visiveis do usuario logado.
       * @return Array retorna query()->fetchAll()
       * @param  int $pagina  : pagina atual, para a paginacao
       * @param  lista $listaIdEmpresa : lista com as id's das empresas a serem filtradas
       * @param  lista $listaIdTimesEscolhidos : lista com as id's dos times a serem filtradas.
       * @param  Booelan $remover: Se False, time.id_time not in (' . $listaIdTimesEscolhidos . ')');
       * se True time.id_time in (' . $listaIdTimesEscolhidos . ')');
       * @version 1.0
     */
    public function exibir($pagina)
    {                  
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario_tipo',array('id_funcionario_tipo','titulo'));
            
            $select->order('funcionario_tipo.titulo');
            //ZendUtils::transmissorMsg($select,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar o tipo, tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

