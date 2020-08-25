-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2019 at 03:54 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bithub`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment_tb`
--

CREATE TABLE `comment_tb` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_tb`
--

INSERT INTO `comment_tb` (`comment_id`, `post_id`, `uid`, `comment_text`, `comment_time`) VALUES
(1, 1, 2, 'Jyeshtha&#39;s first post', '2018-11-12 22:27:58'),
(2, 4, 2, 'My second post!', '2018-11-12 22:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `doc_tb`
--

CREATE TABLE `doc_tb` (
  `doc_id` int(11) NOT NULL,
  `doc_name` text NOT NULL,
  `doc_path` text NOT NULL,
  `doc_postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doc_tb`
--

INSERT INTO `doc_tb` (`doc_id`, `doc_name`, `doc_path`, `doc_postid`) VALUES
(1, 'Module 1_ Introduction.pdf', '../../uploads/jyeshtha.v/Module 1_ Introduction5be9b0695a3f4.pdf', 1),
(2, 'Module 2- Requirements Analysis.pdf', '../../uploads/jyeshtha.v/Module 2- Requirements Analysis5be9b0695aaf9.pdf', 1),
(3, 'Character Generation_aliasing_antialiasing.pptx', '../../uploads/jyeshtha.v/Character Generation_aliasing_antialiasing5be9b08bd6586.pptx', 2),
(4, 'Unit 1.pptx', '../../uploads/akshay.vb/Unit 15be9b0ebf3c27.pptx', 3),
(5, 'Unit 2-NEW 18.pptx', '../../uploads/akshay.vb/Unit 2-NEW 185be9b0ec000a1.pptx', 3),
(6, '4.1 Project Estimation.pdf', '../../uploads/akshay.vb/4.1 Project Estimation5be9b16d3d519.pdf', 4),
(7, '4.2 Scheduling.pdf', '../../uploads/akshay.vb/4.2 Scheduling5be9b16d3dee9.pdf', 4),
(8, '5.2 Data and Architecture Design.pdf', '../../uploads/chetan.k/5.2 Data and Architecture Design5be9b1eaa721d.pdf', 5),
(9, '5.2 Design-CouplingandCohesion.pdf', '../../uploads/chetan.k/5.2 Design-CouplingandCohesion5be9b1eaa788f.pdf', 5),
(10, '5.2.Design Patterns.pdf', '../../uploads/chetan.k/5.2.Design Patterns5be9b1eaa7e41.pdf', 5),
(11, 'STQA_Module 2.pdf', '../../uploads/jyeshtha.v/STQA_Module 25dc035c1e7349.pdf', 6);

-- --------------------------------------------------------

--
-- Table structure for table `followers_tb`
--

CREATE TABLE `followers_tb` (
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers_tb`
--

INSERT INTO `followers_tb` (`uid`, `fid`) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `like_tb`
--

CREATE TABLE `like_tb` (
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `like_tb`
--

INSERT INTO `like_tb` (`userid`, `postid`) VALUES
(1, 4),
(1, 6),
(2, 1),
(2, 2),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `post_tb`
--

CREATE TABLE `post_tb` (
  `post_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `post_title` text NOT NULL,
  `post_des` text,
  `post_systime` datetime DEFAULT CURRENT_TIMESTAMP,
  `post_UTCtime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_tb`
--

INSERT INTO `post_tb` (`post_id`, `uid`, `post_title`, `post_des`, `post_systime`, `post_UTCtime`) VALUES
(1, 1, 'oose', 'module 1 and 2', '2018-11-12 22:25:05', '2018-11-12 16:55:05'),
(2, 1, 'cg', 'module 3', '2018-11-12 22:25:39', '2018-11-12 16:55:39'),
(3, 2, 'ITC', 'module 1 and 2', '2018-11-12 22:27:15', '2018-11-12 16:57:15'),
(4, 2, 'OOSE ', 'module 4', '2018-11-12 22:29:25', '2018-11-12 16:59:25'),
(5, 3, 'OOSE ', 'module 5', '2018-11-12 22:31:30', '2018-11-12 17:01:30'),
(6, 1, 'STQA', 'module 2', '2019-11-04 19:59:21', '2019-11-04 14:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `uid` int(11) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`uid`, `firstName`, `lastName`, `email`, `password`) VALUES
(1, 'Jyeshtha', 'Vartak', 'jyeshtha.v', 'hidden'),
(2, 'Akshay', 'Bhatt', 'akshay.vb', 'something'),
(3, 'Chetan', 'Kachaliya', 'chetan.k', 'chetan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment_tb`
--
ALTER TABLE `comment_tb`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `doc_tb`
--
ALTER TABLE `doc_tb`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `doc_postid` (`doc_postid`);

--
-- Indexes for table `followers_tb`
--
ALTER TABLE `followers_tb`
  ADD PRIMARY KEY (`uid`,`fid`),
  ADD KEY `fid` (`fid`);

--
-- Indexes for table `like_tb`
--
ALTER TABLE `like_tb`
  ADD PRIMARY KEY (`userid`,`postid`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `post_tb`
--
ALTER TABLE `post_tb`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment_tb`
--
ALTER TABLE `comment_tb`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doc_tb`
--
ALTER TABLE `doc_tb`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `post_tb`
--
ALTER TABLE `post_tb`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment_tb`
--
ALTER TABLE `comment_tb`
  ADD CONSTRAINT `comment_tb_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post_tb` (`post_id`),
  ADD CONSTRAINT `comment_tb_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users_tb` (`uid`);

--
-- Constraints for table `doc_tb`
--
ALTER TABLE `doc_tb`
  ADD CONSTRAINT `doc_tb_ibfk_1` FOREIGN KEY (`doc_postid`) REFERENCES `post_tb` (`post_id`);

--
-- Constraints for table `followers_tb`
--
ALTER TABLE `followers_tb`
  ADD CONSTRAINT `followers_tb_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users_tb` (`uid`),
  ADD CONSTRAINT `followers_tb_ibfk_2` FOREIGN KEY (`fid`) REFERENCES `users_tb` (`uid`);

--
-- Constraints for table `like_tb`
--
ALTER TABLE `like_tb`
  ADD CONSTRAINT `like_tb_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users_tb` (`uid`),
  ADD CONSTRAINT `like_tb_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `post_tb` (`post_id`);

--
-- Constraints for table `post_tb`
--
ALTER TABLE `post_tb`
  ADD CONSTRAINT `post_tb_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users_tb` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
