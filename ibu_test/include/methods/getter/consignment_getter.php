<?php

class ConsignmentGetter extends Getter
{
	protected $consignment;
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


	protected function getKeyAsSentence() {
		
	}
	
	protected function getTable()
	{
		return "consignments";
	}
	
	public function checkForPreExistingConsignment() 
	{
		$query = $this->constructConsignmentSearch();
		
		$stmt = $this->commitToDatabase($query);
		$stmt->bind_result($consignment_number);
		
		while($row = $stmt->fetch())
		{
			$consignment_number = $consignment_number; 
		}
		$stmt->close();
			
		if ($consignment_number) {
			$this->consignment->setConsignmentNumber($consignment_number);
		}
		return (($consignment_number == 0) ? true : false);
	}
	
	private function constructConsignmentSearch()
	{
		if (date('M') == 1 || date('M') == 12) {
			$query = $this->constructConsignmentSearchTermTwo();
		} else {
			$query = $this->constructConsignmentSearchTermOne();
		}
		return $query;
	}
	
	private function constructConsignmentSearchTermOne()
	{
		$select = "SELECT consignment_number ";
		$from = "FROM consignments ";
		$where = "WHERE student_id = " . $this->consignment->getStudentID();
		$upperDateLimit = " AND date >= '" . date('Y') . "-04-01'";
		$lowerDateLimit = " AND date <= '" . date('Y') . "-09-31'";
		
		return $select . $from . $where . $upperDateLimit . $lowerDateLimit;
	}
	
	private function constructConsignmentSearchTermTwo()
	{
		$select = "SELECT consignment_number";
		$from = "FROM consignments";
		$where = "WHERE student_id = " . $this->consignment->getStudentID();
		$upperDateLimit = " AND date >= '" . date('Y') . "-12-01'";
		$lowerDateLimit = " AND date <= '" . (date('Y') + 1) . "-01-31'";
		
		return $select . $from . $where . $upperDateLimit . $lowerDateLimit;
	}
	
	public function determineConsignmentNumber() 
	{
		if (!$this->consignment->getConsignmentNumber()) {
			// using this method for this purpose is a bit sloppy,
			// at the very least consider changing the name of the methods
			$this->checkForPreExistingConsignment();
		}
	}
}