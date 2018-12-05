-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.17 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla maringraf.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla maringraf.categorias: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`id`, `denominacion`) VALUES
	(1, 'cat1'),
	(2, 'cat2');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Volcando estructura para tabla maringraf.noticias
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `contenido` text,
  `imagen` varchar(255) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla maringraf.noticias: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` (`id`, `fecha`, `titulo`, `contenido`, `imagen`, `idCategoria`) VALUES
	(1, '2018-12-03', 'Noticia ejemplo', '<p><strong>asd</strong></p>\r\n\r\n<blockquote>\r\n<p><strong>aaaaaaaaaaaaaa</strong></p>\r\n</blockquote>\r\n\r\n<p><strong><span class="marker">ffffffff</span></strong></p>', 'stock info.png', 1),
	(2, '2018-12-03', 'Noticia ejemplo', '<p><strong>asd</strong></p>\r\n\r\n<blockquote>\r\n<p><strong>aaaaaaaaaaaaaa</strong></p>\r\n</blockquote>\r\n\r\n<p><strong><span class="marker">ffffffff</span></strong></p>', 'stock info.png', 1),
	(3, '2018-12-03', 'Noticia ejemplo', '<p><strong>asd</strong></p>\r\n\r\n<blockquote>\r\n<p><strong>aaaaaaaaaaaaaa</strong></p>\r\n</blockquote>\r\n\r\n<p><strong><span class="marker">ffffffff</span></strong></p>', 'stock info.png', 1),
	(4, '2018-12-03', 'Noticia ejemplo', '<p><strong>asd</strong></p>\r\n\r\n<blockquote>\r\n<p><strong>aaaaaaaaaaaaaa</strong></p>\r\n</blockquote>\r\n\r\n<p><strong><span class="marker">ffffffff</span></strong></p>', 'stock info.png', 1);
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;

-- Volcando estructura para tabla maringraf.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `detalle` text,
  `precio` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla maringraf.productos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `titulo`, `imagen`, `detalle`, `precio`) VALUES
	(1, 'corporeos metálicos', '20160523_060608.jpg', 'aoiwdj oaijdaoijdajiwdnaoheiouefh uef wefwhoe fiuwheif weifh wiuef hiwufh wef', 300.00),
	(2, 'corporeo luminoso', '20160422_072939.jpg', 'iefuif uwheifu hwifhw ifhiwu ehfiwe fh', 100.00),
	(3, 'hormigas', '12440549_1698885847013057_8100834627954676507_o.jpg', 'asdwdawdad', 500.00);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla maringraf.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imagen` varchar(255) DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla maringraf.servicios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` (`id`, `imagen`, `titulo`, `texto`) VALUES
	(1, 'advice-advise-advisor-7096.jpg', 'Servicio ejemplo', 'lorem ipsum');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
