INSERT INTO `ibu_test`.`users` (`student_id`, `first_name`, `last_name`, `email`, `phone_number`) 
VALUES 
('1', 'Clark', 'Kent', 'kent@mail.com', '1234541234'), 
('2', 'Bruce', 'Wayne', 'wayne@mail.com', '1231231234'), 
('3', 'Barry', 'Allen', 'allen@mail.com', '12312341234'), 
('4', 'hal', 'jordan', 'jordan@mail.com', '12312341234'), 
('5', 'wally', 'west', 'west@mail.com', '12312341234'), 
('6', 'john', 'jones', 'jones@mail.com', '12312341234'), 
('7', 'dona', 'troy', 'troy@mail.com', '12312341234'), 
('8', 'tim', 'drake', 'drake@mail.com', '12312341234'),
('9', 'stephanie', 'brown', 'brown@mail.com', '12312341234'),
('0', 'richard', 'grayson', 'gray@mail.com', '12312341234');

INSERT INTO `ibu_test`.`books` (`isbn`, `title`, `author`, `edition`) 
VALUES 
('1', 'long halloween', 'loeb', '1'), 
('2', 'whatever happened to...', 'moore', '2'), 
('3', 'kingdom come', 'waid', '3'), 
('4', 'red son', 'millar', '4'), 
('5', 'blackest night', 'johns', '5'), 
('6', 'killing joke', 'moore', '6'), 
('7', 'whats so funny about..', 'kelly', '7'), 
('8', 'for all seasons', 'loeb', '8'),
('9', 'death in the family', 'starlin', '9'),
('0', 'crisis on infinite earths', 'wolfman', '0');

INSERT INTO `ibu_test`.`consignments` (`isbn`, `student_id`, `price`, `current_state`) 
VALUES 
('1', '1', '20', '1'), 
('2', '2', '20', '2'), 
('3', '3', '20', '3'), 
('4', '4', '20', '4'), 
('5', '5', '20', '5'), 
('6', '6', '20', '6'), 
('7', '7', '20', '7'), 
('8', '8', '20', '8'),
('9', '9', '20', '9'),
('0', '0', '20', '0');


INSERT INTO `ibu_test`.`courses` (`isbn`, `subject`, `course_number`) 
VALUES
(000000000001, "batm", 236),
(0000000000004, "supm", 321),
(0000000000000, "dccm", 100),
(0000000000005, "grln", 412);

INSERT INTO `ibu_test`.`courses` (`isbn`, `subject`, `course_number`) 
VALUES
(0000000000003, "dccm", 432),
(0000000000003, "supm", 100),
(0000000000003, "batm", 213);


SELECT * FROM books JOIN courses ON books.isbn = courses.isbn WHERE isbn = 0000000000003;

ALTER TABLE books DROP COLUMN courses;
