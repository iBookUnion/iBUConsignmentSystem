<?php
	
	require_once('../include/Dbhandler.php');
	require_once '../include/DbUserHandler.php';
	require_once '../include/DbBookHandler.php';
	require_once '../include/DbConsignmentHandler.php';
	require_once '../include/DbInventoryHandler.php';
	require_once '../include/DbCoursesHandler.php';
	require('../libs/Slim/Slim.php');

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

$app->get('/hello/:name', hello($name));

function hello($name) {
	$app = \Slim\Slim::getInstance();
	
	echo "hello!";
	var_dump($name);
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
