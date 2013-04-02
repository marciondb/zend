<?php

class Application_Model_GrupoFuncionalidade extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_GrupoFuncionalidade();
    }
    
    /***
     * Salva as permissoes do usuario
     * @param int $idGrupo id do grupo que receberá as permissoes
     * @param array $id_funcionalidades Array com as funcionalidades
     * @param array $funcionalidade_editar Array com as funcionalidades editar
     * @param array $funcionalidade_deletar Array com as funcionalidades deletar
     * @param array $funcionalidade_liberar Array com as funcionalidades liberar
     * @param array $funcionalidade_pai Array com as funcionalidades pai
     * @param array $permissao Array com as permissoes do usuario logado, para fazer a validacao
     */
    public function gravar($idGrupo,$id_funcionalidades,$funcionalidade_editar,$funcionalidade_deletar,$funcionalidade_liberar,$funcionalidade_pai, $permissao)
    {      
        $this->_permissao = $permissao;
        $editar  = '';
        $deletar = '';
        $liberar = '';        
                
        try
        {            
            //Salva cada funcionalidade
            foreach ($id_funcionalidades as $key_funcionalidade) 
            {
                //Lembrando a estrutura da tabela grupo_funcionalidade, 
                //que é:id_grupo_de_acesso | id_funcionalidade | id_editar | id_deletar | id_liberar
                //Entao devemos salvar junto com cada funcionalidade, os ids das funcionalidades do LED (liberar, editar e deletar).

                //Cada funcionalidade no formulario de cadastro/editar de controle de acesso possui a funcionalidade pai mais o id da funcionalidade em si, nesta ordem.
                //Então retira a funcionalidade em si, que esta depois da virgula
                $key_funcionalidade = substr($key_funcionalidade,strpos($key_funcionalidade, ',')+1);

                //E retira as funcionalidades LED para a funcionalidade $key_funcionalidade 

                //procura a funcionalidade editar da funcionalidade $key_funcionalidade
                foreach ($funcionalidade_editar as $key_editar) 
                {
                    //Retirar o pai
                    $key_editar_pai = substr($key_editar,0,strpos($key_editar, ','));

                    //Verifica se a $key_funcionalidade é o pai
                    if($key_funcionalidade==$key_editar_pai)
                    {    
                        //monta a string com o id desta funcionalidade
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

                //$arrayFuncionalidade[$count] = array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_funcionalidade,'editar'=>$editar,'deletar'=>$deletar,'liberar'=>$liberar);
                //salva
                $this->save(array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_funcionalidade,'editar'=>$editar,'deletar'=>$deletar,'liberar'=>$liberar));

            }

            //Para cada um das funcionalidade do LED, devemos salva-la como uma permissao especifica
            // id_grupo_de_acesso   |id_funcionalidade | id_editar | id_deletar | id_liberar
            // id_grupo_de_acesso   |        0         |     0     |      0     |     0

            foreach ($funcionalidade_editar as $key_editar) 
            {
                if($key_editar != ",")
                {
                    $key_editar = substr($key_editar,strpos($key_editar, ',')+1);                   

                    //$arrayFuncionalidade[$count]= array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_editar,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_editar,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }
            }

            foreach ($funcionalidade_deletar as $key_deletar) 
            {
                if($key_deletar != ",")
                {
                    $key_deletar = substr($key_deletar,strpos($key_deletar, ',')+1);

                    //$arrayFuncionalidade[$count]= array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_deletar,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_deletar,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }
            }

            foreach ($funcionalidade_liberar as $key_liberar) 
            {
                if($key_liberar != ",")
                {
                    $key_liberar = substr($key_liberar,strpos($key_liberar, ',')+1);

                    //$arrayFuncionalidade[$count]= array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_liberar,'editar'=>0,'deletar'=>0,'liberar'=>0);
                    //$count++;
                    $this->save(array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$key_liberar,'editar'=>0,'deletar'=>0,'liberar'=>0));
                }
            }

            foreach ($funcionalidade_pai as $idPai) 
            {
                $idPai = substr($idPai,strpos($idPai, ',')+1);

                //$arrayFuncionalidade[$count]= array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$idPai,'editar'=>0,'deletar'=>0,'liberar'=>0);
                //$count++;
                $this->save(array('id_grupo_de_acesso'=>$idGrupo,'id_funcionalidade'=>$idPai,'editar'=>0,'deletar'=>0,'liberar'=>0));
            }
            // print_r($arrayFuncionalidade);
            
            
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao cadastrar a funcionalidade do grupo. Tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            return $e->getMessage();
        }
        
    }
    
    
    
    /***
     * Retorna todas as id's das funcionalidades do grupo, concatenadas por ","
     * @param Int $idGrupo Id do grupo
     * @return Lista Zero se não tiver funcionalidade ou
     * a lista com as funcionalidade
     */
    public function getIdFuncionalidade($idGrupo) {
        
        $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  from('grupo_funcionalidade', array('id_funcionalidade'))->
                  where('grupo_funcionalidade.id_grupo_de_acesso = ?', $idGrupo);
       
        
        $listaIdFuncionalidade = '';
        
        foreach ($select->query()->fetchAll() as $idFuncionalidade)
        {
            $listaIdFuncionalidade .= $idFuncionalidade['id_funcionalidade'].',';
        }    
        
        $listaIdFuncionalidade = substr($listaIdFuncionalidade,0,-1);
        
        if(!$select->query()->rowCount())
            return "0";
        else    
            return $listaIdFuncionalidade;
    }
    
    public function deletar($array)
    {
        try 
        {
                          
            $this->delete($array);
            
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao apagar o grupo de funcionalidade. Tente novamente mais tarde. Caso o erro persista, entre em contato com a o administrador!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }

    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

