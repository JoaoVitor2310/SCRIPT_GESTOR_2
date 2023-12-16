-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Jul-2022 às 03:51
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestor`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `options_system`
--

CREATE TABLE `options_system` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `options_system`
--

INSERT INTO `options_system` (`id`, `name`, `value`) VALUES
(4, 'dominio', 'gestormaster.top'),
(6, 'api_zap_address', 'http://62.72.11.236:3333'),
(7, 'color_background_admin', '#0d0c0c'),
(8, 'color_menu_admin', '#9c39ff'),
(9, 'mod_ligh', '1'),
(10, 'client_id_imgur', '303beb55fb36c03');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `options_system`
--
ALTER TABLE `options_system`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `options_system`
--
ALTER TABLE `options_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
