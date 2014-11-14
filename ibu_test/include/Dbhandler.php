<?php
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 */
class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
 
    /* ------------- `users` ------------------ */
 
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
 


            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $student_id, $first_name, $last_name, $email, $phone_number);
            $result = $stmt->execute();
 
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
			
 
 
        return $response;
    }
 
 
    /**
     * 
	 * SELECT *
	 * FROM users
	 * WHERE student_id = student_id
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
	
 
/* ------------- `books` ------------------ */
 
   
    /**
     * 
     * 
     */
   
    public function createBook($isbn, $titile, $author, $editon, $courses) {
        $response = array();
 
        // First check if user already existed in db
        // if (!$this->isBookExists($isbn)) {

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO books values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $isbn, $titile, $author, $editon, $courses);
 
            $result = $stmt->execute();
 
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return BOOK_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return BOOK_CREATE_FAILED;
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
        $stmt = $this->conn->prepare("SELECT isbn, titile, author, edition, courses FROM books WHERE isbn = ?");
        $stmt->bind_param("s", $isbn);
		if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($isbn, $titile, $author, $edition, $courses);
            $stmt->fetch();
            $res["isbn"] = $isbn;
            $res["titile"] = $titile;
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
	
	
 
/* ------------- `consignments` ------------------ */   
  
}  
?>