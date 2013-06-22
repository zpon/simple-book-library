<?php

/**
 * Created by JetBrains PhpStorm.
 * User: sjuul
 * Date: 4/27/13
 * Time: 11:48 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Library\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class BookCopy implements InputFilterAwareInterface {

    private $id;
    private $book_id;
    private $location_id;
    private $owner_id;
    private $condition;
    private $additional_id;
    private $comment;
    private $lost;
    private $location_name; // Not returned by getArrayCopy as it is not directly part of the table
    private $owner_name; // ditto
    private $loan;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->loan = new Loan;
        $this->loan->importData($data);
        $this->id = (isset($data['id']) ? $data['id'] : null);
        $this->book_id = (isset($data['book_id']) ? $data['book_id'] : null);
        $this->additional_id = (isset($data['additional_id']) ? $data['additional_id'] : "");
        $this->condition = (isset($data['condition']) ? $data['condition'] : null);
        $this->comment = (isset($data['comment']) ? $data['comment'] : null);
        $this->lost = (isset($data['lost']) ? $data['lost'] : null);
        $this->location_id = (isset($data['location_id']) ? $data['location_id'] : null);
        $this->location_name = (isset($data['location_name']) ? $data['location_name'] : null);
        $this->owner_id = (isset($data['owner_id']) ? $data['owner_id'] : null);
        $this->owner_name = (isset($data['owner_name']) ? $data['owner_name'] : null);
    }

    public function getId() {
        return $this->id;
    }

    public function getBookId() {
        return $this->book_id;
    }

    public function getLocationId() {
        return $this->location_id;
    }

    public function getAdditionalId() {
        return $this->additional_id;
    }

    public function getCondition() {
        switch ($this->condition) {
            case 1: return "Perfect";
            case 5: return "Good";
            case 10: return "Bad";
            case 15: return "Needs exchange";
        }
    }

    public function getLoanOutTo() {
        return $this->loan->getLoanOutTo();
    }
    
    public function getLoanObject() {
        return $this->loan;
    }

    public function setLoanOutTo($new_value) {
        $this->loan_out_to = $new_value;
    }

    public function getLocationName() {
        return $this->location_name;
    }
    
    public function getOwnerName() {
        return $this->owner_name;
    }

    public function isLost() {
        return $this->lost;
    }

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'book_id' => $this->book_id,
            'condition' => $this->condition,
            'additional_id' => $this->additional_id,
            'owner_id' => $this->owner_id,
            'location_id' => ($this->location_id == 0 ? NULL : $this->location_id),
            'comment' => $this->comment,
            'lost' => $this->lost,
        );
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'book_id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'location_id',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'additional_id',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 0,
                                    'max' => 65535,
                                ),
                            ),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'condition',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'Int',
                            ),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'comment',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 0,
                                    'max' => 65535,
                                ),
                            ),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'lost',
                        'required' => true,
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}