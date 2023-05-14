--
-- DROP DATABASE IF EXISTS competition;
-- Database: `demo` and php web application user
CREATE DATABASE competition;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON competition.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE competition;
--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `piece` varchar(255) NOT NULL,
  `duration` int(10) NOT NULL,
  `birth` date NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `piece`, `duration`, `birth`, `image`) VALUES
(1, 'Richard Clayderman', 'Beethoven Piano Sonata No. 14 Moonlight', '12', '2000-06-06', 'image/id-1'),
(2, 'Yo-Yo Ma', 'The Cello Concerto No. 1 by Joseph Haydn', '09', '2002-08-08', 'image/id-2'),
(3, 'Siqing Lu', 'The Butterfly Lovers', '16', '1998-10-10', 'image/id-3'),
(4, 'Bobbi Humphrey', 'Mozart Flute Concerto No. 1', '18', '2004-12-12', 'image/id-4');

