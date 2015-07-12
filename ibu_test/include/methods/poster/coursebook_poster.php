<?php

class CourseBookPoster extends Poster
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

	public function insert() {
		$result = new CourseResult($this->course);

		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);
		
		echo "this should have gotten submitted to the db:";
		var_dump($this->getCourse());
		
        $result->setResults($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "course_books";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (subject, course_number, isbn) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$course = $this->getCourse();
		$subject = $course->getSubject();
		$course_number = $course->getCourseNumber();
		$isbn = $course->getISBN();

		//make string
		$subject = stringify($subject);

		$params = array();
		$params[] = $subject;
		$params[] = $course_number;
		$params[] = $isbn;
		$string = implode_comma($params);

		$values = "VALUES (" . $string . ") ";
		return $values;
	}
}
