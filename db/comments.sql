-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-12-05 15:01
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `book_platform`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `author_nickname` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `content`, `author_nickname`, `created_at`, `updated_at`) VALUES
(1, 32, '123', 'user3', '2024-11-20 17:06:32', NULL),
(2, 32, '123', 'user3', '2024-11-20 17:08:05', NULL),
(3, 32, '12345', 'user3', '2024-11-20 17:08:23', NULL),
(4, 32, '12345', 'user3', '2024-11-20 17:09:16', NULL),
(5, 32, '1234567', 'user3', '2024-11-20 17:09:33', NULL),
(6, 32, 'hi', 'user3', '2024-11-20 17:10:43', NULL),
(7, 32, 'hi', 'user3', '2024-11-20 17:13:06', NULL),
(8, 32, '45', 'user3', '2024-11-20 17:13:12', NULL),
(10, 32, '45', 'user3', '2024-11-20 17:15:12', '2024-11-20 18:26:33'),
(11, 32, '456', 'user3', '2024-11-20 09:20:45', NULL),
(12, 32, '456', 'user3', '2024-11-20 09:22:24', NULL),
(13, 32, '454', 'user3', '2024-11-20 18:10:50', NULL),
(14, 32, '454ㅇㅇㅇ', 'user3', '2024-11-20 18:15:05', '2024-11-20 20:48:01'),
(16, 32, 'ㅇㅇ', 'user3', '2024-11-20 20:22:30', '2024-11-20 20:47:57'),
(18, 42, 'ㅇ', 'todayis', '2024-12-05 03:14:21', NULL);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
