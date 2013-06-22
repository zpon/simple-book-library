<?php

namespace Library\Model;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\Adapter\Adapter;
use ZfcBase\Mapper\AbstractDbMapper;

/**
 * Description of LocationTable
 *
 * @author sjuul
 */
class LocationTable extends AbstractDbMapper {

    protected $tableName; // Refers back to $tableName in AbstractDbMapper

    public function __construct(Adapter $adapter, HydratorInterface $hydrator, $entityPrototype, $tableName = null) {
        $this->tableName = $tableName;

        $this->setDbAdapter($adapter);
        $this->setHydrator($hydrator);
        $this->setEntityPrototype($entityPrototype);
    }

    public function getLocation($id) {
        $result = $this->select($this->getSelect()->where(array('id' => $id)));

        $row = $result->current();
        if(!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getLocations() {
        $result = $this->select($this->getSelect());

        return $result;
    }

    public function saveLocation(Location $location) {
        $data = $location->getArrayCopy();

        if ($location->getId() == 0) {
            $this->insert($data);
        } else {
            if ($this->getLocation($location->getId())) {
                $this->update($data, array('id' => $location->getId()));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteLocation($id) {
        $this->delete(array('id' => $id));
    }
}

?>