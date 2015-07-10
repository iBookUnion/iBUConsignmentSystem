<?php 

class ConsignedItemPoster extends Poster 
{
	private $consignedItem;
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

	protected function insert() {
		$result = new CourseResult($this->course);
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResult($res);

		return $result;
	}

	protected function getTable() 
	{
		$table = "consigned_items";
		return $table;
	}

	protected function getColumns() 
	{
    	$columns = " (consignment_number, isbn, price, current_state) ";
    	return $columns;		
	}

	protected function getValues() 
	{
		$consignedItem = $this->getConsignedItem();
		$consignment_number = $consignedItem->getConsignmentNumber();
		$isbn = $consignedItem->getISBN();
		$price = $consignedItem->getPrice();
		$current_state = $consignedItem->getCurrentState();

		//make string
		$current_state = stringify($current_state);

		$params = array();
		$params[] = $consignedItem;
		$params[] = $consignment_number;
		$params[] = $isbn;
		$params[] = $price;
		$param[] = $current_state;
		$string = implode_comma($params);

		$values = " (" . $string . ") ";
	}
}
