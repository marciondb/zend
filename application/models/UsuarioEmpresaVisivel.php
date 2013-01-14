<?php

class Application_Model_UsuarioEmpresaVisivel extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioEmpresaVisivel();
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->_id_usuario = $arrayIdentity->id_usuario;
    }

    /***
     * Torna as empresas visiveis para os usuarios
     * @param array $array_id_usuario Array com as ids dos usuarios que verao as empresas
     * @param array/lista $array_id_empresa Array ou lista de ids concatenadas por "," com as ids das empresas
     */
    public function gravar($array_id_usuario,$array_id_empresa,$validar = true){
        //ZendUtils::transmissorMsg('id_empresa:'.$array_id_empresa['id_empresa'],  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
                    //ZendUtils::transmissorMsg('id_empresa:'.$value2.'id_usuario:'.$value['id_usuario'],  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                    if($validar)
                        $this->save(array('id_usuario'=>$value['id_usuario'],'id_empresa'=>$value2['id_empresa'],'id_usuario_pai'=>$this->_id_usuario));
                    else
                        $this->_insert(array('id_usuario'=>$value['id_usuario'],'id_empresa'=>$value2,'id_usuario_pai'=>$this->_id_usuario));
                }
            }
        }
        catch(Exception $e)
        {
            //ZendUtils::transmissorMsg('Erro ao gravar a empresa visivel, favor contactar o administrador<br>'.$e,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
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
            ZendUtils::transmissorMsg('Erro ao deletar as empresas visiveis, favor contactar o administrador<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
    /***
     * Exibe as empresas visiveis do usuario
     * @param int $idUsuario id do usuario
     * @return Array $select->query()->fetchAll();
     */
    public function exibir($idUsuario) {
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('usuario_empresa_visivel', 'usuario_empresa_visivel.id_empresa')->
                    where('usuario_empresa_visivel.id_usuario = ?',$idUsuario);
        $select->group('usuario_empresa_visivel.id_empresa');    
        return $select->query()->fetchAll();
    }


    protected function _validarDados(array $data){
        // Validação
        $erros = TRUE;        
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('usuario_empresa_visivel', 'usuario_empresa_visivel.id_empresa')->
                    where('usuario_empresa_visivel.id_usuario = ?',$this->_id_usuario)->
                    where('usuario_empresa_visivel.id_empresa = ?', $data['id_empresa']);
           
        if(!$select->query()->rowCount())
            $erros = "ERRO 171 - Empresa";
        
        return $erros;
    }
    
   
       
}

