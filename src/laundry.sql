-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2020 at 09:16 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `users`

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `customers`

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(25) NOT NULL,
  `tot_clothes` int,
  `tot_paid` double,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `laundry_categories`

CREATE TABLE `laundry_categories` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `max_capacity` int NOT NULL,
  `available_capacity` int NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `laundry_items`

CREATE TABLE `laundry_items` (
  `id` int NOT NULL,
  `laundry_category_id` int NOT NULL,
  `weight` double NOT NULL,
  `laundry_id` int NOT NULL,
  `unit_price` double NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY(id)
  -- FOREIGN KEY(laundry_category_id) references laundry_categories(id) on delete cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `laundry_list`

CREATE TABLE `laundry_list` (
  `id` int NOT NULL,
  `customer_name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=in queue, 1 = washing,2= washed,3= delivered',
  `queue` int NOT NULL,
  `total_amount` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE VIEW `admins_view` as
SELECT id, name, username
from users;

-- Inserting data for table `users`

INSERT INTO `users` (`id`, `name`, `username`, `password`) VALUES
(1, 'Admin', 'admin', 'admin123'),
(2, 'Amaan', 'amaan', 'amaan123'),
(3, 'Pulkit', 'pulkit', 'pulkit123');

-- Inserting data for table `customers`

INSERT INTO `customers` (`id`, `name`, `contact`, `email`, `tot_clothes`, `tot_paid`) VALUES
(1, 'Rahul', '7870145569', 'asddfa@dfad', 0, 0),
(2, 'Kumar', '7870145569', 'asddfa@dfad', 0, 0);

-- Inserting data for table `laundry_categories`

INSERT INTO `laundry_categories` (`id`, `name`, `price`, `max_capacity`, `available_capacity`) VALUES
(1, 'Curtains', 20, 100, 100),
(3, 'Bed Sheets', 25, 100, 100);

-- Inserting data for table `laundry_items`

INSERT INTO `laundry_items` (`id`, `laundry_category_id`, `weight`, `laundry_id`, `unit_price`, `amount`) VALUES
(4, 3, 10, 4, 25, 250);

-- Inserting data for table `laundry_list`

INSERT INTO `laundry_list` (`id`, `customer_name`, `status`, `queue`, `total_amount`, `date_created`) VALUES
(2, 'Amaan Zafar', 3, 1, 555, '2022-04-4 11:54:47'),
(4, 'Pulkit Gupta', 3, 1, 250, '2022-04-5 13:29:33');
  
-- AUTO_INCREMENT for table `laundry_categories`
--
ALTER TABLE `laundry_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `laundry_items`
--
ALTER TABLE `laundry_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laundry_list`
--
ALTER TABLE `laundry_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;