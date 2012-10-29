<?php

class Application_Model_UsuarioEmpresaVisivel extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioEmpresaVisivel();
    }

    public function gravar($array_id_usuario,$array_id_empresa){
        
        if(!is_array($array_id_empresa))
        {
            $array_id_empresa_aux = explode(',', $array_id_empresa);
            $array_id_empresa = array();
            $cont=0;
            foreach ($array_id_empresa_aux as $value)
            {
                $array_id_empresa[$cont] = array('id_empresa'=>$value);
                $cont++;
            }
        }    
        
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                foreach ($array_id_empresa as $value2) 
                {
                    $this->save(array('id_usuario'=>$value['id_usuario'],'id_empresa'=>$value2['id_empresa']));
                }
            }
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao gravar a empresa visivel, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }    
    }

    public function deletar($array_id_usuario)
    {
        try 
        {
            foreach ($array_id_usuario as $value) 
            {
                 $this->delete('id_usuario='.(int)$value['id_usuario']);
            }
        }
        catch(Exception $e)
        {
            //ZendUtils::transmissorMsg('Erro ao deletar as empresas visiveis, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
   
       
}

