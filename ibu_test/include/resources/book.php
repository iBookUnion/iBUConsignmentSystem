<?php


class Book extends Resource 
{
	protected $isbn;
	protected $title;
	protected $author;
	protected $edition;
	protected $courses; // an array of courses
	
	function __construct($params)
	{
		$this->setISBN($params["isbn"]);
		$this->setTitle($params["title"]);
		$this->setAuthor($params["author"]);
		$this->setEdition($params["edition"]);
		$this->setCourses($params["courses"]);
	}

//setters
	private function setISBN($isbn) {$this->isbn = $isbn;}
	private function setTitle($title) {$this->title = $title;}
	private function setAuthor($author) {$this->author = $author;}
	private function setEdition($edition) {$this->edition = $edition;}
	private function setCourses($courses) {$this->courses = $courses;}

//getters
	public function getISBN() {return $this->isbn;}
	public function getTitle() {return $this->title;}
	public function getAuthor() {return $this->author;}
	public function getEdition() {return $this->edition;}
	public function getCourses() {return $this->courses;}
	
	public function printOut() {
		$isbn = $this->getISBN();
		$title = $this->getTitle();
		$author = $this->getAuthor();
		$edition = $this->getEdition();
		$courses = $this->getCourses();
		
		echo "This is the isbn: \n";
		var_dump($isbn);
		echo "This is the title: \n";
		var_dump($title);
		echo "This is the author: \n";
		var_dump($author);
		echo "This is the edition: \n";
		var_dump($edition);


		foreach ($courses as $course)
		{
			$course->printOut();
		} 
	}
	
	public function getPoster($conn) {
		// check whether the resouce to be created existed prior
		// to trying to create it again
		$result = $this->confirmResourceDoesNotExist($conn);
		if ($result) {
			$poster = new BookPoster($this, $conn);			
		} else {
			// blank poster, will not actually attempt to push to db
			$poster = new NullPoster();
		}

		return $poster;
	}

	private function confirmResourceDoesNotExist($conn) 
	{
		$getter = $this->getGetter($conn);
		$result = $getter->retrieve();
		return $result;
	}

	public function getGetter($conn)
	{
		$getter = new BookGetter($this, $conn);
		return $getter;
	}

	public function getDeleter($conn) {
		$deleter = new BookDeleter($conn);
		return $deleter;
	}
}
