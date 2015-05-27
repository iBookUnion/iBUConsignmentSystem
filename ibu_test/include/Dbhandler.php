<?php

abstract class DbHandler {



	// Retrieves A Record From A Database Table
	public function get($query_params) {

		$conditions = array();
		$package = array();
		
		$conditions = $this->set_conditions($query_params);

		$query = $this->set_query($conditions);

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		
		$package = $this->package_result($stmt);

		 return $package;

    }

    // Adds A Record To A Database Table
    public function create($params) {


        $key = $this->obtain_key($params);

        if (!$this->verify_existence($key)) {
            return $this->insert($params);
        }
            return "Sorry, this user already exists";
    }        
    
    // Alters
    public function update() {
        
    }


    // helper functions for get()
    abstract protected function set_conditions($query_params);
    abstract protected function package_result($stmt);
    abstract protected function get_table();

    // helper functions for create()
    abstract protected function obtain_key($params);
    abstract protected function get_columns();
    abstract protected function prepare_strings($params);

    // Creates SQL SELECT Statement
    protected function set_query($conditions) {

    	// Default will obtain all records from the table
    	$query = "SELECT * FROM " . $this->get_table();
        $cnd_stmt = $this->implode_and($conditions);


    	if ($cnd_stmt != "")
		{
			$query .= ' WHERE ' . $cnd_stmt;
		}

		return $query;

    }

    protected function implode_and($conditions) {
            return $this->implode_recursive($conditions, " AND ");
    }

    protected function implode_comma($conditions) {
            return $this->implode_recursive($conditions, ", ");
    }

    protected function implode_recursive($conditions, $glue) {

        if ($conditions != null) {
            $condition = array_shift($conditions);
            if ($condition != "") {
                return $condition . $this->implode_helper($conditions, $glue);
            } else {
                return $this->implode_recursive($conditions, $glue);
            }
        }
    }

    protected function implode_helper($conditions, $glue) {
        if (current($conditions) != "") {
            return $glue . $this->implode_recursive($conditions, $glue);
        } else {
            return $this->implode_recursive($conditions, $glue);
        }

    }

    protected function insert($params) {
        $insert = $this->obtain_statement($params);

        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute();
        $stmt->close();

        return ($result) ? "Successfully Created" : "There Was An Error";

    }

    protected function verify_existence($key) {
        $result = false;
        $query_params = $this->get_search_array($key);
        $response = $this->get($query_params);

        if ($response != null) {
            $result = true;
        }
            return $result;
    }

    protected function obtain_statement($params) {
        $columns = $this->get_columns();
        $values = $this->get_values($params);
        $statement = "INSERT INTO " . $this->get_table() . $columns . " VALUES " . $values; 
            return $statement;
    }

    protected function get_values($params) {
        $params = $this->prepare_strings($params);
        $values = " (" . $this->implode_comma($params) . ") ";
            return $values;
    }

    protected function stringify($param) {
            return str_pad($param, strlen($param) + 2, '"', STR_PAD_BOTH);
    }


}
?>