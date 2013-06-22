<?php

namespace Library\Service;

use Zend\Config\Reader\Ini;
use Library\Module;

class BookLookup {
    private $accessKey = "KTYEWI5G";

    function __construct() {
        $reader = new Ini();
        $data = $reader->fromFile(__DIR__ . "/../../../config/booklookup.ini");
        $accessKey = $data['isbndb']['accesskey'];
    }

    function isbnLookup($isbn) {

        $result = array('title' => '',
                'author' => '',
                'summary' => '',
                'isbn' => '');

        $data = simplexml_load_file("http://isbndb.com/api/books.xml?access_key=$this->accessKey&results=texts&index1=isbn&value1=$isbn");

        $result['title'] = (string)$data->BookList->BookData->Title;
        $result['author'] = (string)$data->BookList->BookData->AuthorsText;
        $result['summary'] = (string)$data->BookList->BookData->Summary;
        $result['isbn'] = (string)$data->BookList->BookData['isbn13'];

        if(empty($result['isbn'])) {
            $result['isbn'] = (string)$data->BookList->BookData['isbn'];
        }

        return $result;
    }
}
