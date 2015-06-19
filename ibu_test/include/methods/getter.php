<?php

// there needs to be one of these classes for every type of query required
// based on the joining of the tables neccessary
abstract class Getter {
	
	public function retrieve($params) {
		$conditions = $this->set_search_conditions($params);
		$query = $this->prepare_query_statement($conditions);
		
		var_dump($query);
		
		// should I leave the actual execuion to another class?
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		
		$packaged_results = $this->package_results($stmt);
		
			return $packaged_results;

	}

	abstract protected function set_search_conditions($params);

	abstract protected function get_table();
	
	// Default will obtain all records from the table
	protected function prepare_query_statement($conditions) {

    	$query = "SELECT * FROM " . $this->get_table();
        $cnd_stmt = implode_and($conditions);
        

    	if ($cnd_stmt != "")
		{
			$query .= ' WHERE ' . $cnd_stmt;
		}

	    	return $query;
	}

	abstract protected function package_results($stmt);

	// the setter methods are repetitive, should do something about that

}

class User_Getter extends Getter {
		protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
    
	// with the changes that have occured I should not get a list element if the param is non-existant
	protected function set_search_conditions($query_params){
		$conditions = array();

		$conditions["student_id"] = $this->set_student_id($query_params["student_id"]);
		$conditions["first_name"] = $this->set_first_name($query_params["first_name"]);
		$conditions["last_name"] = $this->set_last_name($query_params["last_name"]);
		$conditions["email"] = $this->set_email($query_params["email"]);
		$conditions["phone_number"] = $this->set_phone_number($query_params["phone_number"]);

			return $conditions;
	}

	protected function get_table() {
		return "users";
	}

	protected function package_results($stmt) {
		$rows = $stmt->num_rows;
		$stmt->bind_result($student_id, $first_name, $last_name, $email, $phone_number);
		
		$users = array();

		while($row = $stmt->fetch())
		{
			$user["student_id"] = $student_id;
			$user["first_name"] = $first_name;
			$user["last_name"] = $last_name;
			$user["email"] = $email;
			$user["phone_number"] = $phone_number;
			$users[] = $user;	
		}
		
		$stmt->close();		

			return $users;		
	}

	private function set_student_id($query_param) {
    	if ($query_param != null) {
			$cond = "student_id = " . $query_param;
				return $cond;
		}
    }

    private function set_first_name($query_param) {
		if ($query_param != null) {
			$cond = "first_name = " . $this->stringify($query_param);
				return $cond;		
    	}
    }

    private function set_last_name($query_param) {
    	if ($query_param != null) {
			$cond = "last_name = " . $this->stringify($query_param); 	
				return $cond;		
		}
    }

    private function set_email($query_param) {
    	if ($query_param != null) {
			$cond = "email = " . $this->stringify($query_param);   
				return $cond;
		}
    }

    private function set_phone_number($query_param) {
     	if ($query_param != null) {
			$cond = "phone_number = " . $query_param;
				return $cond;
		}
	}
}

class Books_Courses_Getter extends Getter {
			protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
    
    protected function prepare_query_statement($conditions) {

		$fields = "books.isbn, title, author, edition, GROUP_CONCAT( CONCAT(subject, ' ', course_number)) as courses ";
    	$query = "SELECT " . $fields . "FROM " . $this->get_table();
        $cnd_stmt = implode_and($conditions);
        

    	if ($cnd_stmt != "")
		{
			$query .= ' WHERE ' . $cnd_stmt;
		}
		
		$query .=  " GROUP BY books.isbn";

	    	return $query;
	}
	
	protected function set_search_conditions($query_params) {
		$conditions = array();

		$conditions["isbn"] = $this->set_isbn($query_params["isbn"]);
		$conditions["author"] = $this->set_author($query_params["author"]);
		$conditions["title"] = $this->set_title($query_params["title"]);
		$conditions["edition"] = $this->set_edition($query_params["edition"]);
		$conditions["subject"] = $this->set_subject($query_params["subject"]);
		$conditions["course_number"] = $this->set_course_number($query_params["course_number"]);

			return $conditions; 		
	}

	protected function get_table() {
		return "books LEFT JOIN course_books ON books.isbn = course_books.isbn";
	}

	protected function package_results($stmt) {
		$rows = $stmt->num_rows;
		$stmt->bind_result($isbn, $title, $author, $edition, $courses);
		
		$books = array();
		while($row = $stmt->fetch())
		{
			$book["isbn"] = $isbn;
			$book["title"] = $title;
			$book["author"] = $author;
			$book["edition"] = $edition;
			$book["courses"] = $courses;
			$books[] = $book;
		}
		
		$stmt->close();
			return $books;	
	}

	private function set_isbn($query_param) {
    	if ($query_param != null) {
    		$cond = "books.isbn = " . $query_param;
    		    return $cond;
    	}
    }

	private function set_author($query_param) {
    	if ($query_param != null) {
    		$cond = "author = " . $this->stringify($query_param);
    		    return $cond;
    	}
	}

	private function set_title($query_param) {
    	if ($query_param != null) {
    		$cond =  "(title LIKE '%" . ($query_param) . "%')";;
    		    return $cond;
    	}
	}

	private function set_edition($query_param) {
    	if ($query_param != null) {
    		$cond = "edition = " . $this->stringify($query_param);
    		    return $cond;
    	}
	}
	
	private function set_subject($query_param) {
	    if ($query_param != null) {
	        $cond = "subject = " . $this->stringify($query_param);
	            return $cond;
	    }
	}
	
	private function set_course_number($query_param) {
	    if ($query_param != null) {
	        $cond = "course_number = " . $this->stringify($query_param);
	            return $cond;

	    }
	}

}

class ALL_Consignment_Getter extends Getter {
		protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
	
	protected function prepare_query_statement($conditions) {

		$fields = "consignments.consignment_number, users.student_id, first_name, last_name, email, phone_number,
					date, consigned_items.consignment_item, books.isbn, title, edition, price, current_state";
    	$query = "SELECT " . $fields . " FROM " . $this->get_table();
        $cnd_stmt = implode_and($conditions);

    	if ($cnd_stmt != "")
		{
			$query .= ' WHERE ' . $cnd_stmt;
		}
		
		$query .=  " ORDER BY consignments.consignment_number";

	    	return $query;
	}
	
	protected function set_search_conditions($query_params) {
		$conditions = array();
    	
    	$conditions["consignment_number"] = $this->set_consignment_number($query_params["consignment_number"]);
		$conditions["isbn"] = $this->set_isbn($query_params["isbn"]);
		$conditions["student_id"] = $this->set_student_id($query_params["student_id"]);
		$conditions["price"] = $this->set_price($query_params["price"]);
		$conditions["current_state"] = $this->set_current_state($query_params["current_state"]);
		$conditions["date"] = $this->set_date($query_params["date"]);

			return $conditions;	
	}

	protected function get_table() {
		$table = "books
	    	JOIN consigned_items
		      ON books.isbn = consigned_items.isbn
		   JOIN consignments
		     ON consignments.consignment_number = consigned_items.consignment_number
		   JOIN users
		     ON consignments.student_id = users.student_id";
			
			return $table;
	}

	protected function package_results($stmt) {
		$rows = $stmt->num_rows;
		$stmt->bind_result($consignment_number, $student_id, $first_name, $last_name, $email, $phone_number,
					$date, $consignment_item, $isbn, $title, $edition, $price, $current_state);
		
		$consignments = array();
		while($row = $stmt->fetch())
		{			
			$consignment["consignment_number"] = $consignment_number;
			$consignment["student_id"] = $student_id;
			$consignment["first_name"] = $first_name;
			$consignment["last_name"] = $last_name;
			$consignment["email"] = $email;
			$consignment["phone_number"] = $phone_number;
			$consignment["date"] = $date;
			$consignment["consignment_item"] = $consignment_item;
			$consignment["isbn"] = $isbn;
			$consignment["title"] = $title;
			$consignment["edition"] = $edition;
			$consignment["price"] = $price;
			$consignment["current_state"] = $current_state;
			
			$consignments[] = $consignment;
		}
		
		$stmt->close();
			return $consignments;	
	}
	
	private function set_consignment_number($query_param) {
		if ($query_param != null) {
			$cond = "consignments.consignment_number = " . $query_param;
				return $cond;
		}
	}
	
	private function set_isbn($query_param) {
		if ($query_param != null) {
			$cond = "isbn = " . $query_param;
    		    return $cond;
    	}
	}

	private function set_student_id($query_param) {
		if ($query_param != null) {
			$cond = "student_id = " . $query_param;
    		    return $cond;
    	}
	}

	private function set_price($query_param) {
		if ($query_param != null) {
			$cond = "price = " . $query_param;
    	return $cond;
    	}
	}

	private function set_current_state($query_param) {
		if ($query_param != null) {
			$cond = "current_state = " . $this->stringify($query_param);
    		    return $cond;
    	}
	}

	private function set_date($query_param) {
		if ($query_param != null) {
			$cond = "date = " . $query_param;
    		    return $cond;
    	}
	}
}

class Inventory_Getter extends Getter {
			protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }

    protected function prepare_query_statement($conditions) {

		$fields = "consignment_number, consignment_item, books.isbn, title, author, edition, price, current_state, GROUP_CONCAT( CONCAT(subject, ' ', course_number)) as courses ";
		$query = "SELECT " . $fields . "FROM " . $this->get_table();
	    $cnd_stmt = implode_and($conditions);
	    

		if ($cnd_stmt != "")
		{
			$query .= ' WHERE ' . $cnd_stmt;
		}
		
		$query .=  " GROUP BY books.isbn";

	    	return $query;
	}
    
	protected function set_search_conditions($query_params) {
		$conditions = array();

		$conditions["isbn"] = $this->set_isbn($query_params["isbn"]);
		$conditions["author"] = $this->set_author($query_params["author"]);
		$conditions["title"] = $this->set_title($query_params["title"]);
		$conditions["edition"] = $this->set_edition($query_params["edition"]);
		// $conditions["price"] = $this->set_price($query_params["price"]);
		$conditions["current_state"] = $this->set_current_state($query_params["current_state"]);
		// $conditions["date"] = $this->set_date($query_params["date"]);
		
			return $conditions;         
	}
	
	protected function get_table() {
		return "books JOIN consigned_items ON books.isbn = consigned_items.isbn LEFT JOIN course_books ON books.isbn = course_books.isbn";
	}
	
	protected function package_results($stmt) {
		$rows = $stmt->num_rows;
		$stmt->bind_result($consignment_number, $consignment_item,
							$isbn, $title, $author, $edition, $price,
							$current_state, $courses);
		
		$inventory = array();

		while($row = $stmt->fetch())
		{
			$book["isbn"] = $isbn;
			$book["title"] = $title;
			$book["author"] = $author;
			$book["edition"] = $edition;
			$book["courses"] = $courses;
			$book["price"] = $price;
			$book["current_state"] = $current_state;
			$book["consignment_number"] = $consignment_number;
			$book["consigned_item"] = $consignment_item;

			
			$inventory[] = $book;	
		}
		
		$stmt->close();		

			return $inventory;	
	}
	    private function set_isbn($query_param) {
    	if ($query_param != null) {
    		$cond = "books.isbn = " . $query_param;
    		    return $cond;
    	}
    }
    
	private function set_student_id($query_param) {
		if ($query_param != null) {
			$cond = "student_id = " . $query_param;
    		    return $cond;
    	}
	}
	
	private function set_author($query_param) {
    	if ($query_param != null) {
    		$cond = "author = " . stringify($query_param);
    		    return $cond;
    	}
	}

	private function set_title($query_param) {
    	if ($query_param != null) {
    		$cond = "(title LIKE '%" . ($query_param) . "%')";
    		    return $cond;
    	}
	}

	private function set_edition($query_param) {
    	if ($query_param != null) {
    		$cond = "edition = " . stringify($query_param);
    		    return $cond;
    	}
	}    
	private function set_price($query_param) {
		if ($query_param != null) {
			$cond = "price = " . $query_param;
    		    return $cond;
    	}
	}

	private function set_current_state($query_param) {
		if ($query_param != null) {
			$cond = "current_state = " . stringify($query_param);
    		    return $cond;
    	}
	}

	private function set_date($query_param) {
		if ($query_param != null) {
			$cond = "date = " . $query_param;
    		    return $cond;
    	}
	}
}

function implode_and($conditions) {
        return implode_recursive($conditions, " AND ");
}

function implode_comma($conditions) {
        return implode_recursive($conditions, ", ");
}

function implode_recursive($conditions, $glue) {
    if ($conditions != null) {
        $condition = array_shift($conditions);
        if ($condition == null) {
            return implode_recursive($conditions, $glue);
        } else {
            return $condition . implode_helper($conditions, $glue);
        }
    }
}

function implode_helper($conditions, $glue) {
    if ($conditions != null) {    
        $condition = array_shift($conditions);
        if ($condition == null) {
            return implode_helper($conditions, $glue);
        } else {
            return $glue . $condition . implode_helper($conditions, $glue);
        }
    }    
}
