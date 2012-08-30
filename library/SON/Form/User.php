<?php

class SON_Form_User extends Zend_Form {

    public function init() {
        $this->setName('user');
        $this->setAttrib( 'class', 'zend_form form-horizontal' );

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o nome');
        $this->addElement($nome);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o e-mail');
        $this->addElement($email);

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Senha:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o password');
        $this->addElement($password);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')
                ->setAttrib('class', 'btn btn-large btn-primary')
                ->setIgnore(true);
        $this->addElement($submit);
    }
}