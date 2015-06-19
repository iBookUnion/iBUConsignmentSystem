<?php
	
	require_once('../include/Dbhandler.php');
	require('../libs/Slim/Slim.php');

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();


// users are all very repetitive could technically refactor into one call
// use methods to determine what to do, set up is

$app->get('/users(/:student_id)', function($student_id = null) use ($app) {
		$params = package_user_parameters($student_id, $app);
				
		$db = new DbUserResourceHandler();
		$response["errors"] = false;
		$response["users"] = $db->get_method($params) ?: null;
		
		// manage errors
		if (!empty($response["users"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
		}
});

$app->get('/books(/:isbn)', function($isbn = null) use ($app) {
		$params = package_book_parameters($isbn, $app);
				
		$db = new DbBooksResourceHandler();
		$reponse["error"] = false;
		$response["books"] = $db->get_method($params) ?: null;
		
		// manage errors
		if (!empty($response["books"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
		}
});

$app->get('/consignments(/:consignment_number)', function($consignment_number = null) use ($app){
		$params = package_consignment_parameters($consignment_number, $app);
		
				
		$db = new DbConsignmentsResourceHandler();
		$response["errors"] = false;
		$response["consignments"] = $db->get_method($params) ?: null;
		
		// manage errors
		if (!empty($response["consignments"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
		}
});


$app->get('/inventory(/:isbn)', function($isbn = null) use ($app){
		
		$params = package_inventory_parameters($isbn, $app);
				
		$db = new DbInventoryResourceHandler();
		$reponse["error"] = false;
		$response["books"] = $db->get_method($params);
		
		// manage errors
		if (!empty($response["books"]))
		{
			echoRespnse(200, $response);
		} else {
			$response["error"] = true;
			$response["message"] = "The requested resource doesn't exist";
			echoRespnse(404, $response);
		}	
});

$app->patch('/users/:student_id', function($student_id) use ($app) {
		$params = package_user_parameters($student_id, $app);
		
				//var_dump($params);
		
		$db = new DbUserResourceHandler();
		
		$res = $db->patch_method($params);
		
		//manage errors
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
        echoRespnse(200, $response);
		
		
});

$app->delete('/users/:student_id', function($student_id) use ($app) {
		$params = package_user_parameters($student_id, $app);
		// create controller
		//manage errors
});

$app->post('/books', function() use ($app) {
				// calll to functions
});

$app->patch('/books/:isbn', function($isbn) use ($app) {
		$params = package_book_parameters($isbn, $app);
				
				//var_dump($params);
		
		$db = new DbBooksResourceHandler();
		
		$res = $db->patch_method($params);
		
		//manage errors
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
        echoRespnse(200, $response);		
		
		
});

$app->delete('/books/:isbn', function() use ($app){
		$params = package_book_parameters($isbn, $app);
});

$app->post('/consignments', function() use ($app) {

});

$app->patch('/consignments/:consignment_number(/:consignment_item)', function($consignment_number, $consignment_item = null) use ($app){
		$params = package_consignment_patch_parameters($consignment_number,$consignment_item, $app);
		
		$db = new DbConsignmentsResourceHandler();
		
		$res = $db->patch_method($params);
		
		if ($res) {
			echo "this worked";
		} else {
			echo "something went wrong";
		}
		
		//manage errors
});

$app->delete('/consignments/:consignment_number', function() use ($app){
		$params = package_book_parameters($consignment_number, $app);
});

function package_user_parameters($student_id, $app) {
	$first_name = $app->request()->params('first_name');
	$last_name = $app->request()->params('last_name');
	$email = $app->request()->params('email');
	$phone_number = $app->request()->params('phone_number');
	
	$params = array("student_id" => $student_id,
						  "first_name" => $first_name,
						  "last_name" => $last_name,
						  "email" => $email,
						  "phone_number" => $phone_number);

			return $params;
}

function package_book_parameters($isbn, $app) {
	$author = $app->request()->params('author');
	$title = $app->request()->params('title');
	$edition = $app->request()->params('edition');
	$courses = $app->request()->params('courses');
	$subject = $app->request()->params('subject');
	$course_number = $app->request()->params('course_number');

	$params = array("isbn" => $isbn,
				  "author" => $author,
				  "title" => $title,
				  "edition" => $edition,
				  "subject" => $subject,
				  "course_number" => $course_number);

			return $params;
}

function package_consignment_parameters($consignment_number, $app) {

		$isbn = $app->request()->params('isbn');
		$student_id = $app->request()->params('student_id'); 
		$price = $app->request()->params('price');
		$current_state = $app->request()->params('current_state');
		$date = $app->request()->params('date');

		$params = array("consignment_number" => $consignment_number,		
						"isbn" => $isbn,
					    "student_id" => $student_id,
					    "price" => $price,
					    "current_state" => $current_state,
					    "date" => $date);

			return $params;
}

function package_consignment_patch_parameters($consignment_number,$consignment_item, $app) {
			
			$price = $app->request()->params('price');
			$current_state = $app->request()->params('current_state');
			
			$params = array("consignment_number" => $consignment_number,		
						    "price" => $price,
						    "current_state" => $current_state,
						    "consignment_item" => $consignment_item,
					    );
			
			
			return $params;
}

function package_inventory_parameters($isbn, $app) {
	// need to be able to take approx titles..
	$title = $app->request()->params('title');
	$subject = $app->request()->params('subject');	
	$course_number = $app->request()->params('course_number');	
	$current_state = $app->request()->params('current_state');	
	$consignment_number = $app->request()->params('consignment_number');
	$author = $app->request()->params('author');
	$edition = $app->request()->params('edition');
	$consignment_item = $app->request()->params('consignment_item');
	
	$params = array("isbn" => $isbn,
				  "author" => $author,
				  "title" => $title,
				  "edition" => $edition,
				  "subject" => $subject,
				  "course_number" => $course_number,
				  "current_state" => $current_state,
				  "consignment_number" => $consignment_number);

			return $params;
}
	
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