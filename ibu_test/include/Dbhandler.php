<?php

abstract class DbHandler {



	// Retrieves A Record From A Database Table
	public function get($query_params) {

		$conditions = array();
		$package = array();
		
		$conditions = $this->set_not_null_conditions($query_params);

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
            return "Sorry, this record already exists";
    }        

    // Updates A Record If It Exists Otherwise Creates it
    public function alter($params) {
        $key = $this->obtain_key($params);
        
        if (!$this->verify_existence($key)) {
            return $this->insert($params);
        } else {
            $conditions = $this->set_conditions($params);
                    var_dump($conditions);
            return $this->change($conditions);
        }
    }
    
    // Updates A Record in A Database Table
    public function update($params) {
        
    $key = $this->obtain_key($params);
    
    if ($this->verify_existence($key)) {
        $conditions = $this->set_not_null_conditions($params);
        return $this->change($conditions);
    }
            return "Sorry, this record doesn't exist";
    }
    
    // 
    public function delete() {}
    
    // helper functions for get()
    abstract protected function set_conditions($query_params);
    abstract protected function package_result($stmt);
    abstract protected function get_table();

    // helper functions for create()
    abstract protected function obtain_key($params);
    abstract protected function get_columns();
    abstract protected function prepare_strings($params);
    
    // helper functions for update()
    abstract protected function get_identity($params);

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
    
    protected function set_not_null_conditions($params) {
        $conditions = $this->set_conditions($params);
        
        //filter conditions
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
            if ($condition == null) {
                return $this->implode_recursive($conditions, $glue);
            } else {
                return $condition . $this->implode_helper($conditions, $glue);
            }
        }
    }

    protected function implode_helper($conditions, $glue) {
        if ($conditions != null) {    
            $condition = array_shift($conditions);
            if ($condition == null) {
                return $this->implode_helper($conditions, $glue);
            } else {
                return $glue . $condition . $this->implode_helper($conditions, $glue);
            }
        }    
    }

    protected function insert($params) {
        $insert = $this->obtain_insert_statement($params);

        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute();
        $stmt->close();

        return ($result) ? "Successfully Created" : "There Was An Error";

    }
    
    protected function change($conditions) {
        $revision = $this->obtain_update_statement($conditions);
        $stmt = $this->conn->prepare($revision);
        $result = $stmt->execute();
        $stmt->close();
        
        return ($result) ? "Successfully Updated" : "There Was An Error";
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

    protected function obtain_insert_statement($params) {
        $columns = $this->get_columns();
        $values = $this->get_values($params);
        $statement = "INSERT INTO " . $this->get_table() . $columns . " VALUES " . $values; 
            return $statement;
    }
    
    protected function obtain_update_statement($conditions) {
        $alterations = $this->get_set_values($conditions);
        $identity = $this->get_identity($conditions);
        $statement = "UPDATE " . $this->get_table() . " SET " . $alterations . " WHERE " . $identity;
            return $statement;
        
    }
    
    protected function get_values($params) {
        $params = $this->prepare_strings($params);
        $values = " (" . $this->implode_comma($params) . ") ";
            return $values;
    }
    
    protected function get_set_values($conditions) {
        $alterations = $this->implode_comma($conditions);
            return $alterations;
    }
    
    protected function stringify($param) {
            return str_pad($param, strlen($param) + 2, '"', STR_PAD_BOTH);
    }


}