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
(27, 'Teste', '2', 45765799, '60b9301b18a6f', '2021-09-02 18:31:38'),
(28, 'Deu certo bb :D', '4', 45765799, '60b9301b18a6f', '2021-09-02 18:33:49');

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
('60b9301b18a6f', 'Novela de gerson com o olympique continua', 'O imbróglio continua', '<h1>Gerson acerta futuro</h1>\r\n<p>Em reuni&atilde;o na ter&ccedil;a-feira (1), Flamengo e Olympique de Marselha acertaram os &uacute;ltimos detalhes para o contrato de venda de Gerson e a negocia&ccedil;&atilde;o j&aacute; est&aacute; sacramentada, faltando apenas a assinatura do contrato para o an&uacute;ncio. Segundo o site \'Ge\', o volante ainda voltar&aacute; da sele&ccedil;&atilde;o ol&iacute;mpica para disputar mais alguns jogos pelo Rubro-Negro antes da despedida</p>\r\n<p>Em reuni&atilde;o na ter&ccedil;a-feira (1), Flamengo e Olympique de Marselha acertaram os &uacute;ltimos detalhes para o contrato de venda de Gerson e a negocia&ccedil;&atilde;o j&aacute; est&aacute; sacramentada, faltando apenas a assinatura do contrato para o an&uacute;ncio. Segundo o site \'Ge\', o volante ainda voltar&aacute; da sele&ccedil;&atilde;o ol&iacute;mpica para disputar mais alguns jogos pelo Rubro-Negro antes da despedida</p>', 1, 'resources/images/image1918161352519109.jpg', '2021-06-03', 'Gerson já não tem mais paciência com frieza da direção', 'Novela-de-gerson-com-o-olympique-continua'),
('612e3ecccf450', 'Será que a dupla Éverton e Gabi jogará junto hoje?', 'cscaccsa', '<p>vsdvdsvsd</p>', 1, 'resources/images/image1020421711614136.jpg', '2021-08-31', 'vsdvdsv', 'sera-que-a-dupla-everton-e-gabi-jogara-junto-hoje');

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nome` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuario` (`id`, `nome`, `is_admin`, `email`, `telefone`) VALUES
(1, 'admin', 1, 'admin@email.com', '1199999999999'),
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
  ADD KEY `id_noticia` (`id_noticia`);

ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `avaliacao_usuario_noticia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;


ALTER TABLE `avaliacao_usuario_noticia`
  ADD CONSTRAINT `avaliacao_usuario_noticia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `avaliacao_usuario_noticia_ibfk_2` FOREIGN KEY (`id_noticia`) REFERENCES `noticia` (`id`);

ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `usuario_admin` (`id`);

ALTER TABLE `usuario_admin`
  ADD CONSTRAINT `usuario_admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
