-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 06 月 11 日 07:58
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `find`
--

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `category` tinyint(1) NOT NULL,
  `place` varchar(80) NOT NULL,
  `time` date NOT NULL,
  `link_man` char(50) NOT NULL,
  `link_phone` char(20) DEFAULT NULL,
  `link_email` char(40) DEFAULT NULL,
  `link_qq` char(20) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `post_time` datetime NOT NULL,
  `author` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `tname` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`id`, `tid`, `tname`) VALUES
(1, 0, '书籍资料'),
(2, 1, '衣服饰品'),
(3, 2, '交通工具'),
(4, 3, '随身物品'),
(5, 4, '电子数码'),
(6, 5, '卡类证件'),
(7, 6, '其他物品');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(16) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `registerTime` datetime NOT NULL,
  `ip` char(32) NOT NULL,
  `key` char(32) NOT NULL,
  `forgot_key` char(32) NOT NULL DEFAULT '0',
  `forgot_key_time` int(10) NOT NULL,
  `key_time` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `registerTime`, `ip`, `key`, `forgot_key`, `forgot_key_time`, `key_time`, `status`) VALUES
(35, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'r.ming@qq.com', '2012-01-19 22:23:56', '127.0.0.1', '0', '0', 0, 1327125907, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
