SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- BASE `HoneyPot` --
-- --------------------------------------------------------

CREATE DATABASE HoneyPot;
use HoneyPot;


-- TABLE `User` --
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL UNIQUE,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- TABLE `Account` --
CREATE TABLE IF NOT EXISTS `Account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,

  PRIMARY KEY (`id`),
  CONSTRAINT `FK_account_user` FOREIGN KEY (`userId`) REFERENCES User(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- TABLE `Deposit` --
CREATE TABLE IF NOT EXISTS `Deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountId` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `date` date NOT NULL DEFAULT "0000-00-00",
  
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_deposit_account` FOREIGN KEY (`accountId`) REFERENCES Account(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- TABLE `Objective` --
CREATE TABLE IF NOT EXISTS `Objective` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `goal` decimal(6,2) NOT NULL,
  `validationDate` date NOT NULL DEFAULT "0000-00-00",
  
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_objective_user` FOREIGN KEY (`userId`) REFERENCES User(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- TABLE `Allocate` --
CREATE TABLE IF NOT EXISTS `Allocate` (
  `accountId` int(11) NOT NULL,
  `objectiveId` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  PRIMARY KEY (`accountId`, `objectiveId`),

  CONSTRAINT `FK_allocate_account` FOREIGN KEY (`accountId`) REFERENCES `Account` (`id`),
  CONSTRAINT `FK_allocate_objective` FOREIGN KEY (`objectiveId`) REFERENCES `Objective` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;