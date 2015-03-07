-- Initial Schema - 0.1 Version.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP DATABASE IF EXISTS `map_places_db`;
CREATE DATABASE `map_places_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `map_places_db`;

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `id`    int           UNSIGNED AUTO_INCREMENT NOT NULL,
  `name`  varchar (256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar (256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

DROP TABLE IF EXISTS `markers`;
CREATE TABLE IF NOT EXISTS `markers` (
  `id`      int            UNSIGNED AUTO_INCREMENT NOT NULL,
  `name`    varchar (256)  COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar (256)  COLLATE utf8_unicode_ci NOT NULL,
  `lat`     decimal (10,6) NOT NULL,
  `lng`     decimal (10,6) NOT NULL,
  `type`    int            UNSIGNED NOT NULL,
  `active`  tinyint (1)    NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`type`) REFERENCES `types` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

DROP TABLE IF EXISTS `contents`;
CREATE TABLE IF NOT EXISTS `contents` (
  `id`     int           UNSIGNED AUTO_INCREMENT NOT NULL,
  `email`  varchar (256) COLLATE utf8_unicode_ci NOT NULL,
  `url`    varchar (256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone`  varchar (256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text`   longtext      COLLATE utf8_unicode_ci DEFAULT NULL,
  `marker` int           UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`marker`) REFERENCES `markers` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

DROP TABLE IF EXISTS `registrations`;
CREATE TABLE IF NOT EXISTS `registrations` (
  `id`     int           UNSIGNED AUTO_INCREMENT NOT NULL,
  `skey`   varchar (256) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint (1)   NOT NULL DEFAULT '0',
  `date`   date          NOT NULL,
  `marker` int           UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`marker`) REFERENCES `markers` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
