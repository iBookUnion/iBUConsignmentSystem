<?php

// only allow deletion by key?

abstract class Deleter {
	
	protected function destroy($params) {
	// verification will be handled by the level above this one
	$order = $this->obtain_deletion_statement($conditions);

	// get another object to actually execute??
    
    return ($result) ? "Successfully Deleted" : "There Was An Error";
	}

	protected function obtain_deletion_statement($conditions) {
		$key = $this->get_key($conditions);
		
        $statement = "DELETE FROM " . $this->get_table() . " WHERE " . $key;
            return $statement;
	}

	abstract protected function get_table();
	abstract protected function get_key($params);
}

class User_Deleter extends Deleter {
	protected function get_table() {
		return "users";
	}
	protected function get_key($params) {
		return "student_id = " . $params["student_id"];
	}
}

class Book_Deleter extends Deleter {
	protected function get_table() {
		return "books";
	}
	protected function get_key($params) {
		return "isbn = " . $params["isbn"];
	}	
}

class Course_Deleter extends Deleter {
	protected function get_table() {
		return "courses";
	}
	protected function get_key($params) {
		return "subject = " . $params["subject"] . " AND " . "course_number = " . $params["course_number"];
	}
}

class Course_Books_Deleter extends Deleter {
	protected function get_table() {
		return "course_books";
	}
	protected function get_key($params) {
		return "isbn = " . $params["isbn"] . " AND " . "subject = " . $params["subject"] . " AND " . "course_number = " . $params["course_number"];
	}	
}

class Consignment_Deleter extends Deleter {
	protected function get_table() {
		return "consignments";
	}
	protected function get_key($params) {
		return "consignment_number = " . $param["consignment_number"];
	}
}

class Consigned_Item_Deleter extends Deleter {
	protected function get_table() {
		return "consigned_items";
	}
	protected function get_key($params) {
		return "consignment_number = " . $params["consignment_number"] . " AND " . "consignment_item = " . $params["consignment_item"];
	}
}