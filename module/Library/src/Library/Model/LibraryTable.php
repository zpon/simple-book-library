<?php

namespace Library\Model;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\Adapter\Adapter;
use Library\Model\Book;
use Library\Model\Loan;

class LibraryTable extends AbstractDbMapper {

    protected $tableName; // Refers back to $tableName in AbstractDbMapper

    public function __construct(Adapter $adapter, HydratorInterface $hydrator, $entityPrototype, $tableName = null) {
        $this->tableName = $tableName;

        $this->setDbAdapter($adapter);
        $this->setHydrator($hydrator);
        $this->setEntityPrototype($entityPrototype);
    }

    public function fetchAll() {
        $select = $this->getSelect();
        $select->columns(array('*', 'copies_count' => new \Zend\Db\Sql\Expression("count(book_copies.book_id)")));
        $select->join('book_copies', 'book.id = book_copies.book_id', array("book_id"), $select::JOIN_LEFT);
        $select->group('book.id');

        $resultSet = $this->select($select);

        return $resultSet;
    }

    public function getBookCopies($bookId) {
        $select = $this->getSelect('book_copies')->where(array('book_id' => $bookId))
                ->join('location', 'book_copies.location_id = location.id', array('location_name' => 'name'), \Zend\Db\Sql\Select::JOIN_LEFT)
                ->join('owner', 'book_copies.owner_id = owner.id', array('owner_name' => 'name'), \Zend\Db\Sql\Select::JOIN_LEFT)
                ->join('loan_outs', new \Zend\Db\Sql\Predicate\Expression('book_copies.id = loan_outs.book_copy_id AND stop is NULL'), array('loan_out_to', 'loan_start' => 'start', 'loan_stop' => 'stop', 'loan_book_copy_id' => 'book_copy_id', 'loan_id' => 'id'), \Zend\Db\Sql\Select::JOIN_LEFT);
        //echo $select->getSqlString();
        $result = $this->select($select, new BookCopy);

        return $result;
    }

    public function getLoanForBook($book_copy_id) {
        $select = $this->getSelect('loan_outs')->where('book_copy_id = ?', $book_copy_id)->where('start IS NOT NULL')->where('stop IS NULL');

        $result = $this->select($select, new Loan);

        $row = $result->current();
        if (!$row) {
            throw new \Exception("Could not loan for book copy with id: $book_copy_id");
        }
        return $row;
    }

    public function saveLoan($loan) {
        $data = $loan->getArrayCopy();

        $id = (int) $loan->getId();
        if ($id == 0) {
            $this->insert($data, 'loan_outs');
        } else {
            if ($this->getLoan($id)) {
                $this->update($data, array('id' => $id), 'loan_outs');
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function getLoan($id) {
        $id = (int) $id;
        $rowset = $this->select($this->getSelect('loan_outs')->where(array('id' => $id)));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getBook($id) {
        $id = (int) $id;
        $rowset = $this->select($this->getSelect()->where(array('id' => $id)));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getBookCopy($id) {
        $id = (int) $id;

        $select = $this->getSelect('book_copies')->where(array('book_copies.id' => $id))
                ->join('location', 'book_copies.location_id = location.id', array('location_name' => 'name'), \Zend\Db\Sql\Select::JOIN_LEFT)
                ->join('owner', 'book_copies.owner_id = owner.id', array('owner_name' => 'name'), \Zend\Db\Sql\Select::JOIN_LEFT)
                ->join('loan_outs', new \Zend\Db\Sql\Predicate\Expression('book_copies.id = loan_outs.book_copy_id AND stop is NULL'), array('loan_out_to', 'loan_start' => 'start', 'loan_stop' => 'stop', 'loan_book_copy_id' => 'book_copy_id', 'loan_id' => 'id'), \Zend\Db\Sql\Select::JOIN_LEFT);
        
        $rowset = $this->select($select, new BookCopy());
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function deleteBookCopy($id) {
        $this->delete(array('id' => $id), 'book_copies');
    }

    public function returnBookCopy($id) {
        $this->update(array('loan_out_to' => ""), array('id' => $id), 'book_copies');
    }

    public function saveBook(Book $book) {
        $data = $book->getArrayCopy();

        $id = (int) $book->getId();
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getBook($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function saveBookCopy(BookCopy $bookCopy) {
        $data = $bookCopy->getArrayCopy();

        $id = (int) $bookCopy->getId();
        if ($id == 0) {
            $this->insert($data, 'book_copies');
        } else {
            if ($this->getBookCopy($id)) {
                $this->update($data, array('id' => $id), 'book_copies');
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteBook($id) {
        $this->delete(array('id' => $id));
    }
}