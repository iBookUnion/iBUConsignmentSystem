<?php

// should create a result instance that 
// specifies that the resource to be created already existed
class NullPoster extends Poster {
	private $resource;
	protected $conn;

	function __construct($resource, $conn) {
		$this->setResource($resource);
		$this->setConn($conn);
	}

	//setters
	private function setResource($user) {$this->resource = $user;}
	private function setConn($conn) {$this->conn = $conn;}
	//getter
	public function getResource() {return $this->user;}


	// create a result instance for the given resource specifiing
	// to the result class that the reosurce aready existed
	public function insert() {
		$result = $this->getResultForResource();
		// no need to construct an sql senetence....

		$result->setResourceAsExisted();

		return $result;
	}

	private function getResultForResource()
	{	
		// going need to figure out what the resource is exactly
		// this would need to be altered if we ever add more resources
		$user = "User";
		$book = "Book";
		$consignedItem = "Consigneditem";
		$course = "Course";
		$consignment = "Consignment";


		// create a instance of a result for the gven class
		if (is_a($this->resource, $user))
		{
			$result = new UserResult($this);
		}
		else if (is_a($this->resource, $book))
		{
			$result = new BookResult($this);
		}
		else if (is_a($this->resource, $consignedItem)) 
		{
			$result = new ConsignedItemResult($this);
		}	
		else if (is_a($this->resource, $course))
		{
			$result = new CourseResult($this);
		}
		else if (is_a($this->resource, $consignment))
		{
			$result = new ConsignmentResult($this);

		}
		else {
			//we should throw an exception here as this resource is not of a known class
			// for now...
			echo "Something has wrong\n The given object does not have a recognizable class.\n";
		}

		return $result;
	}

}