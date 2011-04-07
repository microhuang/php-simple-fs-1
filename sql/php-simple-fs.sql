-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2011 at 01:47 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php-simple-fs`
--

-- --------------------------------------------------------

--
-- Table structure for table `download_key`
--

CREATE TABLE IF NOT EXISTS `download_key` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `key` varchar(40) NOT NULL DEFAULT '' COMMENT '下载key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='下载key表' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
  `mime_type` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `size` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '大小',
  `file_hash` varchar(40) NOT NULL DEFAULT '' COMMENT '哈希',
  `fetch_hash` varchar(40) NOT NULL DEFAULT '',
  `full_path` varchar(255) DEFAULT NULL COMMENT '所在路径',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文件基本表' AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '代号',
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT '加密Key',
  `token` varchar(40) NOT NULL DEFAULT '' COMMENT '令牌',
  `dir_name` varchar(255) DEFAULT NULL COMMENT '指定文件夹',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='令牌基本表' AUTO_INCREMENT=2 ;
