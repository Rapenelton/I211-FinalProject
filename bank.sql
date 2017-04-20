-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: mysql.iu.edu:3704
-- Generation Time: Mar 18, 2017 at 12:40 PM
-- Server version: 5.0.83
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bank`
--

DROP DATABASE `bank`;
CREATE DATABASE `bank` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bank`;

-- --------------------------------------------------------

--
-- Table structure for table `users and accounts`
--
--

CREATE TABLE IF NOT EXISTS `users` (
  `client_id` smallint(6) NOT NULL auto_increment,
  `last_name` varchar(40) default NULL,
  `first_name` varchar(40) default NULL,
  `birth_date` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `SSN` smallint(10) default NULL,
  `role` varchar(20) NOT NULL,
   PRIMARY KEY (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `accounts` (
    `id` smallint(6) NOT NULL auto_increment,
    `client_id` smallint(6) NOT NULL,
    `account_number` varchar(20) NOT NULL UNIQUE,
    `balance` varchar(40) NOT NULL,
    `routing_number` varchar(40) NOT NULL,
    `account_type` smallint(6) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`client_id`) REFERENCES users(`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `users` and table `accounts`
--

INSERT INTO `users` (`last_name`, `first_name`, `birth_date`, `email`, `SSN`, `role`) VALUES
('Penelton', 'Ryan', '03/12/1992', 'rpenelton@example.com', '123456789', '1'),
('Kozakli', 'Hazal', '05/15/1992', 'hkozakli@example.com', '987654321', '2'),
('Solo', 'Jaina', '07/13/4059', 'jsolo@example.com', '563491278', '2');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `accounts` (`client_id`, `account_number`, `balance`, `routing_number`, `account_type`) VALUES
('88', 22, 22000, 43566, 1),
('89', 24, 24000, 95834, 1),
('90', 26, 26000, 48473, 2);
