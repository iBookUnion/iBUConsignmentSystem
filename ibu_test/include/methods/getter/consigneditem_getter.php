<?php

class ConsignedItemGetter extends Getter
{
	protected $consignedItem;
	protected $conn;
	
	function __construct($consignedItem, $conn) {
	    
		$this->setConsignedItem($consignedItem);
		$this->setConn($conn);
	}
//setters
	private function setConsignedItem($consignedItem) {$this->consignedItem = $consignedItem;}
	private function setConn($conn) {$this->conn = $conn;}
//getter
	public function getConsignedItem() {return $this->consignedItem;}

	protected function getTable()
	{
		return "consigned_items ";
	}


	protected function getKeyAsSentence() {
	    $consigneditem = $this->consignedItem;
		$consignmentNumber = $consigneditem->getConsignmentNumber();
		$isbn = $consigneditem->getISBN();
		$keyAsSentence = "consignment_number = " . $consignmentNumber . " AND isbn = " . $isbn;
		return $keyAsSentence;  
	}
}