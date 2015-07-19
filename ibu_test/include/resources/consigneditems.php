<?php

class ConsignedItem extends Resource
{
	protected $book;
	protected $consignment_number;
	protected $consigned_item;
	protected $price;
	protected $current_state;
	
	function __construct($params)
	{
		$this->setBook($params["book"]);
		$this->setConsignedItem($params["consigned_item"]);
		$this->setPrice($params["price"]);
		$this->setCurrentState($params["current_state"]);
	}

//setters
	private function setConsignedItem($consigned_item) {$this->consigned_item = $consigned_item;}
	private function setPrice($price) {$this->price = $price;}
	private function setBook($book) {$this->book = $book;}
	private function setCurrentState($current_state) {$this->current_state = $current_state;}
	public function setConsignmentNumber($consignment_number) {$this->consignment_number = $consignment_number;}
//getters
	public function getConsignedItem() {return $this->consigned_item;}
	public function getPrice() {return $this->price;}
	public function getBook() {return $this->book;}
	public function getISBN() {return $this->book->getISBN();}
	public function getCurrentState() {return $this->current_state;}
    public function getConsignmentNumber() {return $this->consignment_number;}
    
	public function printOut() {
		$consigned_item = $this->getConsignedItem();
		$price = $this->getPrice();
		$current_state = $this->getCurrentState();
		$book = $this->getBook();

		echo "This is the consigned_item number: \n";
		var_dump($consigned_item);
		echo "This is the book: \n";
		$book->printOut();
		echo "This is the price: \n";
		var_dump($price);
		echo "This is the current state: \n";
		var_dump($current_state);
	}
}
