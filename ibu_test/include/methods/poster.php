<?php

abstract class Poster {

	public function create($params) {
		// check for prior existence will be taken care by handler
	   	$insert = $this->obtain_insert_statement($params);

	   // relegate use of DB

        return ($result) ? "Successfully Created" : "There Was An Error";
	}

	protected function obtain_insert_statement($params) {
		$columns = $this->get_columns();
        $values = $this->get_values($params);
        $statement = "INSERT INTO " . $this->get_table() . $columns . " VALUES" . $values; 
            return $statement;
	}

	protected function get_values($params) {
		$params = prepare_strings($params);
        $values = " (" . implode_comma($params) . ") ";
            return $values;
	}

	abstract protected function get_columns();
	abstract protected function get_table();


}

class User_Poster extends Poster {
	protected function get_columns() {
    	$columns = " (student_id, first_name, last_name, email, phone_number) ";
    		return $columns;		
	}

	protected function get_table() {
		return "users"
	}

}

class Book_Poster extends Poster {
	protected function get_columns() {
        $columns = " (isbn, title, author, edition)";
            return $columns;
	}

	protected function get_table() {
		return "books"
	}

}

class Course_Poster extends Poster {
	protected function get_columns() {
		$columns = " (subject, course_number) ";
			return $columns;
	}

	protected function get_table() {
		return "courses";
	}

}

class Book_Course_Poster extends Poster {
	protected function get_columns() {
		$columns = " (isbn, subject, course_number) ";
			return $columns;
	}

	protected function get_table() {
		return "";
	}

}

class Consignment_Poster extends Poster {
	protected function get_columns() {
		$columns = " (consignment_number, student_id, date) ";
			return $columns;
	}
	
	protected function get_table() {
		return "consignments"
	}

}

class Consigned_Item_Poster extends Poster {
	protected function get_columns() {
		$columns = " (consignment_number, isbn, consignment_item, current_state, price) ";
			return $columns;
	}

	protected function get_table() {
		return "consignment_items";
	}

}