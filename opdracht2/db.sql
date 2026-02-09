-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 09, 2026 at 10:49 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpoop`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_connections`
--

DROP TABLE IF EXISTS `auth_connections`;
CREATE TABLE IF NOT EXISTS `auth_connections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `provider` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_provider_connection` (`provider`,`provider_id`),
  KEY `idx_user_provider` (`user_id`,`provider`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_connections`
--

INSERT INTO `auth_connections` (`id`, `user_id`, `provider`, `provider_id`, `created_at`) VALUES
(1, 2, 'discord', '986605191627431986', '2026-02-09 10:32:57'),
(2, 3, 'github', '101514045', '2026-02-09 10:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_bytes` int UNSIGNED NOT NULL,
  `alt_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_media_created_at` (`created_at`),
  KEY `idx_media_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `type`, `original_name`, `filename`, `path`, `mime_type`, `size_bytes`, `alt_text`, `created_at`) VALUES
(1, 'image', 'tester.jpg', 'f248292dc2f1ddb994832b22b0d4d6c7.jpg', 'uploads', 'image/jpeg', 106267, 'ddd', '2026-02-02 11:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_media_id` int UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `meta_title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked_by` int UNSIGNED DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_posts_featured_media` (`featured_media_id`),
  KEY `fk_posts_locked_by` (`locked_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `status`, `slug`, `featured_media_id`, `created_at`, `updated_at`, `deleted_at`, `published_at`, `meta_title`, `meta_description`, `locked_by`, `locked_at`) VALUES
(1, 'hoi', 'Welkom bij MiniCMS Pro met database.', 'published', 'hoi', NULL, '2026-01-22 09:53:12', NULL, NULL, '2026-01-22 09:53:12', NULL, NULL, NULL, NULL),
(4, 'test4', 'dit is een aanpassing voor de revisie', 'published', 'test4', NULL, '2026-01-26 09:22:32', '2026-02-09 11:45:47', NULL, '2026-01-26 09:22:00', NULL, NULL, NULL, NULL),
(5, 'fdsfdfds', 'dsdsdsfdsdssffdsdsdsfdsffds nieuw', 'draft', 'fdsfdfds', 1, '2026-01-26 03:37:24', '2026-02-09 11:46:45', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_revisions`
--

DROP TABLE IF EXISTS `post_revisions`;
CREATE TABLE IF NOT EXISTS `post_revisions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_media_id` int UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_revisions_post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_revisions`
--

INSERT INTO `post_revisions` (`id`, `post_id`, `user_id`, `title`, `content`, `slug`, `featured_media_id`, `created_at`) VALUES
(3, 4, 1, 'test4', 'test4', 'test4', NULL, '2026-02-09 11:40:01'),
(4, 4, 1, 'test4', 'test4stefqsdscdsazd', 'test4', NULL, '2026-02-09 11:44:48'),
(5, 4, 1, 'test4', 'dit is een aanpassing voor de revisie', 'test4', NULL, '2026-02-09 11:45:47'),
(7, 5, 1, 'fdsfdfds', 'dsdsdsfdsdssffdsdsdsfdsffds nieuw', 'fdsfdfds', 1, '2026-02-09 11:46:26'),
(8, 5, 1, 'fdsfdfds', 'dsdsdsfdsdssffdsdsdsfdsffds nieuw', 'fdsfdfds', 1, '2026-02-09 11:46:37'),
(9, 5, 1, 'fdsfdfds', 'dsdsdsfdsdssffdsdsdsfdsffds', 'fdsfdfds', 1, '2026-02-09 11:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_users_roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `name`, `role_id`, `created_at`, `is_active`) VALUES
(1, 'admin@minicms.test', '$2y$10$dFGk7PkYxy5UgOdQKzqlg.zRUGMjtFlfgZkNKxN62Gt654inn3fim', 'Admin', 1, '2026-02-09 08:40:43', 1),
(2, 'J-A-R-I@github.placeholder', '', 'J-A-R-I', 1, '2026-02-09 10:03:24', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_connections`
--
ALTER TABLE `auth_connections`
  ADD CONSTRAINT `fk_auth_connections_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_featured_media` FOREIGN KEY (`featured_media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posts_locked_by` FOREIGN KEY (`locked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_revisions`
--
ALTER TABLE `post_revisions`
  ADD CONSTRAINT `fk_revisions_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
