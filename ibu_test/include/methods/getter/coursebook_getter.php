<?php

class CourseBookGetter extends Getter
{
	protected $courseBook;
	protected $conn;

	protected function getTable()
	{
		return "course_books";
	}

	protected function getKeyAsSentence() {
	    $course = $this->coursebook;
		$subject = $course->getSubject();
		$courseNumber = $course->getCourseNumber();
		$isbn = $course->getISBN();
		$keyAsSentence = "subject = " . $subject . " AND " . "course_number = " . $courseNumber . " AND " . " isbn = " . $isbn;
		return $keyAsSentence;  
	}

}