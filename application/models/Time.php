<?php

class Application_Model_Time extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Time();
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
                $id_time = $this->save($parametros);    
                
                return (int)$id_time;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar o time, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
                ZendUtils::transmissorMsg('Erro ao atualizar o time. Tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
    }
    
    public function deletar($id_time)
    {
        try 
        {       
            $this->delete(array('id_time=?'=>$id_time));
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao apagar o time, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
    public function exibir($pagina,$listaIdEmpresa,$listaIdTimesEscolhidos,$remover)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();      
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario);
            
            //Filtrar por empresa
            if($listaIdEmpresa)
                $select->where('time.id_empresa in ('.$listaIdEmpresa.')');
            
           if(!$remover)
            {
               //Não exibe os times com ids na lista
               if ($listaIdTimesEscolhidos)
                    $select->where('time.id_time not in (' . $listaIdTimesEscolhidos . ')');
            }
            else
                $select->where('time.id_time in (' . $listaIdTimesEscolhidos . ')');
            
            $select->group('usuario_time_visivel.id_time');
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            if(!$remover)
                $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar o Time, tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }


    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

