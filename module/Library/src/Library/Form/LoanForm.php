<?php

namespace Library\Form;

use \Zend\Form\Form;

class LoanForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('loan_outs');
    }

    public function init() {
        parent::init();

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'book_copy_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'loan_out_to',
            'type' => 'Text',
            'options' => array(
                'label' => 'Loaned out to',
            ),
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
?>
