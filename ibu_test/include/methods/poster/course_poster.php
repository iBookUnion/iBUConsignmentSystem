<?php

class CoursePoster extends Poster 
{
	private $course;
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

	protected function insert() {
		$result = new CourseResult($this->course);
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResult($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "courses";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (subject, course_number) ";
    		return $columns;		
	}

	protected function getValues() 
	{
		$course = $this->getCourse();
		$subject = $course->getSubject();
		$course_number = $course->getCourseNumber();

		//make string

		$values = "( " . $string . ") ";
	}
}