<?php
	
	require_once('../include/Dbhandler.php');
	require_once '../include/DbUserHandler.php';
	require_once '../include/DbBookHandler.php';
	require_once '../include/DbConsignmentHandler.php';
	require_once '../include/DbInventoryHandler.php';
	require('../libs/Slim/Slim.php');

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
	
	$app->get('/inventory', function() use ($app) {

		$isbn = $app->request()->get('isbn');
		$student_id = $app->request()->get('student_id'); 
		$author = $app->request()->get('author');
		$title = $app->request()->get('title');
		$edition = $app->request()->get('edition');
		$courses = $app->request()->get('courses');
		$price = $app->request()->get('price');
		$current_state = $app->request()->get('current_state');
		$date = $app->request()->get('date');
		
		
		$query_params = array("isbn" => $isbn,
							  "student_id" => $student_id,
							  "author" => $author,
							  "title" => $title,
							  "edition" => $edition,
							  "courses" => $courses,
							  "price" => $price,
							  "current_state" => $current_state,
							  "date" => $date
							  );


		$db = new DbInventoryHandler();
		$response["error"] = false;
		$response["inventory"] = array();
		
		$response["inventory"] = $db->get($query_params) ?: null;

		if (!empty($response["inventory"]))
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
        } else if ($res == "Sorry, this record already exists") {
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
	            $response["message"] = "The Book was successfully added";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record already exists") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, this Book already exists";
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
	            $response["message"] = "The consignment was successfully created!";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record already exists") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, this consignment already exists";
	        }
            echoRespnse(201, $response);
    });
	
	$app->put('/users', function() use ($app) {
		
        $response = array();
		$params = array();

		$student_id = $app->request()->put('student_id');
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
        $res = $db->alter($params);

        if ($res == "Successfully Updated") {
            $response["error"] = false;
            $response["message"] = "The User's Information was successfully changed!";
        } else if ($res == "There Was An Error") {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred!";                
        } else if ($res == "Sorry, this record doesn't exist") {
            $response["error"] = true;
            $response["message"] = "Sorry, this user does not exists";
        }
        echoRespnse(201, $response);		
	});
	
	$app->put('/books', function() use ($app) {
		
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
            $res = $db->update($params);
 
	        if ($res == "Successfully Updated") {
	            $response["error"] = false;
	            $response["message"] = "The Book Record was successfully changed";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record doesn't exist") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, this Book doesn't exist";
	        }
            echoRespnse(201, $response);		
	});

	$app->put('/consignments', function() use ($app) {
		
            $response = array();
			$params = array();

			$isbn = $app->request->post('isbn');
            $student_id = $app->request->post('student_id');
			$price = $app->request->post('price');
			$current_state = $app->request->post('current_state');
			$date = $app->request->post('date');

			$params = array("isbn" => $isbn,
							"student_id" => $student_id,
							"price" => $price,
							"current_state" => $current_state,
							"date" => $date);

            $db = new DbConsignmentHandler();
            $res = $db->update($params);
 
	        if ($res == "Successfully Updated") {
	            $response["error"] = false;
	            $response["message"] = "The consignment was successfully changed!";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record doesn't exist") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, the consignment does not exist!";
	        }
            echoRespnse(201, $response);		
	});
	
	
	$app->patch('/users', function() use ($app) {
				
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
        $res = $db->update($params);

        if ($res == "Successfully Updated") {
            $response["error"] = false;
            $response["message"] = "The User's Information was successfully changed!";
        } else if ($res == "There Was An Error") {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred!";                
        } else if ($res == "Sorry, this record doesn't exist") {
            $response["error"] = true;
            $response["message"] = "Sorry, this user does not exists";
        }
        echoRespnse(201, $response);
	});
	
	$app->patch('/books', function() use ($app) { 
				
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
            $res = $db->update($params);
 
	        if ($res == "Successfully Updated") {
	            $response["error"] = false;
	            $response["message"] = "The Book Record was successfully changed";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record doesn't exist") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, this Book doesn't exist";
	        }
            echoRespnse(201, $response);
	});	
	
	$app->patch('/consignments', function() use ($app) {
				
            $response = array();
			$params = array();

			$isbn = $app->request->post('isbn');
            $student_id = $app->request->post('student_id');
			$price = $app->request->post('price');
			$current_state = $app->request->post('current_state');
			$date = $app->request->post('date');

			$params = array("isbn" => $isbn,
							"student_id" => $student_id,
							"price" => $price,
							"current_state" => $current_state,
							"date" => $date);

            $db = new DbConsignmentHandler();
            $res = $db->update($params);
 
	        if ($res == "Successfully Updated") {
	            $response["error"] = false;
	            $response["message"] = "The consignment was successfully changed!";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record doesn't exist") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, the consignment does not exist!";
	        }
            echoRespnse(201, $response);
	});
	
	$app->delete('/users', function() use ($app) { 
				
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
        $res = $db->delete($params);

        if ($res == "Successfully Deleted") {
            $response["error"] = false;
            $response["message"] = "The User's Information was successfully Deleted!";
        } else if ($res == "There Was An Error") {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred!";                
        } else if ($res == "Sorry, this record doesn't exist") {
            $response["error"] = true;
            $response["message"] = "Sorry, this user does not exist";
        }
        echoRespnse(201, $response);	
	});
	
	$app->delete('/books', function() use ($app) { 
				
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
            $res = $db->update($params);
 
	        if ($res == "Successfully Deleted") {
	            $response["error"] = false;
	            $response["message"] = "The Book Record was successfully Deleted";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record doesn't exist") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, this Book doesn't exist";
	        }
            echoRespnse(201, $response);
	});	
	
	$app->delete('/consignments', function() use ($app) {
		
            $response = array();
			$params = array();

			$isbn = $app->request->post('isbn');
            $student_id = $app->request->post('student_id');
			$price = $app->request->post('price');
			$current_state = $app->request->post('current_state');
			$date = $app->request->post('date');

			$params = array("isbn" => $isbn,
							"student_id" => $student_id,
							"price" => $price,
							"current_state" => $current_state,
							"date" => $date);

            $db = new DbConsignmentHandler();
            $res = $db->update($params);
 
	        if ($res == "Successfully Deleted") {
	            $response["error"] = false;
	            $response["message"] = "The consignment was successfully Deleted!";
	        } else if ($res == "There Was An Error") {
	            $response["error"] = true;
	            $response["message"] = "Oops! An error has occurred!";                
	        } else if ($res == "Sorry, this record doesn't exist") {
	            $response["error"] = true;
	            $response["message"] = "Sorry, the consignment does not exist!";
	        }
            echoRespnse(201, $response);	
	});
	
	function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();

   // setting response content type to json
    $app->contentType('application/json');
    $app->response->setStatus($status_code);

    // Allow CORS
    $app->response->headers->set('Access-Control-Allow-Origin', '*');

    //echo json_encode($response);

    
    $app->response->setBody(json_encode($response));
    }
	
	
$app->run();
