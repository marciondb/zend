<?php

class Application_Model_UsuarioEmpresaVisivel extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioEmpresaVisivel();
    }

    public function gravar($array_id_usuario,$array_id_empresa){
        
        foreach ($array_id_usuario as $value) 
        {
            foreach ($array_id_empresa as $value2) 
            {
               //echo 'id_usuario'.$value['id_usuario'].'id_empresa'.$value2['id_empresa'];
               
                $this->save(array('id_usuario'=>$value['id_usuario'],'id_empresa'=>$value2['id_empresa']));
            }
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
   
       
}

