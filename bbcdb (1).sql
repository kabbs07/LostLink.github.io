-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 02:48 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbcdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `announcement_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `announcement_text`, `created_at`) VALUES
(4, 'Test', '2023-05-18 20:03:02'),
(5, 'a', '2023-05-20 14:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `court_list`
--

CREATE TABLE `court_list` (
  `court_id` int(30) NOT NULL,
  `court` text NOT NULL,
  `rent_price` float(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `court_list`
--

INSERT INTO `court_list` (`court_id`, `court`, `rent_price`) VALUES
(1, 'Court 1', 100.00),
(2, 'Court 2', 100.00),
(3, 'Court 3', 100.00),
(4, 'Court 4', 100.00),
(5, 'Court 5', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `product_price` float(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'available',
  `product_quantity` int(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `name`, `product_price`, `status`, `product_quantity`) VALUES
(1, 'Shuttle Cock', 50.00, 'available', 100),
(2, 'Racket Rental', 50.00, 'available', 100),
(3, 'Racket and Shuttlecock', 100.00, 'available', 100),
(4, 'a', 22.00, 'available', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `end_time` time NOT NULL,
  `hours` float(12,2) NOT NULL DEFAULT 0.00,
  `party_size` int(11) NOT NULL,
  `court_number` int(11) NOT NULL,
  `equipment` varchar(100) DEFAULT NULL,
  `quantity` int(100) NOT NULL,
  `total` float(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `user_name`, `email`, `date`, `time`, `end_time`, `hours`, `party_size`, `court_number`, `equipment`, `quantity`, `total`) VALUES
(2, 10, 'Garcia', '', '2023-05-17', '21:00:00', '23:00:00', 2.00, 2, 2, 'Shuttle Cock', 3, 200.00),
(3, 9, 'Patrick', '', '2023-05-17', '20:50:00', '00:50:00', 4.00, 4, 4, 'Bring Your Own Equipment', 0, 400.00),
(4, 9, 'Patrick', '', '2023-05-25', '20:55:00', '22:55:00', 2.00, 2, 2, 'Shuttle Cock', 3, 350.00),
(5, 9, 'Patrick', '', '2023-05-19', '08:57:00', '10:57:00', 2.00, 3, 3, 'Shuttle Cock', 2, 300.00),
(6, 9, 'Patrick', '', '2023-05-26', '20:58:00', '23:58:00', 3.00, 2, 2, 'Racket Rental', 1, 350.00),
(7, 9, 'Patrick', '', '2023-05-27', '21:01:00', '00:01:00', 3.00, 3, 3, 'Shuttle Cock', 2, 400.00),
(8, 9, 'Patrick', '', '2023-05-27', '21:02:00', '22:02:00', 1.00, 1, 1, 'Racket Rental', 3, 250.00),
(9, 9, 'Patrick', '', '2023-05-27', '00:22:00', '03:22:00', 3.00, 3, 2, 'Shuttle Cock', 3, 450.00),
(10, 9, 'Patrick', '', '2023-05-26', '00:31:00', '02:31:00', 2.00, 2, 2, 'bring', 0, 200.00),
(11, 9, 'Patrick', '', '2023-05-23', '00:31:00', '02:31:00', 2.00, 2, 2, 'Shuttle Cock', 3, 350.00),
(12, 9, 'Patrick', '', '2023-06-02', '00:33:00', '03:33:00', 3.00, 3, 3, 'bring', 0, 300.00),
(13, 9, 'Patrick', 'patrickjeri.garcia@gmail.com', '2023-05-24', '22:18:00', '00:18:00', 2.00, 2, 2, 'Shuttle Cock', 2, 300.00),
(14, 9, 'Patrick', 'patrickjeri.garcia@gmail.com', '2023-05-24', '11:25:00', '13:25:00', 2.00, 2, 2, 'Racket and Shuttlecock', 2, 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `code`, `is_admin`) VALUES
(9, 'Patrick', 'patrickjeri.garcia@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '416ab4ffd75042b667bd7d32a075e7e3', 1),
(10, 'Garcia', 'garciapatrick341@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '', 0),
(52, 'Patrick', 'pgarcia3434@yahoo.com', '202cb962ac59075b964b07152d234b70', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court_list`
--
ALTER TABLE `court_list`
  ADD PRIMARY KEY (`court_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `court_number` (`court_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `court_list`
--
ALTER TABLE `court_list`
  MODIFY `court_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
