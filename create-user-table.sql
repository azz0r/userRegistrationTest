CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forename` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `telephone_number` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;