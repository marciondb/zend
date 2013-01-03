<?php

class Application_Model_Funcionario extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Funcionario();
    }
    
    /***
     * Grava o funcionario ou atualiza caso o parametro $update seja diferente de false.
     * @param array $parametros Array com os dados a serem gravados
     * @param Model [$_endereco] Model do endereco apenas se for salva e ou atualizar o endereco
     * @param boolean [$update] Atualiza caso o parametro $update seja diferente de false
     * @param string [$where] condicao
     */
    public function gravar($parametros,$_endereco = false, $update = FALSE, $where = FALSE,$id_funcionario=false)
    {
        $arrayFuncionario = $parametros;
        
        //retirando do array campos que não pertencem a tabela do BD
        unset($arrayFuncionario['module']);
        unset($arrayFuncionario['cpf']);
        unset($arrayFuncionario['controller']);
        unset($arrayFuncionario['action']);
        unset($arrayFuncionario['id_empresa']);
        unset($arrayFuncionario['arrayIdTempTime']);
        unset($arrayFuncionario['arrayIdTempEmpresa']);
        unset($arrayFuncionario['celular3']);
        unset($arrayFuncionario['dddCel3']);
        unset($arrayFuncionario['celular2']);
        unset($arrayFuncionario['dddCel2']);
        unset($arrayFuncionario['celular1']);
        unset($arrayFuncionario['dddCel1']);
        unset($arrayFuncionario['telefoneRes2']);
        unset($arrayFuncionario['dddTelRes2']);
        unset($arrayFuncionario['telefoneRes1']);
        unset($arrayFuncionario['dddTelRes1']);
        unset($arrayFuncionario['tipoEmpresa']);
        unset($arrayFuncionario['cep']);
        unset($arrayFuncionario['tipo_logradouro']);
        unset($arrayFuncionario['numero']);
        unset($arrayFuncionario['complemento']);
        unset($arrayFuncionario['bairro']);
        unset($arrayFuncionario['cidade']);
        unset($arrayFuncionario['estado']);
        unset($arrayFuncionario['referencia']);
        unset($arrayFuncionario['id_setor']);
        unset($arrayFuncionario['id_cargo']);
        unset($arrayFuncionario['id_funcionario_tipo']);
        unset($arrayFuncionario['temFilho']);
        unset($arrayFuncionario['status']);
        
        
        if(!$update)
        {
            $arrayEndereco = $parametros;

            $dataEndereco =   array("cep" => $arrayEndereco['cep'],
                                    "tipo_logradouro" => $arrayEndereco['tipo_logradouro'],
                                    "numero" => $arrayEndereco['numero'],
                                    "complemento" => $arrayEndereco['complemento'],
                                    "bairro" => $arrayEndereco['bairro'],
                                    "cidade" => $arrayEndereco['cidade'],
                                    "estado" => $arrayEndereco['estado'],
                                    "referencia" => $arrayEndereco['referencia']);
            try
            {
                $id_endereco = $_endereco->save($dataEndereco);
                //ZendUtils::transmissorMsg('Erro '.$id_endereco,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                $arrayFuncionario['id_endereco'] = $id_endereco;
                $id_funcionario = $this->save($arrayFuncionario);   
                return (int)$id_funcionario;

            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao cadastrar a Funcionário. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        else
        {
            try
            {   
                $id_funcionario = $id_funcionario;
                $id_funcionario = (int)$id_funcionario;
                
                //qdo for o atualizar do editar funcionario
                if(isset($arrayFuncionario['idFuncionario']))
                    $id_funcionario = $arrayFuncionario['idFuncionario'];
                
                unset($arrayFuncionario['idFuncionario']);
                unset($arrayFuncionario['nomeFuncionario']);
                unset($arrayFuncionario['atualizar']);
                unset($arrayFuncionario['email_empresa']);
                unset($arrayFuncionario['flagLotacao']);
                $this->save($arrayFuncionario,$update,$where);
                return (int)$id_funcionario;
            }
            catch(Exception $e)
            {
                ZendUtils::transmissorMsg('Erro ao atualizar o Funcionário. Tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
                return $e->getMessage();
            }
        }
        
        
    }
    
    /**
       * Exibe tds as funcionarios visiveis.      
       * @return Array retorna query()->fetchAll()
       * @version 1.0
       * @author Márcio & Marco
     */
    public function exibir($pagina,$listaIdEmpresa,$listaIdFuncionario,$listaIdTime,$idSetor,$idCargo,$idFuncionario_tipo,$listaIdFuncionarioEscolhido,$remover)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{           
            $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_funcionario','nome','apelido','tel_residencial_1','celular_1'))->
                    join('time','funcionario.id_time = time.id_time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',array('lotacao.data_hora'))->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',array('nome_fantasia'))->
                    join('usuario', 'funcionario.id_usuario = usuario.id_usuario',array('cpf'))->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1');
                    
            // Para melhor entendimento, vá em Controle de Acesso/Cadastrar tab Funcionário, 
            // na parte "Escolha os funcionários que receberão acessos".
            // Ao clicar em "+", o funcionário será removido da div atual e adicionado na div abaixo.
            // Atente para o "not in" no SQL
            if(!$remover)
            {
                if ($listaIdEmpresa)
                    $select->where('lotacao.id_empresa in (' . $listaIdEmpresa . ')');
                if ($listaIdTime)
                    $select->where('funcionario.id_time in (' . $listaIdTime . ')');
                if ($idSetor)
                    $select->where('lotacao.id_setor in (' . $idSetor . ')');
                if ($idCargo)
                    $select->where('lotacao.id_cargo in (' . $idCargo . ')');
                if ($idFuncionario_tipo)
                    $select->where('lotacao.id_funcionario_tipo in (' . $idFuncionario_tipo . ')');
                
                if ($listaIdFuncionarioEscolhido && $remover==0)
                    $select->where('funcionario.id_funcionario not in (' . $listaIdFuncionarioEscolhido . ')');
            }
            else
                $select->where('funcionario.id_funcionario in (' . $listaIdFuncionarioEscolhido . ')');

            $select->order('funcionario.nome ASC');
            $select->group('funcionario.id_funcionario');
            
            //ZendUtils::transmissorMsg('e'.$select,  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            if(!$remover)
                $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            //setMsg('ERRO','Erro ao selecionar a Funcionário, favor contactar Criweb<br>'.$e->getMessage(),0);
            ZendUtils::transmissorMsg('Erro ao selecionar a Funcionário, tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }
    
    /***
     * Pega a id do usuário passando a id do funcionário sem filtro de time.
     * @param lista $listaIdFuncionario Lista com as ids dos funcionarios 
     * separadas por vírgulas.
     * @return array Array fetchAll com todas as ids dos usuários
     * @example getIdUsuario('1,3,6')
     */
    public function getIdUsuarioSF($listaIdFuncionario)
    {
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_usuario'))->
                    where('funcionario.id_funcionario in (' . $listaIdFuncionario . ')');
        
        return $select->query()->fetchAll(); 
    }
    
    /**
       * Exibe tds os funcionarios os quais o usuario logado deu acesso.      
       * @return Array retorna query()->fetchAll()
       * @version 1.0
       * @author Márcio & Marco
     */
    public function exibirca($pagina,$listaIdEmpresa,$listaIdTime,$idSetor,$idCargo,$idFuncionario_tipo)
    {           
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $perPage = Zend_Registry::get('config')->paginator->totalItemPerPage;
        
        try{           
            $select1 = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_funcionario','nome','apelido','tel_residencial_1','celular_1'))->
                    join('time','funcionario.id_time = time.id_time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',array('lotacao.data_hora'))->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',array('nome_fantasia'))->
                    join('usuario_funcionalidade', 'usuario_funcionalidade.id_usuario = funcionario.id_usuario',null)->
                    join('usuario', 'funcionario.id_usuario = usuario.id_usuario',array('cpf'))->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('usuario_funcionalidade.id_usuario_pai = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1')->
                    where('funcionario.id_usuario <> ?', $arrayIdentity->id_usuario);
                    
            if ($listaIdEmpresa)
                $select1->where('lotacao.id_empresa in (' . $listaIdEmpresa . ')');
            if ($listaIdTime)
                $select1->where('funcionario.id_time in (' . $listaIdTime . ')');
            if ($idSetor)
                $select1->where('lotacao.id_setor in (' . $idSetor . ')');
            if ($idCargo)
                $select1->where('lotacao.id_cargo in (' . $idCargo . ')');
            if ($idFuncionario_tipo)
                $select1->where('lotacao.id_funcionario_tipo in (' . $idFuncionario_tipo . ')');
            
            $select2 = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_funcionario','nome','apelido','tel_residencial_1','celular_1'))->
                    join('time','funcionario.id_time = time.id_time',array('id_time','titulo'))->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',array('lotacao.data_hora'))->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',array('nome_fantasia'))->
                    join('usuario_grupo', 'usuario_grupo.id_usuario = funcionario.id_usuario',null)->
                    join('usuario', 'funcionario.id_usuario = usuario.id_usuario',array('cpf'))->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('usuario_grupo.id_usuario_pai = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1')->
                    where('funcionario.id_usuario <> ?', $arrayIdentity->id_usuario);
                    
            if ($listaIdEmpresa)
                $select2->where('lotacao.id_empresa in (' . $listaIdEmpresa . ')');
            if ($listaIdTime)
                $select2->where('funcionario.id_time in (' . $listaIdTime . ')');
            if ($idSetor)
                $select2->where('lotacao.id_setor in (' . $idSetor . ')');
            if ($idCargo)
                $select2->where('lotacao.id_cargo in (' . $idCargo . ')');
            if ($idFuncionario_tipo)
                $select2->where('lotacao.id_funcionario_tipo in (' . $idFuncionario_tipo . ')');
            
            $select = $this->_dbTable->
                  select()->
                  setIntegrityCheck(false)->
                  //Funcionario ou está em um grupo de acesso ou possui permissoes ou em ambos
                  union(array($select1,$select2));

            $select->order('nome ASC')->
                    group('funcionario.id_funcionario');
            
            
            $paginator = Zend_Paginator::factory( $select );
            $paginator->setCurrentPageNumber($pagina);
            $paginator->setItemCountPerPage($perPage);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao selecionar a Funcionário, tente novamente mais tarde. Caso o erro persista, entre em contato com a CRIWEB!<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
        
        
        return $paginator;
        
    }
    
    /***
     * Pega a id do usuário passando a id do funcionário.
     * @param lista $listaIdFuncionario Lista com as ids dos funcionarios 
     * separadas por vírgulas.
     * @return array Array fetchAll com todas as ids dos usuários
     * @example getIdUsuario('1,3,6')
     */
    public function getIdUsuario($listaIdFuncionario)
    {
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        
        $select = $this->_dbTable->
                    select()->
                    setIntegrityCheck(false)->
                    from('funcionario',array('id_usuario'))->
                    join('time','funcionario.id_time = time.id_time',null)->
                    join('usuario_time_visivel', 'time.id_time = usuario_time_visivel.id_time',null)->
                    join('lotacao', 'funcionario.id_funcionario = lotacao.id_funcionario',null)->
                    join('empresa', 'empresa.id_empresa = lotacao.id_empresa',null)->
                    where('usuario_time_visivel.id_usuario = ?', $arrayIdentity->id_usuario)->
                    where('lotacao.atual = 1')->
                    where('funcionario.id_funcionario in (' . $listaIdFuncionario . ')');
        //return $select;
        return $select->query()->fetchAll(); 
    }
    
    
    protected function _validarDados(array $data){
        // Validação
        //$erros = "";
        
        
        return true;
    }
       
}

