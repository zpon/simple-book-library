<?php

namespace Library\Form;

use Zend\Form\Element\Select;
use Library\Model\LocationTable;
/**
 * Description of LocationSelect
 *
 * @author sjuul
 */
class LocationSelect extends Select {
    public function __construct(LocationTable $table) {
        parent::__construct('LocationSelect');
        
        $locations = $table->getLocations();
        
        $locationArray = array();
        $locationArray[0] = "No location";
        foreach($locations as $location) {
            $locationArray[$location->getId()] = $location->getName();
        }
        
        $this->setValueOptions($locationArray);
    }
}

?>
