<?php 

class DbBooksResourceHandler implements DbHandler 
{
	protected $conn;
	protected $delegate;

	function __construct() {
    require_once  '../include/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    $this->delegate = new Delegate();
    }

    public function postMethod($resource) 
    {
        $listOfResults = array();
        $listOfPosters = array();
        
        $listOfPosters[] = $this->delegate->getBookPoster($resource, $this->conn); 
 
        $listOfPosters = array_merge($listOfPosters, $this->delegate->getCoursePosters($resource, $this->conn));

        $listOfResults = $this->usePosters($listOfPosters);

        //$this->rollback($listOfResults);

        return $listOfResults;
    }

    private function usePosters($listOfPosters)
    {
        $listOfResults = array();

        foreach ($listOfPosters as $poster) {
            $listOfResults[] = $poster->insert();
        }
        return $listOfResults;
    }
}