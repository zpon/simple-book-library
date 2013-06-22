<?php

namespace Library\Controller;

use Library\Model\Location;
use Library\Form\LocationForm;
use Zend\View\Helper\HeadScript;
use Zend\Mvc\Controller\AbstractActionController;

class LocationController extends AbstractActionController {

    private $locationTable;

    public function indexAction() {
        parent::indexAction();
        $header = new HeadScript();
        $header->appendFile("/js/delete_dialog.js");
        $header->appendFile("/js/location/index.js");
        
        return array('locations' => $this->getLocationTable()->getLocations());
    }

    public function getLocationTable() {
        if (!$this->locationTable) {
            $sm = $this->getServiceLocator();
            $this->locationTable = $sm->get('Library\Model\LocationTable');
        }
        return $this->locationTable;
    }

    public function addAction() {
        $form = new LocationForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $location = new Location();
            $form->setInputFilter($location->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $location->exchangeArray($form->getData());
                $this->getLocationTable()->saveLocation($location);

                // Redirect to list of location
                return $this->redirect()->toRoute('location');
            } else {
                error_log(var_export($form->getMessages(), true));
            }
        }
        return array('form' => $form);
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->getLocationTable()->deleteLocation($id);

        return $this->redirect()->toRoute('location');
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('location');
        }

        try {
            $location = $this->getLocationTable()->getLocation($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('location');
        }
        
        $form = new LocationForm();
        $form->bind($location);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setInputFilter($location->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid()) {
                $this->getLocationTable()->saveLocation($form->getData());
                
                return $this->redirect()->toRoute('location');
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

}

?>
