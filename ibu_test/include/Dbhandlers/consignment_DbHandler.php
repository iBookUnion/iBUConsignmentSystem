<?php


class DbConsignmentsResourceHandler extends DbHandler 
{
    protected $conn;

    function __construct() {
    require_once  '../include/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }

    public function postMethod($resource)
    {
        $listOfResults = array();
        $listOfPosters = array();

        //need to create the user first to create the consignmn
        $user = $resource->getUser();
        $userPoster = $user->getPoster($this->conn);
        $listOfResults[] = $userPoster->insert();

        // create the consignment and obtain the generated consignment number
        // so the consigned items can be created
        $consignmentPoster = $resource->getPoster($this->conn);
        $listOfResults[] = $consignmentPoster->insert();
        $consignmentNumber = $this->assignConsignmentNUmberFromDatabase($resource);

        // have the consigned item return posters for itself and its respective book
        $books = $resource->getBooks();
        $bookPosters = $this->getBookPosters($books);
        $listOfResults = array_merge($listOfResults, $this->usePosters($bookPosters));

        // need to create the courses as well
        $coursePosters = $this->getCoursePosters($books);
        $listOfResults = array_merge($listOfResults, $this->usePosters($coursePosters));

        //$this->rollback($listOfResults);

        return $listOfResults;
    }

    // this should not only figure out the consignment number it should also
    // make sure the consignment number is correctly assigned to all the objects that require it
    private function assignConsignmentNUmberFromDatabase($consignment)
    {
        $consignmentGetter = $consignment->getGetter($this->conn);
        $consignmentNumber = $consignmentGetter->determineConsignmentNumber();
        $consignment->setConsignmentNumber($consignmentNumber);
        $consignment->assignConsignmentNumberToConsignmentItems();
    }

    private function getBookPosters($books) 
    {
        $listOfPosters = array();
        foreach ($books as $book) {
            $listOfPosters = array_merge($listOfPosters, $book->getPoster($this->conn)); // can return two posters
        }
        return $listOfPosters;
    }

    private function getCoursePosters($books)
    {
        $courses = $this->getAllCourses($books);
        $listOfPosters = array();
        foreach ($courses as $course) {
            $listOfPosters = array_merge($listOfPosters, $course->getPoster($this->conn)); // returns two posters
        }
        return $listOfPosters;
    }

    private function getAllCourses($books)
    {
        $courses = array();
        foreach ($books as $key => $book) {
            $courses = array_merge($courses, $book->getBook()->getCourses());
        }
        return $courses;
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