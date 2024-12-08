-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-12-05 15:02
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
-- 테이블 구조 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_copied` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author_id`, `created_at`, `updated_at`, `view_count`, `file_name`, `file_type`, `file_copied`, `category`) VALUES
(32, 'test1', 'ㄴㄴㄴㄴ', 'user3', '2024-11-19 23:08:06', NULL, 83, '', '', '', 'novel'),
(33, 'test1', '123', 'user3', '2024-11-20 04:51:21', NULL, 2, '', '', '', 'novel'),
(35, 'ㅇ', 'ㅇ', 'todayis', '2024-12-03 23:58:45', NULL, 0, '', '', '', 'novel'),
(36, 'test1', 'ㅇ', 'todayis', '2024-12-03 23:58:56', NULL, 0, '', '', '', 'novel'),
(38, 'ㅇ', 'ㅇ', 'todayis', '2024-12-03 23:59:16', NULL, 0, '', '', '', 'novel'),
(39, 'test1', 'ㅇ', 'todayis', '2024-12-04 00:03:39', NULL, 1, '', '', '', 'novel'),
(40, 'ㅇ', 'ㅇ', 'todayis', '2024-12-04 00:03:50', NULL, 0, '', '', '', 'novel'),
(42, 'ㅇㅇㅇ', 'ㅇㅇㅇ', 'todayis', '2024-12-04 00:04:15', NULL, 83, '', '', '', 'novel'),
(43, '오늘의 책 추천', '.', 'todayis', '2024-12-05 00:59:02', NULL, 2, '', '', '', 'novel');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_author_id` (`author_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_author_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`nickname`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
