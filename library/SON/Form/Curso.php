<?php

class SON_Form_Curso extends Zend_Form {

    public function init() {
        $this->setName('curso');
        $this->setAttrib( 'class', 'zend_form form-horizontal' );

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o nome');
        $this->addElement($nome);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')
                ->setAttrib('class', 'btn btn-large btn-primary')
                ->setIgnore(true);
        $this->addElement($submit);
    }
}