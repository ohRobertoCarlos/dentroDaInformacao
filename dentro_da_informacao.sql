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
  `id` varchar(32) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `subtitulo` varchar(70) NOT NULL,
  `texto_conteudo` text NOT NULL,
  `id_autor` int(11) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `data_publicacao` date NOT NULL,
  `descricao` text NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `noticia` (`id`, `titulo`, `subtitulo`, `texto_conteudo`, `id_autor`, `thumbnail`, `data_publicacao`, `descricao`, `slug`) VALUES
('60b92ea890500', 'atlético vence o corinthias de goleada', 'Vergonha que passa o timão', '<h1>Timao desaponta</h1>\r\n<p>&nbsp;</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mollis massa sed eros aliquet euismod. Quisque efficitur ac diam non suscipit. Phasellus eu purus scelerisque, interdum urna nec, faucibus risus. Proin in libero volutpat, mollis elit nec, auctor metus. Pellentesque dapibus pharetra quam, sed lobortis tortor viverra vel. Nunc orci enim, pretium a magna at, placerat ullamcorper tortor. Pellentesque sed placerat ex, et euismod mauris. Aliquam ut convallis eros, eu semper nisi. Pellentesque tempor rutrum nisi vitae accumsan. Donec ut ipsum vitae purus eleifend facilisis. Nam turpis nibh, dignissim sagittis volutpat id, lacinia vitae dolor.</p>\r\n<p>&nbsp;</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mollis massa sed eros aliquet euismod. Quisque efficitur ac diam non suscipit. Phasellus eu purus scelerisque, interdum urna nec, faucibus risus. Proin in libero volutpat, mollis elit nec, auctor metus. Pellentesque dapibus pharetra quam, sed lobortis tortor viverra vel. Nunc orci enim, pretium a magna at, placerat ullamcorper tortor. Pellentesque sed placerat ex, et euismod mauris. Aliquam ut convallis eros, eu semper nisi. Pellentesque tempor rutrum nisi vitae accumsan. Donec ut ipsum vitae purus eleifend facilisis. Nam turpis nibh, dignissim sagittis volutpat id, lacinia vitae dolor.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mollis massa sed eros aliquet euismod. Quisque efficitur ac diam non suscipit. Phasellus eu purus scelerisque, interdum urna nec, faucibus risus. Proin in libero volutpat, mollis elit nec, auctor metus. Pellentesque dapibus pharetra quam, sed lobortis tortor viverra vel. Nunc orci enim, pretium a magna at, placerat ullamcorper tortor. Pellentesque sed placerat ex, et euismod mauris. Aliquam ut convallis eros, eu semper nisi. Pellentesque tempor rutrum nisi vitae accumsan. Donec ut ipsum vitae purus eleifend facilisis. Nam turpis nibh, dignissim sagittis volutpat id, lacinia vitae dolor.</p>', 1, 'resources/images/image181514918111171810.jpg', '2021-06-03', 'O Corinthians vira um verdadeiro freguês do Atlético-GO', 'atletico-vence-o-corinthias-de-goleada'),
('60b9301b18a6f', 'Novela de gerson com o olympique continua', 'O imbróglio continua', '<h1>Gerson acerta futuro</h1>\r\n<p>Em reuni&atilde;o na ter&ccedil;a-feira (1), Flamengo e Olympique de Marselha acertaram os &uacute;ltimos detalhes para o contrato de venda de Gerson e a negocia&ccedil;&atilde;o j&aacute; est&aacute; sacramentada, faltando apenas a assinatura do contrato para o an&uacute;ncio. Segundo o site \'Ge\', o volante ainda voltar&aacute; da sele&ccedil;&atilde;o ol&iacute;mpica para disputar mais alguns jogos pelo Rubro-Negro antes da despedida</p>\r\n<p>Em reuni&atilde;o na ter&ccedil;a-feira (1), Flamengo e Olympique de Marselha acertaram os &uacute;ltimos detalhes para o contrato de venda de Gerson e a negocia&ccedil;&atilde;o j&aacute; est&aacute; sacramentada, faltando apenas a assinatura do contrato para o an&uacute;ncio. Segundo o site \'Ge\', o volante ainda voltar&aacute; da sele&ccedil;&atilde;o ol&iacute;mpica para disputar mais alguns jogos pelo Rubro-Negro antes da despedida</p>', 1, 'resources/images/image1918161352519109.jpg', '2021-06-03', 'Gerson já não tem mais paciência com frieza da direção', 'Novela-de-gerson-com-o-olympique-continua');

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario` (`id`, `nome`, `is_admin`, `email`, `telefone`) VALUES
(1, 'admin', 1, 'admin@email.com', '1199999999999');

CREATE TABLE `usuario_admin` (
  `id` int(11) NOT NULL,
  `email_login` varchar(50) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario_admin` (`id`, `email_login`, `senha`, `id_usuario`) VALUES
(1, 'admin@email.com', '1234', 1);


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
