<?php


class DbConsignmentsResourceHandler implements DbHandler 
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

        //need to create the user first to create the consignment
        $user = $resource->getUser();
        $userPoster = $this->delegate->getUserPoster($user, $this->conn);
        $listOfResults[] = $userPoster->insert();

        $consignmentPoster = $this->delegate->getConsignmentPoster($resource, $this->conn);
        $listOfResults[] = $consignmentPoster->insert(); 
       
        $this->assignConsignmentNumberFromDatabase($resource);

        // have the consigned item return posters for itself and its respective book
        $consignmentItems = $resource->getConsignmentItems();
        $consignmentItemsPosters = $this->delegate->getConsignmentItemPosters($consignmentItems, $this->conn);
        $listOfResults = array_merge($listOfResults, $this->usePosters($consignmentItemsPosters));

        // need to create the courses as well
        $coursePosters = $this->delegate->getAllCoursePosters($consignmentItems, $this->conn);
        $listOfResults = array_merge($listOfResults, $this->usePosters($coursePosters));

        //$this->rollback($listOfResults);

        return $listOfResults;
    }

    private function assignConsignmentNumberFromDatabase($consignment)
    {   
        $consignmentGetter = $this->delegate->getConsignmentGetter($consignment, $this->conn);
        $consignmentNumber = $consignmentGetter->determineConsignmentNumber();
        $consignment->assignConsignmentNumberToConsignmentItems();
    }

    // should generalize to make it work on any list of posters
    private function usePosters($posters)
    {
        $listOfResults = array();
        foreach ($posters as $poster) {
            $listOfResults[] = $poster->insert();            
        }
        return $listOfResults;
    }
}