<?php
	
	require('user_poster.php');
	require('book_poster.php');
	require('consignedItem_poster.php');
	require('course_poster.php');
	require('coursebook_poster.php');
	require('consignment_poster.php');
	require('null_poster.php');
	
//needs to require helper

abstract class Poster {

	protected function commitToDatabase($insert)
	{	
		
		$stmt = $this->conn->prepare($insert);
        $res = $stmt->execute();
        $stmt->close();

        return $res;
	}

	protected function constructStatement()
	{
		$insert = "INSERT INTO ";
		$table = $this->getTable();
		$columns = $this->getColumns();
		$values = $this->getValues();
		
		
		

		$insert = $insert . $table . $columns . $values;
		return $insert;
	}

	// abstract protected function getTable();
	// abstract protected function getColumns();
	// abstract protected function getValues();
}