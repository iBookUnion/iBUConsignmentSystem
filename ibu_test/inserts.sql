INSERT INTO `users` (`student_id`, `first_name`, `last_name`, `email`, `phone_number`) 
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

INSERT INTO `books` (`isbn`, `title`, `author`, `edition`) 
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

INSERT INTO `consignments` (`isbn`, `student_id`, `price`, `current_state`) 
VALUES 
('1', '1', '20', '1'), 
('2', '2', '88', '1'), 
('3', '3', '23', '1'), 
('4', '4', '77', '1'), 
('5', '5', '30', '1'), 
('6', '6', '20', '1'), 
('7', '7', '40', '1'), 
('8', '8', '80', '1'),
('9', '9', '20', '1'),
('0', '0', '30', '1');

INSERT INTO `courses` (`isbn`, `subject`, `course_number`)
VALUES
('1', 'TEST', '101'),
('2', 'TEST', '102'),
('3', 'TEST', '103'),
('4', 'TEST', '104'),
('5', 'TEST', '105'),
('6', 'TEST', '106'),
('7', 'TEST', '107'),
('8', 'TEST', '108'),
('9', 'TEST', '109'),
('0', 'TEST', '100')