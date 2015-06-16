-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2015 at 07:41 PM
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
  `name` char(30) NOT NULL,
  `contactno` bigint(10) NOT NULL,
  `ca_email` varchar(40) NOT NULL,
  `cur_org` varchar(30) NOT NULL,
  `exprnc` tinyint(4) DEFAULT '0',
  `cur_ctc` int(11) DEFAULT '0',
  `exp_ctc` int(11) DEFAULT '0',
  `not_period` int(11) NOT NULL DEFAULT '0',
  `not_period_dm` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` bigint(100) NOT NULL,
  `categ` varchar(30) NOT NULL,
  `resext` char(7) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`candid_id`, `name`, `contactno`, `ca_email`, `cur_org`, `exprnc`, `cur_ctc`, `exp_ctc`, `not_period`, `not_period_dm`, `added_by`, `categ`, `resext`) VALUES
(12, 'Prashant Verma', 9927971203, 'prashant.kv00@gmail.com', 'Fresher', 0, 0, 100000, 0, 0, 2, 'Embeeded Systems', ''),
(13, 'Mayank Bansal', 9412727202, 'mk.sk@gmail.com', 'Fresher', 0, 0, 100000, 0, 0, 2, 'Embeeded Systems', ''),
(14, 'Abhishek Singh', 9837449449, 'kapil.agrawal947@gmail.com', 'Erasmith Technologies', 1, 125000, 100000, 12, 0, 2, 'Embeeded Systems', ''),
(15, 'lalal', 9999999998, 'test@test.com', 'Testing Co.', 2, 125000, 220000, 1, 0, 2, 'Embeeded Systems', ''),
(19, 'Jayati Krishna Goswami', 8171806228, 'jayati.krishna@gmail.com', 'VVDN Technologies', 0, 9000, 15000, 1, 0, 2, 'Embeeded Systems', ''),
(23, 'Karan Banga', 9045522021, 'karanbanga21@gmail.com', 'Hewlett Packard', 1, 125000, 350000, 1, 1, 3, 'Web Development', ''),
(24, 'Baldev Patwari', 8756159999, 'baldevp@gmail.com', 'OMitra', 0, 125000, 15000, 2, 1, 2, '', ''),
(25, 'Satish Kaushik', 9837449449, 'abcd@abc.com', 'Erasmith Technologies', 0, 18562, 32486, 5, 1, 2, 'IT', ''),
(26, 'Who', 9999999999, 'abc@abcd.com', 'Erasmith Technologies', 5, 250000, 500000, 19, 0, 2, '', ''),
(27, 'Narendra', 101010101, 'nm@mygov.in', 'Indian Government', 0, 15000, 15000, 0, 0, 2, '', ''),
(28, 'Narendra', 101010101, 'nmdi@mygov.in', 'Indian Government', 0, 158000, 15000, 0, 0, 2, '', 'pdf'),
(29, 'Sanjeev Agarwal', 9810604597, 'sanjeev@erasmith.com', 'Erasmith Technologies Pvt Ltd', 25, 30, 40, 60, 0, 4, '', ''),
(30, 'Sanjeev Agarwal', 9810604597, 'sanjeevuk@yahoo.co.uk', 'Erasmith Technologies Pvt Ltd', 25, 30, 40, 60, 0, 4, 'Delivery Manager', '');

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
(15, 5),
(19, 5),
(23, 5),
(23, 6),
(24, 5),
(25, 8),
(25, 5),
(25, 6),
(26, 5),
(26, 6),
(26, 7),
(26, 8),
(27, 5),
(28, 9),
(30, 10),
(30, 5);

-- --------------------------------------------------------

--
-- Table structure for table `candi_field_title`
--

CREATE TABLE IF NOT EXISTS `candi_field_title` (
`field_id` bigint(20) NOT NULL,
  `field_title` varchar(50) NOT NULL,
  `field_name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candi_field_title`
--

INSERT INTO `candi_field_title` (`field_id`, `field_title`, `field_name`) VALUES
(1, 'Category', 'categ');

-- --------------------------------------------------------

--
-- Table structure for table `client_details`
--

CREATE TABLE IF NOT EXISTS `client_details` (
`client_id` bigint(30) NOT NULL,
  `client_name` char(40) NOT NULL,
  `client_addr` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_details`
--

INSERT INTO `client_details` (`client_id`, `client_name`, `client_addr`) VALUES
(8, 'Erasmith Technologies Pvt Ltd', 'New Delhi, Delhi-110077');

-- --------------------------------------------------------

--
-- Table structure for table `contact_person_details`
--

CREATE TABLE IF NOT EXISTS `contact_person_details` (
`cp_id` bigint(100) NOT NULL,
  `cp_name` char(40) NOT NULL,
  `cp_phnno` bigint(10) NOT NULL,
  `cp_email` varchar(50) NOT NULL,
  `client_id` bigint(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_person_details`
--

INSERT INTO `contact_person_details` (`cp_id`, `cp_name`, `cp_phnno`, `cp_email`, `client_id`) VALUES
(2, 'Kapil Agrawal', 9837449449, 'kapil.agrawal947@gmail.com', 8),
(3, 'Abhishek Singh', 9761250893, 'yabhis@gmail.com', 8);

-- --------------------------------------------------------

--
-- Table structure for table `qualif`
--

CREATE TABLE IF NOT EXISTS `qualif` (
`qid` bigint(11) NOT NULL,
  `qname` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualif`
--

INSERT INTO `qualif` (`qid`, `qname`) VALUES
(5, 'B.Tech'),
(6, 'M.Tech'),
(7, 'Ph.D'),
(8, 'B.Arch'),
(9, 'B.A.'),
(10, 'Mba');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `actual_id` bigint(100) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
`user_id` bigint(100) NOT NULL,
  `user_name` char(40) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_pass` varchar(50) DEFAULT NULL,
  `user_right` tinyint(4) DEFAULT '-1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `del_on` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_right`, `active`, `del_on`) VALUES
(2, 'Admin', 'test@era.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 0, 1, '0000-00-00 00:00:00'),
(3, 'Kapi Agrawal', 'kapil.agrawal947@gmail.com', '281f09155c96bf1277ed70fab0b043322f873f41', 0, 0, '2015-06-15 13:50:44'),
(4, 'Surabhi Singh', 'surabhi.singh@erasmith.com', 'c9833ed8fe055d885f3715cd0f9d74fc4bc03a7d', 0, 1, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
 ADD PRIMARY KEY (`candid_id`), ADD UNIQUE KEY `ca_email` (`ca_email`), ADD KEY `added_by` (`added_by`);

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
-- Indexes for table `client_details`
--
ALTER TABLE `client_details`
 ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `contact_person_details`
--
ALTER TABLE `contact_person_details`
 ADD PRIMARY KEY (`cp_id`), ADD UNIQUE KEY `cp_email` (`cp_email`), ADD KEY `client_id` (`client_id`);

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
MODIFY `candid_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `candi_field_title`
--
ALTER TABLE `candi_field_title`
MODIFY `field_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `client_details`
--
ALTER TABLE `client_details`
MODIFY `client_id` bigint(30) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `contact_person_details`
--
ALTER TABLE `contact_person_details`
MODIFY `cp_id` bigint(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `qualif`
--
ALTER TABLE `qualif`
MODIFY `qid` bigint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
MODIFY `user_id` bigint(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate_details`
--
ALTER TABLE `candidate_details`
ADD CONSTRAINT `candidate_details_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `user_details` (`user_id`);

--
-- Constraints for table `candid_qualif`
--
ALTER TABLE `candid_qualif`
ADD CONSTRAINT `candid_qualif_ibfk_1` FOREIGN KEY (`candid_id`) REFERENCES `candidate_details` (`candid_id`),
ADD CONSTRAINT `candid_qualif_ibfk_2` FOREIGN KEY (`qid`) REFERENCES `qualif` (`qid`);

--
-- Constraints for table `contact_person_details`
--
ALTER TABLE `contact_person_details`
ADD CONSTRAINT `contact_person_details_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_details` (`client_id`);

--
-- Constraints for table `temp`
--
ALTER TABLE `temp`
ADD CONSTRAINT `temp_ibfk_1` FOREIGN KEY (`actual_id`) REFERENCES `user_details` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
