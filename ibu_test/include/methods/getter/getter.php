<?php
	require('user_getter.php');
	require('book_getter.php');
	require('consigneditem_getter.php');
	require('course_getter.php');
	require('coursebook_getter.php');
	require('consignment_getter.php');

// create getters that can work with resource objects to identify existence
// need to create a way to figure out consignment number after consignment has been created
abstract class Getter 

{   
    
    abstract protected function getKeyAsSentence();
    abstract protected function getTable();
    
	// push this up a class to a method class as all the methods are going to have this method
	protected function commitToDatabase($insert)
	{   
		$stmt = $this->conn->prepare($insert);
        $res = $stmt->execute();
        $stmt->store_result();
        return $stmt;
	}

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

	private function getStatement() {
		$select = "SELECT * ";
		$from = "FROM " . $this->getTable();
		$where = "WHERE " . $this->getKeyAsSentence();
		
		return $select . $from . $where;
	}
}