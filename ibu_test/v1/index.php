<?php
	
	//require_once('../include/Dbhandler.php');
	require('../libs/Slim/Slim.php');
	require('../include/resources/factory.php');
	require('../include/resources/resources.php');
	require('../include/resources/book.php');
	require('../include/resources/consigneditems.php');
	require('../include/resources/consignment.php');
	require('../include/resources/course.php');
	require('../include/Dbhandler.php');
	require('../include/results/results.php');
	require('../include/helpers/helpers.php');
	

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();


// users are all very repetitive could technically refactor into one call
// use methods to determine what to do, set up is


$app->post('/users', function() use ($app) {
		
		$userFactory = new UserFactory($app);
		$dbHandler = new DbUserResourceHandler;
		$parameters = $userFactory->getParameters();
		
		$user = $userFactory->makeObject($parameters);
		
		$result = $dbHandler->postMethod($user);
		
		$user->printOut();
		echoRespnse($result->getStatusCode(), $result->produceResponse());

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