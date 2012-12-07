<?php

class Application_Model_GrupoDeAcesso extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_GrupoDeAcesso();
    }
    
    /***
     * Atualiza caso o parametro $update seja diferente de false.
     * @param array $parametros Array com os dados a serem gravados
     */
    public function gravar($parametros, $update = FALSE)
    {
        try
        {
            $id_grupo_de_acesso = $this->save($parametros);   

            return (int)$id_grupo_de_acesso;
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao cadastrar o Grupo de Acesso. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            return $e->getMessage();
        }
    }
    
    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
    
   
       
}

