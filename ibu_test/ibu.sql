CREATE DATABASE ibu_test;
 
USE ibu_test;

CREATE TABLE IF NOT EXISTS `users` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phone_number` int(11) NOT NULL,
  PRIMARY KEY (`student_id`)
);
 
CREATE TABLE IF NOT EXISTS `books` (
  `isbn` int(14) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(35) NOT NULL,
  `edition` int(2) NOT NULL,
  `courses` blob NOT NULL,
  PRIMARY KEY (`isbn`)
);
 
CREATE TABLE IF NOT EXISTS `consignments` (
  `isbn` int(14) NOT NULL,
  `student_id` int(11) NOT NULL,
  `price` decimal(6,0) NOT NULL,
  `current_state` char(4) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`isbn`,`student_ID`)
);
 
 ALTER TABLE  `consignments` ADD FOREIGN KEY (  `student_id` ) REFERENCES  `ibu_test`.`users` (
`student_ID`
) ON DELETE CASCADE ON UPDATE CASCADE ;
 
ALTER TABLE  `consignments` ADD FOREIGN KEY (  `isbn` ) REFERENCES  `ibu_test`.`books` (
`isbn`
) ON DELETE CASCADE ON UPDATE CASCADE ;