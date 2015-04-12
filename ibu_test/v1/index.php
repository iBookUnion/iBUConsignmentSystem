<?php
/* ---------------------------------------------------------------------------------------------------------------------------------------------------
   | URL                                             |METHOD    |PARAMETERS                                               |DESCRIPTION               |
   |-------------------------------------------------------------------------------------------------------------------------------------------------|
   | http://localhost/ibu_test/v1/register             POST      student_id, first_name, last_name, email, phone_number    Creates a user            |
   | http://localhost/ibu_test/v1/user/:id             GET       student_id                                                Retrieves a user          |
   | http://localhost/ibu_test/v1/users                GET       NONE                                                      Retrieves all users       |
   | http://localhost/ibu_test/v1/addBook              POST      isbn, author, title, edition, courses                     Creates a book            |
   | http://localhost/ibu_test/v1/books/:isbn          GET       isbn                                                      Retrieves a book          |
   | http://localhost/ibu_test/v1/books                GET       NONE                                                      Retrieves all books       |
   | http://localhost/ibu_test/v1/consign              POST      isbn, student_id, price, current_state                    Creates a consignment     |
   | http://localhost/ibu_test/v1/consignment/:id      GET       student_id                                                Retrieves a consignment   |
   | http://localhost/ibu_test/v1/consignment/:isbn    GET       isbn                                                      Retrieves a consignment   |
   | http://localhost/ibu_test/v1/consignments         GET       NONE                                                      Retrieves all consignments|
   | http://localhost/ibu_test/v1/consignment_update   PUT       current_state                                             alters state              |
   ---------------------------------------------------------------------------------------------------------------------------------------------------
   
*/

require_once '../include/DbHandler.php';
require '.././libs/Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/test', function () { 
    echo 'Hello World';
});

$app->get('/test/:name', 'helloname');

function helloname($name) {
  echo "Hello $name";
}

/*
* USER:: METHOD: GET (By STUDENT ID)
* http://localhost/ibu_test/v1/user/:id
* 
*/
$app->get('/user/:student_id', function($student_id) use ($app) {
                 $db = new DbHandler();
				 $response = array();
             	 $user = $db->getUser($student_id);
	             
			if ($user != NULL) {
                $response["error"] = false;
                $response['student_id'] = $user['student_id'];
                $response['first_name'] = $user['first_name'];
                $response['last_name'] = $user['last_name'];
                $response['email'] = $user['email'];
				$response['phone_number'] = $user['phone_number'];
                echoRespnse(200, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
            }
        });

/*
* BOOK:: METHOD: GET (By ISBN)
* http://localhost/ibu_test/v1/books/:isbn
* 
*/		
$app->get('/book/:isbn', function($isbn) use ($app) {
                 $db = new DbHandler();
				 $response = array();
             	 $book = $db->getBook($isbn);
	             
			if ($book != NULL) {
                $response["error"] = false;
                $response['isbn'] = $book['isbn'];
                $response['titile'] = $book['title'];
                $response['author'] = $book['author'];
                $response['edition'] = $book['edition'];
				$response['courses'] = $book['courses'];
                echoRespnse(200, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
            }
        });		
		
		
/*
*
* USERS :: METHOD: GET (all users)
* http://localhost/ibu_test/v1/users
*		
*/		
		
$app->get('/users', function() use ($app) {
                 $db = new DbHandler();
				 $response = array();
				 $users = $db->getAllUsers();
				 
				 if ($users != NULL) {
				 
				$response["error"] = false;
				$response["users"] = array();
				
				 while ($user = $users->fetch_assoc()) {
                 $tmp = array();
                 $tmp["student_id"] = $user["student_id"];
                 $tmp["first_name"] = $user["first_name"];
                 $tmp["last_name"] = $user["last_name"];
				 $tmp["email"] = $user["email"];
				 $tmp["phone_number"] = $user["phone_number"];
                 array_push($response["users"], $tmp);
                }
                echoRespnse(200, $response);
				} else {
				$response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
				}
				
});



/*
*
* BOOKS :: METHOD: GET (all books)
* http://localhost/ibu_test/v1/books
*		
*/	
$app->get('/books', function() use ($app) {
                 $db = new DbHandler();
				 $response = array();
				 $books = $db->getAllBooks();
				 
				 if ($books != NULL) {
				 
				$response["error"] = false;
				$response["books"] = array();
				
				 while ($book = $books->fetch_assoc()) {
                 $tmp = array();
                 $tmp["isbn"] = $book["isbn"];
                 $tmp["title"] = $book["title"];
                 $tmp["author"] = $book["author"];
				 $tmp["edition"] = $book["edition"];
				 $tmp["courses"] = $book["courses"];
                 array_push($response["books"], $tmp);
                }
                echoRespnse(200, $response);
				} else {
				$response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
				}
				
});


/*
*
* BOOKS :: METHOD: GET (By student_id)
* http://localhost/ibu_test/v1/consignment/:id
*		
*/	
$app->get('/consignment/:id', function($student_id) use ($app) {
                 $db = new DbHandler();
				 $response = array();
				 $consignments = $db->getConsignment($student_id);
				 
				 if ($consignments != NULL) {
				 
				$response["error"] = false;
				$response["consignments"] = array();
				
				 while ($consignment = $consignments->fetch_assoc()) {
                 $tmp = array();
                 $tmp["isbn"] = $consignment["isbn"];
                 $tmp["student_id"] = $consignment["student_id"];
                 $tmp["price"] = $consignment["price"];
				 $tmp["current_state"] = $consignment["current_state"];
                 array_push($response["consignments"], $tmp);
                }
                echoRespnse(200, $response);
				} else {
				$response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
				}
				
});



/*
*
* BOOKS :: METHOD: GET (By ISBN)
* http://localhost/ibu_test/v1/consignment/:isbn
*		
*/	
$app->get('/consignment/:id', function($isbn) use ($app) {
                 $db = new DbHandler();
				 $response = array();
				 $consignments = $db->getConsignments($isbn);
				 
				 if ($consignments != NULL) {
				 
				$response["error"] = false;
				$response["consignments"] = array();
				
				 while ($consignment = $consignments->fetch_assoc()) {
                 $tmp = array();
                 $tmp["isbn"] = $consignment["isbn"];
                 $tmp["student_id"] = $consignment["student_id"];
                 $tmp["price"] = $consignment["price"];
				 $tmp["current_state"] = $consignment["current_state"];
                 array_push($response["consignments"], $tmp);
                }
                echoRespnse(200, $response);
				} else {
				$response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
				}
				
});


/*
*
* BOOKS :: METHOD: GET (By student_id)
* http://localhost/ibu_test/v1/consignments
*		
*/	
$app->get('/consignments', function() use ($app) {
                 $db = new DbHandler();
				 $response = array();
				 $consignments = $db->getAllConsignment();
				 
				 if ($consignments != NULL) {
				 
				$response["error"] = false;
				$response["consignments"] = array();
				
				 while ($consignment = $consignments->fetch_assoc()) {
                 $tmp = array();
                 $tmp["isbn"] = $consignment["isbn"];
                 $tmp["student_id"] = $consignment["student_id"];
                 $tmp["price"] = $consignment["price"];
				 $tmp["current_state"] = $consignment["current_state"];
                 array_push($response["consignments"], $tmp);
                }
                echoRespnse(200, $response);
				} else {
				$response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
				}
				
});



/**
 * User Registration
 * url - /register
 * method - POST
 * params - student_id, first_name, last_name, email, phone_number
 */
$app->post('/register', function() use ($app) {	
		
            $response = array();
 
            // reading post params
            $student_id = $app->request->post('student_id');
			$first_name = $app->request->post('first_name');
			$last_name = $app->request->post('last_name');
            $email = $app->request->post('email');
            $phone_number = $app->request->post('phone_number');
 
            $db = new DbHandler();
            $res = $db->createUser($student_id, $first_name, $last_name, $email, $phone_number);
 
            if ($res == 0) {
                $response["error"] = false;
                $response["message"] = "You are successfully registered";
            } else if ($res == 1) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";                
            } else if ($res == 2) {
                $response["error"] = true;
                $response["message"] = "Sorry, this user already exists";
            }
			// echo json response
            echoRespnse(201, $response);
        });
		

		

/**
 * Book submission to DB
 * url - /addBook
 * method - POST
 * params - isbn, title, author, edition, course/s
 */
$app->post('/addBook', function() use ($app) {

            $response = array();
 
            // reading post params
            $isbn = $app->request->post('isbn');
			$title = $app->request->post('title');
			$author = $app->request->post('author');
			$edition = $app->request->post('edition');
            $courses = $app->request->post('courses');
 
            $db = new DbHandler();
            $res = $db->createBook($isbn, $title, $author, $edition, $courses);
 
            if ($res == 0) {
                $response["error"] = false;
                $response["message"] = "The book has been successfully added";
                echoRespnse(201, $response);
            } else if ($res == 1) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while adding the book";
                echoRespnse(200, $response);
            } else if ($res == 2) {
                $response["error"] = true;
                $response["message"] = "Sorry, this book already existed";
                echoRespnse(200, $response);
            } 
        });
	
	
	/*
	* Consignment submission to DB
    * url - /consign
    * method - POST
    * params - isbn, student_id
	*/	
	$app->post('/consign', function() use ($app) {            
			
            $response = array();
 
            // reading post params
			$isbn = $app->request->post('isbn');
            $student_id = $app->request->post('student_id');
			$price = $app->request->post('price');
			$current_state = $app->request->post('current_state');

 
            $db = new DbHandler();
            $res = $db->createConsignment($isbn, $student_id, $price, $current_state);
 
            if ($res == 0) {
                $response["error"] = false;
                $response["message"] = "Consignment was successfully added";
            } else if ($res == 1) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while adding the Consignment";                
            } else if ($res == 2) {
                $response["error"] = true;
                $response["message"] = "Sorry, this consignment already exists";
            } else if ($res == 3) {
			    $response["error"] = true;
				$reponse["message"] = "Sorry, it appears the book or the user do not exist";
		    }
			// echo json response
            echoRespnse(201, $response);
        });	

	$app->put('/consignment_update', function() use ($app) {	
            
			$response = array();
			
			// reading post params
			$isbn = $app->request->post('isbn');
			$student_id = $app->request->post('student_id');
			$current_status = $app->request->post('current_status');
			
			$db = new DbHandler();
            
			

            // updating task
            $result = $db->updateConsignment($current_status, $isbn, $student_id);
            if ($result) {
                // consignment update successfully
                $response["error"] = false;
                $response["message"] = "Consignment updated successfully";
            } else {
                // consignment failed to update
                $response["error"] = true;
                $response["message"] = "Consignment failed to update. Please try again!";
            }
            echoRespnse(200, $response);
		
		
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