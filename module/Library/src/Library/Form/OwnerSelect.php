<?php

namespace Library\Form;

use Zend\Form\Element\Select;
use Library\Model\OwnerTable;
/**
 * Description of LocationSelect
 *
 * @author sjuul
 */
class OwnerSelect extends Select {
    public function __construct(OwnerTable $table) {
        parent::__construct('OwnerSelect');
        
        $owners = $table->getOwners();
        
        $ownerArray = array();
        $ownerArray[0] = "No owner";
        foreach($owners as $owner) {
            $ownerArray[$owner->getId()] = $owner->getName();
        }
        
        $this->setValueOptions($ownerArray);
    }
}

?>
