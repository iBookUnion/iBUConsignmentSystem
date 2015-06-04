<?php

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
        $columns = " (isbn, title, author, edition, courses)";
            return $columns;
    }

    protected function get_search_array($key) {
        $query_params = array("isbn" => $key,
                              "title" => null,
                              "author" => null,
                              "edition" => null,
                              "subject" => null,
                              "course_number" => null);
            return $query_params;
    }
    
    protected function get_identity($conditions) {
    	$identity = $conditions[$this->key];
    		return $identity;
    }
    
    protected function insert($params) {
        $books_insert = $this->obtain_insert_statement($params);
        $courses_insert = $this->obtain_course_insert_statement($params);

        $stmt = $this->conn->prepare($books_insert);
        $books_result = $stmt->execute();
        $stmt->close();
        
        $stmt = $this->conn->prepare($courses_insert);
        $courses_result = $stmt->execute();
        $stmt->close();
        
        $result = $books_result && $courses_result;
    
        // going to need more complicated logic here, going to need to need to push up thiis change to index
        return ($result) ? "Successfully Created" : "There Was An Error";

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
    
    private function obtain_course_insert_statement($params) {
        // needs to be something like INSERT INTO courses (`isbn`, `subject`, `course_number`) VALUES ()
        $stmt_base = "INSERT INTO courses (`isbn`, `subject`, `course_number`) VALUES ";
        $values = get_course_values($params);
        $insert = $stmt_base . $values;
            return $insert;
        
    }
    
    private function get_course_values($params) {
        $values_list = array();
        $isbn = $params["isbn"];
        $course_list = $params["courses"];
        
        foreach ($course_list as $course) {
            $subject = $course["subject"];
            $classes = $course["classes"];
            foreach ($classes as $cls) {
                $class = $classes["course"];
                
                $values_list[] = "(" . $isbn . ", " . $subject . ", " . $class . ")"; 
            }
        }
        
    }
    
    protected function prepare_strings($params) {
        $params["title"] = $this->stringify($params["title"]);  
        $params["author"] =  $this->stringify($params["author"]);
        $params["courses"] = $this->stringify($params["courses"]);
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