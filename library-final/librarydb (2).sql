-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2023 at 09:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `adminemail` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `firstname`, `middlename`, `lastname`, `adminemail`, `password`) VALUES
(1, 'admin', 'Norman', 'b.', 'hello', 'norman@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `isbn` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `datepublished` date DEFAULT NULL,
  `copies` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`isbn`, `title`, `author`, `category`, `datepublished`, `copies`, `status`, `image`) VALUES
('77777777', 'hello', 'Trinidad Christian B.', 'Memoir', '2023-05-16', 0, 'Not Available', 'books_img/sp.jpg'),
('8749857', 'Ni kelly nga bassit', 'Trinidad Christian B.', 'Fantasy', '2023-05-22', 2, 'Available', 'books_img/small.jpg'),
('9780385755887', 'Velva Jean Learns to Fly', 'Jennifer Niven', 'Historical Fiction', '2009-07-14', 1, 'Available', 'books_img/velvajean.jpg'),
('9780385755900', 'Holding Up the Universe Movie Tie-In Edition', 'Jennifer Niven', 'Young Adult', '2016-10-04', 4, 'Available', 'books_img/holdingup.jpg'),
('9780385755917', 'All the Bright Places Movie Tie-In Edition', 'Jennifer Niven', 'Young Adult', '2015-01-06', 0, 'Not Available', 'books_img/allthebrightplaces.jpg'),
('9780439064873', 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 'Fantasy', '1999-07-08', 5, 'Available', 'books_img/harry_potter3.jpg'),
('9780590353427', 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Fantasy', '1997-06-26', 2, 'Available', 'books_img/harry_potter1.jpg'),
('9780747532699', 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'Fantasy', '1998-07-02', 2, 'Available', 'books_img/harry_potter2.jpg'),
('9781524701994', 'Breathless', 'Jennifer Niven', 'Young Adult', '2020-09-29', 0, 'Not Available', 'books_img/breathless.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

CREATE TABLE `issued_books` (
  `issued_id` int(191) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `book_isbn` varchar(20) DEFAULT NULL,
  `requestTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateApproved` date NOT NULL DEFAULT current_timestamp(),
  `returnDate` date DEFAULT NULL,
  `returnStatus` varchar(20) DEFAULT NULL,
  `fine` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `issued_books`
--

INSERT INTO `issued_books` (`issued_id`, `user`, `book_isbn`, `requestTime`, `dateApproved`, `returnDate`, `returnStatus`, `fine`) VALUES
(10, 'pittu', '9780590353427', '2023-05-21 18:08:47', '2023-05-21', '2023-05-24', 'Returned', '10.00'),
(11, 'rose', '77777777', '2023-05-23 16:16:37', '2023-05-21', '2023-05-26', 'Not yet returned', '50.00'),
(14, 'kelly', '77777777', '2023-05-23 15:43:44', '2023-05-23', '2023-05-28', 'Returned', '500000.00'),
(16, 'mark', '9780385755887', '2023-05-23 18:45:09', '2023-05-24', '2023-05-29', 'Not yet returned', NULL),
(17, 'kelly', '9780747532699', '2023-05-23 19:02:59', '2023-05-24', '2023-05-29', 'Not yet returned', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pending_book_requests`
--

CREATE TABLE `pending_book_requests` (
  `br_id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `book_isbn` varchar(100) NOT NULL,
  `request_status` varchar(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pending_book_requests`
--

INSERT INTO `pending_book_requests` (`br_id`, `user`, `book_isbn`, `request_status`, `time`) VALUES
(46, 'kelly', '9780747532699', '', '2023-05-24 03:22:44'),
(47, 'kelly', '9780385755887', '', '2023-05-24 03:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `MI` varchar(2) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `MI`, `address`, `phone`, `email`, `username`, `password`, `date_created`, `date_updated`) VALUES
(1, 'christian', 'trinidad', 'b', '25 camguidan batac ilocos norte', '09612387594', 'toks@gmail.com', 'christiantrinidad222@gmail.com', '123', '2023-05-18 17:12:18', '2023-05-18 17:12:18'),
(2, 'kelly', 'balanay', 'c', 'Batac city', '09978550135', 'kelly123@gmail.com', 'kelly', '123', '2023-05-18 17:12:18', '2023-05-23 08:28:00'),
(3, 'mark', 'trinidad', 'b', '13 laoag', '09978550125', 'mark@gmail.com', 'mark', '123', '2023-05-18 17:15:00', '2023-05-18 17:15:00'),
(4, 'rose', 'Averill', 'b.', '25 camguidan batac ilocos norte', '123456787912', 'rose@gmail.com', 'rose', 'rider', '2023-05-19 22:16:50', '2023-05-21 02:44:18'),
(5, 'christian', 'rangcapan', 'd.', '26 parangopong', '7826589234', 'gaggagsa@gmail.com', 'pittu', '123', '2023-05-20 13:42:39', '2023-05-20 13:42:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`isbn`);

--
-- Indexes for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD PRIMARY KEY (`issued_id`);

--
-- Indexes for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  ADD PRIMARY KEY (`br_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `issued_books`
--
ALTER TABLE `issued_books`
  MODIFY `issued_id` int(191) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  MODIFY `br_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
