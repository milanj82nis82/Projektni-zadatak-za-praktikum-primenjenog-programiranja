-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 04:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zadaci`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Administrator'),
(2, 'Rukovodilac'),
(3, 'Izvršilac');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `reset_token` varchar(255) NULL,
  `reset_token_expiry` timestamp NOT NULL DEFAULT current_timestamp(),
  `birth_date` date NOT NULL,
  `is_active` int(11) DEFAULT 0,
  `role_id` int(11) DEFAULT 3,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `phone`, `state`, `city`, `postal_code`, `address`, `token`, `birth_date`, `is_active`, `role_id`, `created_at`, `updated_at`) VALUES
(2, 'milanj82nis', 'Milan', 'Janković', '$2y$10$FTRVSNR9gSw.3jbjGRGZa.usPbsdeG5Px.bNzFSOgBfvMQwundZMy', 'milan82nis@gmail.com', '0629659932', 'Srbija', 'Niš', '18000', 'Gabrovačka reka 78', '1d091b86dee5bad7996cbc322ef744f29bcb7b0f6c829e75d5196cc891ab456ab563a679df7dde22d1ab6f331bca6b58d8a3', '2025-02-11', 0, 1, '2025-02-09 14:57:10', '2025-02-09 15:03:55'),
(3, 'milanj82nis2', 'Milan', 'Janković', '$2y$10$gu7tixrz2x5AYyrIRiGZtebnQlVB0Dv8UKEdrnTdEMCgjqNec6GRa', 'milanj31@gmail.com', '0628985971', 'Srbija', 'Niš', '18000', 'Branka Miljkovića 8', 'b10b6048627ada3d1aff07c841eb8fb38b4994806f9f50f6b070b157c6b3ad385c7bdc3f271a5f1aed64249a747a74d2c892', '2025-02-11', 0, 3, '2025-02-09 15:03:28', '2025-02-09 15:03:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
