<?php

// create getters that can work with resource objects to identify existence
// need to create a way to figure out consignment number after consignment has been created
abstract class Getter 
{
	// push this up a class to a method class as all the methods are going to have this method
	protected commitToDatabase($insert)
	{
		$stmt = $this->conn->prepare($insert);
        $res = $stmt->execute();
        $stmt->store_result();
        return $res;
	}
}

class UserGetter extends Getter
{	
	protected $user;
	protected $conn;

	public function retrieve() 
	{
		// construct the statement of the form:
		// SELECT * FROM <table> WHERE key = <given param>
		$queryParams = $this->getKeyAsSentence()
		$statement = $this->getStatement(); 
		$res = $this->commitToDatabase($statement);

		if ($res->num_rows == 0) {
			return false;
		} else {
			return true;
		}

	}

	// I should refactor this when I get back to general searches
	// give it a param that specifies the where portion
	private function getStatement() {
		$select = "SELECT * ";
		$from = "FROM users ";
		$where = "wHERE " . $
	}

	private function getKeyAsSentence() {
		$student_id = $this->user->getStudentID();
		$keyAsSentence = "student_id = " . $student_id;
		return $keyAsSentence;  
	}
	
}

class BookGetter extends Getter
{
	protected $book;
	protected $conn;

	public function retrieve()
	{

	}
}

class CourseGetter extends Getter
{
	protected $course;
	protected $conn;
	public function retrieve()
	{
		
	}
}

class CourseBookGetter extends Getter
{
	protected $courseBook;
	protected $conn;

	public function retrieve() 
	{

	}
}

class ConsignmentGetter extends Getter
{
	protected $consignment;
	protected $conn;

	public function retrieve() 
	{

	}
}

class ConsignedItemGetter extends Getter
{
	protected $consignedItem;
	protected $conn;

	public function retrieve() 
	{

	}
}