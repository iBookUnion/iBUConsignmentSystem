<?php

class UserGetter extends Getter
{	
	protected $user;
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

	public function retrieve() 
	{
		// construct the statement of the form:
		// SELECT * FROM <table> WHERE key = <given param>
		$queryParams = $this->getKeyAsSentence();
		$statement = $this->getStatement(); 
		$res = $this->commitToDatabase($statement);
        
		if ($res->num_rows) {
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
		$where = "WHERE " . $this->getKeyAsSentence();
		
		return $select . $from . $where;
	}

	protected function getKeyAsSentence() {
	    $user = $this->user;
		$student_id = $user->getStudentID();
		$keyAsSentence = "student_id = " . $student_id;
		return $keyAsSentence;  
	}
	
	protected function getTable() {
	    
	}
	
}