<?php

// what should I do about objects not created through $app?
// make another method or have it go through makeObject and change what goes throough it?

abstract class Factory 
{
	abstract public function makeObject($params);
	abstract public function getParameters();
}

/**
* 
*/
class UserFactory extends Factory
{
	protected $app;

	function __construct($app)
	{
		$this->app = $app;
	}

	public function makeObject($params) 
	{	
		$user = new User($params);
		return $user;
	}

	public function getParameters() 
	{
		$student_id = $this->app->request()->post('student_id');
		$first_name = $this->app->request()->post('first_name');
		$last_name = $this->app->request()->post('last_name');
		$email = $this->app->request()->post('email');
		$phone_number = $this->app->request()->post('phone_number');
		
		$params = array("student_id" => $student_id,
						"first_name" => $first_name,
						"last_name" => $last_name,
						"email" => $email,
						"phone_number" => $phone_number);

		return $params;
	}
}

// class BookFactory extends Factory
// {
// 	protected $app;

// 	function __construct($app) 
// 	{
// 		$this->app = $app;
// 	}

// 	public function makeObject($params)
// 	{	
// 		$courseFactory = new CourseFactory($this->app);
		
// 		$courses = $courseFactory->makeListOfObjects($params["isbn"], $params["courses"]);
// 		$params["courses"] = $courses; 
		
// 		$book = new Book($params);
// 		return $book;
// 	}

// 	public function getParameters() 
// 	{
// 		$json = $this->app->request->getBody();
//         $params = json_decode($json, true);
//         return $params;
// 	}
// }


// class CourseFactory extends Factory
// {
// 	protected $app;

// 	function __construct($app)
// 	{
// 		$this->app = $app;
// 	}

// 	public function makeObject($params)
// 	{
// 		$params = $this->getParameters();
// 		$course = new Course($params);
// 		return $course;
// 	}

// 	public function makeListOfObjects($isbn, $courseParams)
// 	{	
// 		$courses = array();
// 		foreach ($courseParams as $courseParam)
// 		{	
// 			$courseParam["isbn"] = $isbn;
// 			$course = new Course($courseParam);
// 			$courses[] = $course;
// 		}
// 		return $courses;
// 	}

// 	public function getParameters() 
// 	{


// 	}
// }

// class ConsignmentFactory extends Factory 
// {
// 	protected $app;
	
// 	function __construct($app)
// 	{
// 		$this->app = $app;
// 	}

// 	public function makeObject($params)
// 	{	
// 		$consignedItemFactory = new ConsignedItemFactory($this->app);
// 		$userFactory = new UserFactory($this->app);

// 		$params = $this->getParameters();
		
// 		$books = $consignedItemFactory->makeListOfObjects($params["books"]);
// 		$params["books"] = $books; 

// 		$user = $userFactory->makeObject($params);
// 		$params["user"] = $user;

// 		$consignment = new Consignment($params);
// 		return $consignment;
// 	}

// 	public function getParameters()
// 	{
// 		$json = $this->app->request->getBody();
//         $params = json_decode($json, true);
        
//         return $params;
// 	}

// }

// class ConsignedItemFactory extends Factory
// {
// 	protected $app;
	
// 	function __construct($app)
// 	{
// 		$this->app = $app;
// 	} 

// 	public function makeObject($params)
// 	{
// 		// make the a consigned item
// 		// create a book to pass it on to the consigned item
// 		// this will require passing on the task of creating the course within 
// 		// books to the bookfactory, which will hopefully work
// 		$bookfactory = new BookFactory($this->app);
		
// 		$book = $bookfactory->makeObject($params);
// 		$params["book"] = $book;
		
// 		$consignedItem = new ConsignedItem($params);
// 		return $consignedItem;
// 	}

// 	public function makeListOfObjects($consignedbookParams)
// 	{	
// 		$consignedbooks = array();
// 		foreach ($consignedbookParams as $consignedbookParam)
// 		{	
// 			$consignedbook = $this->makeObject($consignedbookParam);
// 			$consignedbooks[] = $consignedbook;
// 		}
// 		return $consignedbooks;
// 	}

// 	public function getParameters()
// 	{

// 	}
// }