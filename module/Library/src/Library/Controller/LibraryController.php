<?php

namespace Library\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\View\Helper\HeadScript;
use Library\Model\Book;
use Library\Model\BookCopy;
use Library\Form\BookForm;
use Library\Form\BookCopyForm;
use Library\Service\BookLookup;

class LibraryController extends AbstractActionController {

    protected $libraryTable;

    public function indexAction() {
        $header = new HeadScript();
        $header->appendFile("/js/library/index.js");

        $table = $this->getLibraryTable();
        $books = $table->fetchAll();

        return new ViewModel(array('books' => $books));
    }

    public function addAction() {
        $header = new HeadScript();
        $header->appendFile("/js/library/add.js");

        $form = new BookForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $book = new Book();
            $form->setInputFilter($book->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                error_log("is valid");
                $book->exchangeArray($form->getData());
                $this->getLibraryTable()->saveBook($book);

                // Redirect to list of albums
                return $this->redirect()->toRoute('library');
            } else {
                error_log(var_export($form->getMessages(), true));
            }
        }
        return array('form' => $form);
    }

    public function viewAction() {
        $header = new HeadScript();
        $header->appendFile("/js/delete_dialog.js");
        $header->appendFile("/js/library/view.js");

        $id = (int) $this->params()->fromRoute('id', 0);

        $book = $this->getLibraryTable()->getBook($id);
        $copies = $this->getLibraryTable()->getBookCopies($id);
        return new ViewModel(array('book' => $book, 'copies' => $copies));
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $this->getLibraryTable()->deleteBook($id);
        return $this->redirect()->toRoute('library');
    }

    public function isbnLookupAction() {
        $isbn = $this->params()->fromRoute('id', 0);

        $lookup = new BookLookup();
        $result = $lookup->isbnLookup($isbn);

        return new JsonModel($result);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('library', array(
                        'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $book = $this->getLibraryTable()->getBook($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('library', array(
                        'action' => 'index'
            ));
        }

        $form = new BookForm();
        $form->bind($book);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($book->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $this->getLibraryTable()->saveBook($data);

                // Redirect to list of library
                return $this->redirect()->toRoute('library', array('action' => 'view', 'id' => $data->getId()));
            } else {
                
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function getLibraryTable() {
        if (!$this->libraryTable) {
            $sm = $this->getServiceLocator();
            $this->libraryTable = $sm->get('Library\Model\LibraryTable');
        }
        return $this->libraryTable;
    }

}
