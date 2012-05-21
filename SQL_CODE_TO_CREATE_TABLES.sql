CREATE DATABASE `Tropo`;

USE `Tropo`;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `calls` (
  `callId` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `channel` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `network` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `callId` (`callId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `recordings` (
  `callId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recording_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `callId` (`callId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
