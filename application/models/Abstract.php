<?php

abstract class Application_Model_Abstract {

    protected $_dbTable;
    
    public function find($id) {
        return $this->_dbTable->find($id)->current()->toArray();
    }

    public function save(array $data, $update = FALSE) {

        $validacao = $this->_validarDados($data);

        if (is_string($validacao))
            throw new Exception($validacao);
        else {
            if ($update) {
                return $this->_update($data);
            } else {
                return $this->_insert($data);
            }
        }
    }
    
    public function _insert(array $data) {
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data) {
        return $this->_dbTable->update($data);
    }

    public function delete($id) {
        return $this->_dbTable->delete('id='.(int) $id);
    }

    /***
     * @param String $order Para ter a opção de order by
     * basta passar a string com o order desejado, ex: "order by campo ASC"
     */
    public function fetchAll($conditions=null,$order=null) {
        $select = $this->_dbTable->select();

        if (!is_null($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key, $condition);
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
    
    abstract protected function _validarDados(array $data);
    
}
