<?php

namespace Library\Form;

use Zend\Form\Form;

class BookForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('book');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Title*',
            ),
        ));
        $this->add(array(
            'name' => 'author',
            'type' => 'Text',
            'options' => array(
                'label' => 'Author*',
            ),
        ));
        $this->add(array(
            'name' => 'summary',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Summary',
            ),
        ));
        $this->add(array(
            'name' => 'year',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Year*',
            ),
            'attributes' => array(
                'min' => 1000,
                'max' => 9999,
        )));
        $this->add(array(
            'name' => 'isbn',
            'type' => 'Text',
            'options' => array(
                'label' => 'ISBN',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }

}

?>
