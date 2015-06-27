<?php

abstract class Poster {
	
	// if a resource was successfully created its key should be returned
	// this is in case it has to be rollbacked by the dbhandler
	public function create($params) {
		// check for prior existence will be taken care by handler
	   	$insert = $this->obtain_insert_statement($params);
		
		var_dump($insert);
		
	   // relegate use of DB
	   	$stmt = $this->conn->prepare($insert);
		$res = $stmt->execute();
		$stmt->store_result();
		
		$result = $this->get_result($res, $params);

        return $result;
	}

	protected function obtain_insert_statement($params) {
		$columns = $this->get_columns();
        $values = $this->get_values($params);
        $statement = "INSERT INTO " . $this->get_table() . $columns . " VALUES" . $values; 
            return $statement;
	}

	protected function get_values($params) {
		$params = $this->prepare_strings($params);
        $values = " (" . implode_comma($params) . ") ";
            return $values;
	}

	abstract protected function get_columns();
	abstract protected function get_table();
	abstract protected function get_result($res, $params);

}

class User_Poster extends Poster {
	protected function get_columns() {
    	$columns = " (student_id, first_name, last_name, email, phone_number) ";
    		return $columns;		
	}

	protected function get_table() {
		return "users";
	}
	
	protected function get_result($res, $params) {
		$result["error"] = $res;
		$result["user"] = $params["student_id"];
		
		return $result;
	}
}

class Book_Poster extends Poster {
        protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
    
	protected function get_columns() {
        $columns = " (isbn, title, author, edition)";
            return $columns;
	}

	protected function get_table() {
		return "books";
	}
	
	protected function prepare_strings($params) {
        $params["title"] = stringify($params["title"]);  
        $params["author"] =  stringify($params["author"]);
        //$params["courses"] = $this->stringify($params["courses"]);
            return $params;
    }
    
    protected function get_result($res, $params) {
		$result["error"] = $res;
		$result["book"] = $params["isbn"];
		
		return $result;
	}
}

class Course_Poster extends Poster {
        protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }	
	protected function get_columns() {
		$columns = " (subject, course_number) ";
			return $columns;
	}

	protected function get_table() {
		return "courses";
	}
	
	protected function get_result($res, $params) {
		$result["error"] = $res;
		// how do I handle double key here?
		$result["course"] = $params["student_id"];
		
		return $result;
	}

}

class Course_Books_Poster extends Poster {
	   protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
	protected function get_columns() {
		$columns = " (isbn, subject, course_number) ";
			return $columns;
	}

	protected function get_table() {
		return "";
	}
	
	protected function get_result($res, $params) {
		$result["error"] = $res;
		// how do I handle the double key here?
		$result["course_books"] = $params["student_id"];
		
		return $result;
	}

}

class Consignment_Poster extends Poster {
	protected function get_columns() {
		$columns = " (consignment_number, student_id, date) ";
			return $columns;
	}
	
	protected function get_table() {
		return "consignments";
	}

}

class Consigned_Item_Poster extends Poster {
	        protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
	protected function get_columns() {
		$columns = " (consignment_number, isbn, consignment_item, current_state, price) ";
			return $columns;
	}

	protected function get_table() {
		return "consignment_items";
	}

}