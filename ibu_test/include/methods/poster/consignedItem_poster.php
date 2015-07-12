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

	public function insert() {
		$result = new ConsignmentResult($this->getConsignedItem());
		// constuct the sql statment
		$insert = $this->constructStatement();
		// commit it to the db
		$res = $this->commitToDatabase($insert);

        $result->setResults($res);

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
		$consignedItem = $this->getConsignedItem()->getConsignedItem();
		$consignment_number = $this->getConsignedItem()->getConsignmentNumber();
		$isbn = $this->getConsignedItem()->getBook()->getISBN();
		$price = $this->getConsignedItem()->getPrice();
		$current_state = $this->getConsignedItem()->getCurrentState();

		//make string
		$current_state = stringify($current_state);

		$params = array();
		$params[] = $consignedItem;
		$params[] = $consignment_number;
		$params[] = $isbn;
		$params[] = $price;
		$params[] = $current_state;
		$string = implode_comma($params);

		$values = "VALUES (" . $string . ") ";

		return $values;
	}
}
