<?php
	
	//require_once('../include/Dbhandler.php');
	require('../libs/Slim/Slim.php');
	require('../include/resources/factory.php');
	require('../include/Dbhandler.php');

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();


// users are all very repetitive could technically refactor into one call
// use methods to determine what to do, set up is



$app->post('/books', function() use ($app) {

		$bookFactory = new BookFactory($app);
      	$parameters = $bookFactory->getParameters();
      	$book = $bookFactory->makeObject($parameters);
      	$book->printOut();
});

$app->post('/users', function() use ($app) {
		
		$userFactory = new UserFactory($app);
		$dbHandler = new DbUserResourceHandler;
		$parameters = $userFactory->getParameters();
		
		$user = $userFactory->makeObject($parameters);
		
		$result = $dbHandler->postMethod($user);
		
		$user->printOut();
		echoRespnse($result->getStatusCode(), $result->produceResponse());
});

$app->post('/consignments', function() use ($app) {
	
		$consignmentsFactory = new ConsignmentFactory($app);
		
		$json = $app->request->getBody();
        $params = json_decode($json, true);
		
		$parameters = $consignmentsFactory->getParameters();
		$consignment = $consignmentsFactory->makeObject($parameters);
		$consignment->printOut();
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