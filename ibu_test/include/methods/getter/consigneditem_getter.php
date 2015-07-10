<?php

class ConsignedItemGetter extends Getter
{
	protected $consignedItem;
	protected $conn;

	protected function getTable()
	{
		return "consigned_items";
	}


	protected function getKeyAsSentence() {
	    $consigneditem = $this->consignedItem;
		$student_id = $consigneditem->getStudentID();
		$consignmentNumber = $consigneditem->getConsignmentNumber();
		$keyAsSentence = "student_id = " . $student_id . " AND " . "consignment_number = " . $consignmentNumber;
		return $keyAsSentence;  
	}
}