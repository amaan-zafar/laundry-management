CREATE DATABASE `laundry`;

USE `laundry`;


START TRANSACTION;

-- Table structure for table `users`

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `customers`

CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(25) NOT NULL,
  `tot_clothes` int,
  `tot_paid` double,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `laundry_categories`

CREATE TABLE `laundry_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `max_capacity` int NOT NULL,
  `available_capacity` int NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `laundry_list`

CREATE TABLE `laundry_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT 0 COMMENT '0=in queue, 1=washing, 2=washed, 3=delivered',
  `queue` int NOT NULL,
  `total_amount` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(id),
  FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `laundry_items`

CREATE TABLE `laundry_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `laundry_category_id` int NOT NULL,
  `weight` double NOT NULL,
  `laundry_id` int NOT NULL,
  `unit_price` double NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(laundry_category_id) REFERENCES laundry_categories(id) ON DELETE CASCADE,
  FOREIGN KEY(laundry_id) REFERENCES laundry_list(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE VIEW `admins_view` as
SELECT id, name, username
from users;

CREATE VIEW `customers_view` as
SELECT name, contact
from customers;

CREATE VIEW `categories` as
SELECT name, max_capacity, available_capacity
from laundry_categories;

-- Inserting data for table `users`

INSERT INTO `users` (`name`, `username`, `password`) VALUES
('Admin', 'admin', 'admin123'),
('Amaan', 'amaan', 'amaan123'),
('Pulkit', 'pulkit', 'pulkit123');

-- Inserting data for table `customers`

INSERT INTO `customers` (`name`, `contact`, `email`, `tot_clothes`, `tot_paid`) VALUES
('Rahul', '7870145569', 'asddfa@dfad', 0, 0),
('Kumar', '7870145569', 'asddfa@dfad', 0, 0);

-- Inserting data for table `laundry_categories`

INSERT INTO `laundry_categories` (`name`, `price`, `max_capacity`, `available_capacity`) VALUES
('Curtains', 20, 100, 100),
('Bed Sheets', 25, 250, 250);

-- Inserting data for table `laundry_list`

INSERT INTO `laundry_list` (`customer_id`, `status`, `queue`, `total_amount`, `date_created`) VALUES
(1, 3, 1, 555, '2022-04-4 11:54:47'),
(2, 3, 1, 250, '2022-04-5 13:29:33');

-- Inserting data for table `laundry_items`

INSERT INTO `laundry_items` (`laundry_category_id`, `weight`, `laundry_id`, `unit_price`, `amount`) VALUES
(1, 10, 2, 25, 250);
COMMIT;


SELECT * FROM admins_view;
SELECT * FROM customers_view;
SELECT * FROM categories;

-- Procedure to see login credentials 
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `login`(IN un varchar(100), IN pass varchar(200))
	READS SQL DATA
	DETERMINISTIC
	SQL SECURITY INVOKER
BEGIN
SELECT * FROM users where username = un and password = pass;
END$$
DELIMITER ;
CALL login('amaan', 'amaan123');

-- Procedure to add users 
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user`(IN nm varchar(100), IN un varchar(100), IN pass varchar(200))
	READS SQL DATA
	DETERMINISTIC
	SQL SECURITY INVOKER
BEGIN
INSERT INTO users 
set name = nm, username=un, password=pass;
END$$
DELIMITER ;
CALL add_user('Mann','mann', 'mann123');

UPDATE users 
set name = 'Rohan', username='rohan', password='rohan123' 
where id = 5;

SELECT * FROM laundry_categories;

INSERT INTO laundry_categories 
set name = 'pillow cover', price = 10, max_capacity = 200;  

UPDATE laundry_categories 
set name = 'socks', price = 5, max_capacity = 300
where id = 3;  

DELETE FROM laundry_categories where id = 2;

INSERT INTO laundry_items 
set laundry_id = 2, laundry_category_id = 2, weight = 2, unit_price = 5.0, amount = 10.0;

UPDATE laundry_items 
set laundry_id = 2, laundry_category_id = 2, weight = 2, unit_price = 5.0, amount = 10.0
where id = 2;

DELETE FROM laundry_items where laundry_id = 3;

UPDATE laundry_list 
set customer_name = 'Rahul', status = 3, queue=1, total_amount=555, date_created='2022-04-10 11:54:47'
where id = 2;

DELETE FROM laundry_list where id = 2;

-- DROP TABLES

-- DROP TABLE users;
-- DROP TABLE laundry_categories;
-- DROP TABLE laundry_items;
-- DROP TABLE laundry_list;

-- DROP VIEW admins_view;
-- DROP VIEW customers_view;
-- DROP VIEW categories;

-- DROP DATABASE `laundry`;