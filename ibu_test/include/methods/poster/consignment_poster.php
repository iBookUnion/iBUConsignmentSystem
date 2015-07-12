<?php


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

	public function insert() {
		$result = new CourseResult($this->consignment);

		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResults($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "consignments";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (student_id) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$consignment = $this->getConsignment();
		$student_id = $consignment->getStudentID();
		var_dump($student_id);
		// make string
		$params = array();
		$params[] = $student_id;
		$string = implode_comma($params);

		$values = "VALUES (" . $string . ") ";
		
		return $values;
	}

}
