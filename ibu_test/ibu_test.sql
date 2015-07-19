CREATE DATABASE ibu_test;
 
USE ibu_test;

CREATE TABLE IF NOT EXISTS `users` (
  `student_id` int(10) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phone_number` int(10),
  PRIMARY KEY (`student_id`)
);
 
CREATE TABLE IF NOT EXISTS `books` (
  `isbn` int(13) NOT NULL,
  `title` varchar(35) NOT NULL,
  `author` varchar(35) NOT NULL,
  `edition` varchar(25) NOT NULL,
  PRIMARY KEY (`isbn`)
);

CREATE TABLE IF NOT EXISTS `courses` (
  `subject` varchar(4) NOT NULL,
  `course_number` int(3) NOT NULL,
  PRIMARY KEY (`subject`,`course_number`)
);
 
CREATE TABLE IF NOT EXISTS `consignments` (
  `consignment_number` int AUTO_INCREMENT,
  `student_ID` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`consignment_number`)
);

CREATE TABLE IF NOT EXISTS `consigned_items` (
  `consigned_items` int NOT NUll,
  `consignment_number` int NOT NULL,
  `isbn` int(13) NOT NULL,
  `price` decimal(6,0) NOT NULL,
  `current_state` varchar(25) NOT NULL,
  PRIMARY KEY (`consignment_number`,`isbn`)
);

CREATE TABLE IF NOT EXISTS `course_books` (
  `subject` char(4) NOT NULL,
  `course_number` int(3) NOT NULL,
  `isbn` int(13) NOT NULL,
  PRIMARY KEY (`subject`,`course_number`,`isbn`)
);

ALTER TABLE `consignments` ADD FOREIGN KEY ( `student_ID` ) REFERENCES  `ibu_test`.`users` 
(`student_ID`) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE  `consigned_items` ADD FOREIGN KEY ( `isbn` ) REFERENCES  `ibu_test`.`books` 
 (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE ;
 
ALTER TABLE  `consigned_items` ADD FOREIGN KEY ( `consignment_number` ) REFERENCES  `ibu_test`.`consignments` 
 (`consignment_number`) ON DELETE CASCADE ON UPDATE CASCADE ;
 
ALTER TABLE  `course_books` ADD FOREIGN KEY ( `subject` ) REFERENCES  `ibu_test`.`courses` 
 (`subject`) ON DELETE CASCADE ON UPDATE CASCADE ; 

ALTER TABLE  `course_books` ADD FOREIGN KEY ( `course_number` ) REFERENCES  `ibu_test`.`courses` 
 (`course_number`) ON DELETE CASCADE ON UPDATE CASCADE ;  

ALTER TABLE  `course_books` ADD FOREIGN KEY ( `isbn` ) REFERENCES  `ibu_test`.`books` 
 (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE ;  