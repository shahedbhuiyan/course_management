-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2016 at 12:46 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `exam_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `authentication_info`
--

CREATE TABLE IF NOT EXISTS `authentication_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `authentication_info`
--

INSERT INTO `authentication_info` (`id`, `user_name`, `password`, `user_type`) VALUES
(1, 'nahian.asif@gmail.com', '123', 'AD'),
(2, 'tanvir@gmail.com', '444', 'IN'),
(3, 'shahed.blackmagic@gmail.com', '123', 'IN');

-- --------------------------------------------------------

--
-- Table structure for table `batch_details`
--

CREATE TABLE IF NOT EXISTS `batch_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_name` varchar(20) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `enrollment_key` varchar(10) DEFAULT NULL,
  `st_date` date DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `batch_details`
--

INSERT INTO `batch_details` (`id`, `batch_name`, `course_id`, `enrollment_key`, `st_date`, `instructor_id`) VALUES
(7, 'BATCH_001', 1, 'tXmPL29CCN', '2016-04-30', 5),
(8, 'BATCH_002', 2, 'lsakdjflks', '2016-04-29', 5),
(9, 'BATCH_003', 7, 'xyTF9Mzj', '2016-04-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE IF NOT EXISTS `catagory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catagory_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`id`, `catagory_name`) VALUES
(1, 'Networking'),
(2, 'Programming'),
(3, 'Vendor Exam');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(40) DEFAULT NULL,
  `catagory_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_name`, `catagory_id`) VALUES
(1, 'CCNA', 1),
(2, 'CCNP', 1),
(3, 'Java SE', 2),
(4, 'Java EE', 2),
(5, 'PHP', 2),
(6, 'Android Development', 1),
(7, 'Web Programming', 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_topic`
--

CREATE TABLE IF NOT EXISTS `course_topic` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(100) DEFAULT NULL,
  `tdate` date DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `class_no` decimal(2,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_topic`
--

INSERT INTO `course_topic` (`id`, `topic_name`, `tdate`, `batch_id`, `class_no`) VALUES
(1, 'Introduction to CCNA', '2016-04-15', 7, 1),
(2, 'CCNA Routing', '2016-04-16', 7, 2),
(3, 'Introduction to CCNP', '2016-04-15', 8, 1),
(4, 'CCNP Security', '2016-04-16', 8, 2),
(5, 'Security Structure', '2016-04-17', 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_info`
--

CREATE TABLE IF NOT EXISTS `enrollment_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `batch_id` int(10) NOT NULL,
  `isEnrolled` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_info`
--

CREATE TABLE IF NOT EXISTS `instructor_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `fb_id` varchar(80) DEFAULT NULL,
  `image` varchar(10) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `instructor_info`
--

INSERT INTO `instructor_info` (`id`, `name`, `email`, `contact`, `fb_id`, `image`, `join_date`, `password`, `faculty_id`) VALUES
(1, 'shahed bhuiyan', 'shahed.blackmagic@gmail.com', '01821152983', 'fb.com/shahed.blackmagic', '0182115298', '2016-04-15', '123', 2),
(3, 'Nahian Asif', 'nahian.asif@gmail.com', '3443543534', 'fb.com/shahed.blackmagic', '3443543534', '2016-04-21', '123', 1),
(5, 'tanvir', 'tanvir@gmail.com', '98988989', 'fb.com/shahed.blackmagic', '98988989.j', '2016-04-23', '444', 1);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `question` text,
  `question_desc` text,
  `course_topic_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE IF NOT EXISTS `student_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `contact` varchar(14) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `occupation` char(2) DEFAULT NULL,
  `image` varchar(40) DEFAULT NULL,
  `address` text,
  `password` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `name`, `email`, `contact`, `gender`, `occupation`, `image`, `address`, `password`) VALUES
(4, 'lkajsd;flj', 'lkjaslfdkj', 'lkjasdflkj', 'M', 'ST', 'lkjasdflkj.jpg', 'alskdfj', 'lkjasfdlk');

-- --------------------------------------------------------

--
-- Table structure for table `topic_content`
--

CREATE TABLE IF NOT EXISTS `topic_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_topic_id` int(11) DEFAULT NULL,
  `topic_desc` text,
  `topic_file` varchar(50) DEFAULT NULL,
  `importantLink1` text,
  `importantLink2` text,
  `videoLink1` varchar(255) DEFAULT NULL,
  `videoLink2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `topic_content`
--

INSERT INTO `topic_content` (`id`, `course_topic_id`, `topic_desc`, `topic_file`, `importantLink1`, `importantLink2`, `videoLink1`, `videoLink2`) VALUES
(2, 1, 'kasdfl kdsfjlsakdfjsldfk ', '1-1.jpg_1-2.jpg_1-3.jpg_1-4.jpg', 'https://www.youtube.com/watch?v=MTA8DE5fjsk', 'https://www.youtube.com/watch?v=MTA8DE5fjsk', 'https://www.youtube.com/embed/IYU1co7sBWU', 'https://www.youtube.com/embed/IYU1co7sBWU'),
(4, 2, 'this is topic content 2', '1-1.jpg_1-2.jpg_1-3.jpg_1-4.jpg', 'https://www.youtube.com/watch?v=MTA8DE5fjsk', 'https://www.youtube.com/watch?v=MTA8DE5fjsk', 'https://www.youtube.com/embed/fELbobRy3Wg', 'https://www.youtube.com/embed/fELbobRy3Wg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
