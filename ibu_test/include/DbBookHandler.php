<?php

// courses perhaps hosuld have a default value so that there is not a problem when searching books

class DbBookHandler extends Dbhandler {

	protected $conn;
	protected $table = "books";
    protected $key = "isbn";

	function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    
    	// Retrieves A Record From A Database Table
	public function get($query_params) {

		$conditions = array();
		$package = array();
		
		$query_params["title"] = "(title LIKE '%" . $query_params["title"] . "%')";
		
		$conditions = $this->set_not_null_conditions($query_params);
		$query = $this->set_query($conditions);
        
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		
		$package = $this->package_result($stmt);

		    return $package;
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
		$stmt->bind_result($isbn, $title, $author, $edition, $course_isbn, $subject, $course_number);
		
		$books = array();
		while($row = $stmt->fetch())
		{
			$book["isbn"] = $isbn;
			$book["title"] = $title;
			$book["author"] = $author;
			$book["edition"] = $edition;
			$book["subject"] = $subject;
			$book["course_number"] = $course_number;
			$books[] = $book;
		}
		
		$stmt->close();
			return $books;	
    }

    protected function obtain_key($params) {
        $k = $params[$this->key];
            return $k;
    }

    protected function get_table() {
    		return $this->table;
    }

    protected function get_columns() {
        $columns = " (isbn, title, author, edition)";
            return $columns;
    }

    protected function get_search_array($key) {
        $query_params = array("isbn" => $key,
                              "title" => null,
                              "author" => null,
                              "edition" => null,
                              "course" => null,
                              "subject" => null,
                              "course_number" => null);
            return $query_params;
    }
    
    protected function get_identity($conditions) {
    	$identity = $conditions[$this->key];
    		return $identity;
    }
    
    protected function insert($params) {
        $course_params = $params["courses"];
        unset($params["courses"]);
        
        $books_insert = $this->obtain_insert_statement($params); // need to remove courses array from here
        $courses_insert = $this->obtain_course_insert_statement($params["isbn"], $course_params);
        
        $stmt = $this->conn->prepare($books_insert);
        $books_result = $stmt->execute();
        $stmt->close();
        
        $stmt = $this->conn->prepare($courses_insert);
        $courses_result = $stmt->execute();
        $stmt->close();
        
        $result = $books_result && $courses_result;

                return ($result) ? "Successfully Created" : $this->get_result($books_result, $courses_result);
    }
    
    private function get_result($books_result, $courses_result) {
        if ($books_result) {
                return "There was an error with courses";
        } else {
                return "There was an error with books";
        }
    }
    
    protected function set_query($conditions) {

    	// Default will obtain all records from the table
    	$query = "SELECT * FROM " . $this->get_table();
    	$join = " JOIN courses ON books.isbn = courses.isbn";
    	$joined_query = $query . $join; 
        $cnd_stmt = $this->implode_and($conditions);
        

    	if ($cnd_stmt != "")
		{
			$joined_query .= ' WHERE ' . $cnd_stmt;
		}

	    	return $joined_query;

    }
    
    private function obtain_course_insert_statement($isbn, $params) {
        // needs to be something like INSERT INTO courses (`isbn`, `subject`, `course_number`) VALUES ()
        $stmt_base = "INSERT INTO courses (`isbn`, `subject`, `course_number`) VALUES ";
        $values = $this->get_course_values($isbn, $params);
        
        $insert = $stmt_base . $values;
            return $insert;
    }
    
    private function get_course_values($isbn, $params) {
        $values_list = array();
        $course_list = $params;
        
        foreach ($course_list as $course) {
            $subject = $course["subject"];
            $classes = $course["classes"];
            foreach ($classes as $cls) {
                $class = $cls["course"];
                $values_list[] = "(" . $isbn . ", " . $this->stringify($subject) . ", " . $class . ")";
            }
        }
        
        // need to add commas to the values_list
        $values_list = $this->implode_comma($values_list);
                return $values_list;
        
    }
    
    protected function prepare_strings($params) {
        $params["title"] = $this->stringify($params["title"]);  
        $params["author"] =  $this->stringify($params["author"]);
        //$params["courses"] = $this->stringify($params["courses"]);
            return $params;
    }

    private function set_isbn($query_param) {
    	if ($query_param != null) {
    		$cond = "books.isbn = " . $query_param;
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
    		$cond = $query_param;
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