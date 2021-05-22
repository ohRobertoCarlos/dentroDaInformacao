SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `contato` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

INSERT INTO `noticia` (`id`, `titulo`, `subtitulo`, `texto_conteudo`, `id_autor`, `thumbnail`, `data_publicacao`, `descricao`, `slug`) VALUES
(1, 'River-Plate improvisa jogador de linha no gol', 'Lorem ipsum dolor sit amet, consectetur adiLorem ipsu', 'Lorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adi', 1, 'resources/images/futebol.jpg', '2021-05-19', 'river...', 'river-improvisa'),
(2, 'Mc morre por fato curioso', 'r adiLorem ipsum dolor sit amet, consectet', 'r adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetur adiLorem ipsum dolor sit amet, consectetu', 1, 'resources/images/futebol.jpg', '2021-05-19', 'A polícia investiga, mas causa da morte pode ter sido aventura sexual', 'mc-morre-fato-curioso');

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `telefone` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario` (`id`, `nome`, `is_admin`, `email`, `telefone`) VALUES
(1, 'Roberto', 1, '', ''),
(3, 'jose', 0, 'jose@gmail.com', '62999999999');

CREATE TABLE `usuario_admin` (
  `id` int(11) NOT NULL,
  `email_login` varchar(50) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario_admin` (`id`, `email_login`, `senha`, `id_usuario`) VALUES
(1, 'roberto@email.com', '1234', 1);


ALTER TABLE `contato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `usuario_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `contato`
  ADD CONSTRAINT `contato_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `usuario_admin` (`id`);

ALTER TABLE `usuario_admin`
  ADD CONSTRAINT `usuario_admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
