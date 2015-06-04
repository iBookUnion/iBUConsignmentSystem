<?php 

class DbCourseHandler extends DbHandler {

    protected $conn;
	protected $table = "books JOIN courses ON books.isbn = courses.isbn";
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
		$conditions["author"] = $this->set_author($query_params["author"]);
		$conditions["title"] = $this->set_title($query_params["title"]);
		$conditions["edition"] = $this->set_edition($query_params["edition"]);
		$conditions["subject"] = $this->set_subject($query_params["subject"]);
		$conditions["course_number"] = $this->set_course_number($query_params["course_number"]);
		
			return $conditions;         
    }
    
    protected function package_result($stmt) {
        $rows = $stmt->num_rows;
		$stmt->bind_result($isbn, $title, $author, $edition, $courses, $isbn_alt, $subject, $course_number);
		
		$books = array();

		while($row = $stmt->fetch())
		{
			$book["isbn"] = $isbn;
			$book["student_id"] = $student_id;
			$book["title"] = $title;
			$book["author"] = $author;
			$book["edition"] = $edition;
			$book["courses"] = $courses;
			$book["price"] = $price;
			$book["current_state"] = $current_state;
			$book["date"] = $date;			
			$books[] = $book;	
		}
		
		$stmt->close();		

			return $books;	
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
    
    // helper functions for update()
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
    
    private function set_subject($query_param) {
    	if ($query_param != null) {
    		$cond = "subject = " . $this->stringify($query_param);
    	} else {
    	    $cond = "subject = null";
    	}
    		    return $cond;
	}
	
	private function set_course_number($query_param) {
    	if ($query_param != null) {
    		$cond = "course_number = " . $this->stringify($query_param);
    	} else {
    	    $cond = "course_number = null";
    	}
    		    return $cond;
	}    	
    
}