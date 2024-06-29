-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 07:53 AM
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
-- Database: `sse3308`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `timestamp`, `email`) VALUES
(3, 'hwei625', 'I love your smooth pistachio butter spread! Its the best in the world!', '2024-06-13 09:18:34', 'hwei625@gmail.com'),
(4, 'abc', 'Your almond butter is the best in the world!', '2024-06-13 09:23:58', 'abc@dhong.xyz');

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `serving_size` varchar(50) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `total_fat_value` int(11) DEFAULT NULL,
  `total_fat_percent` int(11) DEFAULT NULL,
  `cholesterol_value` int(11) DEFAULT NULL,
  `cholesterol_percent` int(11) DEFAULT NULL,
  `sodium_value` int(11) DEFAULT NULL,
  `sodium_percent` int(11) DEFAULT NULL,
  `total_carbohydrate_value` int(11) DEFAULT NULL,
  `total_carbohydrate_percent` int(11) DEFAULT NULL,
  `dietary_fiber_value` int(11) DEFAULT NULL,
  `dietary_fiber_percent` int(11) DEFAULT NULL,
  `sugars_value` int(11) DEFAULT NULL,
  `sugars_percent` int(11) DEFAULT NULL,
  `protein_value` int(11) DEFAULT NULL,
  `protein_percent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`id`, `name`, `price`, `image`, `description`, `ingredients`, `serving_size`, `calories`, `total_fat_value`, `total_fat_percent`, `cholesterol_value`, `cholesterol_percent`, `sodium_value`, `sodium_percent`, `total_carbohydrate_value`, `total_carbohydrate_percent`, `dietary_fiber_value`, `dietary_fiber_percent`, `sugars_value`, `sugars_percent`, `protein_value`, `protein_percent`) VALUES
(1, 'Smooth Peanut Butter', 'RM20', '/img/peanut butter jar.png', 'Experience the unparalleled richness of our Smooth Peanut Butter, crafted from the finest roasted peanuts to deliver a creamy, indulgent texture. Perfect for spreading on toast, or enjoying straight from the jar.', 'Peanuts, Salt', '2 tbsp (32g)', 180, 15, 23, 0, 0, 140, 6, 6, 2, 2, 8, 3, 0, 7, 14),
(2, 'Chunky Peanut Butter', 'RM21', '/img/peanut butter jar.png', 'Our Chunky Peanut Butter blends creamy peanut butter with delightful peanut chunks, offering a satisfying crunch. Perfect on toast, smoothies, or as a snack.', 'Peanuts, Salt', '2 tbsp (32g)', 190, 16, 25, 0, 0, 150, 6, 7, 2, 2, 8, 3, 0, 8, 16),
(3, 'Peanut Butter Gift Set', 'RM59', '/img/peanut-butter-gift-set.png', 'Gift the ultimate peanut butter experience with our exclusive Peanut Butter Gift Set, featuring a variety of best-selling flavors, perfect for any occasion.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Smooth Almond Butter', 'RM25', '/img/almond butter jar.png', 'Indulge in the smoothness of our Almond Butter, made from premium roasted almonds. Perfect for spreading on toast, adding to recipes, or enjoying straight from the jar.', 'Almonds, Salt', '2 tbsp (32g)', 190, 17, 26, 0, 0, 60, 3, 6, 2, 3, 12, 1, 0, 6, 12),
(5, 'Chunky Almond Butter', 'RM26', '/img/almond butter jar.png', 'Our Chunky Almond Butter combines a creamy base with pieces of real roasted almonds. Perfect for adding texture to toast, smoothies, or baked goods.', 'Almonds, Salt', '2 tbsp (32g)', 200, 18, 28, 0, 0, 65, 3, 7, 2, 3, 12, 2, 0, 7, 14),
(6, 'Smooth Pistachio Butter', 'RM24', '/img/pistachio butter jar.png', 'Discover the luxurious taste of our Smooth Pistachio Butter, made from the finest pistachios. Perfect for gourmet uses or as a delicious standalone snack.', 'Pistachios, Salt', '2 tbsp (32g)', 190, 17, 26, 0, 0, 70, 3, 8, 3, 3, 12, 2, 0, 6, 12),
(7, 'Smooth Cashew Butter', 'RM22', '/img/cashew butter jar.png', 'Our Smooth Cashew Butter is a creamy treat made from premium cashews, perfect for spreading, incorporating into recipes, or enjoying straight from the jar.', 'Cashews, Salt', '2 tbsp (32g)', 180, 14, 22, 0, 0, 120, 5, 9, 3, 1, 4, 2, 0, 5, 10),
(8, 'Chunky Cashew Butter', 'RM23', '/img/cashew butter jar.png', 'Enjoy the best of both worlds with our Chunky Cashew Butter, featuring a creamy base with crunchy pieces of cashew. Perfect for spreading, recipes, or as a snack.', 'Cashews, Salt', '2 tbsp (32g)', 190, 15, 23, 0, 0, 125, 5, 10, 3, 1, 4, 2, 0, 6, 12);

-- --------------------------------------------------------

--
-- Table structure for table `status_updates`
--

CREATE TABLE `status_updates` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `status` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_updates`
--

INSERT INTO `status_updates` (`id`, `username`, `status`, `timestamp`) VALUES
(1, 'current_user', 'b', '2024-06-12 04:44:12'),
(2, 'current_user', 'b', '2024-06-12 04:44:14'),
(3, 'current_user', 'basd', '2024-06-12 04:45:11'),
(4, 'current_user', 'asdas', '2024-06-12 09:01:04'),
(5, 'current_user', 'asd', '2024-06-13 09:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(4, 'hwei625', '$2y$10$G/NWU7ou.pV0cI2nUeclPeIDxf7SYCd37I5iShRqKGGSJrPYt3HZC', 'hwei625@gmail.com'),
(5, 'abc', '$2y$10$jZaV/VUCmQU3QGiHJQxCIuSuQPzV.USUoYpvhnWTvftVav1yrZm.i', 'abc@dhong.xyz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_updates`
--
ALTER TABLE `status_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status_updates`
--
ALTER TABLE `status_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
