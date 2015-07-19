<?php

class DbUserResourceHandler implements DbHandler 
{
	protected $conn;
	protected $delegate;

	function __construct() {
    // opening db connection
    $db = new DbConnect();
    $this->conn = $db->connect();
    $this->delegate = new Delegate();
    }	

    public function postMethod($resource) 
    {
        $poster = $this->delegate->getUserPoster($resource, $this->conn);
        $result = $poster->insert();
        return $result;
    }
}