<?php

//needs to require helper

abstract class Poster {

	protected function commitToDatabase($insert)
	{
		$stmt = $this->conn->prepare($insert);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
	}

	protected function constructStatement()
	{
		$insert = "INSERT INTO ";
		$table = $this->getTable();
		$columns = $this->getColumns();
		$values = $this->getValues();

		$insert = $insert . $table . $columns . $values;
		return $insert;
	}

	abstract protected function getTable();
	abstract protected function getColumns();
	abstract protected function getValues();
}

class UserPoster extends Poster {
	private $user;
	protected $conn;

	function __construct($user, $conn) {
		$this->setUser($user);
		$this->setConn($conn);
	}

//setters
	private function setUser($user) {$this->user = $user;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getUser() {return $this->user;}

	protected function insert() 
	{	
		$result = new UserResult($this->user);
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResult($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "users";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (student_id, first_name, last_name, email, phone_number) ";
    		return $columns;		
	}

	protected function getValues() 
	{
		$user = $this->getUser();
		$student_id = $user->getStudentID();
		$first_name = $user->getFirstName();
		$last_name = $user->getLastName();
		$email = $user->getEmail();
		$phone_number = $user->getPhoneNumber();

		//make string
		$first_name = stringify($first_name);
		$last_name = stringify($last_name);
		$email = stringify($email);

		$params = array();
		$params[] = $student_id;
		$params[] = $first_name;
		$params[] = $last_name;
		$params[] = $email;
		$params[] = $phone_number;

		$string = implode_comma($params);

		$values = " (" . $string . ") ";
	}

	
}

class BookPoster extends Poster 
{
	private $book;
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

	protected function insert() 
	{
		$result = new BookResult($this->book);
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResult($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "books";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (isbn, title, author, edition) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$book = $this->getBook();
		$isbn = $book->getISBN();
		$title = $book->getTitle();
		$author = $book->getAuthor();
		$edition = $book->getEdition();

		//make string
		$title = stringify($title);
		$author = stringify($author);

		$params = array();
		$params[] = $isbn;
		$params[] = $title;
		$params[] = $author;
		$params[] = $edition;
		$string = implode_comma($params);

		$values = " (" . $string . ") ";
	}

}

class ConsignedItemPoster extends Poster 
{
	private $consignedItem;
	protected $conn;

	function __construct($consignedItem, $conn) {
		$this->setConsignedItem($consignedItem);
		$this->setConn($conn);
	}

//setters
	private function setConsignedItem($consignedItem) {$this->consignedItem = $consignedItem;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getConsignedItem() {return $this->consignedItem;}

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
		$table = "consigned_items";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (consignment_number, isbn, price, current_state) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$consignedItem = $this->getConsignedItem();
		$consignment_number = $consignedItem->getConsignmentNumber();
		$isbn = $consignedItem->getISBN();
		$price = $consignedItem->getPrice();
		$current_state = $consignedItem->getCurrentState();

		//make string
		$current_state = stringify($current_state);

		$params = array();
		$params[] = $consignedItem;
		$params[] = $consignment_number;
		$params[] = $isbn;
		$params[] = $price;
		$param[] = $current_state;
		$string = implode_comma($params);

		$values = " (" . $string . ") ";
	}
}

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

	protected function insert() {
		$result = new CourseResult($this->course);

		$result = new User_Result($this->user);
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResult($res);

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

		$values = " (" . $string . ") ";
	}
}

class ConsignmentPoster extends Poster
{
	private $consignment;
	protected $conn;

	function __construct($consignment, $conn) {
		$this->setConsignment($consignment);
		$this->setConn($conn);
	}

//setters
	private function setConsignment($consignment) {$this->consignment = $consignment;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getConsignment() {return $this->consignment;}

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
		$table = "consignments";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (consignment_number, student_id) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$consignment = $this->getConsignment();
		$consignment_number = $consignment->getConsignmentNumber();
		$student_id = $consignment->getStudentID();

		// make string
		$params = array();
		$params[] = $consignment_number;
		$params[] = $student_id;
		$string = implode_comma($params);

		$values = " (" . $string . ") ";
	}

}

// should create a result instance that 
// specifies that the resource to be created already existed
class NullPoster extends Poster {
	private $resource;
	protected $conn;

	function __construct($resource, $conn) {
		$this->setResource($resource);
		$this->setConn($conn);
	}

	//setters
	private function setResource($user) {$this->resource = $user;}
	private function setConn($conn) {$this->conn = $conn;}
	//getter
	public function getResource() {return $this->user;}


	// create a result instance for the given resource specifiing
	// to the result class that the reosurce aready existed
	protected function insert() {
		$result = $this->getResultForResource();
		// no need to construct an sql senetence....

		$result->setResourceAsExisted();

		return $result;
	}

	private function getResultForResource()
	{	
		// going need to figure out what the resource is exactly
		// this would need to be altered if we ever add more resources
		$user = "User";
		$book = "Book";
		$consignedItem = "Consigneditem";
		$course = "Course";
		$consignment = "Consignment";


		// create a instance of a result for the gven class
		if (is_a($this->resource, $user))
		{
			$result = new UserResult;
		}
		else if (is_a($this->resource, $book))
		{
			$result = new BookResult;
		}
		else if (is_a($this->resource, $consignedItem)) 
		{
			$result = new ConsignedItemResult;
		}	
		else if (is_a($this->resource, $course))
		{
			$result = new CourseResult;
		}
		else if (is_a($this->resource, $consignment))
		{
			$result = new ConsignmentResult;

		}
		else {
			//we should throw an exception here as this resource is not of a known class
			// for now...
			echo "Something has wrong\n The given object does not have a recognizable class.\n";
		}

		return $result;
	}

}