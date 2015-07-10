<?php

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

	public function insert() 
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

		$values = "VALUES (" . $string . ") ";
		
		return $values;
	}

	
}