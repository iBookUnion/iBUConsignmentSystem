<?php


class Course extends Resource {
	protected $subject;
	protected $course_number;
	protected $isbn;
	

	function __construct($parameters) {
		$this->setISBN($parameters["isbn"]);
		$this->setSubject($parameters["subject"]);
		$this->setCourseNumber($parameters["course_number"]);
	}


//setters
	private function setSubject($subject) {$this->subject = $subject;}
	private function setCourseNumber($course_number) {$this->course_number = $course_number;}
	private function setISBN($isbn) {$this->isbn = $isbn;}

//getters
	public function getSubject() {return $this->subject;}
	public function getCourseNumber() {return $this->course_number;}
	public function getISBN() {return $this->isbn;}

	public function printOut() {
		$isbn = $this->getISBN();
		$subject = $this->getSubject();
		$course_number = $this->getCourseNumber();
		
		echo "This is the isbn: \n";
		var_dump($isbn);
		echo "This is the subject: \n";
		var_dump($subject);
		echo "This is the course number: \n";
		var_dump($course_number);
	}

	public function getPoster($conn) {
		// check whether the resouce to be created existed prior
		// to trying to create it again
		$posters = array();
		$results = array();

		$results = $this->confirmResourceDoesNotExist($conn);
		if ($results["courseBookResult"])
			$posters[] = new NullPoster();
		else if ($results["courseResult"]) {
			$posters[] = new CourseBookPoster($this, $conn);
		} else {
			$posters[] = new CourseBookPoster($this, $conn);
			$posters[] = new CoursePoster($this, $conn);
		}
		
		return $posters;
	}

	// should check if the consigned item exists
	// if it does there is no need to check if the book does
	// if it doesn't should check if the book does
	private function confirmResourceDoesNotExist($conn) 
	{
		$results = array();
		$getter = $this->getGetter($conn);
		$courseBookGetter = $getter["courseBookGetter"];
		$courseGetter = $getter["CourseGetter"];

		$results["courseBookResult"] = $courseBookGetter->retrieve();
		$results["courseResult"] = $courseGetterGetter->retrieve();
		return $results;
	}

	public function getGetter($conn)
	{
		$getters = array();
		$courseGetter = new CourseGetter($this, $conn);
		$courseBookGetter = new CourseBookGetter($this, $conn);
		$getters["courseGetter"] = $courseGetter;
		$getters["courseBookGetter"] = $courseBookGetter;
		return $getters;
	}

	public function getDeleter($conn) {
		$deleters = array();
		$courseDeleter = new CourseDeleter($conn);
		$courseBookDeleter = new courseBookDeleter($conn);
		$deleters["courseDeleter"] = $courseDeleter;
		$deleters["courseBookDeleter"] = $courseBookDeleter;

		return $deleters;
	} 	
}