<?php

class Application_Model_UsuarioTimeVisivel extends Application_Model_Abstract
{
    
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioTimeVisivel();
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->_id_usuario = $arrayIdentity->id_usuario;
    }

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
            //ZendUtils::transmissorMsg('Erro ao gravar a time visivel, favor contactar Criweb<br>'.$e,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);            
            return $e->getMessage();
            
        }
    }
    
    public function deletar($array_id_usuario)
    {
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                $this->delete(array('id_usuario'=>(int)$value['id_usuario'],'id_usuario_pai'=>$this->_id_usuario));                 
            }
        }
        catch(Exception $e)
        {
            //ZendUtils::transmissorMsg('Erro ao deletar os times visiveis aos usuários, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
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

