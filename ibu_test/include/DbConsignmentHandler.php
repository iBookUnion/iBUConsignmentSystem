<?php 

// overload the get statement creator to allow table join
// will need to further change methods to take in more variables
// I can get the consignments now,
// should I set it up so that it works a bit more cleanly when searching for a exact consignment?
// need to add the ew columns to the table

// the post is a bit more difficult, should follow the bookhandler design
// a bit more complicate as it requires more tables

// student info
// books list
// book info
// courses list
// course info

class DbConsignmentHandler extends DbHandler {

	protected $conn;
	protected $table = "consignments";
	protected $key = ["isbn","student_id"];

	function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    
    protected function set_conditions($query_params) {
    	$conditions = array();
    	
		$conditions["isbn"] = $this->set_isbn($query_params["isbn"]);
		$conditions["student_id"] = $this->set_student_id($query_params["student_id"]);
		$conditions["price"] = $this->set_price($query_params["price"]);
		$conditions["current_state"] = $this->set_current_state($query_params["current_state"]);
		$conditions["date"] = $this->set_date($query_params["date"]);

			return $conditions;	
    }

    protected function package_result($stmt) {
    	$rows = $stmt->num_rows;
		$stmt->bind_result($isbn, $student_id, $price, $current_state,
							$date, $consignment_number, $consignment_item,
							$student_id2, $first_name, $last_name,
							$email, $phone_number);
		
		$consignments = array();
		while($row = $stmt->fetch())
		{			
			$consignment["consignment_number"] = $consignment_number;
			$consignment["student_id"] = $student_id;
			$consignment["first_name"] = $first_name;
			$consignment["last_name"] = $last_name;
			$consignment["email"] = $email;
			$consignment["phone_number"] = $phone_number;
			$consignment["isbn"] = $isbn;
			$consignment["consignment_item"] = $consignment_item;
			$consignment["price"] = $price;
			$consignment["current_state"] = $current_state;
			$consignment["date"] = $date;
			$consignments[] = $consignment;
		}
		
		$stmt->close();
			return $consignments;		

    }

    protected function obtain_key($params) {
    	// need to specifiy two locations in the $params array
  		$k = array("isbn" => $params[$this->key[0]],
  					"student_id" => $params[$this->key[1]]);
    		return $k;
    }

    protected function get_table() {
    		return $this->table;
    }

    protected function get_columns() {
    	$columns = "(isbn, student_id, price, current_state)";
    		return $columns;
    }
    
    protected function get_search_array($key) {
        $query_params = array("isbn" => $key["isbn"],
                      		  "student_id" => $key["student_id"],
                      		  "price" => null,
                      		  "current_state" => null,
                      		  "date" => null);
        	return $query_params;
    }
    
    protected function get_identity($conditions) {
    	        var_dump($conditions);
    	$key_0 = $conditions[$this->key[0]];
    	$key_1 = $conditions[$this->key[1]];
    	$identity = $key_0 . " AND " . $key_1;
    		return $identity;
    }
    
    protected function insert($params) {
    	// need to insert into users, books, courses, consignments
    	// all need their own ois
        $users_insert =  $this->obtain_user_insert_statement($params);
   		$books_insert =  $this->obtain_book_insert_statement($params);
   		$courses_insert =  $this->obtain_courses_insert_statement($params);
   		// needs to have ois modified so that they all get the same consignment number
   		$consignments_insert =  $this->obtain_insert_statement($params);
		
		//if it fails at any point need to backtrack and delete what succeeded 
    	$result["user"] = $this->user_insert($users_insert); // "User insert failed"  
		$result["book"] = $this->book_insert($books_insert); // "book insert failed"
		$result["course"] = $this->course_insert($courses_insert); // "course insert failed"
		$result["consignment"] = $this->consignment_insert($consignments_insert); // "consignment insert failed"
		
		// make a method to deal with the results
        	return $ths->set_result($result);

    }
    
    private function user_insert($users_insert) {
    	$stmt = $this->conn->prepare($users_insert);
        $result = $stmt->execute();
        $stmt->close();
        	return $result;
    }
    
    private function book_insert($books_insert) {
    	$stmt = $this->conn->prepare($books_insert);
        $result = $stmt->execute();
        $stmt->close();
        	return $result;
    }
    
    private function course_insert($courses_insert) {
    	$stmt = $this->conn->prepare($courses_insert);
        $result = $stmt->execute();
        $stmt->close();
        	return $result;
    }
    
    private function consignment_insert($consignments_insert) {
    	$stmt = $this->conn->prepare($consignments_insert);
        $result = $stmt->execute();
        $stmt->close();
        	return $result;
    }

	// returns an array: first element is a boolean specifying if there was an error
	// second is the message specifiying the error
    private function set_result($result) {
    	// check if all the insertion occurred correctly
    	// if any of them failed delete what occurred before (how would I do this???) 
    	// may need to refrain from doing the deletion until the next refactoring
		$result_statement = array();
		$result_statement["error"] = false;
		// is there a map in php? probably...
		$res = $result["user"] && $result["book"] && $result["course"] && $result["consignment"];
		
		if ($res) {
			$result_statement["message"] = "Consignment Successfully Created";
			return $result_statement;
		} else {
			return $this->get_result($result);			
		}
    }
    
    private function get_error($result) {
    	$result_statement = array();
		$result_statement["error"] = true;
    	
    	if (!$result["user"]) {
    		$result_statement["message"] = "There Was An Error In Creating User Record. ";
    	} elseif (!$result["book"]) {
    		$result_statement["message"] .= "There Was An Error In A Creating Book Record. ";
    	} elseif (!$result["course"]) {
    		$result_statement["message"] .= "There Was An Error In Creating Course Record. ";
    	} elseif (!$result["consignment"]) {
    		$result_statement["message"] .= "There Was An Error In Creating Consignment Record. ";
    	}
    		return $result_statement;
    }
    
    //overloaded method:
    protected function set_query($conditions) {

    	// obtain records from the join of users and consignments
    	$query = "SELECT * FROM " . $this->get_table();
    	$join = " JOIN users ON users.student_id = consignments.student_id";
    	$query .= $join;
    	
        $cnd_stmt = $this->implode_and($conditions);
        
    	if ($cnd_stmt != "")
		{
			$query .= ' WHERE ' . $cnd_stmt;
		}
	    	return $query;
    }
    
    private function obtain_user_insert_statement($params) {
        $stmt_base = "INSERT INTO users (student_id, first_name, last_name, email, phone_number) VALUES ";
        $values = $this->get_user_values($params);
        
        $insert = $stmt_base . $values;
            return $insert;
    }
   	
   	private function obtain_book_insert_statement($params) {
        $stmt_base = "INSERT INTO books (isbn, title, author, edition) VALUES ";
        $values = $this->get_book_values($params["books"]);
        
        $insert = $stmt_base . $values;
            return $insert;	
   	}
   	
   	private function obtain_courses_insert_statement($params) {
        $stmt_base = "INSERT INTO courses (`isbn`, `subject`, `course_number`) VALUES ";
        $values = $this->get_course_values($params["books"]);
        
        $insert = $stmt_base . $values;
            return $insert;
   	}
   	
   	private function obtain_insert_statement($params) {
        $stmt_base = "INSERT INTO consignments (isbn, student_id, price, current_state, consignment_number, consignment_item) VALUES ";
        $values = $this->get_consignment_values($params);
        
        $insert = $stmt_base . $values;
            return $insert;
   	}

    private function get_user_values($params) {
        unset($params["books"]);
        $user_values = $this->get_values($params);
            return $user_values;
    }

    private function get_book_values($params) {
        //may be the case that i have a list of books...
        // snip the courses etc.
        // get values, wrap values and combine
    }

    private function get_course_values($params) {
        // for each book in the list get the isbn
        // go through course list and wrap up
        // wrap them all up together
    }

    private function get_consignment_values($params) {
        //  will need to use the student_id on all of them
        // then for each book in the list
        // get the isbn etc.
        // we know the state
        // need to figure out how we will determine a consignment number.....
    }
      
    protected function prepare_strings($params) {
    	$params["current_state"] = $this->stringify($params["current_state"]);  
    		return $params;    	
    }    

	private function set_isbn($query_param) {
		if ($query_param != null) {
			$cond = "isbn = " . $query_param;
		} else {
    	    $cond = "isbn = null";
    	}
    		    return $cond;
	}

	private function set_student_id($query_param) {
		if ($query_param != null) {
			$cond = "student_id = " . $query_param;
		} else {
    	    $cond = "student_id = null";
    	}
    		    return $cond;
	}

	private function set_price($query_param) {
		if ($query_param != null) {
			$cond = "price = " . $query_param;
		} else {
    	    $cond = "price = null";
    	}
    		    return $cond;
	}

	private function set_current_state($query_param) {
		if ($query_param != null) {
			$cond = "current_state = " . $this->stringify($query_param);
		} else {
    	    $cond = "current_state = null";
    	}
    		    return $cond;
	}

	private function set_date($query_param) {
		if ($query_param != null) {
			$cond = "date = " . $query_param;
		} else {
    	    $cond = "date = null";
    	}
    		    return $cond;
	}

}