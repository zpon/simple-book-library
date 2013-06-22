<?php

namespace Library\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Loan implements InputFilterAwareInterface {

    private $id;
    private $book_copy_id;
    private $loan_out_to;
    private $start;
    private $stop;

    public function exchangeArray($data) {
        $this->id = (isset($data['id']) ? $data['id'] : null);
        $this->book_copy_id = (isset($data['book_copy_id']) ? $data['book_copy_id'] : null);
        $this->loan_out_to = (isset($data['loan_out_to']) ? $data['loan_out_to'] : null);
        $this->start = (isset($data['start']) ? $data['start'] : null);
        $this->stop = (isset($data['stop']) ? $data['stop'] : null);
        var_dump($this->getArrayCopy());
    }
    
    public function importData($data) {
        $this->id = (isset($data['loan_id']) ? $data['loan_id'] : null);
        $this->book_copy_id = (isset($data['loan_book_copy_id']) ? $data['loan_book_copy_id'] : null);
        $this->loan_out_to = (isset($data['loan_out_to']) ? $data['loan_out_to'] : null);
        $this->start = (isset($data['loan_start']) ? $data['loan_start'] : null);
        $this->stop = (isset($data['loan_stop']) ? $data['loan_stop'] : null);
    }

    public function getId() {
        return $this->id;
    }

    public function getBookCopyId() {
        return $this->book_copy_id;
    }

    public function getLoanOutTo() {
        return $this->loan_out_to;
    }

    public function getStart() {
        return $this->start;
    }

    public function setStartToNow() {
        $this->start = date('Y-m-d H:i:s');
    }

    public function getStop($stop) {
        return $stop;
    }

    public function setStopToNow() {
        $this->stop = date('Y-m-d H:i:s');
    }

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'book_copy_id' => $this->book_copy_id,
            'loan_out_to' => $this->loan_out_to,
            'start' => $this->start,
            'stop' => $this->stop,
        );
    }

    public function extract() {
        return $this->getArrayCopy();
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
                        'name' => 'book_copy_id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'loan_out_to',
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

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

?>
