<?php

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


	// instead of having the object pass itself around
	// this could be changed to have the handler set the 
	// resource object to hte mthod object after the reosurce
	// object has returned the method object
	public function getPoster($conn) {
		// check whether the resouce to be created existed prior
		// to trying to create it again
		$result = $this->confirmResourceDoesNotExist($conn);
		if ($result) {
			$poster = new UserPoster($this, $conn);			
		} else {
			// blank poster, will not actually attempt to push to db
			$poster = new NullPoster($this, $conn);
		}

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
		$getter = new UserGetter($this, $conn);
		return $getter;
	}

	public function getDeleter($conn) {
		$deleter = new UserDeleter($this, $conn);
		return $deleter;
	}
}