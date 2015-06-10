-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2015 at 11:04 AM
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
  `contactno` int(10) NOT NULL,
  `ca_email` varchar(40) NOT NULL,
  `cur_org` varchar(30) NOT NULL,
  `exprnc` tinyint(4) DEFAULT '0',
  `cur_ctc` int(11) DEFAULT '0',
  `exp_ctc` int(11) DEFAULT '0',
  `not_period` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qualif`
--

CREATE TABLE IF NOT EXISTS `qualif` (
`qid` int(11) NOT NULL,
  `qname` varchar(10) NOT NULL,
  `candid_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
(2, 'Admin', 'test@era.com', '606af0892aa85ced2e877e30cd30fe10d5533997', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
 ADD PRIMARY KEY (`candid_id`), ADD UNIQUE KEY `ca_email` (`ca_email`);

--
-- Indexes for table `qualif`
--
ALTER TABLE `qualif`
 ADD PRIMARY KEY (`qid`), ADD KEY `candid_id` (`candid_id`);

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
MODIFY `candid_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `qualif`
--
ALTER TABLE `qualif`
MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `qualif`
--
ALTER TABLE `qualif`
ADD CONSTRAINT `qualif_ibfk_1` FOREIGN KEY (`candid_id`) REFERENCES `candidate_details` (`candid_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
