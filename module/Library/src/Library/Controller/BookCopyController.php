<?php

namespace Library\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Library\Model\BookCopy;
use Library\Model\Loan;

/**
 * Description of BookCopyController
 *
 * @author sjuul
 */
class BookCopyController extends AbstractActionController {

    protected $libraryTable;

    /**
     * Add a copy of a give book
     * @return type
     */
    public function addAction() {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Library\Form\BookCopyForm');

        $form->get('submit')->setValue('Add copy');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('library');
        }

        try {
            $book = $this->getLibraryTable()->getBook($id);
            $form->get('book_id')->setValue($book->getId());
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('library');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $bookCopy = new BookCopy();
            $form->setInputFilter($bookCopy->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                error_log("is valid");
                $bookCopy->exchangeArray($form->getData());
                $this->getLibraryTable()->saveBookCopy($bookCopy);

                return $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $id));
            } else {
                error_log(var_export($form->getMessages(), true));
            }
        }

        return array('form' => $form);
    }

    public function loanAction() {
        $book_copy_id = (int) $this->params()->fromRoute('id', 0);
        if (!$book_copy_id) {
            return $this->redirect()->toRoute('library');
        }

        try {
            $loan = $this->getLibraryTable()->getLoanForBook($book_copy_id);
            return $this->redirect()->toRoute('library');
        } catch (\Exception $e) {
            // We expect an exception as this method should only be used when no loans are active.
            $formManager = $this->serviceLocator->get('FormElementManager');
            $form = $formManager->get('Library\Form\LoanForm');
            $form->get('book_copy_id')->setValue($book_copy_id);

            $request = $this->getRequest();
            if ($request->isPost()) {

                $loan = new Loan();
                $form->setInputFilter($loan->getInputFilter());
                $form->setData($request->getPost());

                if ($form->isValid()) {
                    $loan->exchangeArray($form->getData());

                    // Save loan
                    $loan->setStartToNow();
                    $this->getLibraryTable()->saveLoan($loan);

                    // Get book copy object to get book id
                    $bookCopy = $this->getLibraryTable()->getBookCopy($book_copy_id);

                    return $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $bookCopy->getBookId()));
                }
            }
        }

        /*
          $form->bind($loan);

          $form->get('submit')->setValue('Loan');

          $request = $this->getRequest();
          if ($request->isPost()) {
          $form->setInputFilter($copy->getInputFilter());

          // Update 'loan_out_to' field on original copy object
          $data = $copy->getArrayCopy();
          $formData = $request->getPost();
          $data['loan_out_to'] = $formData['loan_out_to'];
          // Set updated data on form
          $form->setData($data);

          if ($form->isValid()) {
          $this->getLibraryTable()->saveBookCopy($form->getData());

          return $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $form->getData()->getBookId()));
          }
          } */

        return array('id' => $book_copy_id, 'form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('library');
        }

        try {
            $copy = $this->getLibraryTable()->getBookCopy($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('library');
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Library\Form\BookCopyForm');
        $form->bind($copy);

        $form->get('submit')->setValue('Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($copy->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getLibraryTable()->saveBookCopy($form->getData());
                $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $form->getData()->getBookId()));
            }
        }

        return array('id' => $id, 'form' => $form);
    }

    public function returnAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $copy = $this->getLibraryTable()->getBookCopy($id);
            error_log(var_export($copy, true));
            $loan = $copy->getLoanObject();
            $loan->setStopToNow();
            $this->getLibraryTable()->saveLoan($loan);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->redirect()->toRoute('library');
        }

        return $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $copy->getBookId()));
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        $copy = $this->getLibraryTable()->getBookCopy($id);
        $this->getLibraryTable()->deleteBookCopy($id);

        return $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $copy->getBookId()));
    }

    public function getLibraryTable() {
        if (!$this->libraryTable) {
            $sm = $this->getServiceLocator();
            $this->libraryTable = $sm->get('Library\Model\LibraryTable');
        }
        return $this->libraryTable;
    }

}

?>
