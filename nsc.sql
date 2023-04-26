-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2023 at 01:15 PM
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
-- Database: `nsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `date_commented` date NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth`
--

CREATE TABLE `oauth` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `secret` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oauth`
--

INSERT INTO `oauth` (`id`, `client_id`, `secret`) VALUES
(1, '741392903976-3f38abbdq0fibv6i9sgv1tk3rnjlecdq.apps.googleusercontent.com', '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');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_text` text NOT NULL,
  `post_picture` text NOT NULL,
  `date_posted` date NOT NULL,
  `date_updated` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `upvote_count` bigint(20) DEFAULT NULL,
  `downvote_count` bigint(20) NOT NULL,
  `post_title` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_text`, `post_picture`, `date_posted`, `date_updated`, `user_id`, `upvote_count`, `downvote_count`, `post_title`) VALUES
(20, 'This is a testing post', '', '2023-04-03', '2023-04-03', 8, 0, 1, 'testing'),
(21, 'This is another testing post', '', '2023-04-03', '2023-04-03', 8, 0, 0, 'NEW testing'),
(22, 'I hate pizza, But I love burgers', '', '2023-04-03', '2023-04-03', 10, 0, 0, 'Pizza'),
(23, 'Dogs are cute', '', '2023-04-03', '2023-04-03', 10, 0, 0, 'dog'),
(25, 'new pic', 'http://localhost/Social_platform_PHP/app/upload/post_pics/936378.jpg', '2023-04-26', '2023-04-26', 8, 0, 0, 'new picture post');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `reaction_id` int(11) NOT NULL,
  `reaction_type` tinyint(1) DEFAULT NULL,
  `date_reacted` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`reaction_id`, `reaction_type`, `date_reacted`, `user_id`, `post_id`) VALUES
(14, 0, '2023-04-03', 8, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(80) DEFAULT NULL,
  `profile_picture` varchar(300) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `last_login` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_picture`, `date_joined`, `last_login`) VALUES
(8, 'Rusian 0', 'masona954@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/AGNmyxbDlQoh12-6cirrZeifAKcSU9PcARAoQR1MizRp0g=s96-c', '2023-04-03', '2023-04-03'),
(9, 'arafat', 'araf@gmail.com', '$2y$10$15XsqsfI/LUbm18kyyxm1.OpXJ.GwxwOUR8C.7YKPhri1BMIdpP.a', NULL, '0000-00-00', NULL),
(10, 'robin', 'arafat.rahman19@northsouth.edu', NULL, 'http://localhost/Social_platform_PHP/app/upload/profile_pics/uwp3509956.jpeg', '2023-04-03', '2023-04-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_Posts` (`post_id`),
  ADD KEY `comment_Users` (`user_id`);

--
-- Indexes for table `oauth`
--
ALTER TABLE `oauth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `Posts_Users` (`user_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD KEY `Reactions_Users` (`user_id`),
  ADD KEY `Reactions_Posts` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth`
--
ALTER TABLE `oauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `reaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_Posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `Posts_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `Reactions_Posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Reactions_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
