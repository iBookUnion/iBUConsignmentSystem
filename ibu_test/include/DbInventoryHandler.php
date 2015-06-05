<?php
 
class DbInventoryHandler extends DbHandler {
    
    protected $conn;
	protected $table = "books JOIN consignments ON books.isbn = consignments.isbn";
	protected $key = "isbn";
	
	function __construct() {
    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    }
	
    protected function set_conditions($query_params) {
    	$conditions = array();

		$conditions["isbn"] = $this->set_isbn($query_params["isbn"]);
		$conditions["student_id"] =$this->set_student_id($query_params["student_id"]);
		$conditions["author"] = $this->set_author($query_params["author"]);
		$conditions["title"] = $this->set_title($query_params["title"]);
		$conditions["edition"] = $this->set_edition($query_params["edition"]);
		$conditions["price"] = $this->set_price($query_params["price"]);
		$conditions["current_state"] = $this->set_current_state($query_params["current_state"]);
		$conditions["date"] = $this->set_date($query_params["date"]);
		
			return $conditions;         
    }
    
    protected function package_result($stmt) {
    	$rows = $stmt->num_rows;
		$stmt->bind_result($isbn, $title, $author, $edition,
						   $isbn_alt, $student_id, $price,
						   $current_state, $date, $consignment_number, $consignment_item);
		
		$inventory = array();

		while($row = $stmt->fetch())
		{
			$book["isbn"] = $isbn;
			$book["student_id"] = $student_id;
			$book["title"] = $title;
			$book["author"] = $author;
			$book["edition"] = $edition;
			$book["price"] = $price;
			$book["current_state"] = $current_state;
			$book["date"] = $date;
			$book["consignment_number"] = $consignment_number;
			$book["consignment_item"] = $consignment_item;
			
			$inventory[] = $book;	
		}
		
		$stmt->close();		

			return $inventory;	
    }
    
    protected function get_table() {
            return $this->table;    
    }

    // helper functions for create()
    protected function obtain_key($params) {
            return $this->key;    
    }
    
    protected function get_columns() {
        
    }
    
    protected function get_search_array($key) {
        
    }
    
    protected function prepare_strings($params) {
        
    }
    
    protected function get_identity($params) {
        
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
    	    $cond = "isbn = null";
    	}
    		    return $cond;
	}
	
	private function set_author($query_param) {
    	if ($query_param != null) {
    		$cond = "author = " . $this->stringify($query_param);
    	} else {
    	    $cond = "author = null";
    	}
    		    return $cond;
	}

	private function set_title($query_param) {
    	if ($query_param != null) {
    		$cond = "(title LIKE '%" . ($query_param) . "%')";
    	} else {
    	    $cond = "title = null";
    	}
    		    return $cond;
	}

	private function set_edition($query_param) {
    	if ($query_param != null) {
    		$cond = "edition = " . $this->stringify($query_param);
    	} else {
    	    $cond = "edition = null";
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
    	    $cond = "current_state = 1";
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