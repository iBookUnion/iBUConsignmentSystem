<?php

// need some classed to create these objects
// This family of classes is meant to contain parameters
abstract class Resource 
{
	abstract public function getPoster($conn);
	abstract public function getDeleter($conn);
	//abstract public function getGetter($conn);
	//abstract public function getKey();
	abstract public function printOut();
}

class User extends Resource 
{

	protected $studentID;
	protected $first_name;
	protected $last_name;
	protected $email;
	protected $phone_number;

	function __construct($params)
	{	
		$this->setStudentID($params["student_id"]);
		$this->setFirstName($params["first_name"]);
		$this->setLastName($params["last_name"]);
		$this->setEmail($params["email"]);
		$this->setPhoneNumber($params["phone_number"]);		
	}
// setters (should they be private or public)
	private function setStudentID($student_id) { $this->studentID = $student_id;}
	private function setFirstName($first_name) {$this->first_name = $first_name;}
	private function setLastName($last_name) {$this->last_name = $last_name;}
	private function setEmail($email) {$this->email = $email;}
	private function setPhoneNumber($phone_number) {$this->phone_number = $phone_number;}

// getters
	public function getStudentID() {return $this->studentID;}
	public function getFirstName() {return $this->first_name;}
	public function getLastName() {return $this->last_name;}
	public function getEmail() {return $this->email;}
	public function getPhoneNumber(){return $this->phone_number;}

	public function printOut()
	{
		$student_id = $this->getStudentID();
		$first_name = $this->getFirstName();
		$last_name = $this->getLastName();
		$email = $this->getEmail();
		$phone_number = $this->getPhoneNumber();

		echo "This is the student ID: \n";
		var_dump($student_id);
		echo "This is the first name: \n";
		var_dump($first_name);
		echo "This is the last name: \n";
		var_dump($last_name);
		echo "This is the email: \n";
		var_dump($email);
		echo "This is the phone number: \n";
		var_dump($phone_number);
	}

	public function getPoster($conn) {
		$poster = new UserPoster($conn);
		return $poster;
	} 
	public function getDeleter($conn) {
		$deleter = new UserDeleter($conn);
		return $deleter;
	}
}

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
		$poster = new BookPoster($conn);
		return $poster;
	} 
	public function getDeleter($conn) {
		$deleter = new BookDeleter($conn);
		return $deleter;
	}
}


class ConsignedItem extends Resource
{
	protected $book;
	protected $consigned_item;
	protected $price;
	protected $current_state;
	
	function __construct($params)
	{
		$this->setBook($params["book"]);
		$this->setConsignedItem($params["consigned_item"]);
		$this->setPrice($params["price"]);
		$this->setCurrentState($params["current_state"]);
	}

//setters
	private function setConsignedItem($consigned_item) {$this->consigned_item = $consigned_item;}
	private function setPrice($price) {$this->price = $price;}
	private function setBook($book) {$this->book = $book;}
	private function setCurrentState($current_state) {$this->current_state = $current_state;}
//getters
	public function getConsignedItem() {return $this->consigned_item;}
	public function getPrice() {return $this->price;}
	public function getBook() {return $this->book;}
	public function getCurrentState() {return $this->current_state;}

	public function printOut() {
		$consigned_item = $this->getConsignedItem();
		$price = $this->getPrice();
		$current_state = $this->getCurrentState();
		$book = $this->getBook();

		echo "This is the consigned_item number: \n";
		var_dump($consigned_item);
		echo "This is the book: \n";
		$book->printOut();
		echo "This is the price: \n";
		var_dump($price);
		echo "This is the current state: \n";
		var_dump($current_state);
	}

	public function getPoster($conn) {
		$posters = array();
		$bookPoster = new BookPoster($conn);
		$consignedItemPoster = new ConsignedItemPoster($conn);
		$posters["bookPoster"] = $bookPoster;
		$posters["ConsignedItemPoster"] = $consignedItemPoster;
		return $posters;
	}
	public function getDeleter($conn) {

	}
}

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
		$posters = array();
		$coursePoster = new CoursePoster($conn);
		$courseBookPoster = new courseBookPoster($conn);
		$poster["coursePoster"] = $coursePoster;
		$poster["courseBookPoster"] = $courseBookPoster;

		return $poster;
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

class Consignment {
	//protected $consignment_number; ----> don't forget the db is the one that sets thiis
	// note: as we dno't yet have this key this will complicate the deletion
	protected $student_id;
	protected $books; //list of books

	function __construct($params) 
	{
		$this->setStudentID($params["student_id"]);
		$this->setBooks($params["books"]);
	}

//setters
	//private function set_consignment_number($consignment_number) {$this->consignment_number = $consignment_number;}
	private function setStudentID($student_id) {$this->student_id = $student_id;}
	private function setBooks($books) {$this->books = $books;}

//getters
	//public function get_consignment_number() {return $this->consignment_number;}
	public function getStudentID() {return $this->student_id;}
	public function getBooks() {return $this->books;}

	public function printOut() 
	{
		$student_id = $this->getStudentID();
		$books = $this->getBooks();

		foreach ($books as $book) {
			$book->printOut();
		}
	}

	public function getPoster($conn) {
		$poster = new ConsignmentPoster($conn);
		return $poster;
	} 
	public function getDeleter($conn) {
		$deleter = new ConsignmentDeleter($conn);
		return $deleter;
	}

}




