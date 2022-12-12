DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cat` int(255) DEFAULT NULL,
  `pay` double NOT NULL,
  `time` int(255) NOT NULL,
  `location` text NOT NULL,
  `description` text NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `chat`;

CREATE TABLE `chat` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `dst` int(255) NOT NULL,
  `src` text NOT NULL,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `notif`;

CREATE TABLE `notif` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL,
  `icon` enum('HIRED','APPLIED') DEFAULT NULL,
  `text` text NOT NULL,
  `link` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ratings`;

CREATE TABLE `ratings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `rated` int(255) NOT NULL,
  `rater` int(255) NOT NULL,
  `job` int(255) NOT NULL,
  `stars` int(255) NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `responses`;

CREATE TABLE `responses` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `adid` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `comment` text,
  `matched` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` enum('EMPLOYEE','EMPLOYER','ADMIN') NOT NULL DEFAULT 'EMPLOYEE',
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `address` text,
  `bio` text,
  `notify` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `session` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
