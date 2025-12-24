-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 07:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tchat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `message`, `created_at`) VALUES
(5, 6, 'hy the admin of this system is yve.dev', '2025-06-02 17:54:24'),
(6, 8, 'mrning', '2025-06-03 05:05:45'),
(7, 8, 'mrning', '2025-06-03 05:06:45'),
(8, 9, 'hello', '2025-06-03 12:45:02'),
(9, 10, 'vp', '2025-06-03 12:45:50'),
(10, 11, 'hy', '2025-06-03 13:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `email`, `location`, `age`) VALUES
(1, 'kevin', '$2y$10$uje.YvuKvCvIJZNq6JEyuemYsElv0emxiCcBylAhk16Rsa305L1Mu', '2025-06-02 08:35:28', NULL, NULL, NULL),
(2, 'mugisha', '$2y$10$rkZoxgFXUZvlmCmWREUbweADF4ALbBerQQf6cdqjiZTmVIAELGQJi', '2025-06-02 17:01:15', NULL, NULL, NULL),
(3, 'keve', '$2y$10$KS/wgTFIkUXRBljU2gJ1GuqXT5jqsXWRfiugF2DHvqo3aBGKlPUnK', '2025-06-02 17:19:53', NULL, NULL, NULL),
(4, 'mucyo', '$2y$10$OYsPuyKBo/YAyxPFrjuQy.Zcfu0x1YCa3qp6.VMe08NJgAt1CMHkC', '2025-06-02 17:20:41', NULL, NULL, NULL),
(5, 'bwiza', '$2y$10$MDhGh.vpYECZl6DViNAiiOqpvBt0Ftm8swN5TPTflCUOJa.0vBLV2', '2025-06-02 17:21:18', NULL, NULL, NULL),
(6, 'mwiza', '$2y$10$OuhK1O4a.24ks02IUPQvfuL5CV2jrFPAYvu6NyMUuzwJuby9tNzq.', '2025-06-02 17:27:31', NULL, NULL, NULL),
(7, 'nambaje', '$2y$10$jsVkU9n27cPxJbBPHu1lJ.FebWSe6BGUYHn2njy9.V5YycVX/r.qS', '2025-06-03 05:03:55', NULL, NULL, NULL),
(8, 'gisa', '$2y$10$suFssfMsCxK1Y99qp9bPK.drKzNBqKlkN5LT75GxJmHl3byC.Csy.', '2025-06-03 05:05:25', NULL, NULL, NULL),
(9, 'kenny', '$2y$10$hcru4xWDUXLflMxw./NMIezyS0XnvHftD4NdMP2qlOMEZC0U.mvZO', '2025-06-03 12:40:54', NULL, NULL, NULL),
(10, 'gold', '$2y$10$aAdLF3OI16.FLnuIguJZiOB/nIRO88VgWg4/jOVeMRoMGrYy8xJ8e', '2025-06-03 12:45:32', NULL, NULL, NULL),
(11, 'adelnoel', '$2y$10$KIHpEPKu.jFPiVQYDpXIeOZAwblHNA2HtnC0XDkVqGAcDXegctZ2G', '2025-06-03 13:22:49', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
