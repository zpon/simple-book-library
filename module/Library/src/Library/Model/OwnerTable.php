<?php

namespace Library\Model;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\Adapter\Adapter;
use ZfcBase\Mapper\AbstractDbMapper;
use Library\Model\Owner;

/**
 * Description of LocationTable
 *
 * @author sjuul
 */
class OwnerTable extends AbstractDbMapper {

    protected $tableName; // Refers back to $tableName in AbstractDbMapper

    public function __construct(Adapter $adapter, HydratorInterface $hydrator, $entityPrototype, $tableName = null) {
        $this->tableName = $tableName;

        $this->setDbAdapter($adapter);
        $this->setHydrator($hydrator);
        $this->setEntityPrototype($entityPrototype);
    }

    public function getOwner($id) {
        $result = $this->select($this->getSelect()->where(array('id' => $id)));

        $row = $result->current();
        if(!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function getOwners() {
        $rowset = $this->select($this->getSelect());
        
        return $rowset;
    }


    public function saveOwner(Owner $owner) {
        $data = $owner->getArrayCopy();

        if ($owner->getId() == 0) {
            $this->insert($data);
        } else {
            if ($this->getOwner($owner->getId())) {
                $this->update($data, array('id' => $owner->getId()));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteOwner($id) {
        $this->delete(array('id' => $id));
    }
}

?>