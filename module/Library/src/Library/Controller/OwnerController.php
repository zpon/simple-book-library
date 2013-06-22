<?php

namespace Library\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\HeadScript;
use Library\Form\OwnerForm;
use Library\Model\Owner;

class OwnerController extends AbstractActionController {

    private $locationTable;

    public function indexAction() {
        parent::indexAction();
        $header = new HeadScript();
        $header->appendFile("/js/delete_dialog.js");
        $header->appendFile("/js/owner/index.js");

        return array('owners' => $this->getOwnerTable()->getOwners());
    }

    public function addAction() {
        $form = new OwnerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $owner = new Owner();
            $form->setInputFilter($owner->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $owner->exchangeArray($form->getData());
                $this->getOwnerTable()->saveOwner($owner);

                // Redirect to list of location
                return $this->redirect()->toRoute('owner');
            } else {
                error_log(var_export($form->getMessages(), true));
            }
        }
        
        return array('form' => $form);
    }
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->getOwnerTable()->deleteOwner($id);

        return $this->redirect()->toRoute('owner');
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('owner');
        }

        try {
            $owner = $this->getOwnerTable()->getOwner($id);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->redirect()->toRoute('owner');
        }
        
        $form = new OwnerForm();
        $form->bind($owner);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setInputFilter($owner->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid()) {
                $this->getOwnerTable()->saveOwner($form->getData());
                
                return $this->redirect()->toRoute('owner');
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function getOwnerTable() {
        if (!$this->locationTable) {
            $sm = $this->getServiceLocator();
            $this->locationTable = $sm->get('Library\Model\OwnerTable');
        }
        
        return $this->locationTable;
    }

}

?>
