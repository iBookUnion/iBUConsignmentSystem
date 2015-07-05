<?php 

	require_once '../include/methods/poster.php';
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

    public function postMethod() 
    {
        $listOfResults = array();
        
        $bookPoster = $book->getPoster($this->conn);
        $listOfResults = $bookPoster->insert();
       // that assignment to the list might override the result of the book
        $coursePosters = $this->getCoursePosters($book);
        $listOfResults = $this->useCoursePosters($coursePosters);        

        $this->rollback($listOfResults);

        return $listOfResults;
    }

}

class DbConsignmentsResourceHandler extends DbHandler 
{
    protected $conn;

    function __construct() {
    require_once  '../include/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }

    public function postMethod($consignment)
    {
        $listOfResults = array();

        $consignmentPoster = $consignment->getPoster($conn);
        $listOfResults[] = $consignmentPoster->insert();

        $books = $consignment->getBooks();
        $bookPosters = $this->getBookPosters($consignment); 
        $listOfResults[] = $this->useBookPosters($bookPosters);
        // need to create the courses as well
        $coursePosters = $this->getCoursePosters($consignment);
        $listOfResults[] = $this->useCoursePosters($coursePosters);

        $this->rollback($listOfResults);

        return $listOfResults;
    }
}
