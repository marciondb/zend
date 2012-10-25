<?php

class Application_Model_UsuarioTimeVisivel extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioTimeVisivel();
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
                    $this->save(array('id_usuario'=>$value['id_usuario'],'id_time'=>$value2['id_time']));
                }
            }
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao gravar a time visivel, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
   
       
}

