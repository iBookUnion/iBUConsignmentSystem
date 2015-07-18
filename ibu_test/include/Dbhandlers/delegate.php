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


}