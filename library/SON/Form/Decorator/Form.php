<?php

class SON_Form_Decorator_Form extends Zend_Form {

        protected $_formDecorator = array( 'FormElements', 'Fieldset', 'Form' );

        protected $_elementDecorator = array(
                'ViewHelper',
                'Errors',
                array( 'Description', array('tag' => 'p', 'class' => 'description') ),
                array( 'HtmlTag', array(
                     'tag' => 'div',
                     'class' => 'controls'
                ) ),
                array( 'Label', array('tag' => null , 'class' => 'control-label') ),
                array( array('row'=>'HtmlTag'), array('tag'=>'div', 'class' => 'control-group') )
        );

        protected $_submitDecorator = array();

        public function __construct( $options = null ) {
                parent::__construct( $options );

                $this->setAttrib( 'class', 'zend_form form-horizontal' );
                $this->setDecorators( $this->_formDecorator );
        }

        public function addDisplayGroup(array $elements, $name, $options = null) {

                parent::addDisplayGroup($elements, $name, $options);

                if( $name == 'action' ) {
                        $this->getDisplayGroup($name)
                                ->addDecorators( array(
                                        'FormElements',
                                        array(
                                            'HtmlTag',
                                            array('tag'=>'div', 'class' => 'form-actions ' . $this->_cssClassGroup)
                                        )
                                ) )
                                ->removeDecorator('DtDdWrapper');
                } else {
                        $this->getDisplayGroup($name)
                                ->addDecorators( array(
                                        'FormElements',
                                        array(
                                            'HtmlTag',
                                            array('tag'=>'div', 'class' => 'display-group ' . $this->_cssClassGroup)
                                        )
                                ) );
                }
        }

        public function addElement($element, $name = null, $options = null) {
                
                if( !is_string($element) ) {
                        $element->setDisableLoadDefaultDecorators(true);

                        if( ( $element instanceof Zend_Form_Element_Submit ) 
                                || ( $element instanceof Zend_Form_Element_Button ) 
                                || ( $element instanceof Zend_Form_Element_Reset ) ) {
                                $element->addDecorators( $this->_submitDecorator )
                                        ->removeDecorator('DtDdWrapper');
                        } else {
                                $element->addDecorators( $this->_elementDecorator );
                        }
                }

                parent::addElement($element, $name, $options);

                return $this;
        }
}