SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `avaliacao_usuario_noticia` (
  `id` int NOT NULL,
  `comentario` text NOT NULL,
  `nota` char(1) NOT NULL,
  `id_usuario` int NOT NULL,
  `id_noticia` varchar(32) NOT NULL,
  `data_avaliacao` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `avaliacao_usuario_noticia` (`id`, `comentario`, `nota`, `id_usuario`, `id_noticia`, `data_avaliacao`) VALUES
(40, 'Teste de cookies', '4', 8513942, '61329a1196908', '2021-09-03 21:56:57');

CREATE TABLE `noticia` (
  `id` varchar(32) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `subtitulo` varchar(70) NOT NULL,
  `texto_conteudo` text NOT NULL,
  `id_autor` int NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `data_publicacao` date NOT NULL,
  `descricao` text NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `noticia` (`id`, `titulo`, `subtitulo`, `texto_conteudo`, `id_autor`, `thumbnail`, `data_publicacao`, `descricao`, `slug`) VALUES
('61329a1196908', 'Testando', 'dcsc', 'xaxs', 1, 'resources/images/image20618691061511.png', '2021-09-03', 'scsdc', 'testando');

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nome` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuario` (`id`, `nome`, `is_admin`, `email`, `telefone`) VALUES
(1, 'admin', 1, 'admin@email.com', '1199999999999'),
(8513942, 'user2021_09_03_18_56_57_61329a29c5259', 0, NULL, NULL),
(45765799, 'user2021-09-02 15:28:40_613117d848fbf', 0, NULL, NULL);

CREATE TABLE `usuario_admin` (
  `id` int NOT NULL,
  `email_login` varchar(50) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuario_admin` (`id`, `email_login`, `senha`, `id_usuario`) VALUES
(1, 'admin@email.com', '1234', 1);


ALTER TABLE `avaliacao_usuario_noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `avaliacao_usuario_noticia_ibfk_2` (`id_noticia`);

ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `avaliacao_usuario_noticia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;


ALTER TABLE `avaliacao_usuario_noticia`
  ADD CONSTRAINT `avaliacao_usuario_noticia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `avaliacao_usuario_noticia_ibfk_2` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id`) ON DELETE CASCADE;

ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `usuario_admin` (`id`);

ALTER TABLE `usuario_admin`
  ADD CONSTRAINT `usuario_admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
