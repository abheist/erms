-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2015 at 05:06 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `erms`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate_details`
--

CREATE TABLE IF NOT EXISTS `candidate_details` (
`candid_id` bigint(20) NOT NULL,
  `name` char(20) NOT NULL,
  `contactno` bigint(10) NOT NULL,
  `ca_email` varchar(40) NOT NULL,
  `cur_org` varchar(30) NOT NULL,
  `exprnc` tinyint(4) DEFAULT '0',
  `cur_ctc` int(11) DEFAULT '0',
  `exp_ctc` int(11) DEFAULT '0',
  `not_period` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`candid_id`, `name`, `contactno`, `ca_email`, `cur_org`, `exprnc`, `cur_ctc`, `exp_ctc`, `not_period`) VALUES
(12, 'Prashant Verma', 9927971203, 'prashant.kv00@gmail.com', 'Fresher', 0, 0, 100000, 0),
(13, 'Mayank Bansal', 9412727202, 'mk.sk@gmail.com', 'Fresher', 0, 0, 100000, 0),
(14, 'Abhishek Singh', 9837449449, 'kapil.agrawal947@gmail.com', 'Fresher', 0, 0, 100000, 0),
(15, 'Test Candidate', 9999999999, 'test@test.com', 'Testing Co.', 2, 125000, 220000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `candid_qualif`
--

CREATE TABLE IF NOT EXISTS `candid_qualif` (
  `candid_id` bigint(20) NOT NULL,
  `qid` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candid_qualif`
--

INSERT INTO `candid_qualif` (`candid_id`, `qid`) VALUES
(12, 5),
(13, 5),
(14, 7),
(14, 5),
(15, 5);

-- --------------------------------------------------------

--
-- Table structure for table `candi_field_title`
--

CREATE TABLE IF NOT EXISTS `candi_field_title` (
`field_id` bigint(20) NOT NULL,
  `field_title` varchar(50) NOT NULL,
  `field_name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qualif`
--

CREATE TABLE IF NOT EXISTS `qualif` (
`qid` bigint(11) NOT NULL,
  `qname` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualif`
--

INSERT INTO `qualif` (`qid`, `qname`) VALUES
(5, 'B.Tech'),
(6, 'M.Tech'),
(7, 'Ph.D');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `actual_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
`user_id` int(11) NOT NULL,
  `user_name` char(40) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_pass` varchar(50) DEFAULT NULL,
  `user_right` tinyint(4) DEFAULT '-1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_right`) VALUES
(2, 'Admin', 'test@era.com', 'fcab423c2227a33f4bf84a110c77c7c6fbee6d79', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
 ADD PRIMARY KEY (`candid_id`), ADD UNIQUE KEY `ca_email` (`ca_email`);

--
-- Indexes for table `candid_qualif`
--
ALTER TABLE `candid_qualif`
 ADD KEY `candid_id` (`candid_id`), ADD KEY `qid` (`qid`);

--
-- Indexes for table `candi_field_title`
--
ALTER TABLE `candi_field_title`
 ADD PRIMARY KEY (`field_id`), ADD UNIQUE KEY `field_name` (`field_name`);

--
-- Indexes for table `qualif`
--
ALTER TABLE `qualif`
 ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
 ADD PRIMARY KEY (`actual_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_details`
--
ALTER TABLE `candidate_details`
MODIFY `candid_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `candi_field_title`
--
ALTER TABLE `candi_field_title`
MODIFY `field_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `qualif`
--
ALTER TABLE `qualif`
MODIFY `qid` bigint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `candid_qualif`
--
ALTER TABLE `candid_qualif`
ADD CONSTRAINT `candid_qualif_ibfk_1` FOREIGN KEY (`candid_id`) REFERENCES `candidate_details` (`candid_id`),
ADD CONSTRAINT `candid_qualif_ibfk_2` FOREIGN KEY (`qid`) REFERENCES `qualif` (`qid`);

--
-- Constraints for table `temp`
--
ALTER TABLE `temp`
ADD CONSTRAINT `temp_ibfk_1` FOREIGN KEY (`actual_id`) REFERENCES `user_details` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
