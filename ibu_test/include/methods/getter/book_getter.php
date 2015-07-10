<?php

class BookGetter extends Getter
{
	protected $book;
	protected $conn;

	protected function getTable()
	{
		return "books";
	}


	protected function getKeyAsSentence() {
	    $book = $this->book;
		$isbn = $user->getISBN();
		$keyAsSentence = "isbn = " . $isbn;
		return $keyAsSentence;  
	}

}