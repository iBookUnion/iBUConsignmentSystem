<?php

class BookPoster extends Poster 
{
	private $book;
	protected $conn;

	function __construct($book, $conn) {
		$this->setBook($book);
		$this->setConn($conn);
	}

//setters
	private function setBook($book) {$this->book = $book;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getBook() {return $this->book;}

	public function insert() 
	{
		$result = new BookResult($this->book);
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResult($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "books";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (isbn, title, author, edition) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$book = $this->getBook();
		$isbn = $book->getISBN();
		$title = $book->getTitle();
		$author = $book->getAuthor();
		$edition = $book->getEdition();

		//make string
		$title = stringify($title);
		$author = stringify($author);
		$edition = stringify($edition);

		$params = array();
		$params[] = $isbn;
		$params[] = $title;
		$params[] = $author;
		$params[] = $edition;
		$string = implode_comma($params);

		$values = "VALUES (" . $string . ") ";
		return $values;
	}

}