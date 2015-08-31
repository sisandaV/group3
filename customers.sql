-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2015 at 11:08 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `customers`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `email` varchar(30) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `body` text NOT NULL,
  `payment` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`email`, `subject`, `body`, `payment`) VALUES
('franckykalombo@yahoo.com.au', 'Thanks', 'ghjhk', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'jujuklkklk,', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'well done', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'well done', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'fhgmn,mn, ', ''),
('francky@gmail.com', 'COGRAT', 'THANKS', ''),
('franckykalombo@yahoo.com.au', 'ffg', 'gjhjhk', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'well done', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'congratulations', ''),
('franckykalombo@yahoo.com.au', 'Thanks', 'hghghjh', ''),
('franckykalombo@yahoo.com.au', 'thanks', 'GFHGJH', ''),
('franckykalombo@yahoo.com.au', 'thanks', 'ghg', ''),
('franckykalombo@yahoo.com.au', 'thanks', 'wee', ''),
('fghf@yahoo.com', 'thanx', 'eedfgfhi', 'credit');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
`usr_id` int(11) NOT NULL,
  `usr_name` varchar(100) NOT NULL,
  `usr_password` varchar(100) NOT NULL,
  `usr_email` varchar(100) NOT NULL,
  `usrl_id` int(11) NOT NULL,
  `lng_id` int(11) NOT NULL,
  `usr_active` varchar(100) NOT NULL,
  `usr_question` varchar(100) NOT NULL,
  `usr_answer` varchar(100) NOT NULL,
  `usr_pictures` varchar(100) NOT NULL,
  `usr_password_salt` varchar(100) NOT NULL,
  `usr_registration_date` date NOT NULL,
  `usr_registration_token` varchar(100) NOT NULL,
  `usr_email_confirmed` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`usr_id`, `usr_name`, `usr_password`, `usr_email`, `usrl_id`, `lng_id`, `usr_active`, `usr_question`, `usr_answer`, `usr_pictures`, `usr_password_salt`, `usr_registration_date`, `usr_registration_token`, `usr_email_confirmed`) VALUES
(1, 'jkkjlj', '53eaeb8cc681577d16b4d1088463e605', 'andilemfikii@gmail.com', 2, 1, '0', '', '', '', 'lH\\cFtqb\\nzaC2RHxL_*1Y|KI)RaUtySuL<4<j1I(?bG*&JrdI', '2015-08-28', 'b4045cdaa0d3a2de08dd37bc6fe72b88', '0'),
(2, 'ffjhj', '473470b6ae5cf042211ed62608174dd6', 'jcy@gmail.com', 2, 1, '0', '', '', '', ']VnY5`:g1.S87?)3\\&s2''aE<h&W-KQxk@uGq-TMI(?)+sTg|g(', '2015-08-28', 'fe4d7f5b2415584b2d68c0a9b696d968', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
 ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
