<?php

class CourseGetter extends Getter
{
	protected $course;
	protected $conn;

	protected function getTable()
	{
		return "courses";
	}


	protected function getKeyAsSentence() {
	    $course = $this->course;
		$subject = $course->getSubject();
		$courseNumber = $course->getCourseNumber();
		$keyAsSentence = "subject = " . $subject . " AND " . "course_number = " . $courseNumber;
		return $keyAsSentence;  
	}

}