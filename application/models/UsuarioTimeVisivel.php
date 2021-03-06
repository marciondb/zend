<?php

class Application_Model_UsuarioTimeVisivel extends Application_Model_Abstract
{
    
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioTimeVisivel();
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->_id_usuario = $arrayIdentity->id_usuario;
    }

    /***
     * Salva os usarios em um ou mais times visiveis
     * @param array $arrayIdUsuario Array com os ids dos usuarios
     * @param array/lista $array_id_time Array ou lista, separada por ",", com as ids dos times
     */
    public function gravar($array_id_usuario,$array_id_time)
    {
        
        if(!is_array($array_id_time))
        {
            $array_id_time_aux = explode(',', $array_id_time);
            $array_id_time = array();
            $cont=0;
            foreach ($array_id_time_aux as $value)
            {
                $array_id_time[$cont] = array('id_time'=>$value);
                $cont++;
            }
        }    
        
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                foreach ($array_id_time as $value2) 
                {
                    $this->save(array('id_usuario'=>$value['id_usuario'],'id_usuario_pai'=>$this->_id_usuario,'id_time'=>$value2['id_time']));
                }
            }
            
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao gravar a time visivel, favor contactar o administrador<br>'.$e,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);            
            return $e->getMessage();
            
        }
    }
    
    public function deletar($array_id_usuario)
    {
        try 
        {
            foreach ($array_id_usuario as $value) 
            {               
                $this->delete(array('id_usuario=?'=>(int)$value['id_usuario'],'id_usuario_pai=?'=>$this->_id_usuario));
            }
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao apagar os times visiveis aos usuários, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    
    public function deletarPorTime($id_time)
    {
        try 
        {           
            $this->delete(array('id_time=?'=>$id_time));
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao apagar os times visiveis, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    /***
     * Exibe tds os times visiveis do usuario
     * @param int $idUsuario Id do usario a ser pesquisado
     * @return Array $select->query()->fetchAll();
     */
        public function exibir($idUsuario) {
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('usuario_time_visivel', 'usuario_time_visivel.id_time')->
                    where('usuario_time_visivel.id_usuario = ?',$idUsuario);
        $select->group('usuario_time_visivel.id_time');
           
        return $select->query()->fetchAll();
    }
    
    protected function _validarDados(array $data){
        // Validação
        $erros = TRUE;        
       
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('usuario_time_visivel', 'usuario_time_visivel.id_time')->
                    where('usuario_time_visivel.id_usuario = ?',$this->_id_usuario)->
                    where('usuario_time_visivel.id_time = ?', $data['id_time']);
           
        if(!$select->query()->rowCount())
            $erros = "ERRO 171 - Time";
        
        return $erros;
    }
    
   
       
}

