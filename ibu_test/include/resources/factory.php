<?php

	require('../resources/resources.php');

// what should I do about objects not created through $app?
// make another method or have it go through makeObject and change what goes throough it?

abstract class Factory 
{
	abstract public function makeObject();
	abstract protected function getParameters();
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

	public function makeObject() 
	{
		$params = $this->getParameters();
		$user = new User($params);
		return $user;
	}

	protected function getParameters() 
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

class BookFactory extends Factory
{
	protected $app;

	function __construct($app) 
	{
		$this->app = $app;
	}

	public function makeObject($params)
	{
		$courseFactory = new CourseFactory($this->app);

		$params = $this->getParameters();

		$courses = $courseFactory->makeListOfObjects($params[courses]);
		$params[courses] = $courses; 
		
		$book = new Book($params);
		return $user;
	}

	protected function getParameters() 
	{
		$json = $this->app->request->getBody();
        $params = json_decode($json, true);
        return $params;
	}
}


class CourseFactory extends Factory
{
	
	function __construct($app)
	{
		$this->app = $app;
	}

	public function makeObject()
	{
		$params = $this->getParameters();
		$course = new Course($params);
		return $course;
	}

	public function makeListOfObjectes($courseParams)
	{	
		$courses = array();
		foreach ($courseParams as $courseParam)
		{
			$course = new Course($courseParam);
			$courses[] = $course;
		}

	}

	protected function getParameters() 
	{


	}
}

class ConsignmentFactory extends Factory 
{
	function __construct($app)
	{
		$this->app = $app;
	}

	public function makeObject()
	{
		$params = $this->getParameters();
		$consignment = new Consignment($params);
		return $consignment;
	}

	protected function getParameters()
	{

	}

}