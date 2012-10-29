<?php

class Application_Model_UsuarioFuncionalidade extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_UsuarioFuncionalidade();
    }
    
    public function gravar($arrayIdusuario,$id_funcionalidades,$funcionalidade_editar,$funcionalidade_deletar,$funcionalidade_liberar,$funcionalidade_pai, $update = FALSE)
    {      
        $editar  = '';
        $deletar = '';
        $liberar = '';        
                
        try
        {
            //$count=0;
            
            foreach ($arrayIdusuario as $key_usuario) 
            {
                foreach ($id_funcionalidades as $key_funcionalidade) 
                {
                    $key_funcionalidade = substr($key_funcionalidade,strpos($key_funcionalidade, ',')+1);
                    
                    foreach ($funcionalidade_editar as $key_editar) 
                    {
                        $key_editar_aux = substr($key_editar,0,strpos($key_editar, ','));

                        if($key_funcionalidade==$key_editar_aux)
                        {    
                            $editar = substr($key_editar,strpos($key_editar, ',')+1);
                            break;
                        }
                        else
                            $editar = '0';
                    }

                    foreach ($funcionalidade_deletar as $key_deletar) 
                    {
                        $key_deletar_aux = substr($key_deletar,0,strpos($key_deletar, ','));

                        if($key_funcionalidade==$key_deletar_aux)
                        {    
                            $deletar = substr($key_deletar,strpos($key_deletar, ',')+1);
                            break;
                        }
                        else
                            $deletar = '0';
                    }

                    foreach ($funcionalidade_liberar as $key_liberar) 
                    {
                        $key_liberar_aux = substr($key_liberar,0,strpos($key_liberar, ','));

                        if($key_funcionalidade==$key_liberar_aux)
                        {    
                            $liberar = substr($key_liberar,strpos($key_liberar, ',')+1);
                            break;
                        }
                        else
                            $liberar = '0';
                    }

                    //$arrayFuncionalidade[$count] = array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_funcionalidade,'editar'=>$editar,'deletar'=>$deletar,'liberar'=>$liberar);
                    //$count++;
                    $this->save(array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_funcionalidade,'editar'=>$editar,'deletar'=>$deletar,'liberar'=>$liberar));
                    
                }

                foreach ($funcionalidade_editar as $key_editar) 
                {
                    $key_editar = substr($key_editar,strpos($key_editar, ',')+1);                   

                    //$arrayFuncionalidade[$count]= array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_editar,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_editar,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }

                foreach ($funcionalidade_deletar as $key_deletar) 
                {
                    $key_deletar = substr($key_deletar,strpos($key_deletar, ',')+1);

                    //$arrayFuncionalidade[$count]= array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_deletar,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_deletar,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }

                foreach ($funcionalidade_liberar as $key_liberar) 
                {
                    $key_liberar = substr($key_liberar,strpos($key_liberar, ',')+1);

                    //$arrayFuncionalidade[$count]= array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_liberar,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$key_liberar,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }
                
                foreach ($funcionalidade_pai as $idPai) 
                {
                    $idPai = substr($idPai,strpos($idPai, ',')+1);

                    //$arrayFuncionalidade[$count]= array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$idPai,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_usuario'=>$key_usuario['id_usuario'],'id_funcionalidade'=>$idPai,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }
               // print_r($arrayFuncionalidade);
            }
            
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao cadastrar a funcionalidade do funcionário, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
    }
    
    /**
       * Exibe tds os Grupo de Funcionalidade visiveis.      
       * @return Array retorna query()->fetchAll()
       * @param  Boolean $selecionar  : coloca um elemento checkbox para selecionar a empresa
       * @param  Boolean $editar : coloca um elemento um "botao" para pode editar
       * @param  Boolean $deletar : coloca um elemento um "botao" para pode deletar
       * @version 1.0
       * @author Márcio & Marco
     */
    public function exibir($pagina,$cnpj,$listaIdEmpresasEscolhidas,$remover)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('empresa',array('id_empresa','razao_social','nome_fantasia','apelido','cnpj','telefone_1','telefone_2'))->
                    join('usuario_empresa_visivel', 'empresa.id_empresa = usuario_empresa_visivel.id_empresa',null)->
                    where('usuario_empresa_visivel.id_usuario = ?', $arrayIdentity->id_usuario);
            
            if($cnpj)
            {
                $cnpj = str_replace(".","",$cnpj);
		$cnpj = str_replace("-","",$cnpj);
		$cnpj = str_replace("/","",$cnpj);
                $select->where('empresa.cnpj = ? ',$cnpj);
            }
            
            if(!$remover)
            {
                if ($listaIdEmpresasEscolhidas)
                    $select->where('empresa.id_empresa not in (' . $listaIdEmpresasEscolhidas . ')');
            }
            else
                $select->where('empresa.id_empresa in (' . $listaIdEmpresasEscolhidas . ')');
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            if(!$remover)
                $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Empresa, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }
    
    public function getIdFuncionalidade($idGrupo) {
        
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('grupo_funcionalidade', array('id_funcionalidade'))->
                  where('grupo_funcionalidade.id_grupo_de_acesso = ?', $idGrupo);
       
        
        $arrayIdFuncionalidade = '';
        
        foreach ($select->query()->fetchAll() as $idFuncionalidade)
        {
            $arrayIdFuncionalidade .= $idFuncionalidade['id_funcionalidade'].',';
        }    
        
        $arrayIdFuncionalidade = substr($arrayIdFuncionalidade,0,-1);
        
        if(!$select->query()->rowCount())
            return "0";
        else    
            return $arrayIdFuncionalidade;
    }

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
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
            //echo "<script>setMsg('ERRO','Erro ao retirar as funcionalidades dos usuários, favor contactar Criweb<br>".$e->getMessage()."',1)</script>";            
            //ZendUtils::transmissorMsg('Erro ao retirar as funcionalidades dos usuários, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }
    
}

