<?php

class Consignment {
	//protected $consignment_number; ----> don't forget the db is the one that sets thiis
	// note: as we dno't yet have this key this will complicate the deletion
	protected $student_id;
	protected $consignment_number;
	protected $user;
	protected $consignmentItems; 

	function __construct($params) 
	{	
		$user = $params["user"];
		$this->setUser($user);
		$this->setStudentID($user->getStudentID());
		$this->setConsignmentItems($params["books"]);

	}

//setters
	private function setStudentID($student_id) {$this->student_id = $student_id;}
	private function setUser($user) {$this->user = $user;}
	private function setConsignmentItems($consignmentItems) {$this->consignmentItems = $consignmentItems;}
	public function setConsignmentNumber($consignment_number) {$this->consignment_number = $consignment_number;}

//getters
	//public function get_consignment_number() {return $this->consignment_number;}
	public function getStudentID() {return $this->student_id;}
	public function getUser() {return $this->user;}
	public function getConsignmentItems() {return $this->consignmentItems;}
	public function getConsignmentNumber() {return $this->consignment_number;}
	
	public function printOut() 
	{
		$user = $this->getUser();
		$books = $this->getBooks();
		$user->printOut();

		foreach ($books as $book) {
			$book->printOut();
		}
	}
	
	public function assignConsignmentNumberToConsignmentItems()
	{
	    foreach ($this->getConsignmentItems() as $consignmentItem)
	    {
	        $consignmentItem->setConsignmentNumber($this->getConsignmentNumber());
	    }
	}



}