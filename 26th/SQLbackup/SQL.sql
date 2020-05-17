-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- ホスト: 127.0.0.1:3306
-- 生成日時: 2017 年 10 月 31 日 07:07
-- サーバのバージョン: 5.0.96
-- PHP のバージョン: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `kamakuralive_sessions`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `doctor_tbls`
--

CREATE TABLE IF NOT EXISTS `doctor_tbls` (
  `id` int(11) NOT NULL auto_increment,
  `english_sirname` varchar(100) NOT NULL default '',
  `english_firstname` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `phone` varchar(100) NOT NULL default '',
  `is_male` tinyint(1) NOT NULL default '1',
  `kana_sirname` varchar(100) NOT NULL default '',
  `kana_firstname` varchar(100) NOT NULL default '',
  `kanji_sirname` varchar(100) NOT NULL default '',
  `kanji_firstname` varchar(100) NOT NULL default '',
  `hp_name_english` varchar(100) NOT NULL default '',
  `nation` varchar(50) NOT NULL default '',
  `hp_name_japanese` varchar(100) NOT NULL default '',
  `hp_place_english` varchar(100) NOT NULL default '',
  `hp_place_japanese` varchar(100) NOT NULL default '',
  `member_kind` tinyint(2) NOT NULL default '0',
  `sponsor` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `changed` datetime NOT NULL default '0000-00-00 00:00:00',
  `on2016` tinyint(1) default '1',
  `on2017` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=207 ;



--
-- テーブルの構造 `role_tbls`
--

CREATE TABLE IF NOT EXISTS `role_tbls` (
  `id` int(11) NOT NULL auto_increment,
  `dr_tbl_id` int(11) NOT NULL default '0',
  `role_kind` tinyint(2) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `sessionNo` int(11) NOT NULL default '0',
  `class` varchar(10) default NULL,
  `year` int(4) default NULL,
  `session_tbl_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_DR` (`dr_tbl_id`,`role_kind`,`sessionNo`,`class`,`year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=601 ;

-

-- --------------------------------------------------------

--
-- テーブルの構造 `session_tbls`
--

CREATE TABLE IF NOT EXISTS `session_tbls` (
  `id` int(11) NOT NULL auto_increment,
  `sessionNo` tinyint(2) NOT NULL default '0',
  `begin` time NOT NULL default '00:00:00',
  `duration` int(5) NOT NULL default '0',
  `sessionTitle` varchar(300) NOT NULL default '',
  `cosponsor` varchar(200) NOT NULL default '',
  `lectureTitle` varchar(300) NOT NULL default '',
  `venue` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `changed` datetime NOT NULL default '0000-00-00 00:00:00',
  `class` varchar(10) default NULL,
  `year` int(4) default '0',
  `day` date NOT NULL default '2017-12-09',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=242 ;

--
-- テーブルのデータのダンプ `session_tbls`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
