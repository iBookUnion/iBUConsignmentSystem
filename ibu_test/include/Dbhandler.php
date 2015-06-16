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
        $res["book"] = $list_of_posters["book"]->create($params);
        
        // loops through what should be a list of courses
        // each loops results is checked by union with previous results
        foreach ($params["courses"] as $course) {
            
            $res["course"] = $res["course"] && $list_of_posters["course"]->create($course);
            $res["course_book"] =  $res["course_book"] && $list_of_posters["course_book"]->create($course);
            
        }        
            return $res;
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
        $res["user"] = $list_of_posters["user"]->create($params);
        $res["consignment"] = $list_of_posters["consignment"]->create($params);
        
        // loops through what should be a list 
        // each loops results is checked by union with previous results
        foreach ($params["books"] as $book) {
            
            $res["books"] =  $res["books"] && $list_of_posters["book"]->create($book);
            $res["consigned_items"] = $res["consigned_items"] && $list_of_posters["consigned_item"]->create($book);
            
            foreach ($params["books"]["courses"] as $course) {
                    $res["course"] = $res["course"] && $list_of_posters["course"]->create($course);
                    $res["course_book"] =  $res["course_book"] && $list_of_posters["course_book"]->create($course);
            }
            
        }        
                return $res;
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