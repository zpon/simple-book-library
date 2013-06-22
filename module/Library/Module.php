<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Library;

use Library\Model\Book;
use Library\Model\LibraryTable;
use Library\Model\Location;
use Library\Model\LocationTable;
use Library\Model\Owner;
use Library\Model\OwnerTable;
use Library\Form\LocationSelect;
use Library\Form\OwnerSelect;
use \Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements FormElementProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Library\Model\LibraryTable' => function($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $hydrator = new \Zend\Stdlib\Hydrator\ArraySerializable;

                    return new LibraryTable($adapter, $hydrator, new Book(), 'book');
                },
                'Library\Model\LocationTable' => function($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $hydrator = new \Zend\Stdlib\Hydrator\ArraySerializable;

                    return new LocationTable($adapter, $hydrator, new Location(), 'location');
                },
                'Library\Model\OwnerTable' => function($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $hydrator = new \Zend\Stdlib\Hydrator\ArraySerializable;

                    return new OwnerTable($adapter, $hydrator, new Owner(), 'owner');
                },
            ),
        );
    }

    public function getFormElementConfig() {
        return array('factories' => array(
                'LocationSelect' => function($sm) {
                    $table = $sm->getServiceLocator()->get('Library\Model\LocationTable');
                    return new LocationSelect($table);
                },
                'OwnerSelect' => function($sm) {
                    $table = $sm->getServiceLocator()->get('Library\Model\OwnerTable');
                    return new OwnerSelect($table);
                }
        ));
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'deleteHelper' => function($sm) {
                    $helper = new View\Helper\DeleteDialogHelper;
                    return $helper;
                }
            )
        );
    }

}