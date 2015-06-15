CREATE DATABASE ibu_test;
 
USE ibu_test;

CREATE TABLE IF NOT EXISTS `users` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  PRIMARY KEY (`student_id`)
);
 
CREATE TABLE `books` (
  `isbn` int(14) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(35) NOT NULL,
  `edition` int(2) NOT NULL,
  PRIMARY KEY (`isbn`)
);
 
CREATE TABLE `consignments` (
  `isbn` int(14) NOT NULL,
  `student_id` int(11) NOT NULL,
  `price` decimal(6,0) NOT NULL,
  `current_state` char(4) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `consignment_number` int(11) DEFAULT NULL,
  `consignment_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`isbn`, `student_id`, `consignment_item`, `consignment_number`),
  
  FOREIGN KEY (`student_id`)
  	REFERENCES `ibu_test`.`users`(`student_id`)
  	ON DELETE CASCADE ON UPDATE CASCADE,

  FOREIGN KEY (`isbn`)
  	REFERENCES `ibu_test`.`books`(`isbn`)
  	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `courses` (
  `isbn` int(14) NOT NULL,
  `subject` varchar(4) NOT NULL,
  `course_number` int(3) NOT NULL,
  PRIMARY KEY (`isbn`,`subject`,`course_number`),

  FOREIGN KEY (`isbn`)
  	REFERENCES `ibu_test`.`books`(`isbn`)
  	ON DELETE CASCADE ON UPDATE CASCADE
);