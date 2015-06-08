<?php

// only allow deletion by key?

abstract class Deleter {
	
	protected function destroy($params) {
	// verification will be handled by the level above this one
	$order = $this->obtain_deletion_statement($conditions);

	// get another object to actually execute??
    
    return ($result) ? "Successfully Deleted" : "There Was An Error";
	}

	protected function obtain_deletion_statement() {
		$locations = $this->get_set_values($conditions);
        $statement = "DELETE FROM " . $this->get_table() . " WHERE " . $locations;
            return $statement;
	}

	abstract protected get_table();
}

class User_Deleter extends Deleter {
	protected function get_table() {

	}
}

class Book_Deleter extends Deleter {
	protected function get_table() {
		
	}
}

class Course_Deleter extends Deleter {
	protected function get_table() {
		
	}
}

class Book_Course_Deleter extends Deleter {
	protected function get_table() {
		
	}
}

class Consignment_Deleter extends Deleter {
	protected function get_table() {
		
	}	
}

class Consigned_Item_Deleter extends Deleter {
	protected function get_table() {
		
	}	
}