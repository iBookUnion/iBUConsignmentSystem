<?php

class DbUserHandler extends DbHandler {

	protected $conn;
	protected $table = "users";
	protected $key = "student_id";

	function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }


    protected function set_conditions($query_params) {
		$conditions = array();

		$conditions["student_id"] = $this->set_student_id($query_params["student_id"]);
		$conditions[] = $this->set_first_name($query_params["first_name"]);
		$conditions[] = $this->set_last_name($query_params["last_name"]);
		$conditions[] = $this->set_email($query_params["email"]);
		$conditions[] = $this->set_phone_number($query_params["phone_number"]);

			return $conditions;
    }


    protected function package_result($stmt) {

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

    protected function obtain_key($params) {
    	$k = $params[$this->key];
    		return $k;
    }

    protected function get_table() {
    		return $this->table;
    }

    protected function get_columns() {
    	$columns = " (student_id, first_name, last_name, email, phone_number) ";
    		return $columns;
    }

    protected function get_search_array($key) {
        $query_params = array("student_id" => $key,
                     		  "first_name" => null,
                      		  "last_name" => null,
                              "email" => null,
                      		  "phone_number" => null);
        	return $query_params;
    }
    
    protected function get_identity($conditions) {
    	$identity = $conditions[$this->key];
    		return $identity;
    }

    protected function prepare_strings($params) {
    	$params["first_name"] = $this->stringify($params["first_name"]);  
    	$params["last_name"] =  $this->stringify($params["last_name"]);
    	$params["email"] = $this->stringify($params["email"]);
    		return $params;
    }
    
    private function set_student_id($query_param) {
    	if ($query_param != null) {
			$cond = "student_id = " . $query_param;
		} else {
			$cond = "student_id = null";
		}
				return $cond;
    }

    private function set_first_name($query_param) {
		if ($query_param != null) {
			$cond = "first_name = " . $this->stringify($query_param);
    	} else {
			$cond = "first_name = null";
		}
				return $cond;		
    }
    private function set_last_name($query_param) {
    	if ($query_param != null) {
			$cond = "last_name = " . $this->stringify($query_param);
		} else {
			$cond = "last_name = null";
		}  	
				return $cond;		
    }
    private function set_email($query_param) {
    	if ($query_param != null) {
			$cond = "email = " . $this->stringify($query_param);
		} else {
			$cond = "email = null";
		}    
				return $cond;
    }
    private function set_phone_number($query_param) {
     	if ($query_param != null) {
			$cond = "phone_number = " . $query_param;
		} else {
			$cond = "phone_number = null";
		}
				return $cond;
    }
   
}

?>