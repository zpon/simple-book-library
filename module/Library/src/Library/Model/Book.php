<?php

namespace Library\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Book implements InputFilterAwareInterface {

    private $id;
    private $author;
    private $title;
    private $summary;
    private $year;
    private $isbn;
    private $copies_count;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->author = (isset($data['author'])) ? $data['author'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->year = (isset($data['year'])) ? $data['year'] : null;
        $this->summary = (isset($data['summary'])) ? $data['summary'] : null;
        $this->isbn = (isset($data['isbn'])) ? $data['isbn'] : null;
        $this->copies_count = (isset($data['copies_count']) ? $data['copies_count'] : 0);
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function getAuthor() {
        return $this->author;
    }
    
    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getYear() {
        return $this->year;
    }

    public function getISBN() {
        return $this->isbn;
    }
    
    public function getCopiesCount() {
        return $this->copies_count;
    }

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'year' => $this->year,
            'summary' => $this->summary,
            'isbn' => $this->isbn
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
                        'name' => 'author',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 65535,
                                ),
                            ),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'title',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 65535,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'isbn',
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
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'summary',
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
                                    'min' => 1,
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
