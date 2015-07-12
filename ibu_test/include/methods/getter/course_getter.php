<?php

class CourseGetter extends Getter
{
	protected $course;
	protected $conn;
	
	
	function __construct($course, $conn) {
	    
		$this->setCourse($course);
		$this->setConn($conn);
	}

//setters
	private function setCourse($course) {$this->course = $course;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getCourse() {return $this->course;}

	protected function getTable()
	{
		return "courses ";
	}


	protected function getKeyAsSentence() {
	    $course = $this->course;
		$subject = $course->getSubject();
		$courseNumber = $course->getCourseNumber();
		$keyAsSentence = "subject = " . stringify($subject) . " AND " . "course_number = " . $courseNumber;
		return $keyAsSentence;  
	}

}