<?php

    class SON_Form_Login extends Zend_Form #SON_Form_Decorator_MeuForm
    {
        public function init()
        {  
            $this->setName('login');
            $this->setAttrib('class', 'login');

            $email = new Zend_Form_Element_Text('email');
            $email->setLabel( 'E-mail:' )
                  ->setRequired(true)
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator('NotEmpty')
                  ->addValidator('EmailAddress')
                  ->setAttrib('class', 'input-mg')
                  ->setAttrib('title', 'Informe o e-mail');
                  //->setErrorMessages(array('message'=>"Erro de login"));
            $this->addElement($email);

            $password = new Zend_Form_Element_Password('password');
            $password->setLabel( 'Senha:' )
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty')
                    ->setAttrib('class', 'input-mg')
                    ->setAttrib('title', 'Informe a senha');
            $this->addElement($password);

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel( 'Entrar' )
                    ->setAttrib('class', 'botao-azul-p')
                    ->setAttrib('type', 'submit');
            $this->addElement($submit);
            

        }
    }