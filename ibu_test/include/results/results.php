<?php

// shoudld have a metod called setresultasexisted
// HTTP STATUS CODES:
// if the resource was successully created: 201
// if there was an error: 400
// if the resource previously existed 409

// There may be some cases when  a post request does not
// create all the given resource
// in these instances note that the master result will send back 200
// as that one will always be unique
// if it is the case that the master resource in a post request
// previously existed it will be the case that
// the previously created resources in the requst will be  roll backed
// if they were committed 

// note that there is currently nothing unique about these result classes
// they just hold a resource
// unless they are incharge of the rollbacks, and they shouldnt be there is no
// current reason why they should be unique
// it may be the caee that it would simplify thing s to make them unique to the 
// request being made
// though it may not be neccessary

abstract class Result
{

	//abstract function produceResponse();

	public function setResourceAsExisted() {
		$this->setStatusCode(409);
	}

}

class UserResult extends Result
{
	protected $res;
	protected $user;
	protected $statusCode;

	function __construct($user) 
	{
		$this->setUser($user);
		$this->setResult(false);
		$this->setStatusCode(400);
	}

//setters
	private function setUser($user) {$this->user = $user;}
	
	public function setResult($res) {
		$this->res = $res;

		if ($res) {
			$this->setStatusCode(201);
		}
	}
	
	protected function setStatusCode($status_code) {$this->statusCode = $status_code;}
//getters
	public function getRes() {return $this->res;}
	public function getStatusCode() {return $this->statusCode;}	


	public function produceResponse() {
		$response = array();

        if ($this->statusCode  == 201) {
            $response["error"] = false;
            $response["message"] = "You are successfully registered";
        } else if ($this->statusCode == 400) {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while registereing";                
        } else if ($this->statusCode == 409) {
            $response["error"] = true;
            $response["message"] = "Sorry, this user already exists";
        }		$response = array();

		
		return $response;	
	}	

}

class BookResult extends Result 
{
	protected $res;
	protected $book;
	protected $statusCode;

	function __construct($book)
	{
		$this->setBook($book);
		$this->setResult(false);
		$this->setStatusCode(400);
	}

	private function setBook($book) {$this->book = $book;}
	protected function setStatusCode($status_code) {$this->statusCode = $status_code;}
	public function setResult($res) {
		$this->res = $res;

		if ($res) {
			$this->setStatusCode(201);
		}
	}

	public function getResult() {return $this->res;}
	protected function getStatusCode() {return $this->statusCode;}

	public function produceResponse() {
	    $response = array();

        if ($this->statusCode  == 201) {
            $response["error"] = false;
            $response["message"] = "The Book was Successfully Created.";
        } else if ($this->statusCode == 400) {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while creating the Book.";                
        } else if ($this->statusCode == 409) {
            $response["error"] = true;
            $response["message"] = "Sorry, this book already exists";
        }		$response = array();
		
		return $response;	
	}
}

class CourseResult extends Result
{
	protected $res;
	protected $course;
	protected $statusCode;

	function __construct($course)
	{
		$this->setCourse($course);
		$this->setResults(false);
		$this->setStatusCode(400);
	}

	private function setCourse($course) {$this->course = $course;}
	public function setResults($res) {
		$this->res = $res;
		if ($res) {
			$this->setStatusCode(201);
		}
	}
	protected function setStatusCode($status_code) {$this->statusCode = $status_code;}
	public function getResult() {return $this->res;}

	public function produceResponse() {
	    		$response = array();

        if ($this->statusCode  == 201) {
            $response["error"] = false;
            $response["message"] = "the course book was successfully created.";
        } else if ($this->statusCode == 400) {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while registereing";                
        } else if ($this->statusCode == 409) {
            $response["error"] = true;
            $response["message"] = "Sorry, this course_book already exists";
        }		$response = array();
		
		return $response;	
	}
}

class ConsignmentResult extends Result
{
	protected $res;
	protected $consignment;
	protected $statusCode;

	function __construct($consignment)
	{
		$this->setConsignment($consignment);
		$this->setResults(false);
		$this->setStatusCode(400);
	}

	private function setConsignment($consignment) {$this->consignment = $consignment;}
	public function setResults($res) {
		$this->res = $res;
		if ($res) {
			$this->setStatusCode(201);
		}
	}
	protected function setStatusCode($status_code) {$this->statusCode = $status_code;}
	public function getResult() {return $this->res;}

	public function produceResponse() {
	    		$response = array();

        if ($this->statusCode  == 201) {
            $response["error"] = false;
            $response["message"] = "The consignment was successfully created.";
        } else if ($this->statusCode == 400) {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while consigning";                
        } else if ($this->statusCode == 409) {
            $response["error"] = true;
            $response["message"] = "Sorry, this consignment already exists";
        }		$response = array();

		return $response;	
	}
}