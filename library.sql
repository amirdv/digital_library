-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2015 at 04:52 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `listin_images`
--

CREATE TABLE IF NOT EXISTS `listin_images` (
  `date_modified_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yb_books`
--

CREATE TABLE IF NOT EXISTS `yb_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `release_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `visible` tinyint(4) NOT NULL,
  `content` text NOT NULL,
  `listing_id` int(11) DEFAULT NULL,
  `image_location` varchar(255) DEFAULT NULL,
  `date_created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `date_modified_on` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `yb_books`
--

INSERT INTO `yb_books` (`id`, `category_id`, `category_name`, `author_name`, `release_date`, `visible`, `content`, `listing_id`, `image_location`, `date_created_on`, `created_by`, `modified_by`, `date_modified_on`) VALUES
(1, 1, 'The Time Machine ', 'Herbert George Wells', '2015-10-30 00:00:00', 1, 'Fiction, Scientific romance, Fantasy, Time travel, Novella,gggg', NULL, NULL, '2015-10-22 15:54:49', NULL, NULL, '2015-10-22 15:54:49'),
(4, 2, 'Postwar', 'Tony Judt', '2005-02-09 00:00:00', 1, 'A History of Europe Since 1945 is a 2005 book by historian Tony Judt,', NULL, NULL, '2015-10-22 15:54:49', NULL, NULL, '2015-10-22 15:54:49'),
(32, 2, 'American X History', 'qwq', '2015-10-07 00:00:00', 1, 'American History X is a 199q8 American crime drama', NULL, NULL, '2015-10-23 17:40:05', NULL, NULL, '2015-10-23 17:40:05'),
(33, 3, 'Hamlet', NULL, '2015-10-28 15:49:45', 1, 'The Tragedy of Hamlet, Prince of Denmark,is a tragedy written by William Shakespeare Between 1599 and 1602.', NULL, NULL, '2015-10-23 17:41:07', NULL, NULL, '2015-10-23 17:41:07'),
(34, 3, 'The Grapes of Wrat', NULL, '2015-10-28 15:49:45', 1, 'The Grapes of Wrath is an American realist novel written by John Steinbeck and published in 1939', NULL, NULL, '2015-10-23 17:43:57', NULL, NULL, '2015-10-23 17:43:57'),
(35, 4, 'The Notebook', NULL, '2015-10-28 15:49:45', 1, 'The Notebook is a 1996 romantic novel by American novelist Nicholas Sparks, based on a true story.', NULL, NULL, '2015-10-23 17:44:39', NULL, NULL, '2015-10-23 17:44:39'),
(36, 4, 'Doctor Zhivago', NULL, '2015-10-28 15:49:45', 1, 'Doctor Zhivago is a novel by Boris Pasternak, first published in 1957 in Italy.', NULL, NULL, '2015-10-23 17:47:46', NULL, NULL, '2015-10-23 17:47:46'),
(37, 5, 'The Age of Reason', NULL, '2015-10-28 15:49:45', 1, 'The Age of Reason is a 1945 novel by Jean-Paul Sartre. It is the first part of the trilogy The Roads to Freedom. Wikipedia', NULL, NULL, '2015-10-23 17:51:20', NULL, NULL, '2015-10-23 17:51:20'),
(38, 5, 'Thus Spoke Zarathustra', 'amir', '2015-10-29 00:00:00', 0, 'Thus Spoke Zarathustra: A Book for All and None is a philosophical novel by German philosopher Friedrich Nietzsche,', NULL, NULL, '2015-10-23 17:52:49', NULL, NULL, '2015-10-23 17:52:49'),
(39, 1, 'The Martian', 'Andy Wei', '2015-10-29 18:31:08', 0, 'The Martian is a 2011 science fiction novel. It was the second novel by American author Andy Wei.', NULL, NULL, '2015-10-29 18:31:08', NULL, NULL, '2015-10-29 18:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `yb_category`
--

CREATE TABLE IF NOT EXISTS `yb_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `visible` int(11) DEFAULT NULL,
  `position` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `yb_category`
--

INSERT INTO `yb_category` (`id`, `category_name`, `visible`, `position`) VALUES
(1, 'Science Fiction', 1, 1),
(2, 'History', 1, 2),
(3, 'Drama', 1, 3),
(4, 'Romance', 1, 4),
(5, 'Philosophy', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `yb_users`
--

CREATE TABLE IF NOT EXISTS `yb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `hashed_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `yb_users`
--

INSERT INTO `yb_users` (`id`, `username`, `hashed_password`) VALUES
(1, 'amir.hamzeh', '$2y$10$MmM5OWNkMzQ0NDEwODljM.CqFjE9tFbeCIPSidMTR4O8cIikSIULK'),
(4, 'user', '$2y$10$MjIwZDQyODQxNjg1MzMwYu7GBNDZFzSOknLK9E9OHF5iC4OoMuafm');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
