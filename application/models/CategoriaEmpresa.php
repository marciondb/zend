<?php

class Application_Model_CategoriaEmpresa extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_CategoriaEmpresa();
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
                $id_categoria_empresa = $this->save($parametros);    
                
                return (int)$id_categoria_empresa;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar a categoria, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
                ZendUtils::transmissorMsg('Erro ao atualizar a categoria. Tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
    }
    
    public function deletar($id_categoria_empresa)
    {
        try 
        {       
            $this->delete(array('id_categoria_empresa=?'=>$id_categoria_empresa));
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao apagar a categoria, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
                    from('categoria_empresa',array('id_categoria_empresa','titulo'));
            
            $select->order('categoria_empresa.titulo');
            //ZendUtils::transmissorMsg($select,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a categoria, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

