<?php 

abstract class DbHandler {
	
	// could I just implement here and have a method to fetch back proper getter?
	protected function get_method($params) {
		$getter = $this->get_getter();

		$res = $getter->retrieve($params);

		// for now let's just have it return the response
			return $res;

	}

	abstract protected function post_method($params);
	abstract protected function patch_method($params);
	abstract protected function delete_match($params);

	abstract protected function get_getter();
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
    	$getter = new User_Getter();
    		return $getter;
    }

	protected function patch_method($params) {
		$patcher = new User_Patcher();

		$res = $patcher->update($params);

		//handle response
	}

	protected function delete_match($params) {
	}	

}

class DbBooksResourceHandler extends DbHandler {
		protected $conn;

	function __construct() {
    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }

    protected function get_getter() {
    	$getter = new User_Getter();
    		return $getter;
    }

	protected function post_method($params) {
		// this does a call to books table and courses table and course_books table
		// so create the three poster and have the params fr each prepared
		// remembering that I have to check for prior existence
		// then handle their responses
		// if something goes wrong need to delete all that was created
	}

	protected function patch_method($params) {}

	protected function delete_match($params) {}	

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
    	$getter = new User_Getter();
    		return $getter;
    }

	protected function patch_method($params) {}

	protected function delete_match($params) {}	
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
    	$getter = new User_Getter();
    		return $getter;
    }

	protected function post_method($params) {}

	protected function patch_method($params) {}

	protected function delete_match($params) {}	
}