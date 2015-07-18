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
}