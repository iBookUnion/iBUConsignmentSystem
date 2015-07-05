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

	abstract function produceResponse();

	public function setresultAsExisted() {
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
		$this->setStudentID($user);
		$this->setResult(false);
		$this->setStatusCode(400);
	}

//setters
	private function setUser($student_id) {$this->user = $user;}
	
	public function setResult($res) {
		$this->res = $res;

		if ($res) {
			$this->setStatusCode(201);
		}
	}
	
	private function setStatusCode($status_code) {$this->statusCode = $status_code;}
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
        }
		
		return $response;	
	}	

}

class BookResult extends Result 
{
	protected $res;
	protected $book;

	function __construct($book)
	{
		$this->setISBN($book->getISBN());
		$this->setResult(false);
	}

	private function setBook($book) {$this->book = $book;}
	public function setResult($res) {$this->res = $res;}
	public function getResult() {return $this->res;}

	public function produceResponse();
}

class CourseResult extends Result
{
	protected $res;
	protected $course;

	function __construct($course)
	{
		$this->setCourse($course);
		$this->setResult(false);
	}

	private function setCourse($course) {$this->course = $course;}
	public function setResults($res) {$this->res = $res;}
	public function getResult() {return $this->res;}

	public function produceResponse();
}

class ConsignmentResult extends Result
{
	protected $res;
	protected $consignment;

	function __construct($consignment)
	{
		$this->setConsignment($consignment);
		$this->setResult(false);
	}

	private function setConsignment($consignment) {$this->consignment = $consignment;}
	public function setResults($res) {$this->res = $res;}
	public function getResult() {return $this->res;}

	public function produceResponse();	
}