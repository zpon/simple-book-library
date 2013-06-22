<?php

namespace Library\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends DefaultNavigationFactory {

    protected function getName() {
        return 'secondary';
    }

}

?>
