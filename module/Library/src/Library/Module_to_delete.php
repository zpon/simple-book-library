<?php

namespace Library;

// Add these import statements:
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {

    // getAutoloaderConfig() and getConfig() methods here
    // Add this method:
    public function getServiceConfig() {
        return array(
            'factories' => array(
//                'Library\Model\LibraryTable' => function($sm) {
//                    $libraryGateway = $sm->get('LibraryTableGateway');
//                    $library = new AlbumTable($libraryGateway);
//                    return $library;
//                },
                'LibraryTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Book());
                    return new TableGateway('book', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}
