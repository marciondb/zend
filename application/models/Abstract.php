<?php

/***
 * Contem os métodos genéricos para todas as models do sistema
 * 
 */
abstract class Application_Model_Abstract {

    //tabela que será instanciada
    protected $_dbTable;
    //table do LOG
    protected $_dbTableLog;
    //id do usuario logado
    protected $_id_usuario;
    
    public function _init(){
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->_id_usuario = $arrayIdentity->id_usuario;
        
    }
    
    /***
     * Traz apenas um resgistro cuja id deve ser fornecida
     * @param  integer $id Id a qual sera feita a busca
     * @return array
     */
    public function find($id) {
        return $this->_dbTable->find($id)->current()->toArray();
    }
    
    /***
     * Salva o log da ativitade corrente
     * @param array $arrayPK Array com as PK das tabelas alteradas
     * @return nada
     */
    public function saveLog(array $arrayPK) {
        
        //cria uma instancia da table LOG
        $this->_dbTableLog = new Application_Model_DbTable_Log();
        
        //Logica para montar as PK's em uma variavel do tipo string
        $strPK='';        
        foreach ($arrayPK as $key ) {
            $strPK = $key.',';            
        }
        
        //retira o ultima virgula
        $strPK = substr($strPK, 0,-1);
        
        //monta o array a ser salvo
        $arrayIdentity = Zend_Auth::getInstance()->getIdentity();
        $id_usuario = $arrayIdentity->id_usuario;
        
        $data = array('id_usuario'=>$id_usuario,
                      'data_hora'=>date('Y-m-d H:i:s'),
                      'acao'=>Zend_Controller_Front::getInstance()->getRequest()->getActionName(),
                      'nome_tabela'=>  $this->_dbTable->getTableName(),
                      'valor_id'=>$strPK);
        
        try
        {
            //insere na talbe log
            $this->_dbTableLog->insert($data);
        }
        catch(Exception $e)
        {
            ZendUtils::transmissorMsg('Erro ao salvar o LOG, favor contactar Criweb<br>'.$e->getMessage(),  ZendUtils::MENSAGEM_ERRO,  ZendUtils::MENSAGEM_SEM_TEMPO);
        }
    }

    /***
     * Metodo generico para salvar ou atualizar
     * @param array $data Array com os dados a serem salvos ou atualizados
     * @param boolean $update Se true, ira fazer update, caso contrario, salva
     * @return array Array com as PK's
     */
    public function save(array $data, $update = FALSE, $where = FALSE) {

        $validacao = $this->_validarDados($data);
        $retorno = array();
        
        if (is_string($validacao))
            throw new Exception($validacao);
        else {
            if ($update) {
                $retorno = $this->_update($data,$where);
            } else {
                $retorno = $this->_insert($data);
            }
        }
        
        $retornoAux = $retorno;
        //Se a tabela tiver uma PK
        if(!is_array($retorno))
            $retorno = array($retorno);
        
        //lembrar que tem q modificar o Zend
        $this->saveLog($retorno);
        
        return $retornoAux;
    }
    
    public function _insert(array $data) {
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data,$where) {
        
        return $this->_dbTable->update($data,$where);
    }

    public function delete($arrayId) {
        return $this->_dbTable->delete($arrayId);
    }

    /***
     * Retorna todos registros que satisfazem as contiçoes
     * @param array [$conditions=null] condiçoes do where
     * @param String [$order] Para ter a opção de order by
     * basta passar a string com o order desejado, ex: "order by campo ASC"
     * @return array Retorna todos registros ordenados, que satisfazem as contiçoes
     */
    public function fetchAll(array $conditions=null,$order=null) {
        $select = $this->_dbTable->select();
        
        if (!is_null($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key.'=?', $condition);
            }
        }
        
        if (!is_null($order)) {
            $select->order($order);
        }
        
        return $select->query()->fetchAll();
    }

    public function search(array $params = null) {
        $str = isset($params['str']) ? $params['str'] : "";
        $page = isset($params['page']) ? (int) $params['page'] : 1;
        $conditions = isset($params['conditions']) ? $params['conditions'] : null;
        $perPage = isset($params['perpage']) 
                    ? (int) $params['perpage'] : Zend_Registry::get('config')->paginator->totalItemPerPage;
        $limit = ( $page - 1 ) * $perPage;
        $where = null;
        $select = $this->_dbTable->select();

        if (!empty($str)) {
            $select->where($filtro . " like '%" . $str . "%'" );
        }

        if (is_array($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key, $condition);
            }
        }

        if( !is_null($limit) || $limit != 0 )
            $select->limit( $perPage, $limit );

        $paginator = Zend_Paginator::factory( $select );
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($perPage);
        
        return $paginator;
    }

    public function fetchPairs( $conditions = null )
    {
        $select = $this->_dbTable->select();

        if (is_array($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key, $condition);
            }
        }

        return $this->_dbTable->getDefaultAdapter()->fetchPairs( $select );
    }
    
    /***
     * Toda model deve implementar esse método para validar os dados antes de salvar
     * @param array $data Dados a serem validados
     * @return boolean True se ok
     */
    abstract protected function _validarDados(array $data);
    
}
