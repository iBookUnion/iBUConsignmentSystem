<?php

class Delegate 
{
	
#pragma mark - Methods for User Poster Retrieval

    public function getUserPoster($user, $conn)
    {
		$result = $this->confirmUserDoesNotExist($user, $conn);
		if ($result) {
			$poster = new UserPoster($user, $conn);			
		} else {
			$poster = new NullPoster($user, $conn);
		}

		return $poster;
    }
    
    // it seems somewhat weird to have this method here
    // consider it pushing it back to handler
    private function confirmUserDoesNotExist($user, $conn) 
	{
		$getter = $this->getUserGetter($user, $conn);
		$result = $getter->retrieve();
		return $result;
	}
    
    
    public function getUserGetter($user, $conn)
	{
		$getter = new UserGetter($user, $conn);
		return $getter;
	}
	
	public function getUserDeleter($user, $conn) {
		$deleter = new UserDeleter($user, $conn);
		return $deleter;
	}
	
#pragma mark - methods for Book Poster retrieval


	public function getBookPoster($book, $conn) 
	{
		$result = $this->confirmBookDoesNotExist($book, $conn);
		if ($result) {
			$poster = new BookPoster($book, $conn);			
		} else {
			$poster = new NullPoster($book, $conn);
		}

		return $poster;
	}
	
	public function getCoursePosters($book, $conn)
    {   
        $courses = $book->getCourses();
        
        $listOfPosters = array();
        foreach ($courses as $course) {
            $listOfPosters = array_merge($listOfPosters, $this->getCoursePoster($course, $conn));
        }
                
        return $listOfPosters;
    }

	private function confirmBookDoesNotExist($book, $conn) 
	{
		$getter = $this->getBookGetter($book, $conn);
		$result = $getter->retrieve();
		return $result;
	}

	public function getBookGetter($book, $conn)
	{
		$getter = new BookGetter($book, $conn);
		return $getter;
	}

	public function getBookDeleter($conn) {
		$deleter = new BookDeleter($book, $conn);
		return $deleter;
	}
	
#pragma mark - methods for Course Poster Retrieval

	public function getCoursePoster($course, $conn) 
	{
		$posters = array();
		$results = array();

		$results = $this->confirmCourseResourceDoesNotExist($course, $conn);
		if ($results["courseResult"]) {
            $posters[] = new CourseBookPoster($course, $conn);
			$posters[] = new CoursePoster($course, $conn);			
		} else if ($results["courseBookResult"]) {
			$posters[] = new CourseBookPoster($course, $conn);
		} else {
		    $posters[] = new NullPoster($course, $conn);
		}

		return $posters;
	}

	private function confirmCourseResourceDoesNotExist($course, $conn) 
	{   
		$results = array();
		$getter = $this->getCourseGetter($course, $conn);
		$courseBookGetter = $getter["courseBookGetter"];
		$courseGetter = $getter["courseGetter"];

		$results["courseBookResult"] = $courseBookGetter->retrieve();
		$results["courseResult"] = $courseGetter->retrieve();
		
		return $results;
	}

	public function getCourseGetter($course, $conn)
	{
		$getters = array();
		$courseGetter = new CourseGetter($course, $conn);
		$courseBookGetter = new CourseBookGetter($course, $conn);
		$getters["courseGetter"] = $courseGetter;
		$getters["courseBookGetter"] = $courseBookGetter;
		return $getters;
	}

	public function getDeleter($course, $conn) {
		$deleters = array();
		$courseDeleter = new CourseDeleter($course, $conn);
		$courseBookDeleter = new courseBookDeleter($course, $conn);
		$deleters["courseDeleter"] = $courseDeleter;
		$deleters["courseBookDeleter"] = $courseBookDeleter;

		return $deleters;
	} 

#pragma mark - methods for Consignment Post retrieval

	public function getConsignmentPoster($consignment, $conn) {
		if ($this->confirmConsignmentDoesNotExist($consignment, $conn)) {
			$poster = new NullPoster($consignment, $conn);
		} else {
			$poster = new ConsignmentPoster($consignment,$conn);
		}

		return $poster;
	}
	
	private function confirmConsignmentDoesNotExist($consignment, $conn) 
	{
		$getter = $this->getConsignmentGetter($consignment, $conn);
		$consignmentExisted = $getter->checkForPreExistingConsignment();
		return $consignmentExisted;
	}

	public function getConsignmentGetter($consignment, $conn)
	{
		$getter = new ConsignmentGetter($consignment, $conn);
		return $getter;
	}

	public function getDeleter($consignment, $conn) {
		$deleter = new ConsignmentDeleter($consignment, $conn);
		return $deleter;
	}
	
	public function getConsignmentItemPosters($consignmentItems, $conn) 
    {
        $listOfPosters = array();
        foreach ($consignmentItems as $consignmentItem) {
            $listOfPosters = array_merge($listOfPosters, $this->getConsignmentItemPoster($consignmentItem, $conn)); // can return two posters
        }
        return $listOfPosters;
    }
    
#pragma mark - methods for ConsignedItems Poster retrieval

	public function getPoster($conn) {
		// check whether the resouce to be created existed prior
		// to trying to create it again
		$posters = array();
		$results = array();

		$results = $this->confirmResourceDoesNotExist($conn);
		if ($results["bookResult"]) {
			$posters[] = new ConsignedItemPoster($this, $conn);
			$posters[] = new BookPoster($this->getBook(), $conn);
		} else if ($results["consignedItemResult"]) {
			$posters[] = new ConsignedItemPoster($this, $conn);
		} else {
		    $posters[] = new NullPoster($this, $conn);
		}
		
		return $posters;
	}

	// should check if the consigned item exists
	// if it does there is no need to check if the book does
	// if it doesn't should check if the book does
	private function confirmConsignmentItemDoesNotExist($consignmentItem, $conn) 
	{
		$results = array();
		$getters = $this->getConsignmentItemGetter($consignmentItem, $conn);
		$consignedItemGetter = $getters["consignedItem"];
		$bookGetter = $getters["book"];

		$results["consignedItemResult"] = $consignedItemGetter->retrieve();
		$results["bookResult"] = $bookGetter->retrieve();
		return $results;
	}

	public function getConsignedItemGetter($consignmentItem, $conn)
	{
		$getters = array();
		$consignedItemGetter = new ConsignedItemGetter($consignmentItem, $conn);
		$bookGetter = new BookGetter($consignmentItem, $conn);
		$getters["consignedItem"] = $consignedItemGetter;
		$getters["book"] = $bookGetter;
		return $getters;
	}

	public function getConsignedItemDeleter($conn) 
	{

	}
	
	private function getCoursePosters($consignmentItems, $conn)
    {
        $courses = $this->getAllCourses($consignmentItems);
        $listOfPosters = array();
        foreach ($courses as $course) {
            $listOfPosters = array_merge($listOfPosters, $course->getCoursePoster($conn)); // returns two posters
        }
        return $listOfPosters;
    }

    private function getAllCourses($consignmentItems)
    {
        $courses = array();
        foreach ($consignmentItems as $consignmentItems) {
            $courses = array_merge($courses, $consignmentItem->getBook()->getCourses());
        }
        return $courses;
    }

}