-- Phone Removal Refactoring - 0.2 Version.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

USE `map_places_db`;

DELETE FROM `registrations`;
DELETE FROM `contents`;
DELETE FROM `markers`;
DELETE FROM `types`;

INSERT INTO `types` (`id`, `name`, `image`) VALUES (1, 'Debian', 'debian.png');

INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`, `active`) VALUES (1, 'Efstathios Chatzikyriakidis', 'Hellas', 42.032974, 14.062500, 1, 1);

INSERT INTO `contents` (`id`, `email`, `url`, `text`, `marker`) VALUES (1, 'contact@efxa.org', 'efxa.org', 'To be or not to be.', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
