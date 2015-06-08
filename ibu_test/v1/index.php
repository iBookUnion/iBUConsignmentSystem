<?php
	
	require_once('../include/Dbhandler.php');
	require('../libs/Slim/Slim.php');

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();


// users are all very repetitive could technically refactor into one call
// use methods to determine what to do, set up is

$app->get('/users(/:student_id)', function($student_id = null) use ($app) {
		$params = package_user_parameters($student_id, $app);
		
		echo "sometshing";
				
		$db = new DbUserResourceHandler();
		$db->get_method($params);
		
		// manage errors

});

$app->patch('/users/:student_id', function($student_id) use ($app) {
		$params = package_user_parameters($student_id, $app);
		// create controller
		//manage errors
});

$app->delete('/users/:student_id', function($student_id) use ($app) {
		$params = package_user_parameters($student_id, $app);
		// create controller
		//manage errors
});


$app->get('/books(/:isbn)', function($isbn = null) use ($app) {
		$params = package_book_parameters($isbn, $app);

});

$app->post('/books', function() use ($app) {
				// calll to functions
});

$app->patch('/books/:isbn', function($isbn) use ($app) {
		$params = package_book_parameters($isbn, $app);
});

$app->delete('/books/:isbn', function() use ($app){
		$params = package_book_parameters($isbn, $app);
});

$app->get('/consignments(/:consignment_number)', function() use ($app){
		$params = package_consignment_parameters($consignment_number, $app);
});

$app->post('/consignments', function() use ($app) {

});

$app->patch('/consignments/:consignment_number', function() use ($app){
		$params = package_book_parameters($consignment_number, $app);
});

$app->delete('/consignments/:consignment_number', function() use ($app){
		$params = package_book_parameters($consignment_number, $app);
});


$app->get('/inventory(/:isbn)', function() use ($app){
		$params = package_inventory_parameters($isbn, $app);
});

function package_user_parameters($student_id, $app) {
	$first_name = $app->request()->post('first_name');
	$last_name = $app->request()->post('last_name');
	$email = $app->request()->post('email');
	$phone_number = $app->request()->post('phone_number');
	
	$params = array("student_id" => $student_id,
						  "first_name" => $first_name,
						  "last_name" => $last_name,
						  "email" => $email,
						  "phone_number" => $phone_number);

			return $params;
}

function package_book_parameters($isbn, $app) {
	$author = $app->request()->get('author');
	$title = $app->request()->get('title');
	$edition = $app->request()->get('edition');
	$courses = $app->request()->get('courses');
	$subject = $app->request()->get('subject');
	$course_number = $app->request()->get('course_number');

	$params = array("isbn" => $isbn,
				  "author" => $author,
				  "title" => $title,
				  "edition" => $edition,
				  "subject" => $subject,
				  "course_number" => $course_number);

			return $params;
}

function package_consignment_parameters($consignment_number, $app) {
		$isbn = $app->request()->get('isbn');
		$student_id = $app->request()->get('student_id'); 
		$price = $app->request()->get('price');
		$current_state = $app->request()->get('current_state');
		$date = $app->request()->get('date');

		$params = array("isbn" => $isbn,
							  "student_id" => $student_id,
							  "price" => $price,
							  "current_state" => $current_state,
							  "date" => $date);

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