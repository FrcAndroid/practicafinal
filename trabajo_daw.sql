-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for trabajo_daw
CREATE DATABASE IF NOT EXISTS `trabajo_daw` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `trabajo_daw`;

-- Dumping structure for table trabajo_daw.accesos
CREATE TABLE IF NOT EXISTS `accesos` (
  `ID_ACCESO` varchar(50) NOT NULL,
  `FECHA_HORA_ACCESO` datetime DEFAULT NULL,
  `FECHA_HORA_SALIDA` datetime DEFAULT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ACCESO`),
  KEY `Index 2` (`COD_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.accesos: ~15 rows (approximately)
DELETE FROM `accesos`;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
INSERT INTO `accesos` (`ID_ACCESO`, `FECHA_HORA_ACCESO`, `FECHA_HORA_SALIDA`, `COD_USUARIO`) VALUES
	('', NULL, NULL, NULL),
	('-- -----------------------------------------------', NULL, NULL, NULL),
	('-- Data exporting was unselected.', NULL, NULL, NULL),
	('-- HeidiSQL Version:             10.3.0.5771', NULL, NULL, NULL),
	('-- Host:                         127.0.0.1', NULL, NULL, NULL),
	('-- Server OS:                    Win64', NULL, NULL, NULL),
	('-- Server version:               10.4.11-MariaDB -', NULL, NULL, NULL),
	('/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY', '0000-00-00 00:00:00', NULL, NULL),
	('/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KE', '0000-00-00 00:00:00', NULL, NULL),
	('/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER', '0000-00-00 00:00:00', NULL, NULL),
	('/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'N', '0000-00-00 00:00:00', NULL, NULL),
	('/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_S', '0000-00-00 00:00:00', NULL, NULL),
	('/*!40101 SET NAMES utf8 */', '0000-00-00 00:00:00', NULL, NULL),
	('/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, \'\') */', '0000-00-00 00:00:00', NULL, NULL),
	('/*!50503 SET NAMES utf8mb4 */', '0000-00-00 00:00:00', NULL, NULL);
/*!40000 ALTER TABLE `accesos` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.albaranes
CREATE TABLE IF NOT EXISTS `albaranes` (
  `COD_ALBARAN` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CLIENTE` int(11) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `GENERADO_DE_PEDIDO` varchar(50) DEFAULT NULL,
  `CONCEPTO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_ALBARAN`),
  KEY `COD_CLIENTE` (`COD_CLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.albaranes: ~0 rows (approximately)
DELETE FROM `albaranes`;
/*!40000 ALTER TABLE `albaranes` DISABLE KEYS */;
/*!40000 ALTER TABLE `albaranes` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.articulos
CREATE TABLE IF NOT EXISTS `articulos` (
  `COD_ARTICULO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(50) DEFAULT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `DESCUENTO` int(3) DEFAULT NULL,
  `IVA` int(3) DEFAULT NULL,
  `IMAGEN` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`COD_ARTICULO`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.articulos: ~0 rows (approximately)
DELETE FROM `articulos`;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` (`COD_ARTICULO`, `NOMBRE`, `DESCRIPCION`, `PRECIO`, `DESCUENTO`, `IVA`, `IMAGEN`) VALUES
	(1, 'Bolsa de patatas', 'Sabor queso', 2, 0, 14, 'https://www.alcampo.es/media/h5a/h84/8928729038878.jpg'),
	(2, 'Botella de agua mineral', 'Muy fresca', 2, 0, 14, 'https://www.stickpng.com/assets/images/580b585b2edbce24c47b2780.png');
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `COD_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `CIF_DNI` varchar(50) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(50) DEFAULT NULL,
  `DOMICILIO_SOCIAL` varchar(50) DEFAULT NULL,
  `CIUDAD` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(50) DEFAULT NULL,
  `NICK` varchar(50) NOT NULL,
  `CONTRASEÑA` varchar(50) NOT NULL,
  `ESTADO` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`COD_CLIENTE`),
  UNIQUE KEY `Index 1` (`NICK`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.clientes: ~2 rows (approximately)
DELETE FROM `clientes`;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`COD_CLIENTE`, `CIF_DNI`, `RAZON_SOCIAL`, `DOMICILIO_SOCIAL`, `CIUDAD`, `EMAIL`, `TELEFONO`, `NICK`, `CONTRASEÑA`, `ESTADO`) VALUES
	(1, 'test', 'aaa', 'test', 'test', 'aaa@test.com', '1234', 'test', 'test', 'n'),
	(2, 'aaaaaa', 'aaaaaaaaaa', 'aaaaaaaaaa', 'aaaaaa', 'a', 'sasaaa@gmail.com', 'aaaaa', 'aaaaa', 'n');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `COD_FACTURA` varchar(50) NOT NULL,
  `COD_CLIENTE` int(11) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `DESCUENTO_FACTURA` int(11) DEFAULT NULL,
  `CONCEPTO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_FACTURA`),
  KEY `COD_CLIENTE` (`COD_CLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.facturas: ~0 rows (approximately)
DELETE FROM `facturas`;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.lineas_albaran
CREATE TABLE IF NOT EXISTS `lineas_albaran` (
  `NUM_LINEA_ALBARAN` int(11) NOT NULL,
  `COD_CLIENTE` int(11) NOT NULL,
  `COD_ALBARAN` int(11) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `DESCUENTO` int(11) DEFAULT NULL,
  `%_IVA` int(11) DEFAULT NULL,
  `NUM_LINEA_PEDIDO` int(11) NOT NULL DEFAULT 0,
  `COD_PEDIDO` int(11) NOT NULL,
  `COD_ARTICULO` int(11) DEFAULT NULL,
  `COD_USUARIO_GESTION` int(11) DEFAULT 0,
  PRIMARY KEY (`NUM_LINEA_ALBARAN`,`COD_ALBARAN`),
  KEY `Index 2` (`COD_USUARIO_GESTION`),
  KEY `Index 3` (`NUM_LINEA_PEDIDO`,`COD_PEDIDO`),
  KEY `COD_ARTICULO` (`COD_ARTICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.lineas_albaran: ~0 rows (approximately)
DELETE FROM `lineas_albaran`;
/*!40000 ALTER TABLE `lineas_albaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `lineas_albaran` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.lineas_facturas
CREATE TABLE IF NOT EXISTS `lineas_facturas` (
  `NUM_LINEA_FACTURA` int(11) NOT NULL,
  `COD_ALBARAN` int(11) NOT NULL,
  `COD_CLIENTE` int(11) NOT NULL,
  `COD_FACTURA` int(11) NOT NULL DEFAULT 0,
  `NUM_LINEA_ALBARAN` int(11) NOT NULL,
  `COD_ARTICULO` int(11) DEFAULT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `DESCUENTO` int(11) DEFAULT NULL,
  `%_IVA` int(11) DEFAULT NULL,
  `COD_USUARIO_GESTION` int(11) DEFAULT 0,
  PRIMARY KEY (`NUM_LINEA_FACTURA`,`COD_FACTURA`),
  KEY `Index 2` (`COD_USUARIO_GESTION`),
  KEY `COD_ARTICULO` (`COD_ARTICULO`),
  KEY `Index 3` (`NUM_LINEA_ALBARAN`,`COD_ALBARAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.lineas_facturas: ~0 rows (approximately)
DELETE FROM `lineas_facturas`;
/*!40000 ALTER TABLE `lineas_facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `lineas_facturas` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.lineas_pedidos
CREATE TABLE IF NOT EXISTS `lineas_pedidos` (
  `NUM_LINEA_PEDIDO` int(11) NOT NULL DEFAULT 0,
  `COD_CLIENTE` int(11) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `COD_USUARIO_GESTION` int(11) DEFAULT 0,
  `COD_PEDIDO` int(11) NOT NULL,
  `COD_ARTICULO` int(11) DEFAULT NULL,
  PRIMARY KEY (`NUM_LINEA_PEDIDO`,`COD_PEDIDO`),
  KEY `Index 2` (`COD_PEDIDO`),
  KEY `Index 3` (`COD_ARTICULO`),
  KEY `Index 4` (`COD_USUARIO_GESTION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.lineas_pedidos: ~6 rows (approximately)
DELETE FROM `lineas_pedidos`;
/*!40000 ALTER TABLE `lineas_pedidos` DISABLE KEYS */;
INSERT INTO `lineas_pedidos` (`NUM_LINEA_PEDIDO`, `COD_CLIENTE`, `PRECIO`, `CANTIDAD`, `COD_USUARIO_GESTION`, `COD_PEDIDO`, `COD_ARTICULO`) VALUES
	(0, 0, 8, 4, 1, 2, 1),
	(0, 1, 8, 1, NULL, 8, 1),
	(0, 1, 8, 4, NULL, 9, 1),
	(1, 0, 4, 2, 1, 2, 2),
	(1, 1, 6, 3, NULL, 9, 2),
	(2, 1, 18, 9, NULL, 9, 1);
/*!40000 ALTER TABLE `lineas_pedidos` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `COD_PEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CLIENTE` int(11) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `GENERADO_POR_CLIENTE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_PEDIDO`),
  KEY `COD_CLIENTE` (`COD_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.pedidos: ~2 rows (approximately)
DELETE FROM `pedidos`;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`COD_PEDIDO`, `COD_CLIENTE`, `FECHA`, `GENERADO_POR_CLIENTE`) VALUES
	(1, 0, '2020-03-03 19:50:50', 'SI'),
	(2, 0, '2020-03-04 00:49:39', 'NO');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.solicitudes
CREATE TABLE IF NOT EXISTS `solicitudes` (
  `ID_SOLICITUD` int(11) NOT NULL AUTO_INCREMENT,
  `CIF_DNI` varchar(9) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(200) DEFAULT NULL,
  `DOMICILIO_SOCIAL` varchar(200) DEFAULT NULL,
  `CIUDAD` varchar(50) NOT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(50) DEFAULT NULL,
  `NICK` varchar(50) NOT NULL,
  `CONTRASEÑA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD`),
  UNIQUE KEY `NICK` (`NICK`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.solicitudes: ~0 rows (approximately)
DELETE FROM `solicitudes`;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
INSERT INTO `solicitudes` (`ID_SOLICITUD`, `CIF_DNI`, `RAZON_SOCIAL`, `DOMICILIO_SOCIAL`, `CIUDAD`, `EMAIL`, `TELEFONO`, `NICK`, `CONTRASEÑA`) VALUES
	(1, 'aaa', 'aaa', 'dsds', 'xsfads', 'das%40gmail.com', '52435432', 'ujyithjgkkghj', 'FGHJFJGH'),
	(3, 'aaa', 'aaa', 'dsds', 'xsfads', 'fghjs%40gmail.com', '52435432', 'hjgfj', 'hgfj'),
	(4, 'aaa', 'aaa', 'dsds', 'xsfads', 'fghjs%40gmail.com', '52435432', 'hjgfjghkj', 'dfghfgh');
/*!40000 ALTER TABLE `solicitudes` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.usuarios_gestion
CREATE TABLE IF NOT EXISTS `usuarios_gestion` (
  `COD_USUARIO_GESTION` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `NICK` varchar(50) NOT NULL,
  `CONTRASEÑA` varchar(50) NOT NULL,
  PRIMARY KEY (`COD_USUARIO_GESTION`),
  UNIQUE KEY `Index 1` (`NICK`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.usuarios_gestion: ~1 rows (approximately)
DELETE FROM `usuarios_gestion`;
/*!40000 ALTER TABLE `usuarios_gestion` DISABLE KEYS */;
INSERT INTO `usuarios_gestion` (`COD_USUARIO_GESTION`, `NOMBRE`, `NICK`, `CONTRASEÑA`) VALUES
	(1, 'test', 'test', 'test');
/*!40000 ALTER TABLE `usuarios_gestion` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
