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

//	abstract protected function post_method($params);
	//abstract protected function patch_method($params);
	//abstract protected function delete_match($params);

	abstract protected function get_getter();
    abstract protected function get_patcher();
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
    
//	protected function post_method($params) {
		// this does a call to books table and courses table and course_books table
		// so create the three poster and have the params fr each prepared
		// remembering that I have to check for prior existence
		// then handle their responses
		// if something goes wrong need to delete all that was created
//	}

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
        $patcher = new UserPatcher($this->conn);
            return $patcher;
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
    

}