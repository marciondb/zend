<?php

class Default_IndexController extends Zend_Controller_Action
{
    
    protected $_oferta;
    protected $_estatistica_clique;
    
    public function init()
    {
        /* Initialize action controller here */
         //*******************************************************************
        //  INICIO Instanciando os models, para poder utiliza os metodos relacionado 
        // a banco de dados
        //*******************************************************************
        
        $this->_oferta = new Application_Model_Oferta();
        $this->_estatistica_clique = new Application_Model_EstatisticaClique();
        
        
        //*******************************************************************
        //  FIM Instanciando os models, para poder utilizar os metodos relacionado 
        // a banco de dados
        //******************************************************************* 
        
    }

    public function indexAction()
    {        
        if($this->_request->getParam('android', false)){
            $this->view->lat = $this->_request->getParam('lat', 0);
            $this->view->lng = $this->_request->getParam('lng', 0); 
            $this->view->android = $this->_request->getParam('android', 0);
        }
         
    }
    
    public function ajaxmecbuscaAction()
    {
        //Desabilita o layout
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        
        $this->view->arrayOferta = $this->_oferta->exibirOfertaMapa($parametros['latitude'],
                                                                    $parametros['longitude'],
                                                                    $parametros['raio']);
    }
    
    public function ajaxgravaestatisticaAction()
    {
        //Desabilita o layout
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        $this->view->erros = "";
        
        $teste = $this->_estatistica_clique->gravar($parametros['id_oferta']);
        
        if(is_string($teste))
                $this->view->erros .= " ".$teste; 
    }


}

