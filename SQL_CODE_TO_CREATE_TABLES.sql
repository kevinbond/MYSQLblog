-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2012 at 05:44 PM
-- Server version: 5.5.21
-- PHP Version: 5.2.17
--echo "hello"

CREATE DATABASE `tropo`;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tropo_tropo`
--

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE `calls` (
  `callId` VARCHAR(255) CHARACTER SET utf32 COLLATE utf8_unicode_ci NOT NULL,
  `number` VARCHAR(255) CHARACTER SET utf32 COLLATE utf8_unicode_ci NOT NULL,
  `channel` VARCHAR(255) CHARACTER SET utf32 COLLATE utf8_unicode_ci NOT NULL,
  `network` VARCHAR(255) CHARACTER SET utf32 COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `callId` (`callId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recordings`
--

CREATE TABLE IF NOT EXISTS `recordings` (
  `callId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recording_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `callId` (`callId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
