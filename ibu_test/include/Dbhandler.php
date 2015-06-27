<?php 

	require_once '../include/methods/getter.php';
	require_once '../include/methods/patcher.php';
	require_once '../include/methods/poster.php';
	require_once '../include/DbConnect.php';

abstract class DbHandler {
	
	// could I just implement here and have a method to fetch back proper getter?
	public function get_method($params) {
		$getter = $this->get_getter();
        
		$res = $getter->retrieve($params);
        
		// for now let's just have it return the response
			return $res;
	}
	
	public function patch_method($params) {
	    // this should check for existence
	    $patcher = $this->get_patcher();
	    
	    $res = $patcher->update($params);
	    
	       return ($res) ? "Successfully Updated" : "There Was An Error";
	}
	 
	public function post_method($params) {

	   // need to check for the prior existence of each record....
	   // at this point it would be easier to relegate to poster...but poster are not handlers....
	   
	   $list_of_posters = $this->get_posters();
	   
	   
	   // this will need to handle distribution of the params to the posters
	   // this will also need to check for the prior existence of the records
	   // call_posters will return:
	   // error: boolean
	   // collection of keys
	   $res = $this->call_posters($list_of_posters, $params);
	   
	   // this creates and calls on deleters if there was errors
	   // id of the recource which was unsuccessfully created should be saved into $res....
	   // need to make sure posters check their sql statements
	   $results = $this->handle_errors($res);
        
        // the result needs to be a specification of for which record the process failed for..
        // it may be the case that the resource being created already existed or that there was an error
        // note that if a record already existed that error would be passed to error handler....
        	   
	    return $results;
	   
	}



	//abstract protected function delete_match($params);

	abstract protected function get_getter();
    abstract protected function get_patcher();
    abstract protected function get_posters();
    
    abstract protected function call_posters($list_of_posters, $params);
    abstract protected function verify_nonexistance($params);
    abstract protected function handle_errors($res);
}

class DbUserResourceHandler extends DbHandler {
		protected $conn;

	function __construct() {
    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }	


    protected function get_getter() {
    	$getter = new User_Getter($this->conn);
    		return $getter;
    }
    
    protected function get_patcher() {
        $patcher = new User_Patcher($this->conn);
            return $patcher;
    }
    
    protected function get_posters() {
        $poster = new User_Poster($this->conn);
        $list_of_posters["user"] = $poster;
            return $list_of_posters;
    }
    
    protected function call_posters($list_of_posters, $params) {
        if ($this->verify_nonexistance($params)) {
            
            $res = $list_of_posters["user"]->create($params);
                return $res;
                
        } else {
            $res["error"] = true;
            $res["message"] = "The Record Already Existed";
            $res["keys"] = $params["student_id"];
                return $res;
        }
    }
    
    protected function verify_nonexistance($params) {
        $getter = $this->get_getter();
        $res = $getter->retrieve($params);
            return $res;
    }
    
    // For users this method doesn't actually do anything,
    // There is no case where we have to rollback or change message
    protected function handle_errors($res) {
        return $res;
    } 

}

class DbBooksResourceHandler extends DbHandler {
		protected $conn;

	function __construct() {
    require_once  '../include/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }

    protected function get_getter() {
    	$getter = new Books_Courses_Getter($this->conn);
    		return $getter;
    }
    
    protected function get_patcher() {
        $patcher = new Book_Patcher($this->conn);
            return $patcher;
    }
    
    protected function get_posters() {
        $book_poster = new Book_Poster($this->conn);
        $course_poster = new Course_Poster($this->conn);
        $course_book_poster = new Course_Books_Poster($this->conn);
        
        $list_of_posters["book"] = $book_poster;
        $list_of_posters["course"] = $course_poster;
        $list_of_posters["course_book"] = $course_book_poster;
            return $list_of_posters;
    }

    protected function call_posters($list_of_posters, $params) {
        if (true) {
            $res = $this->get_res_array();
            
            var_dump($res);
            
            $isbn = $params["isbn"];
            $author = $params["author"];
            $title = $params["title"];
            $edition = $params["edition"];
            $courses = $params["courses"]; // should be a list of courses

            $book_params = array("isbn" => $isbn,
                                "author" => $author,
                                "title" => $title,
                                "edition" => $edition);

            $courses_params = array("isbn" => $isbn,
                                    "courses" => $courses);

            $book_result = $list_of_posters["book"]->create($book_params); 
                                                                                        
            $res["error"] = $book_result["error"];
            $res["keys"]["book"] = $book_result;
                                                                                        
            // loops through what should be a list of courses
            // each loops results is checked by union with previous results
            $course_results = $this->call_poster_courses($courses_params);

            $res["error"] = $res["error"] && $course_results["error"];
            $res["keys"]["courses"] = $course_results["courses"];
            $res["keys"]["course_books"] = $course_results["course_books"];
                
                return $res;

            } else {
                $res["error"] = true;
                $res["message"] = "The Record Already Existed";
                $res["keys"]["book"] = $params["isbn"];
                    return $res;
            }
        
    }
    private function call_poster_courses($courses_params) {
        // set the base for the arrays here:
        $res["error"] = false;
        $course_results["error"] = false;
        $course_book_results["error"] = false;
        $course_results["courses"] = array();
        $course_book_results["course_results"] = array();

        // how is this getting the necessary isbn?
        foreach ($courses_params["courses"] as $course) {

            // params for course
            $course_course["subject"] = $course["subject"];
            $course_course["course_number"] = $course["course_number"];

            // params for course_book
            $course_course_books["isbn"] = $courses_params["isbn"];
            $course_course_books["subject"] = $course["subject"];
            $course_course_books["course_number"] = $course["course_number"];

            $course_result = $list_of_posters["course"]->create($course_course);
            $course_results["error"] = $course_results["error"] && $course_result["error"];
            $course_results["courses"][] = $course_result;

            $course_books_result = $list_of_posters["course_book"]->create($course_course_books);
            $course_books_results["error"] = $course_books_results["error"] && $course_book_result["error"];
            $course_books_results["courses"][] = $course_books_result;
        
        }

        $res["error"] = $course_results["error"] && $course_books_results["error"];
        $res["courses"] = $course_results;
        $res["keys"]["course_books"] = $course_book_results;
            return $res;

    }
    private function get_res_array() {
        $res["error"] = false;
        $res["keys"] = $this->get_key_array();
        $res["message"] = "Records were successfully created.";
            return $res;
    }
    private function get_key_array() {
        $keys = array();
        $keys["book"] = null;
        $keys["courses"] = null;
        $keys["course_books"] = null;
            return $keys;
    }

    protected function verify_nonexistance($params) {
        $getter = $this->get_getter();
        $res = $getter->retrieve($params);
            return $res;
    }

    protected function handle_errors($res) {
        if ($res["error"]) {
            
            if ($res["keys"]["book"]["error"]) {

                $this->handle_book_error($res);

            } elseif ($res["keys"]["courses"]["error"]) {

                $this->handle_course_error($res);

            } elseif ($res["keys"]["course_books"]["error"]) {

                $this->handle_course_book_errors($res);
            }


        } else {

            return $res;

        }

    }

    private function handle_book_error($res) {
        // then courses should be deleted
        // course_books will fail if book was not created
        // need to ensure that the message specifies that the book has failed
        if ($res["keys"]["courses"]["error"]) {

            $deleter = new Course_deleter($this->conn);
            foreach ($res["keys"]["courses"]["courses"] as $course) {
                $deleter->delete($course);    
            }
        }
    }
    private function handle_course_error($res) {
        // if a course fails then we do need to rollback the book 
        if ($res["keys"]["book"]["error"]) {
            
            $deleter = new Book_deleter($this->conn);
            $deleter->delete($res["keys"]["book"]["book"]);
        }
    }
    private function handle_course_book_errors($res) {
        // if a course_book fails we need to rollback book and courses
        if ($res["keys"]["book"]["error"]) {
            $deleter = new Book_deleter($this->conn);
            $deleter->delete($res["keys"]["book"]["book"]);   
        }

        if (!$res["keys"]["courses"]["error"]) {

            $deleter = new Course_deleter($this->conn);
            foreach ($res["keys"]["courses"]["courses"] as $course) {
                $deleter->delete($course);    
            }
        }
    }


}


class DbInventoryResourceHandler extends DbHandler {
		protected $conn;
	
	function __construct() {
    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }

    protected function get_getter() {
    	$getter = new Inventory_Getter($this->conn);
    		return $getter;
    }
    
    protected function get_patcher() {
        $patcher = new UserPatcher($this->conn);
            return $patcher;
    }
    
     protected function get_posters() {
         
     }
    
     protected function call_posters($list_of_posters, $params) {
         
     }
     
     protected function handle_errors($res) {
         
     }
     
     protected function verify_nonexistance($params) {
         
     }

}