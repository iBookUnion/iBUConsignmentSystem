<?php

class BookGetter extends Getter
{
	protected $book;
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

	protected function getTable()
	{
		return "books ";
	}


	protected function getKeyAsSentence() {
	    $book = $this->book; 
		
		$isbn = $book->getISBN();
		$keyAsSentence = "isbn = " . $isbn;
		return $keyAsSentence;  
	}

}