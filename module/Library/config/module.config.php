<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Library\Controller\Library' => 'Library\Controller\LibraryController',
            'Library\Controller\Location' => 'Library\Controller\LocationController',
            'Library\Controller\BookCopy' => 'Library\Controller\BookCopyController',
            'Library\Controller\Owner' => 'Library\Controller\OwnerController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'link_library' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Library\Controller\Library',
                        'action' => 'index',
                    ),
                ),
            ),
            'link_location' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/location',
                    'defaults' => array(
                        'controller' => 'Library\Controller\Location',
                        'action' => 'index',
                    ),
                ),
            ),
            'link_owner' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/owner',
                    'defaults' => array(
                        'controller' => 'Library\Controller\Owner',
                        'action' => 'index',
                    ),
                ),
            ),
            'library' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/library[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Library\Controller\Library',
                        'action' => 'index',
                    ),
                ),
            ),
            'location' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/location[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Library\Controller\Location',
                        'action' => 'index',
                    ),
                ),
            ),
            'bookcopy' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/bookcopy[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Library\Controller\BookCopy',
                        'action' => 'index',
                    ),
                ),
            ),
            'owner' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/owner[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Library\Controller\Owner',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Books',
                'title' => 'Library overview',
                'route' => 'link_library',
            ),
            array(
                'label' => 'Book Locations',
                'route' => 'link_location',
            ),
            array(
                'label' => 'Book Owners',
                'title' => 'Book owners',
                'route' => 'link_owner',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'library' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
?>
