<?php

class ConsignmentGetter extends Getter
{
	protected $consignment;
	protected $conn;


	protected function getTable()
	{
		return "consignments";
	}
	public function determineConsignmentNumber() {

		$statement = "SELECT consignment_number FROM consignments";
		$consignment = $this->consignment;
		$studentID = $consignment->getStudentID();

		$where = "WHERE student_id = " . $studentID;

		$statement .= $where . "ORDER BY consignment_number DESC LIMIT 1";

		$stmt = $this->commitToDatabase($statement);
        
		$stmt->bind_result($consignment_number);


		return $consignment_number;
	}
	

}