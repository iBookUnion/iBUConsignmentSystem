<?php

class CourseBookGetter extends Getter
{
	protected $courseBook;
	protected $conn;
	
	function __construct($courseBook, $conn) {
	    
		$this->setCourseBook($courseBook);
		$this->setConn($conn);
	}

//setters
	private function setCourseBook($courseBook) {$this->courseBook = $courseBook;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getCourseBook() {return $this->courseBook;}
	protected function getTable()
	{
		return "course_books ";
	}

	protected function getKeyAsSentence() {
	    $course = $this->courseBook;
		$subject = $course->getSubject();
		$courseNumber = $course->getCourseNumber();
		$isbn = $course->getISBN();
		$keyAsSentence = "subject = " . stringify($subject) . " AND " . "course_number = " . $courseNumber . " AND " . " isbn = " . $isbn;
		return $keyAsSentence;  
	}

}