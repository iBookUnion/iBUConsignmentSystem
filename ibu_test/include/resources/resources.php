<?php

// need some classed to create these objects
// This family of classes is meant to contain parameters
abstract class Resource 
{
	abstract public function getPoster($conn);
	abstract public function getDeleter($conn);
	//abstract public function getGetter($conn);
	//abstract public function getKey();
	abstract public function printOut();
}






