<?php

namespace Library\Form;

use \Zend\Form\Form;

class BookCopyForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('bookcopy');
    }

    public function init() {
        parent::init();

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'book_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'location_id',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'additional_id',
            'type' => 'Text',
            'options' => array(
                'label' => 'Alternative id for this copy',
            ),
        ));

        $this->add(array(
            'name' => 'condition',
            'type' => 'Select',
            'options' => array(
                'label' => 'Condition*',
                'value_options' => array(
                    '1' => "Perfect", 
                    '5' => "Good", 
                    '10' => "Bad", 
                    '15' => "Needs exchange",
                )
            ),
        ));

        $this->add(array(
            'name' => 'comment',
            'type' => 'Text',
            'options' => array(
                'label' => 'Comment',
            ),
        ));

        $this->add(array(
            'name' => 'lost',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Lost',
            ),
        ));

        $this->add(array(
            'name' => 'loan_out_to',
            'type' => 'Text',
            'options' => array(
                'label' => 'Loaned out to',
            ),
        ));

        $this->add(array(
            'name' => 'location_id',
            'type' => 'LocationSelect',
            'options' => array(
                'label' => 'Location',
            )
        ));
        
        $this->add(array(
            'name' => 'owner_id',
            'type' => 'OwnerSelect',
            'options' => array(
                'label' => 'Owner',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

}