-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Jul-2022 às 22:24
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lzap_chatbot`
--
CREATE DATABASE IF NOT EXISTS `lzap_chatbot` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lzap_chatbot`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatbot`
--

DROP TABLE IF EXISTS `chatbot`;
CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `empresa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criacao` datetime NOT NULL DEFAULT current_timestamp(),
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apresentacao` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `despedida` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pedir_nome` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_pedir_nome` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pedir_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_pedir_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_pedir_assunto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_pedir_recado` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_aviso_anotar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempo_espera` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pedirRetorno` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `atendente_p` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `whats_chat`
--

DROP TABLE IF EXISTS `whats_chat`;
CREATE TABLE `whats_chat` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `id_chat` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cadastro` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apelido` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ultima_mensagem` datetime DEFAULT NULL,
  `valida_imagem` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_imagem` datetime DEFAULT NULL,
  `fase_chat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_bot` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_bot` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assunto_bot` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atendente` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protocolo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atendimento` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendente` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incompleto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recive` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bot` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_metrica` datetime DEFAULT current_timestamp(),
  `id_recado` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `whats_mensagem`
--

DROP TABLE IF EXISTS `whats_mensagem`;
CREATE TABLE `whats_mensagem` (
  `id` int(11) NOT NULL,
  `empresa` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mensagem` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_chat` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo_rec` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conteudo` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remetente` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minha` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autor` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `lida` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mencionado` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conteudo_mencionado` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_mencionado` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempo_espera` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `whats_chat`
--
ALTER TABLE `whats_chat`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `whats_mensagem`
--
ALTER TABLE `whats_mensagem`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_mens` (`id_mensagem`),
  ADD KEY `empresa` (`empresa`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `whats_chat`
--
ALTER TABLE `whats_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `whats_mensagem`
--
ALTER TABLE `whats_mensagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
