<?php 

	require_once '../include/methods/getter.php';
	require_once '../include/methods/patcher.php';
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
	    $patcher = $this->get_patcher();
	    
	    $res = $patcher->update($params);
	    
	        return $res;
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
	   $results = $this->handle_results($res);
        
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
    abstract protected function handle_results($res);
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
    protected function handle_results($res) {
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
        if ($this->verify_nonexistance($params["isbn"])) {
            $res = $this->get_res_array();

            $book_result = $list_of_posters["book"]->create($params); 
                                                                                        
            $res["error"] = $book_result["error"];
            $res["keys"]["book"] = $book_result;
                                                                                        
            // loops through what should be a list of courses
            // each loops results is checked by union with previous results
            $course_results = $this->call_poster_courses($params);

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
    private function call_poster_courses($params) {
        // set the base for the arrays here:
        $res["error"] = false;
        $course_results["error"] = false;
        $course_book_results["error"] = false;
        $course_results["courses"] = array();
        $course_book_results["course_results"] = array();

        // how is this getting the necessary isbn?
        foreach ($params["courses"] as $course) {

            $course_result = $list_of_posters["course"]->create($course);
            $course_results["error"] = $course_results["error"] && $course_result["error"];
            $course_results["courses"][] = $course_result;

            $course_books_result = $list_of_posters["course_book"]->create($course);
            $course_books_results["error"] = $course_books_results["error"] && $course_book_result["error"];
            $course_books_results["courses"][] = $course_books_result;
        
        }

        $res["error"] = $course_results["error"] && $course_books_results["error"];
        $res["courses"] = $course_results;
        $res["keys"]["course_books"] = $course_book_results;
            return $res;

    }
    private function get_res_array() {
        $res["errors"] = false;
        $res["keys"] = $this->get_key_array();
        $res["message"] = "Records were successfully created."
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


class DbConsignmentsResourceHandler extends DbHandler {
		protected $conn;

	function __construct() {
    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }		


    protected function get_getter() {
    	$getter = new ALL_Consignment_Getter($this->conn);
    		return $getter;
    }
    
    protected function get_patcher() {
        $patcher = new Consignment_Patcher($this->conn);
            return $patcher;
    }
    
    protected function get_posters() {
        $user_poster = new User_Poster($this->conn);
        $book_poster = new Book_Poster($this->conn);
        $course_poster = new Course_Poster($this->conn);
        $course_book_poster = new Course_Books_Poster($this->conn);
        $consignment_poster = new Consignment_Poster($this->conn);
        $consigned_item_poster = new Consigned_Item_Poster($this->conn);
        
        $list_of_posters["user"] = $user_poster;
        $list_of_posters["book"] = $book_poster;
        $list_of_posters["course"] = $course_poster;
        $list_of_posters["course_book"] = $course_book_poster;
        $list_of_posters["consignment"] = $consignment_poster;
        $list_of_posters["consigned_item"] = $consigned_item_poster;
            return $list_of_posters;
    }
    
    protected function call_posters($list_of_posters, $params) {
       if (verify_nonexistence($params["consignment_number"])) {
            $res = $this->get_res_array();

            $consignment_results = $list_of_posters["consignment"]->create($params);
            $user_results = $list_of_posters["user"]->create($params); 

            $res["error"] = $user_results["error"] && $consignment_results["error"];
            $res["keys"]["user"] = $user_results;
            $res["keys"]["consignment"] = $consignment_results;

            // loops through what should be a list 
            // each loops results is checked by union with previous results
            $book_results = $this->call_poster_books($params);

            $res["error"] = $res["error"] && $book_results["error"];
            $res["keys"]["books"] = $book_results["books"];
            $res["keys"]["consigned_items"] = $book_results["consigned_item"];
            $res["keys"]["courses"] = $book_results["courses"];
            $res["keys"]["course_books"] = $book_results["course_books"];

                    return $res;
        } else {
            $res["error"] = true;
            $res["message"] = "The Record Already Existed";
            $res["keys"]["consignment"] = $params["consignment_number"];

                return $res;
        }
    }
    private function call_poster_books() {
        //set the base for the arrays here:
        $res["error"] = false;
        $book_results["error"] = false;
        $consigned_item_results["error"] = false;

        foreach ($params["books"] as $book) {
            
            $res["books"] =  $res["books"] && $list_of_posters["book"]->create($book);
            $res["consigned_items"] = $res["consigned_items"] && $list_of_posters["consigned_item"]->create($book);
            
            foreach ($params["books"]["courses"] as $course) {
                    $res["course"] = $res["course"] && $list_of_posters["course"]->create($course);
                    $res["course_book"] =  $res["course_book"] && $list_of_posters["course_book"]->create($course);
            }
            
        }
    }
    private function call_poster_courses() {
        //set the base for the arrays here:
        // set the base for the arrays here:
        $res["error"] = false;
        $course_results["error"] = false;
        $course_book_results["error"] = false;
        $course_results["courses"] = array();
        $course_book_results["course_results"] = array();

        // how is this getting the necessary isbn?
        foreach ($params["courses"] as $course) {

            $course_result = $list_of_posters["course"]->create($course);
            $course_results["error"] = $course_results["error"] && $course_result["error"];
            $course_results["courses"][] = $course_result;

            $course_books_result = $list_of_posters["course_book"]->create($course);
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
        $res["message"] = "Records were successfully created."
    }
    private function get_key_array() {
        $keys = array();
        $keys["consignment"] = null;
        $keys["user"] = null
        $keys["consigned_item"] = null;
        $keys["books"] = null;
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
    	$getter = new Book_Consignment_Getter($this->conn);
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
     
     protected function handle_results($res) {
         
     }

}