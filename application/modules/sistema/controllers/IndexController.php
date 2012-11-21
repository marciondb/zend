<?php

/***
 * Chamada apenas para fazer o login, apos o login, toda a aplicacao fica com o 
 * controller logado
 */
class Sistema_IndexController extends Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        parent::init();
        
    }

    public function indexAction()
    {
        //Se ja esta logado, não deve ser exibido o formulario para login, logo sera redirecionado para /logado
        //caso tente acessar sistema/index diretamente
        $this->view->controller = $this->getRequest()->getControllerName();
    }
}