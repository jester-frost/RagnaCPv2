-- phpMyAdmin SQL Dump
-- version 4.4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 15/09/2015 às 09:40
-- Versão do servidor: 5.6.19-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `ragnacrashersdb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `vote_point`
--

CREATE TABLE IF NOT EXISTS `vote_point` (
  `account_id` int(11) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `last_vote1` int(11) NOT NULL DEFAULT '0',
  `last_vote2` int(11) NOT NULL DEFAULT '0',
  `last_vote3` int(11) NOT NULL DEFAULT '0',
  `date` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `vote_point`
--
ALTER TABLE `vote_point`
  ADD PRIMARY KEY (`account_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
