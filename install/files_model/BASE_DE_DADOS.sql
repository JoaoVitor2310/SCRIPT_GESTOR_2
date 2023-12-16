-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jul-2022 às 20:12
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
-- Estrutura da tabela `access_mp`
--

CREATE TABLE `access_mp` (
  `id` int(11) NOT NULL,
  `af` int(11) DEFAULT NULL,
  `acess_token_mp` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_acess_token_mp` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente_mp` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public_key_mp` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_in_mp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atualizacoes`
--

CREATE TABLE `atualizacoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos_painel`
--

CREATE TABLE `avisos_painel` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auto_delete` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias_cliente`
--

CREATE TABLE `categorias_cliente` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `keychat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vencimento` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_plano` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recebe_zap` int(11) NOT NULL,
  `senha` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_painel` int(11) DEFAULT NULL,
  `categoria` int(11) NOT NULL DEFAULT 0,
  `identificador_externo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indicado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `totime` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buy` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cod_promo`
--

CREATE TABLE `cod_promo` (
  `id` int(11) NOT NULL,
  `codigo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validade` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desconto` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comprovantes_fat`
--

CREATE TABLE `comprovantes_fat` (
  `id` int(11) NOT NULL,
  `id_fat` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comprovantes_fat_cli`
--

CREATE TABLE `comprovantes_fat_cli` (
  `id` int(11) NOT NULL,
  `id_fat` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_plano` int(11) NOT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config_cores_plano`
--

CREATE TABLE `config_cores_plano` (
  `id` int(11) NOT NULL,
  `id_plano` int(11) NOT NULL,
  `color1` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color2` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_ticket` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `border_ticket` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_button` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_button` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_final` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `config_cores_plano`
--

INSERT INTO `config_cores_plano` (`id`, `id_plano`, `color1`, `color2`, `color_ticket`, `border_ticket`, `color_button`, `text_button`, `msg_final`) VALUES
(1, 6, '#000', '#000', '#000', '#fff', '#000', 'Comprar', 'Já recebemos seus dados, agora entre em contato conosco através do link abaixo:\r\nhttp://gestormaster.top/gmaster/w/TSh');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conf_cli_area`
--

CREATE TABLE `conf_cli_area` (
  `id` int(11) NOT NULL,
  `nome_area` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_area` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_area` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `situ_area` int(11) NOT NULL,
  `text_suporte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `indicacao` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `planos_amostra` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato_gestorlite`
--

CREATE TABLE `contato_gestorlite` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assunto` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `convidade_acesso`
--

CREATE TABLE `convidade_acesso` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `creditos_rev`
--

CREATE TABLE `creditos_rev` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_bank_user`
--

CREATE TABLE `dados_bank_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `situ` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_mp_user`
--

CREATE TABLE `dados_mp_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `client_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_secret` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_paghiper`
--

CREATE TABLE `dados_paghiper` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `apikey` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `situ` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_painel`
--

CREATE TABLE `dados_painel` (
  `id` int(11) NOT NULL,
  `chave` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cms` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sem nome',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `limit_testes` int(255) NOT NULL,
  `situ_teste` int(11) NOT NULL,
  `template_zap` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_mail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receber_aviso` int(11) NOT NULL DEFAULT 0,
  `api` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'xtream-ui',
  `cloud` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_picpay_user`
--

CREATE TABLE `dados_picpay_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `situ` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `delivery_aut`
--

CREATE TABLE `delivery_aut` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plano_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_delivery` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `situ` int(11) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disparos_zap`
--

CREATE TABLE `disparos_zap` (
  `id` int(11) NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas_clientes`
--

CREATE TABLE `faturas_clientes` (
  `id` int(11) NOT NULL,
  `id_plano` int(11) NOT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `ref` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprovante` varchar(800) COLLATE utf8mb4_unicode_ci DEFAULT 'not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas_user`
--

CREATE TABLE `faturas_user` (
  `id` int(11) NOT NULL,
  `ref` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_plano` int(11) NOT NULL,
  `forma` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprovante` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'plano',
  `moeda` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BRL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fila_cloud`
--

CREATE TABLE `fila_cloud` (
  `id` int(11) NOT NULL,
  `id_panel` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fila_zap`
--

CREATE TABLE `fila_zap` (
  `id` int(11) NOT NULL,
  `device_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `destino` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `api` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rapiwha',
  `codigo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `tipo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `importante` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro`
--

CREATE TABLE `financeiro` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro_gestor`
--

CREATE TABLE `financeiro_gestor` (
  `id` int(11) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1= entrada / 2 = saida',
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_beta`
--

CREATE TABLE `grupo_beta` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historic_teste`
--

CREATE TABLE `historic_teste` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Xtream'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `indicacoes_clientes`
--

CREATE TABLE `indicacoes_clientes` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `qtd` int(11) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lasted_conversion`
--

CREATE TABLE `lasted_conversion` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produto` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `linkzap`
--

CREATE TABLE `linkzap` (
  `id` int(11) NOT NULL,
  `numero` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliques` int(11) NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atividade` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lsita_negra_avisos`
--

CREATE TABLE `lsita_negra_avisos` (
  `id` int(11) NOT NULL,
  `whatsapp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `moeda`
--

CREATE TABLE `moeda` (
  `id` int(11) NOT NULL,
  `simbolo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `moeda`
--

INSERT INTO `moeda` (`id`, `simbolo`, `nome`) VALUES
(1, 'R$', 'BRL'),
(2, '€', 'EUR');

-- --------------------------------------------------------

--
-- Estrutura da tabela `msg_not_pareado`
--

CREATE TABLE `msg_not_pareado` (
  `id` int(11) NOT NULL,
  `text` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `msg_not_pareado`
--

INSERT INTO `msg_not_pareado` (`id`, `text`) VALUES
(1, 'O cliente *{primeiro_nome_cli}* não recebeu a cobrança automática.\r\n\r\n\r\nSeu whatsapp não está pareado com nosso sistema.\r\nAcesse: https://gestormaster.top/painel e faça o pareamento.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notification_af`
--

CREATE TABLE `notification_af` (
  `id` int(11) NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `af` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `num_cobrancas`
--

CREATE TABLE `num_cobrancas` (
  `id` int(11) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `num_cobrancas`
--

INSERT INTO `num_cobrancas` (`id`, `num`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `options_system`
--

CREATE TABLE `options_system` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_graph_user`
--

CREATE TABLE `order_graph_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `order_g` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `planos`
--

CREATE TABLE `planos` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dias` int(11) NOT NULL,
  `template_zap` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_link` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_banner_hash` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `plano_user_gestor`
--

CREATE TABLE `plano_user_gestor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num` int(11) NOT NULL,
  `limit_cli` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `popular` int(11) NOT NULL,
  `financeiro` int(11) NOT NULL,
  `financeiro_avan` int(11) NOT NULL,
  `faturas_cliente` int(11) NOT NULL,
  `mini_area_cliente` int(11) NOT NULL,
  `gateways` int(11) NOT NULL,
  `limit_teste` int(11) NOT NULL,
  `limit_link_zap` int(11) NOT NULL,
  `link_pay` int(11) NOT NULL,
  `creditos` int(11) NOT NULL,
  `deliverys` int(11) NOT NULL DEFAULT 0,
  `chatbot` int(11) NOT NULL DEFAULT 0,
  `categorias_cliente` int(11) NOT NULL DEFAULT 3,
  `notify_page` int(11) NOT NULL DEFAULT 0,
  `edite_templates` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `plano_user_gestor`
--

INSERT INTO `plano_user_gestor` (`id`, `nome`, `num`, `limit_cli`, `text`, `valor`, `popular`, `financeiro`, `financeiro_avan`, `faturas_cliente`, `mini_area_cliente`, `gateways`, `limit_teste`, `limit_link_zap`, `link_pay`, `creditos`, `deliverys`, `chatbot`, `categorias_cliente`, `notify_page`, `edite_templates`) VALUES
(5, 'Amador', 2, 50, '<i class=\"fa fa-check text-success\" ></i> 50 clientes <br />\r\n<i class=\"fa fa-check text-success\" ></i> WhatsAPI ilimitado<br />\r\n<i class=\"fa fa-check text-success\" ></i> Envio de Email<br />\r\n<i class=\"fa fa-check text-success\" ></i> Emite cobranças<br />\r\n<i class=\"fa fa-check text-success\" ></i> 1 Monitoramento Link Whatsapp<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Link de pagamento<br />\r\n<i class=\"fa fa-check text-success\" ></i> Financeiro<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Financeiro Avançado<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Faturas de clientes<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Área de cliente<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Exportar Dados Financeiro<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Integrado a Mercado Pago<br />\r\n<i class=\"fa fa-check text-success\" ></i> API Whatsapp própria<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Suporte Remoto<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Tráfego para seu site<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Criação de Banners<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Chat Bot<br />\r\n<i class=\"fa fa-check text-success\" ></i> Envio Produtos Digitais<br />\r\n<i class=\"fa fa-close text-danger\" ></i> 5 dias grátis<br />\r\n', '0,00', 0, 1, 0, 0, 0, 0, 50, 1, 0, 1, 0, 0, 2, 0, 0),
(6, 'Profissional', 3, 115, '<i class=\"fa fa-check text-success\" ></i> 115 Clientes<br />\r\n<i class=\"fa fa-check text-success\" ></i> WhatsAPI ilimitado<br />\r\n<i class=\"fa fa-check text-success\" ></i> Envio de Email<br />\r\n<i class=\"fa fa-check text-success\" ></i> Emite cobranças<br />\r\n<i class=\"fa fa-check text-success\" ></i> 5 Monitoramento Link Whatsapp<br />\r\n<i class=\"fa fa-check text-success\" ></i> Link de pagamento<br />\r\n<i class=\"fa fa-check text-success\" ></i> Financeiro<br />\r\n<i class=\"fa fa-check text-success\" ></i> Financeiro Avançado<br />\r\n<i class=\"fa fa-check text-success\" ></i> Faturas de clientes<br />\r\n<i class=\"fa fa-check text-success\" ></i> Área de cliente<br />\r\n<i class=\"fa fa-check text-success\" ></i> Exportar Dados Financeiro<br />\r\n<i class=\"fa fa-check text-success\" ></i> Integrado a Mercado Pago<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Suporte Remoto<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Tráfego para seu site<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Criação de Banners<br />\r\n<i class=\"fa fa-close text-danger\" ></i> Chat Bot<br />\r\n<i class=\"fa fa-check text-success\" ></i> Envio Produtos Digitais<br />\r\n<i class=\"fa fa-check text-success\" ></i> 5 dias grátis<br />', '0,00', 0, 1, 1, 1, 1, 1, 100, 5, 1, 1, 2, 0, 4, 0, 0),
(7, 'Patrão', 4, 1000000, '<i class=\"fa fa-check text-success\" ></i> Clientes ilimitados<br />\r\n<i class=\"fa fa-check text-success\" ></i> WhatsAPI ilimitado<br />\r\n<i class=\"fa fa-check text-success\" ></i> Envio de Email<br />\r\n<i class=\"fa fa-check text-success\" ></i> Emite cobranças<br />\r\n<i class=\"fa fa-check text-success\" ></i> 10 Monitoramento Link Whatsapp<br />\r\n<i class=\"fa fa-check text-success\" ></i> Link de pagamento<br />\r\n<i class=\"fa fa-check text-success\" ></i> Financeiro<br />\r\n<i class=\"fa fa-check text-success\" ></i> Financeiro Avançado<br />\r\n<i class=\"fa fa-check text-success\" ></i> Faturas de clientes<br />\r\n<i class=\"fa fa-check text-success\" ></i> Área de cliente<br />\r\n<i class=\"fa fa-check text-success\" ></i> Exportar Dados Financeiro<br />\r\n<i class=\"fa fa-check text-success\" ></i> Integrado a Mercado Pago<br />\r\n<i class=\"fa fa-check text-success\" ></i> Suporte Remoto<br />\r\n<i class=\"fa fa-check text-success\" ></i> Tráfego para seu site<br />\r\n<i class=\"fa fa-check text-success\" ></i> Criação de Banners<br />\r\n<i class=\"fa fa-check text-success\" ></i> Chat Bot<br />\r\n<i class=\"fa fa-check text-success\" ></i> Envio Produtos Digitais<br />\r\n<i class=\"fa fa-close text-danger\" ></i> 5 dias grátis<br />\r\n', '0,00', 1, 1, 1, 1, 1, 1, 1000000000, 10, 1, 4, 50, 1, 10, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `post_comunidade`
--

CREATE TABLE `post_comunidade` (
  `id` int(11) NOT NULL,
  `data` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `autor` int(11) NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pre_cadastro_gestor`
--

CREATE TABLE `pre_cadastro_gestor` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rateio_afiliado`
--

CREATE TABLE `rateio_afiliado` (
  `id` int(11) NOT NULL,
  `plano` int(11) NOT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `afiliado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reference_linkzap`
--

CREATE TABLE `reference_linkzap` (
  `id` int(11) NOT NULL,
  `data` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_link` int(11) NOT NULL,
  `navegador` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dispositivo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origem` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_ref` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reply_chatbot`
--

CREATE TABLE `reply_chatbot` (
  `id` int(11) NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_chat` int(11) NOT NULL,
  `sender_info` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `info` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saldo_user`
--

CREATE TABLE `saldo_user` (
  `id` int(11) NOT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `session_chatbot`
--

CREATE TABLE `session_chatbot` (
  `id` int(11) NOT NULL,
  `chatbot_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senderName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msgs` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_init` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicita_banner`
--

CREATE TABLE `solicita_banner` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `cores_principal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prazo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `free` int(11) DEFAULT NULL,
  `modelo_exemplo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mes` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `informacoes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagens` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_adm` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_download` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicita_saque`
--

CREATE TABLE `solicita_saque` (
  `id` int(11) NOT NULL,
  `id_rev` int(11) NOT NULL,
  `dados` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicita_traffic`
--

CREATE TABLE `solicita_traffic` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origem` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtd_acesso` int(11) NOT NULL,
  `percent_desktop` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percent_mobile` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_delivery_aut`
--

CREATE TABLE `sub_delivery_aut` (
  `id` int(11) NOT NULL,
  `id_delivery` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `enviado` int(11) NOT NULL DEFAULT 0,
  `info_send` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reverse` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `text_pre_cadastro`
--

CREATE TABLE `text_pre_cadastro` (
  `id` int(11) NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `text_pre_cadastro`
--

INSERT INTO `text_pre_cadastro` (`id`, `texto`) VALUES
(1, 'Oi {nome}. \r\n\r\nAgora nosso Gestor Master, está integrado com o Mercado Pago como gateway de pagamento!\r\n\r\nAgora você pode receber pagamentos pelo sistema de forma automática e ser notificado toda vez que isso acontecer! \r\n\r\nNão perde isso não, agora isso ta muito legal! Estamos sempre ouvindo os feedbacks de vocês :).\r\n\r\nhttps://gestormaster.top\r\n\r\nPainel: https://gestormaster.top/painel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `text_recover_pass`
--

CREATE TABLE `text_recover_pass` (
  `id` int(11) NOT NULL,
  `text` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `text_recover_pass`
--

INSERT INTO `text_recover_pass` (`id`, `text`) VALUES
(1, 'Olá {name}. Você solicitou sua senha do Gestor Master ? \r\nBom, se foi você aqui está ela:\r\n\r\n*Senha:* {pass}\r\n\r\nCaso não seja você quem solicitou, pode ficar tranquilo(a), pois somente você tem acesso a seu email, não é mesmo ?\r\n\r\nPara que se sinta mais seguro(a), acesse o Gestor Master, e altere sua senha, Okay ?\r\n\r\nhttps://gestormaster.top/painel\r\n\r\nAtt: Gestor Master');

-- --------------------------------------------------------

--
-- Estrutura da tabela `text_zap_gestor_lite`
--

CREATE TABLE `text_zap_gestor_lite` (
  `id` int(11) NOT NULL,
  `texto` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gatilho` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `text_zap_gestor_lite`
--

INSERT INTO `text_zap_gestor_lite` (`id`, `texto`, `gatilho`) VALUES
(1, '{primeiro_nome}, Sua fatura do *Gestor Master* já está disponível. \r\n\r\nAcesse: https://gestormaster.top/painel | R$ {valor}\r\n\r\nNão perca a chance de automatizar seu painel. Lembre-se tempo é dinheiro e nós economizamos seu tempo.\r\n\r\nTenha um dia master.', 'faturas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `token_login_cliente`
--

CREATE TABLE `token_login_cliente` (
  `id` int(11) NOT NULL,
  `token` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `used_cod`
--

CREATE TABLE `used_cod` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `codigo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ddi` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_plano` int(10) NOT NULL,
  `token_access` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vencimento` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dias_aviso_antecipado` int(11) NOT NULL,
  `lancar_finan` int(11) NOT NULL,
  `dark` int(11) NOT NULL,
  `somente_finan` int(11) DEFAULT NULL,
  `gera_fat_cli` int(11) NOT NULL DEFAULT 0,
  `id_rev` int(11) DEFAULT NULL,
  `indicado` int(11) DEFAULT NULL,
  `teste_free` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sim',
  `moeda` int(11) NOT NULL DEFAULT 1,
  `verificadozap` int(11) NOT NULL DEFAULT 1,
  `verificadomail` int(11) NOT NULL DEFAULT 1,
  `af` int(11) DEFAULT 0,
  `parceiro` int(11) DEFAULT 0,
  `vencimento_flex` int(11) NOT NULL DEFAULT 1,
  `notify_page` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_facto` int(11) NOT NULL DEFAULT 0,
  `google_auth_code` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas_parceiro`
--

CREATE TABLE `vendas_parceiro` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parceiro` int(11) NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plano` int(11) NOT NULL,
  `data` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vps`
--

CREATE TABLE `vps` (
  `id` int(11) NOT NULL,
  `expiration` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_external` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ram` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `service` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vps_users`
--

CREATE TABLE `vps_users` (
  `id` int(11) NOT NULL,
  `id_vps` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `infos` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `whats_api`
--

CREATE TABLE `whats_api` (
  `id` int(11) NOT NULL,
  `device_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `api` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situ` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `access_mp`
--
ALTER TABLE `access_mp`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `avisos_painel`
--
ALTER TABLE `avisos_painel`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categorias_cliente`
--
ALTER TABLE `categorias_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cod_promo`
--
ALTER TABLE `cod_promo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `comprovantes_fat`
--
ALTER TABLE `comprovantes_fat`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `comprovantes_fat_cli`
--
ALTER TABLE `comprovantes_fat_cli`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `config_cores_plano`
--
ALTER TABLE `config_cores_plano`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `conf_cli_area`
--
ALTER TABLE `conf_cli_area`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `contato_gestorlite`
--
ALTER TABLE `contato_gestorlite`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `convidade_acesso`
--
ALTER TABLE `convidade_acesso`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `creditos_rev`
--
ALTER TABLE `creditos_rev`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dados_bank_user`
--
ALTER TABLE `dados_bank_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dados_mp_user`
--
ALTER TABLE `dados_mp_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dados_paghiper`
--
ALTER TABLE `dados_paghiper`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dados_painel`
--
ALTER TABLE `dados_painel`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dados_picpay_user`
--
ALTER TABLE `dados_picpay_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `delivery_aut`
--
ALTER TABLE `delivery_aut`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `disparos_zap`
--
ALTER TABLE `disparos_zap`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `faturas_clientes`
--
ALTER TABLE `faturas_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `faturas_user`
--
ALTER TABLE `faturas_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fila_cloud`
--
ALTER TABLE `fila_cloud`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fila_zap`
--
ALTER TABLE `fila_zap`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `financeiro`
--
ALTER TABLE `financeiro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `financeiro_gestor`
--
ALTER TABLE `financeiro_gestor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `grupo_beta`
--
ALTER TABLE `grupo_beta`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `historic_teste`
--
ALTER TABLE `historic_teste`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `indicacoes_clientes`
--
ALTER TABLE `indicacoes_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lasted_conversion`
--
ALTER TABLE `lasted_conversion`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `linkzap`
--
ALTER TABLE `linkzap`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lsita_negra_avisos`
--
ALTER TABLE `lsita_negra_avisos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `moeda`
--
ALTER TABLE `moeda`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `msg_not_pareado`
--
ALTER TABLE `msg_not_pareado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notification_af`
--
ALTER TABLE `notification_af`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `num_cobrancas`
--
ALTER TABLE `num_cobrancas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `options_system`
--
ALTER TABLE `options_system`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `order_graph_user`
--
ALTER TABLE `order_graph_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `plano_user_gestor`
--
ALTER TABLE `plano_user_gestor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `post_comunidade`
--
ALTER TABLE `post_comunidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pre_cadastro_gestor`
--
ALTER TABLE `pre_cadastro_gestor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rateio_afiliado`
--
ALTER TABLE `rateio_afiliado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `reference_linkzap`
--
ALTER TABLE `reference_linkzap`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `reply_chatbot`
--
ALTER TABLE `reply_chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `saldo_user`
--
ALTER TABLE `saldo_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `session_chatbot`
--
ALTER TABLE `session_chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `solicita_banner`
--
ALTER TABLE `solicita_banner`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `solicita_saque`
--
ALTER TABLE `solicita_saque`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `solicita_traffic`
--
ALTER TABLE `solicita_traffic`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sub_delivery_aut`
--
ALTER TABLE `sub_delivery_aut`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `text_pre_cadastro`
--
ALTER TABLE `text_pre_cadastro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `text_recover_pass`
--
ALTER TABLE `text_recover_pass`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `text_zap_gestor_lite`
--
ALTER TABLE `text_zap_gestor_lite`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `token_login_cliente`
--
ALTER TABLE `token_login_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `used_cod`
--
ALTER TABLE `used_cod`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `vendas_parceiro`
--
ALTER TABLE `vendas_parceiro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `vps`
--
ALTER TABLE `vps`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `vps_users`
--
ALTER TABLE `vps_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `whats_api`
--
ALTER TABLE `whats_api`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `access_mp`
--
ALTER TABLE `access_mp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `avisos_painel`
--
ALTER TABLE `avisos_painel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT de tabela `categorias_cliente`
--
ALTER TABLE `categorias_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3465;

--
-- AUTO_INCREMENT de tabela `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104672;

--
-- AUTO_INCREMENT de tabela `cod_promo`
--
ALTER TABLE `cod_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `comprovantes_fat`
--
ALTER TABLE `comprovantes_fat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1187;

--
-- AUTO_INCREMENT de tabela `comprovantes_fat_cli`
--
ALTER TABLE `comprovantes_fat_cli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6069;

--
-- AUTO_INCREMENT de tabela `config_cores_plano`
--
ALTER TABLE `config_cores_plano`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `conf_cli_area`
--
ALTER TABLE `conf_cli_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1705;

--
-- AUTO_INCREMENT de tabela `contato_gestorlite`
--
ALTER TABLE `contato_gestorlite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=637;

--
-- AUTO_INCREMENT de tabela `convidade_acesso`
--
ALTER TABLE `convidade_acesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `creditos_rev`
--
ALTER TABLE `creditos_rev`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `dados_bank_user`
--
ALTER TABLE `dados_bank_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=521;

--
-- AUTO_INCREMENT de tabela `dados_mp_user`
--
ALTER TABLE `dados_mp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=535;

--
-- AUTO_INCREMENT de tabela `dados_paghiper`
--
ALTER TABLE `dados_paghiper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de tabela `dados_painel`
--
ALTER TABLE `dados_painel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2192;

--
-- AUTO_INCREMENT de tabela `dados_picpay_user`
--
ALTER TABLE `dados_picpay_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT de tabela `delivery_aut`
--
ALTER TABLE `delivery_aut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=477;

--
-- AUTO_INCREMENT de tabela `disparos_zap`
--
ALTER TABLE `disparos_zap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226973;

--
-- AUTO_INCREMENT de tabela `faturas_clientes`
--
ALTER TABLE `faturas_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165393;

--
-- AUTO_INCREMENT de tabela `faturas_user`
--
ALTER TABLE `faturas_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7937;

--
-- AUTO_INCREMENT de tabela `fila_cloud`
--
ALTER TABLE `fila_cloud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de tabela `fila_zap`
--
ALTER TABLE `fila_zap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413279;

--
-- AUTO_INCREMENT de tabela `financeiro`
--
ALTER TABLE `financeiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72579;

--
-- AUTO_INCREMENT de tabela `financeiro_gestor`
--
ALTER TABLE `financeiro_gestor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2563;

--
-- AUTO_INCREMENT de tabela `grupo_beta`
--
ALTER TABLE `grupo_beta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `historic_teste`
--
ALTER TABLE `historic_teste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24655;

--
-- AUTO_INCREMENT de tabela `indicacoes_clientes`
--
ALTER TABLE `indicacoes_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `lasted_conversion`
--
ALTER TABLE `lasted_conversion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `linkzap`
--
ALTER TABLE `linkzap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=689;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=713488;

--
-- AUTO_INCREMENT de tabela `lsita_negra_avisos`
--
ALTER TABLE `lsita_negra_avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT de tabela `moeda`
--
ALTER TABLE `moeda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `msg_not_pareado`
--
ALTER TABLE `msg_not_pareado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `notification_af`
--
ALTER TABLE `notification_af`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `num_cobrancas`
--
ALTER TABLE `num_cobrancas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `options_system`
--
ALTER TABLE `options_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `order_graph_user`
--
ALTER TABLE `order_graph_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9496;

--
-- AUTO_INCREMENT de tabela `plano_user_gestor`
--
ALTER TABLE `plano_user_gestor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `post_comunidade`
--
ALTER TABLE `post_comunidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `pre_cadastro_gestor`
--
ALTER TABLE `pre_cadastro_gestor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rateio_afiliado`
--
ALTER TABLE `rateio_afiliado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `reference_linkzap`
--
ALTER TABLE `reference_linkzap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77725;

--
-- AUTO_INCREMENT de tabela `reply_chatbot`
--
ALTER TABLE `reply_chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4314;

--
-- AUTO_INCREMENT de tabela `saldo_user`
--
ALTER TABLE `saldo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `session_chatbot`
--
ALTER TABLE `session_chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1149755;

--
-- AUTO_INCREMENT de tabela `solicita_banner`
--
ALTER TABLE `solicita_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `solicita_saque`
--
ALTER TABLE `solicita_saque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `solicita_traffic`
--
ALTER TABLE `solicita_traffic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=531;

--
-- AUTO_INCREMENT de tabela `sub_delivery_aut`
--
ALTER TABLE `sub_delivery_aut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5503;

--
-- AUTO_INCREMENT de tabela `text_pre_cadastro`
--
ALTER TABLE `text_pre_cadastro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `text_recover_pass`
--
ALTER TABLE `text_recover_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `text_zap_gestor_lite`
--
ALTER TABLE `text_zap_gestor_lite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `token_login_cliente`
--
ALTER TABLE `token_login_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19763;

--
-- AUTO_INCREMENT de tabela `used_cod`
--
ALTER TABLE `used_cod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3834;

--
-- AUTO_INCREMENT de tabela `vendas_parceiro`
--
ALTER TABLE `vendas_parceiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `vps`
--
ALTER TABLE `vps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `vps_users`
--
ALTER TABLE `vps_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `whats_api`
--
ALTER TABLE `whats_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9978;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
