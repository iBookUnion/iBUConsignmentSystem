<?php 

	require_once '../include/methods/getter/getter.php';
	require_once '../include/methods/poster/poster.php';
	require_once '../include/DbConnect.php';
	require_once 'delegate.php';

interface DbHandler {
    
     function postMethod($resource);
    
}






