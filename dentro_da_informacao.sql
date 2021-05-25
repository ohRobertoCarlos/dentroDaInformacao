SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `dentro_da_informacao` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dentro_da_informacao`;

CREATE TABLE `noticia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `subtitulo` varchar(70) NOT NULL,
  `texto_conteudo` text NOT NULL,
  `id_autor` int(11) NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `data_publicacao` date NOT NULL,
  `descricao` text NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `telefone` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `usuario_admin` (
  `id` int(11) NOT NULL,
  `email_login` varchar(50) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `usuario_admin` (`id`);

ALTER TABLE `usuario_admin`
  ADD CONSTRAINT `usuario_admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
