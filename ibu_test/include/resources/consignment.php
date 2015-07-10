<?php

class Consignment {
	//protected $consignment_number; ----> don't forget the db is the one that sets thiis
	// note: as we dno't yet have this key this will complicate the deletion
	protected $student_id;
	protected $user;
	protected $books; //list of books

	function __construct($params) 
	{	
		$user = $params["user"];
		$this->setUser($user);
		$this->setStudentID($user->getStudentID());
		$this->setBooks($params["books"]);

	}

//setters
	//private function set_consignment_number($consignment_number) {$this->consignment_number = $consignment_number;}
	private function setStudentID($student_id) {$this->student_id = $student_id;}
	private function setUser($user) {$this->user = $user;}
	private function setBooks($books) {$this->books = $books;}

//getters
	//public function get_consignment_number() {return $this->consignment_number;}
	public function getStudentID() {return $this->student_id;}
	public function getUser() {return $this->user;}
	public function getBooks() {return $this->books;}

	public function printOut() 
	{
		$user = $this->getUser();
		$books = $this->getBooks();
		$user->printOut();

		foreach ($books as $book) {
			$book->printOut();
		}
	}

	public function getPoster($conn) {
		// check whether the resouce to be created existed prior
		// to trying to create it again
		$poster = new ConsignmentPoster($this,$conn);

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
		$getter = new ConsignmentGetter($this, $conn);
		return $getter;
	}

	public function getDeleter($conn) {
		$deleter = new ConsignmentDeleter($conn);
		return $deleter;
	}

}