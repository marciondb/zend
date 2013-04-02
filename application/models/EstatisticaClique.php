<?php

class Application_Model_EstatisticaClique extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_EstatisticaClique();
    }
    
    /***
     * Atualiza caso o parametro $update seja diferente de false.
     * @param array $parametros Array com os dados a serem gravados
     */
    public function gravar($id_oferta, $update = FALSE,$where = false)
    {
        if(!$update)
        {
            try
            {                
                $id_estatistica_clique = $this->save(array('id_oferta'=>$id_oferta,'data_hora'=> date('Y-m-d H:i:s')));    
                
                return (int)$id_estatistica_clique;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar a Estatistica, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
                ZendUtils::transmissorMsg('Erro ao atualizar a Estatistica. Tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
    }
    
    public function deletar($id_estatistica_clique)
    {
        try 
        {       
            $this->delete(array('id_estatistica_clique=?'=>$id_estatistica_clique));
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao apagar a Estatistica, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    /**
       * Exibe tds as ofertas clicadas
       * @return Array retorna query()->fetchAll()
       * @param  int $pagina  : pagina atual, para a paginacao
     */
    public function exibir($pagina,$id_empresa_user,$listaIdEmpresa)
    {                  
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('estatistica_clique',null)->
                    join('oferta','oferta.id_oferta = estatistica_clique.id_oferta',array('oferta.id_oferta','oferta.titulo','oferta.descricao','cliques'=>'count(oferta.id_oferta)'))->
                    where('oferta.id_empresa = ?',$id_empresa_user);
            
            if($listaIdEmpresa!=0)
                $select->where('oferta.id_empresa in (?)',$listaIdEmpresa);
            
            $select->order('oferta.id_oferta');
            $select->group('oferta.id_oferta');
            //ZendUtils::transmissorMsg($select,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Estatistica, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

