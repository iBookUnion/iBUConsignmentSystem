<?php 

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
		$stmt->bind_result($isbn, $student_id, $price, $current_state, $date);
		
		$consignments = array();
		while($row = $stmt->fetch())
		{			
			$consignment["isbn"] = $isbn;
			$consignment["student_id"] = $student_id;
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