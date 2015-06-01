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

			return $conditions; 
    }

    protected function package_result($stmt) {
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

    protected function obtain_key($params) {
        $k = $params[$this->key];
            return $k;
    }

    protected function get_table() {
    		return $this->table;
    }

    protected function get_columns() {
        $columns = "(isbn, title, author, edition, courses)";
            return $columns;
    }

    protected function get_search_array($key) {
        $query_params = array("isbn" => $key,
                              "title" => null,
                              "author" => null,
                              "edition" => null,
                              "courses" => null);
            return $query_params;
    }
    
    protected function get_identity($conditions) {
    	$identity = $conditions[$this->key];
    		return $identity;
    }
    
    protected function prepare_strings($params) {
        $params["title"] = $this->stringify($params["title"]);  
        $params["author"] =  $this->stringify($params["author"]);
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

}