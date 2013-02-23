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
    
    public function ajaxnovacontaAction()
    {
        $this->_helper->layout->disableLayout();
        $parametros = $this->_getAllParams();
        
        $msg = "Pedido de aprovação:<br>";
        
        $msg += "nome :".$parametros['nome']."<br>";
        $msg += "email :".$parametros['email']."<br>";
        $msg += "cpf :".$parametros['cpf']."<br>";
        $msg += "cep_residencial :".$parametros['cep_residencial']."<br>";
        $msg += "numero_residencial :".$parametros['numero_residencial']."<br>";
        $msg += "nome_fantasia :".$parametros['nome_fantasia']."<br>";
        $msg += "razao_social :".$parametros['razao_social']."<br>";
        $msg += "cnpj :".$parametros['cnpj']."<br>";
        $msg += "cep_empresa :".$parametros['cep_empresa']."<br>";
        $msg += "numero_empresa :".$parametros['numero_empresa']."<br>";
        $msg += "breve :".$parametros['breve']."<br>";
        
        $mail = new Zend_Mail(); 
        $mail->setBodyHtml($msg);
        $mail->setFrom('consultores@marciondb.com.br', 'PF Ofertas');
        $mail->addTo('marciondb@gmail.com', 'marcio');
        $mail->setSubject('Pedido de aprovação.');
        $mail->send();
        
    }
    
}