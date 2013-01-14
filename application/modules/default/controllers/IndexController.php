<?php

class Default_IndexController extends Zend_Controller_Action
{
    
    protected $_oferta;
    
    public function init()
    {
        /* Initialize action controller here */
         //*******************************************************************
        //  INICIO Instanciando os models, para poder utiliza os metodos relacionado 
        // a banco de dados
        //*******************************************************************
        
        $this->_oferta = new Application_Model_Oferta();
        
        
        //*******************************************************************
        //  FIM Instanciando os models, para poder utilizar os metodos relacionado 
        // a banco de dados
        //*******************************************************************   
    }

    public function indexAction()
    {
        
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


}

