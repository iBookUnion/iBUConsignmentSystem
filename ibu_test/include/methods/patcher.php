<?php

// one for each table, the handler make use of more than one 
abstract class Patcher {
    
    public function update($params) {
        $conditions = $this->set_update_conditions($params);
        $revision = $this->prepare_update_statement($conditions);
        
        var_dump($revision);
        
        // should....
        $stmt = $this->conn->prepare($revision);
        $result = $stmt->execute();
        $stmt->close();
        
        return ($result) ? "Successfully Updated" : "There Was An Error";
    }
    
    protected function prepare_update_statement($conditions) {
        $alterations = $this->get_set_values($conditions);
        
        var_dump($alterations);
        
        $identity = $this->get_key($conditions);
        $statement = "UPDATE " . $this->get_table() . " SET " . $alterations . " WHERE " . $identity;
            return $statement;
    }

    protected function get_set_values($conditions) {
        $alterations = implode_comma($conditions);
            return $alterations;
    }
    
    abstract protected function set_update_conditions($params);
    
    abstract protected function get_table();
    
    abstract protected function get_key($conditions);
}

class User_Patcher extends Patcher {
        protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
    
    protected function set_update_conditions($update_params) {
		$conditions = array();

		$conditions["student_id"] = $this->set_student_id($update_params["student_id"]);
		$conditions["first_name"] = $this->set_first_name($update_params["first_name"]);
		$conditions["last_name"] = $this->set_last_name($update_params["last_name"]);
		$conditions["email"] = $this->set_email($update_params["email"]);
		$conditions["phone_number"] = $this->set_phone_number($update_params["phone_number"]);

			return $conditions;
	}
    
    protected function get_table() {
            return "users";
    }
    
    protected function get_key($conditions) {
        $key = $conditions["student_id"];
            return $key;
    }
    
    private function set_student_id($query_param) {
    	if ($query_param != null) {
			$cond = "student_id = " . $query_param;
				return $cond;
		}
    }

    private function set_first_name($query_param) {
		if ($query_param != null) {
			$cond = "first_name = " . stringify($query_param);
				return $cond;		
    	}
    }

    private function set_last_name($query_param) {
    	if ($query_param != null) {
			$cond = "last_name = " . stringify($query_param); 	
				return $cond;		
		}
    }

    private function set_email($query_param) {
    	if ($query_param != null) {
			$cond = "email = " . stringify($query_param);   
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
class Book_Patcher extends Patcher {
        protected $conn;
	
	function __construct($conn) {
    require_once '../include/DbConnect.php';
    // opening db connection
 		$this->conn = $conn;
    }
    
    protected function set_update_conditions($update_params) {
		$conditions = array();

		$conditions["isbn"] = $this->set_isbn($update_params["isbn"]);
		$conditions["author"] = $this->set_author($update_params["author"]);
		$conditions["title"] = $this->set_title($update_params["title"]);
		$conditions["edition"] = $this->set_edition($update_params["edition"]);
		$conditions["subject"] = $this->set_subject($update_params["subject"]);
		$conditions["course_number"] = $this->set_course_number($update_params["course_number"]);

			return $conditions; 	
	}
    
    protected function get_table() {
            return "books";
    }
    
    protected function get_key($conditions) {
        return $conditions["isbn"];
    }
	
	private function set_isbn($query_param) {
    	if ($query_param != null) {
    		$cond = "books.isbn = " . $query_param;
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
    		$cond =  "(title LIKE '%" . ($query_param) . "%')";;
    		    return $cond;
    	}
	}

	private function set_edition($query_param) {
    	if ($query_param != null) {
    		$cond = "edition = " . stringify($query_param);
    		    return $cond;
    	}
	}
	
	private function set_subject($query_param) {
	    if ($query_param != null) {
	        $cond = "subject = " . stringify($query_param);
	            return $cond;
	    }
	}
	
	private function set_course_number($query_param) {
	    if ($query_param != null) {
	        $cond = "course_number = " . stringify($query_param);
	            return $cond;

	    }
	}
    
    
}

function stringify($param) {
            return str_pad($param, strlen($param) + 2, '"', STR_PAD_BOTH);
}