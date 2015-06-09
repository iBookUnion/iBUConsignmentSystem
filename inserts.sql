-- Some Test Records

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
('0', 'richard', 'grayson', 'gray@mail.com', '12312341234'),
('11', 'mary', 'bromfield', 'mary@mail.com', '1231234123'),
('12', 'holly', 'dayton', 'menta@mail.com', '1231234123'),
('13', 'marcus', 'aelius', 'marc@mail.com', '1231234123');

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
('0', 'crisis on infinite earths', 'wolfman', '0'),
('11', 'rebirth', 'johns', '1'),
('12', 'zero hour', 'jurgens', '10');

INSERT INTO `ibu_test`.`consignments` (`consignment_number`, `student_id`) 
VALUES
(1, '1'),
(2, '2'),
(3, '9'),
(4, '5');

INSERT INTO `ibu_test`.`consigned_items` (`consignment_number`,`isbn`,`price`,`current_state`)
VALUES
('1', '3', 30, 'available'),
('1', '4', 21, 'available'),
('1', '7', 31, 'not in store'),
('2', '6', 54, 'not in store'),
('2', '9', 80, 'not in store'),
('2', '1', 10, 'sold and not paid'),
('3', '0', 140, 'available'),
('4', '5', 5, 'available'),
('4', '11', 23, 'available'),
('4', '12', 33, 'sold and not paid');

INSERT INTO `ibu_test`.`courses` (`subject`, `course_number`)
VALUES
('batm', 121),
('batm', 234),
('batm', 321),
('supm', 110),
('supm', 432),
('dccm', 100),
('dccm', 213),
('glcm', 113),
('fawc', 201);


INSERT INTO `ibu_test`.`course_books` (`subject`, `course_number`, `isbn`)
VALUES
('batm', 121, 9),
('batm', 234, 6),
('batm', 321, 9),
('supm', 110, 4),
('supm', 432, 7),
('dccm', 100, 0),
('dccm', 213, 12),
('glcm', 113, 5),
('fawc', 201, 0);

