<?php

class Application_Model_Oferta extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Oferta();
    }
    
    /***
     * Atualiza caso o parametro $update seja diferente de false.
     * @param array $parametros Array com os dados a serem gravados
     */
    public function gravar($parametros, $update = FALSE,$where = false)
    {
        unset($parametros['module']);
        unset($parametros['controller']);
        unset($parametros['action']);
        
        if(!$update)
        {
            try
            {                   
                $id_oferta = $this->save($parametros);    
                
                return (int)$id_oferta;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar a Oferta, tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            }
        } 
        else
        {
            try
            {                   
                unset($parametros['atualizar']);
                unset($parametros['id_oferta']);
                //ZendUtils::transmissorMsg(print_r($parametros).$where,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                $this->save($parametros,true,$where);
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao atualizar a oferta. Tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
    }
    
    public function deletar($id_oferta)
    {
        try 
        {       
            $this->delete(array('id_oferta=?'=>$id_oferta));
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao deletar a oferta, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
   
    public function exibir($pagina,$id_empresa_user,$lista_id_empresa=false)
    {                  
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('oferta',array('id_oferta','titulo','descricao'))->
                    where('oferta.id_empresa = ?',$id_empresa_user);
            
            $select->order('oferta.titulo');
            //ZendUtils::transmissorMsg($select,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Oferta, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        return $paginator;
        
    }
    
    /***
     * Exibe a oferta no mapa
     * @param decimal $latitude A latitude do centro de quem pesquisa
     * @param decimal $longitude A longitude do centro de quem pesquisa
     * @param int $raio Raio de busca, em metros
     */
    public function exibirOfertaMapa($latitude,$longitude,$raio,$id_categoria)
    {     
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('oferta')->
                    where("ACOS( COS( RADIANS( latitude ) ) * COS( RADIANS( '".$latitude."' )) * COS( RADIANS( longitude ) - RADIANS( '".$longitude."' )) + SIN( RADIANS( latitude ) ) * SIN( RADIANS( '".$latitude."' ) ) ) * 6380*1000 <= ".$raio);
            
            if( ($id_categoria!="") && ($id_categoria!=0))
                        $select->where('oferta.id_categoria_oferta ='.$id_categoria);
            
            return $select->query()->fetchAll();
            
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar as Ofertas, tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
    }
    

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

