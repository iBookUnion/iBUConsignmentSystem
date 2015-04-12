<?php
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 METHODS:
         USERS:
		    createUser => POST:http://localhost/ibu_test/v1/register
            getUser => GET:http://localhost/ibu_test/v1/user/:id
            getAllUsers => GET:http://localhost/ibu_test/v1/users
			UserExists => helper function

         BOOKS:
            createBook => POST:http://localhost/ibu_test/v1/addBook
            getBook => GET:http://localhost/ibu_test/v1/books/:isbn
            getAllBooks => GET:http://localhost/ibu_test/v1/books
			BookExists => helper function
			
         CONSIGNMENTS:
		    createConsignment => POST: http://localhost/ibu_test/v1/consign
			getConsignment => GET:http://localhost/ibu_test/v1/consignment/:id
			getConsignments => GET:http://localhost/ibu_test/v1/consignment/:isbn
			getAllConsignments => GET:http://localhost/ibu_test/v1/consignments
			updateConsignment => PUT:http://localhost/ibu_test/v1/consignment_update
			ConsignmentExists => helper function
        		 

 *
 */
class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
 
    /* ------------- USERS ------------------ */
 
    /**
     * Creating new user
     * @param String $first_name User first name
	 * @param String $last_name User last name
     * @param String $email User login email id
     * @param String $student_id User ID
	 * @param String $phone_number User phone number
     */
    public function createUser($student_id, $first_name, $last_name, $email, $phone_number) {
        $response = array();
 
        // First check if user already existed in db 
        if (!$this->userExists($student_id)) {

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $student_id, $first_name, $last_name, $email, $phone_number);
            $result = $stmt->execute();
 
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return 0; //USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return 1; //USER_CREATE_FAILED;
            }
	    } else {
		    return 2; //USER_ALREADY_EXISTED
		}
 
 
        return $response;
    }
 
 
    /**
     * 
	 * SELECT *
	 * FROM users
	 * WHERE student_id = $student_id
     * 
     */
    public function getUser($student_id) {
        $stmt = $this->conn->prepare("SELECT student_id, first_name, last_name, email, phone_number FROM users WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
		if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($student_id, $first_name, $last_name, $email, $phone_number);
            $stmt->fetch();
            $res["student_id"] = $student_id;
            $res["first_name"] = $first_name;
            $res["last_name"] = $last_name;
			$res["email"] = $email;
			$res["phone_number"] = $phone_number;
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }
	
	/*
	*
	* SELECT * 
	* FROM users
	*
	*/
    public function getAllUsers() {
        
		$stmt = $this->conn->prepare("SELECT * FROM users");
		$stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();
        return $results;
    }
	
	
	/*
    * SELECT student_id
	* FROM users
	* WHERE student_id = $student_id
	* (Used to check if a certain user exists)
    */
    private function userExists($student_id) {
        $stmt = $this->conn->prepare("SELECT student_id from users WHERE student_id = ?");
        $stmt->bind_param("s", $estudent_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
 
/* ------------- BOOKS ------------------ */
 
   
    /**
     * Creating new book
     * @param String $isbn book isbn
	 * @param String $title book title
     * @param String $author book author
     * @param String $edition book edition
	 * @param String $courses book courses
     */
   
    public function createBook($isbn, $title, $author, $edition, $courses) {
        $response = array();
 
        // First check if book already existed in db
        if (!$this->bookExists($isbn)) {

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO books values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $isbn, $title, $author, $edition, $courses);
 
            $result = $stmt->execute();
 
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return 0; //BOOK_CREATED_SUCCESS FULLY;
            } else {
                // Failed to create user
                return 1; //BOOK_CREATE_FAILED;
            } 
		} else {
		    return 2; //BOOK_ALREADY_EXISTED
		}

 
        return $response;
    }
 
 
    /*
	 *
     * SELECT *
	 * FROM books
	 * WHERE isbn = $isbn
     *  
     */
    public function getBook($isbn) {
        $stmt = $this->conn->prepare("SELECT isbn, title, author, edition, courses FROM books WHERE isbn = ?");
        $stmt->bind_param("s", $isbn);
		if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($isbn, $title, $author, $edition, $courses);
            $stmt->fetch();
            $res["isbn"] = $isbn;
            $res["title"] = $title;
            $res["author"] = $author;
			$res["edition"] = $edition;
			$res["courses"] = $courses;
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }
	
	/*
	*
	* SELECT *
	* FROM books
	*
	*/
     public function getAllBooks() {
        
		$stmt = $this->conn->prepare("SELECT * FROM books");
		$stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();
        return $results;
    }
	
	/*
    * SELECT isbn
	* FROM books
	* WHERE isbn = $isbn
	* (Used to check if a certain book exists)
    */
    private function bookExists($isbn) {
        $stmt = $this->conn->prepare("SELECT isbn from books WHERE isbn = ?");
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }	
 
/* ------------- CONSIGNMENTS ------------------ */   


// TO DO:

// createConsignment
    /**
     * Creating new consignment
     * @param int(10) $isbn the isbn of the book 
	 * @param int(13) $student_id the id of the student selling book
     * @param decimal(6,0) $price the desired price for the book
     * @param char(4) $current_state one of ()
     */
   
    public function createConsignment($isbn, $student_id, $price, $current_state) {
        $response = array();
 
        // First check if user already existed in db
        if (!$this->consignmentExists($isbn, $student_id)) {
            if (!($this->userExists($student_id) and $this->bookExists($isbn))) {
            			
                    // insert query
                    $stmt = $this->conn->prepare("INSERT INTO consignments(isbn, student_id, price, current_state) values(?, ?, ?, ?)");
                    $stmt->bind_param("iiii", $isbn, $student_id, $price, $current_state);
                    $result = $stmt->execute();
 
                    $stmt->close();
 
                    // Check for successful insertion
                    if ($result) {
                    // User successfully inserted
                    return 0; //CONSIGNMENT_CREATED_SUCCESS FULLY;
                    } else {
                    // Failed to create user
                    return 1; //CONSIGNMENT_CREATE_FAILED;
                    }
            } else {
			        // Either the isbn or the student_id were not found
                    return 3; //FOREIGN_KEYS_NOT_FOUND 
			}
			
		} else {
		    return 2; //CONSIGNMENT_ALREADY_EXISTED
		}

 
        return $response;
    }


// getConsignment

    /*
	 *
     * SELECT *
	 * FROM consignments
	 * WHERE student_id = $student_id
     *  
     */
     public function getConsignment($student_id) {
        
		$stmt = $this->conn->prepare("SELECT * FROM consignments WHERE student_id = ?");
		$stmt->bind_param("s", $student_id);
		$stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();
        return $results;
    }

// getConsignmnets

    /*
	 *
     * SELECT *
	 * FROM consignments
	 * WHERE isbn = $isbn
     *  
     */
     public function getConsignments($isbn) {
        
		$stmt = $this->conn->prepare("SELECT * FROM consignments WHERE isbn = ?");
		$stmt->bind_param("s", $isbn);
		$stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();
        return $results;
    }


    /*
	 *
     * SELECT *
	 * FROM consignments
     *  
     */
     public function getAllConsignment() {
        
		$stmt = $this->conn->prepare("SELECT * FROM consignments");
		$stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();
        return $results;
    }

	/*
	*
	* UPDATE consignments
	* SET current_status = $current_status
	* WHERE isbn = $isbn AND student_id = $student_id 
	*
	*/
	public function updateConsignment($current_status, $isbn, $student_id) {
	    $stmt = $stmt->conn->prepare("UPDATE consignments SET current_status = ? WHERE isbn = ? AND student_id = ?");
	    $stmt->bind_param("iii", $current_status, $isbn, $student_id);
		$stmt->execute();
	    $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }	
	
	

	/*
    * SELECT isbn
	* FROM consignments
	* WHERE isbn = $isbn AND student_id = $student_id
	* (Used to check if a certain consignment exists)
    */
    private function consignmentExists($isbn) {
        $stmt = $this->conn->prepare("SELECT isbn from consignments WHERE isbn = ? AND student_id = ?");
        $stmt->bind_param("ss", $isbn, $student_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }	
	


  
}  
?>
