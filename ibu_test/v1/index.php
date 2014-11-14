<?php

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
                $response['titile'] = $book['titile'];
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
                 $tmp["titile"] = $book["titile"];
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







/**
 * User Registration
 * url - /register
 * method - POST
 * params - student_id, first_name, last_name, email, phone_number
 */
$app->post('/register', function() use ($app) {
            // check for required params
            // verifyRequiredParams(array('student_id', 'first_name', 'last_name', 'email', 'phone_number'));
           
			
            $response = array();
 
            // reading post params
            $student_id = $app->request->post('student_id');
			$first_name = $app->request->post('first_name');
			$last_name = $app->request->post('last_name');
            $email = $app->request->post('email');
            $phone_number = $app->request->post('phone_number');
 
            $db = new DbHandler();
            $res = $db->createUser($student_id, $first_name, $last_name, $email, $phone_number);
 
            if ($res == USER_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully registered";
            } else if ($res == USER_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";                
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this email already existed";
            }
			// echo json response
            echoRespnse(201, $response);
        });
		

		

/**
 * Book submission to DB
 * url - /addBook
 * method - POST
 * params - isbn, title, author, edition, courses
 */
$app->post('/addBook', function() use ($app) {
            // check for required params
            // verifyRequiredParams(array('isbn', 'title', 'author', 'edition', 'courses'));
 
            $response = array();
 
            // reading post params
            $isbn = $app->request->post('isbn');
			$titile = $app->request->post('titile');
			$author = $app->request->post('author');
			$edition = $app->request->post('edition');
            $courses = $app->request->post('courses');
 
            $db = new DbHandler();
            $res = $db->createBook($isbn, $titile, $author, $edition, $courses);
 
            if ($res == BOOK_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "The book has been successfully added";
                echoRespnse(201, $response);
            } else if ($res == BOOK_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while adding the book";
                echoRespnse(200, $response);
            } else if ($res == BOOK_ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this book already existed";
                echoRespnse(200, $response);
            }
        });

		
    function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
    }
	
	
$app->run();
?>