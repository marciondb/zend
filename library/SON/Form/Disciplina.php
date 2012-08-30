<?php

class SON_Form_Disciplina extends Zend_Form {

    public function init() {
        $this->setName('disciplina');
        $this->setAttrib( 'class', 'zend_form form-horizontal' );

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('title', 'Informe o nome');
        $this->addElement($nome);

        $users = new Application_Model_User();
        $professor = new Zend_Form_Element_Select('professor_id');
        $professor->setLabel('Professor:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setMultiOptions( array('' => '- selecione -') + $users->fetchPairs(
                        array( 'tipo = ?' => 2 )
                ) );
        $this->addElement($professor);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')
                ->setAttrib('class', 'btn btn-large btn-primary')
                ->setIgnore(true);
        $this->addElement($submit);
    }
}