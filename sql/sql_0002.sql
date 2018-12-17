-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2018 a las 21:24:16
-- Versión del servidor: 5.6.17-log
-- Versión de PHP: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `maringraf`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `denominacion`) VALUES
(1, 'Armado de Stands'),
(2, 'Diseños Exclusivos'),
(3, 'Regalos Empresariales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `contenido` text,
  `imagen` varchar(255) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `fecha`, `titulo`, `contenido`, `imagen`, `idCategoria`) VALUES
(1, '2018-12-05', 'Nuevos Almanaques', '<p><strong>Te Presentamos los nuevos almanaques 2018/19</strong></p>\r\n\r\n<p><br />\r\nOfrecemos 3 presentaciones:</p>\r\n\r\n<ul>\r\n	<li>Piramidal</li>\r\n	<li>L&aacute;mina con varilla</li>\r\n	<li>Carpita anillada</li>\r\n</ul>\r\n\r\n<p><em>Cantidad m&iacute;nima 100 unidades</em></p>\r\n\r\n<p>&nbsp;</p>', 'almanaques-piramidal.jpg', 3),
(3, '2018-12-03', 'Sala Gamer', '<p><strong>Estamos muy orgullosos de presentar el proyecto finalizado.</strong></p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n\r\n<blockquote>\r\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n</blockquote>\r\n\r\n<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'noticias-2.jpg', 1),
(4, '2018-12-03', 'Papelería Personalizada para tu evento', '<p>Te mostramos el trabajo que realizamos para la fiesta de 15 de Melania</p>\r\n\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>\r\n\r\n<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur:</p>\r\n\r\n<ul>\r\n	<li>aut odit aut fugit, sed quia</li>\r\n	<li>consequuntur magni dolores</li>\r\n	<li>eos qui ratione voluptatem</li>\r\n	<li>sequi nesciunt.&nbsp;</li>\r\n</ul>\r\n\r\n<p><em>Dise&ntilde;amos la papeleria, souvenires y todo lo que sue&ntilde;es para tu fiesta. <strong>Contactanos!</strong></em></p>\r\n\r\n<p>&nbsp;</p>', 'noticias.jpg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `detalle` text,
  `precio` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `titulo`, `imagen`, `detalle`, `precio`) VALUES
(1, 'Tarjetas Personales', 'tarjetas.jpg', 'En papel ilustración de 300 grs, impresión frente o frente y dorso full color, con opcionales en laminados brillo o mate en polipropileno.\r\nCantidad mínima 100 tarjetas. Consultá por otras cantidades.', 300.00),
(2, 'Folletos', 'folletos.jpg', 'Folletos 150 gr impresión full color frente x 50 unidades.\r\nConsultanos diferentes medidas, materiales, impresión full color frente o frente y dorso y otras cantidades', 200.00),
(3, 'Bolsas', 'DSC_0893.JPG', 'En papel o cartulina, en diferentes medidas, impresión desde 1 color a full color, con manijas de cordón o cinta gross, base reforzada en cartulina, opcionales de laminado brillo o mate en polipropileno. Cantidad minima: 1000 Bolsas.', 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imagen` varchar(255) DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `imagen`, `titulo`, `texto`) VALUES
(1, 'servicio1.jpg', 'Gigantografia y corporeos', '* POLYFAM\r\nEn 3 o 5 cm de espesor, ruteados en diferentes tamaños de letras corporeas, logos, centros de mesa, bases de tortas.\r\nOpcional: pintados, luces, mantados, instalación\r\n*LETRAS EN MADERA:\r\nEn mdf de diferentes espesores y medidas.\r\nOpcional: pintadas, 3D, luces led\r\n* VINILOS DECORATIVOS:\r\nEn varios colores, y esmerilado, ruteado de siluetas, frases, logos, despuntados y con transfer para su colocación.\r\nOpcional instalación\r\n*CARTELERIA Y GIGANTOGRAFIA:\r\nImpresión full color en solvente o latex en: Lona front, vinilo autoadhesivo, cuerina, back light, microperforado, canvas\r\nOpcionales: Ojalillos, bolsillos, montados, ruteados, porta banners, roll up, estructuras metálicas, instalaciones.'),
(2, 'servicio2.jpg', 'Armado de Stands', '*Diseños,\r\n*Armados estructurales,\r\n*Pisos,\r\n*Paredes,\r\n*Carteleria,\r\n*Mobiliario,\r\n*Iluminación'),
(3, 'servicio3.jpg', 'Carteleria y gigantografia', 'Impresión full color en solvente o latex en: Lona front, vinilo autoadhesivo, cuerina, back light, microperforado, canvas\r\nOpcionales: Ojalillos, bolsillos, montados, ruteados, porta banners, roll up, estructuras metálicas, instalaciones.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
