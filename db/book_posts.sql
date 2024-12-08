-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-12-05 15:00
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
-- 테이블 구조 `book_posts`
--

CREATE TABLE `book_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `book_info` text DEFAULT NULL,
  `recommend` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `book_posts`
--

INSERT INTO `book_posts` (`id`, `post_id`, `book_name`, `book_info`, `recommend`) VALUES
(5, 32, '', '제목: 기억 전달자\r\n저자: 로이스 로리\r\n출판사: 비룡소', 'no'),
(6, 33, 'test1', '제목: 기억 전달자\r\n저자: 로이스 로리\r\n출판사: 비룡소', 'yes'),
(8, 35, 'ㅇ', '제목: 기억 전달자\r\n저자: 로이스 로리\r\n출판사: 비룡소', 'yes'),
(9, 36, 'test1', '제목: 기억 전달자\r\n저자: 로이스 로리\r\n출판사: 비룡소', 'no'),
(11, 38, 'ㅇ', '제목: 기억 전달자\r\n저자: 로이스 로리\r\n출판사: 비룡소', 'no'),
(12, 39, 'test1', '제목: 기억 전달자\r\n저자: 로이스 로리\r\n출판사: 비룡소', 'no'),
(13, 40, 'ㅇ', '제목: 차마 돌아서지 못하고\r\n저자: 은강 이정용 시인\r\n출판사: e퍼플', 'no'),
(15, 42, 'ㅇ', '제목: 현대미술 강의\r\n저자: 조주연\r\n출판사: 글항아리', 'no'),
(16, 43, '오늘의 책 추천', '제목: 경영학 콘서트\r\n저자: 장영재\r\n출판사: 정보 없음', 'yes');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `book_posts`
--
ALTER TABLE `book_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `book_posts`
--
ALTER TABLE `book_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `book_posts`
--
ALTER TABLE `book_posts`
  ADD CONSTRAINT `book_posts_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
