<?php
	
	require('../include/results/results.php');
	require('../include/helpers/helpers.php');
	
//needs to require helper

abstract class Poster {

	protected function commitToDatabase($insert)
	{	
		echo "there is likely a problem with statement\n";
		var_dump($insert);
		
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