-- MySQL dump 10.11
--
-- Host: localhost    Database: cats_cats
-- ------------------------------------------------------
-- Server version 5.0.45-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `a_id` int(11) NOT NULL auto_increment,
  `q_id` int(11) NOT NULL default '0',
  `answer` text collate latin1_general_ci NOT NULL,
  `correct` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=944 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Table structure for table `answers_incorrect`
--

DROP TABLE IF EXISTS `answers_incorrect`;
CREATE TABLE `answers_incorrect` (
  `lp_id` int(11) NOT NULL default '0',
  `q_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`lp_id`,`q_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Table structure for table `learnprogress`
--

DROP TABLE IF EXISTS `learnprogress`;
CREATE TABLE `learnprogress` (
  `lp_id` int(11) NOT NULL auto_increment COMMENT 'SchlÃ¼ssel',
  `user_id` varchar(15) collate latin1_general_ci NOT NULL default '0',
  `root` set('CA Cert Signing Authority','CAcert Class 3 Root') collate latin1_general_ci NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'Uhrzeit und Datum',
  `t_id` int(11) NOT NULL default '0' COMMENT 'Themen ID',
  `number` int(11) NOT NULL default '0' COMMENT 'Anzahl der Fragen',
  `correct` int(11) NOT NULL default '0' COMMENT 'Richtige Fragen',
  `wrong` int(11) NOT NULL default '0' COMMENT 'Anzahl der falschen Antworten',
  `percentage` decimal(5,0) default NULL,
  PRIMARY KEY  (`lp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=178 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Table structure for table `question_description`
--

DROP TABLE IF EXISTS `question_description`;
CREATE TABLE `question_description` (
  `q_id` int(11) NOT NULL default '0',
  `description` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`q_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `q_id` int(11) NOT NULL auto_increment COMMENT 'Primärschlüssel',
  `qt_id` int(11) NOT NULL default '0' COMMENT 'Fragetyp',
  `t_id` int(11) NOT NULL default '0' COMMENT 'Topic_id',
  `question` text collate latin1_general_ci NOT NULL COMMENT 'Frage',
  `active` enum('1','0') collate latin1_general_ci NOT NULL default '0',
  `description` enum('1','0') collate latin1_general_ci NOT NULL default '0',
  PRIMARY KEY  (`q_id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Fragen';

--
-- Table structure for table `questiontype`
--

DROP TABLE IF EXISTS `questiontype`;
CREATE TABLE `questiontype` (
  `qt_id` int(11) NOT NULL auto_increment COMMENT 'Fragetypenschlüssel',
  `DE` varchar(25) collate latin1_general_ci NOT NULL default '' COMMENT 'Fragetyp',
  `EN` varchar(25) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`qt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Fragetypen';

--
-- Dumping data for table `questiontype`
--

LOCK TABLES `questiontype` WRITE;
/*!40000 ALTER TABLE `questiontype` DISABLE KEYS */;
INSERT INTO `questiontype` VALUES (1,'Einfachauswahl','single selection'),(2,'Mehrfachauswahl','multiple choice'),(3,'Richtig / Falsch','true / false'),(4,'L?ckentext','fill in the blanks');
/*!40000 ALTER TABLE `questiontype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistics`
--

DROP TABLE IF EXISTS `statistics`;
CREATE TABLE `statistics` (
  `stat_id` int(11) NOT NULL auto_increment COMMENT 'PrimÃ¤rschlÃ¼ssel',
  `q_id` int(11) NOT NULL default '0' COMMENT 'Frage Id',
  `count` int(11) NOT NULL default '0' COMMENT 'ZÃ¤hlen von Antworten',
  PRIMARY KEY  (`stat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `t_id` int(11) NOT NULL auto_increment COMMENT 'Primärschlüssel',
  `topic` varchar(50) collate latin1_general_ci NOT NULL default '' COMMENT 'Thema',
  `active` tinyint(1) NOT NULL default '0',
  `numOfQu` tinyint(4) NOT NULL default '0',
  `percentage` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`t_id`),
  UNIQUE KEY `topic` (`topic`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Themen';

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` varchar(10) collate latin1_general_ci NOT NULL default '0',
  `CN_name` varchar(100) collate latin1_general_ci NOT NULL default '',
  `lang` char(2) collate latin1_general_ci NOT NULL default '',
  `admin` enum('1','0') collate latin1_general_ci NOT NULL default '1',
  `email` varchar(100) collate latin1_general_ci NOT NULL default '',
  `sendCert` set('no','email','post') collate latin1_general_ci NOT NULL default 'no',
  `root` set('CA Cert Signing Authority','CAcert Class 3 Root') collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`user_id`,`root`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `user_id` varchar(10) collate latin1_general_ci NOT NULL default '0',
  `root` set('CA Cert Signing Authority','CAcert Class 3 Root') collate latin1_general_ci NOT NULL default '',
  `firstname` varchar(25) collate latin1_general_ci NOT NULL default '',
  `lastname` varchar(25) collate latin1_general_ci NOT NULL default '',
  `street` varchar(50) collate latin1_general_ci NOT NULL default '',
  `housenumber` varchar(5) collate latin1_general_ci NOT NULL default '',
  `zipcode` varchar(10) collate latin1_general_ci NOT NULL default '',
  `city` varchar(30) collate latin1_general_ci NOT NULL default '',
  `state` varchar(50) collate latin1_general_ci NOT NULL default '',
  `country` varchar(50) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`user_id`,`root`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-01-04 23:53:19
