<?php

	require_once '../include/DbHandler.php';
	require_once '../include/DbUserHandler.php';
	require_once '../include/DbBookHandler.php';
	require_once '../include/DbConsignmentHandler.php';
	require '.././libs/Slim/Slim.php';

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	$app->get('/users', function () use ($app) {

		$student_id = $app->request()->get('student_id');
		$first_name = $app->request()->get('first_name');
		$last_name = $app->request()->get('last_name');
		$email = $app->request()->get('email');
		$phone_number = $app->request()->get('phone_number');
		
		$query_params = array("student_id" => $student_id,
							  "first_name" => $first_name,
							  "last_name" => $last_name,
							  "email" => $email,
							  "phone_number" => $phone_number);


		$db = new DbUserHandler();
		$response["error"] = false;
		$response["users"] = array();
					
		$response["users"] = $db->get($query_params) ?: null;

		if (!empty($response["users"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
			} 

	});

	$app->get('/books', function () use ($app) {

		$isbn= $app->request()->get('isbn');
		$author = $app->request()->get('author');
		$title = $app->request()->get('title');
		$edition = $app->request()->get('edition');
		$courses = $app->request()->get('courses');
		
		$query_params = array("isbn" => $isbn,
							  "author" => $author,
							  "title" => $title,
							  "edition" => $edition,
							  "courses" => $courses);


		$db = new DbBookHandler();
		$response["error"] = false;
		$response["books"] = array();
		
		$response["books"] = $db->get($query_params) ?: null;

		if (!empty($response["books"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
			}

	});

	$app->get('/consignments', function () use($app) {
		
		$isbn = $app->request()->get('isbn');
		$student_id = $app->request()->get('student_id'); 
		$price = $app->request()->get('price');
		$current_state = $app->request()->get('current_state');
		$date = $app->request()->get('date');

		$query_params = array("isbn" => $isbn,
							  "student_id" => $student_id,
							  "price" => $price,
							  "current_state" => $current_state,
							  "date" => $date);

		$db = new DbConsignmentHandler();
		$response["error"] = false;
		$response["consignments"] = array();
		
		$response["consignments"] = $db->get($query_params) ?: null;

		if (!empty($response["consignments"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
			}

	});

	$app->post('/users', function() use ($app) {	
		
        $response = array();
		$params = array();

		$student_id = $app->request()->post('student_id');
		$first_name = $app->request()->post('first_name');
		$last_name = $app->request()->post('last_name');
		$email = $app->request()->post('email');
		$phone_number = $app->request()->post('phone_number');
		
		$params = array("student_id" => $student_id,
							  "first_name" => $first_name,
							  "last_name" => $last_name,
							  "email" => $email,
							  "phone_number" => $phone_number);
			
        $db = new DbUserHandler();
        $res = $db->create($params);
        
        if ($res == "Successfully Created") {
            $response["error"] = false;
            $response["message"] = "You are successfully registered";
        } else if ($res == "There Was An Error") {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while registereing";                
        } else if ($res == "Sorry, this user already exists") {
            $response["error"] = true;
            $response["message"] = "Sorry, this user already exists";
        }
        echoRespnse(201, $response);
    });

	$app->post('/books', function() use ($app) {	
		
            $response = array();
			$params = array();

            $isbn = $app->request->post('isbn');
			$title = $app->request->post('title');
			$author = $app->request->post('author');
			$edition = $app->request->post('edition');
            $courses = $app->request->post('courses');

            $params = array("isbn" => $isbn,
            				"title" => $title,
            				"author" => $author,
            				"edition" => $edition,
            				"courses" => $courses);
			
            $db = new DbBookHandler();
            $res = $db->create($params);
 
        if ($res == "Successfully Created") {
            $response["error"] = false;
            $response["message"] = "You are successfully registered";
        } else if ($res == "There Was An Error") {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while registereing";                
        } else if ($res == "Sorry, this user already exists") {
            $response["error"] = true;
            $response["message"] = "Sorry, this user already exists";
        }
            echoRespnse(201, $response);
    });

	$app->post('/consignments', function() use ($app) {	
		
            $response = array();
			$params = array();

			$isbn = $app->request->post('isbn');
            $student_id = $app->request->post('student_id');
			$price = $app->request->post('price');
			$current_state = $app->request->post('current_state');

			$params = array("isbn" => $isbn,
							"student_id" => $student_id,
							"price" => $price,
							"current_state" => $current_state);

            $db = new DbConsignmentHandler();
            $res = $db->create($params);
 
	        if ($res == "Successfully Created") {
	            $response["error"] = false;
	            $response["message"] = "You are successfully registered";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error occurred while registereing";                
	        } else if ($res == "Sorry, this user already exists") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, this user already exists";
	        }
            echoRespnse(201, $response);
    });


	function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();

    $app->response->setStatus($status_code);

    // Allow CORS
    $app->response->headers->set('Access-Control-Allow-Origin', '*');
 
    // setting response content type to json
    $app->response->headers->set('Content-Type', 'application/json');
    
    $app->response->setBody(json_encode($response));
    }
	
	
$app->run();
?>
