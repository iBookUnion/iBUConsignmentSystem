<?php 

	require_once '../include/methods/getter/getter.php';
	require_once '../include/methods/poster/poster.php';
	require_once '../include/DbConnect.php';

abstract class DbHandler {

}

class DbUserResourceHandler extends DbHandler 
{
		protected $conn;

	function __construct() {
    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }	

    public function postMethod($user) 
    {
        $poster = $user->getPoster($this->conn);
        $result = $poster->insert();
        return $result;
    }

}

class DbBooksResourceHandler extends DbHandler 
{
		protected $conn;

	function __construct() {
    require_once  '../include/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }

    public function postMethod($book) 
    {
        $listOfResults = array();
        $listOfPosters = array();
        
        $listOfPosters[] = $book->getPoster($this->conn); 
 
        $listOfPosters =+ $this->getCoursePosters($book);
        $listOfResults = $this->usePosters($listOfPosters);

        //$this->rollback($listOfResults);

        return $listOfResults;
    }

    private function getCoursePosters($book)
    {   
        $courses = $book->getCourses();
        $listOfPosters = array();
        foreach ($courses as $course) {
            $listOfPosters = $listOfPosters + $course->getPoster(); // this returns two posters not one
        }
    }

    private function usePosters($listOfPosters)
    {
        $listOfResults = array();
        foreach ($listOfPosters as $poster) {
            $listOfResults[] = $poster->insert();
        }
    }

}

// class DbConsignmentsResourceHandler extends DbHandler 
// {
//     protected $conn;

//     function __construct() {
//     require_once  '../include/DbConnect.php';
//     // opening db connection
//     $db = new DbConnect();
//     $this->conn = $db->connect();
//     }

//     public function postMethod($consignment)
//     {
//         $listOfResults = array();
//         $listOfPosters = array();

//         //need to create the user first to create the consignmn
//         $user = $consignment->getUser();
//         $userPoster = $user->getPoster($this->conn);
//         $listOfResults[] = $userPoster->insert();

//         // create the consignment and obtain the generated consignment number
//         // so the consigned items can be created
//         $consignmentPoster = $consignment->getPoster($this->conn);
//         $listOfResults[] = $consignmentPoster->insert();
//         $consignmentNumber = $this->assignConsignmentNUmberFromDatabase($consignment);

//         // have the consigned item return posters for itself and its respective book
//         $books = $consignment->getBooks();
//         $bookPosters = $this->getBookPosters($books);
//         $listOfResults =+ $this->usePosters($bookPosters);

//         // need to create the courses as well
//         $coursePosters = $this->getCoursePosters($books);
//         $listOfResults =+ $this->usePosters($coursePosters);

//         //$this->rollback($listOfResults);

//         return $listOfResults;
//     }

//     // this should not only figure out the consignment number it should also
//     // make sure the consignment number is correctly assigned to all the objects that require it
//     private function assignConsignmentNUmberFromDatabase($consignment)
//     {
//         $consignmentGetter = $consignment->getGetter($this->conn);
//         $consignmentNumber = $consignmentGetter->determineConsignmentNumber();
//         $consignment->setConsignmentNumber($consignmentNumber);
//         $consignment->assignConsignmentNumberToConsignmentItems();
//     }

//     private function getBookPosters($books) 
//     {
//         $listOfPosters = array();
//         foreach ($books as $book) {
//             $listOfPosters =+ $book->getPoster($this->conn); // returns two posters
//         }
//         return $listOfPosters;
//     }

//     private function getCoursePosters($books)
//     {
//         $courses = $this->getAllCourses($books);
//         $listOfPosters = array();
//         foreach ($courses as $course) {
//             $listOfPosters[] = $course->getPoster($this->conn); // returns two posters
//         }
//         return $listOfPosters;
//     }

//     private function getAllCourses($books)
//     {
//         $courses = array();
//         foreach ($books as $key => $book) {
//             $courses =+ $book->getCourses();
//         }
//         return $courses;
//     }

//     // should generalize to make it work on any list of posters
//     private function usePosters($Posters)
//     {
//         $listOfResults = array();
//         foreach ($Posters as $poster) {
//             $listOfResults[] = $poster->insert();            
//         }
//         return $listOfResults;
//     }
// }

