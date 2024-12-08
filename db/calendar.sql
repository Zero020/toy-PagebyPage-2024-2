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
-- 테이블 구조 `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `memo` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `recommend` enum('yes','no') DEFAULT 'no',
  `book_image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `calendar`
--

INSERT INTO `calendar` (`id`, `date`, `book_title`, `memo`, `created_at`, `recommend`, `book_image`, `user_id`) VALUES
(4, '2024-11-05', '프레임', '123', '2024-11-20 18:16:19', 'yes', 'http://books.google.com/books/content?id=7X85EAAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(23, '2024-12-05', '굿모닝', 'ㅇ', '2024-12-04 16:20:42', 'yes', 'http://books.google.com/books/content?id=O3PyEAAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(25, '2024-12-03', '안녕', 'ㅎ', '2024-12-04 17:27:26', 'yes', 'http://books.google.com/books/content?id=DhgsEQAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(26, '2024-12-02', '호호', 'ㅓ', '2024-12-04 17:31:33', 'yes', 'http://books.google.com/books/content?id=MtmTDQAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(27, '2024-12-05', '하늘', '하늘', '2024-12-05 09:34:29', 'no', 'http://books.google.com/books/content?id=abSCDwAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(28, '2024-12-12', '베이커리', '오', '2024-12-05 09:44:16', 'yes', 'http://books.google.com/books/content?id=jp7nAwAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(29, '2024-12-01', '프레임', '오', '2024-12-05 13:43:16', 'no', 'http://books.google.com/books/content?id=9K14EAAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(30, '2024-12-04', '프레임', '오', '2024-12-05 13:52:05', 'no', 'http://books.google.com/books/content?id=9K14EAAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26),
(31, '2024-12-06', '프레임', '오', '2024-12-05 13:54:06', 'yes', 'http://books.google.com/books/content?id=9K14EAAAQBAJ&amp;printsec=frontcover&amp;img=1&amp;zoom=1&amp;edge=curl&amp;source=gbs_api', 26);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calendar_user` (`user_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `fk_calendar_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
