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
  `ID_ACCESO` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_HORA_ACCESO` datetime DEFAULT NULL,
  `FECHA_HORA_SALIDA` datetime DEFAULT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ACCESO`),
  KEY `Index 2` (`COD_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.accesos: ~10 rows (approximately)
DELETE FROM `accesos`;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
INSERT INTO `accesos` (`ID_ACCESO`, `FECHA_HORA_ACCESO`, `FECHA_HORA_SALIDA`, `COD_USUARIO`) VALUES
	(1, '2020-05-13 21:40:45', '2020-05-13 22:17:10', 1),
	(2, '2020-05-14 13:21:57', '2020-05-14 20:30:24', 1),
	(3, '2020-05-14 14:11:35', '2020-05-14 20:30:24', 1),
	(4, '2020-05-14 20:44:28', '2020-05-14 20:52:11', 1),
	(5, '2020-05-14 20:53:24', '2020-05-14 21:10:52', 1),
	(6, '2020-05-14 21:22:10', '2020-05-14 21:22:16', 1),
	(7, '2020-05-14 21:22:52', '2020-05-15 12:25:34', 1),
	(8, '2020-05-16 14:35:03', '2020-05-17 18:15:55', 1),
	(9, '2020-05-17 12:58:47', '2020-05-17 18:15:55', 1),
	(10, '2020-05-17 18:14:15', '2020-05-17 18:15:55', 1),
	(11, '2020-05-17 19:08:22', '2020-05-17 19:43:45', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.albaranes: ~10 rows (approximately)
DELETE FROM `albaranes`;
/*!40000 ALTER TABLE `albaranes` DISABLE KEYS */;
INSERT INTO `albaranes` (`COD_ALBARAN`, `COD_CLIENTE`, `FECHA`, `GENERADO_DE_PEDIDO`, `CONCEPTO`) VALUES
	(28, 1, '2020-05-17 12:59:51', 'SI', ''),
	(29, 0, '2020-05-17 13:49:41', 'SI', 'parte 1'),
	(30, 0, '2020-05-17 13:49:41', 'SI', 'parte 1'),
	(31, 0, '2020-05-17 13:49:54', 'SI', 'parte 2'),
	(32, 0, '2020-05-17 13:49:54', 'SI', 'parte 2'),
	(34, 0, '2020-05-17 13:50:06', 'SI', 'parte 3'),
	(36, 0, '2020-05-17 13:50:18', 'SI', 'parte 4'),
	(37, 0, '2020-05-17 13:50:30', 'SI', 'parte 5'),
	(38, 34, '2020-05-17 19:10:06', 'SI', 'concepto'),
	(39, 34, '2020-05-17 19:10:06', 'SI', 'concepto');
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
  `ACTIVO` enum('s','n') DEFAULT 'n',
  PRIMARY KEY (`COD_ARTICULO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.articulos: ~2 rows (approximately)
DELETE FROM `articulos`;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` (`COD_ARTICULO`, `NOMBRE`, `DESCRIPCION`, `PRECIO`, `DESCUENTO`, `IVA`, `IMAGEN`, `ACTIVO`) VALUES
	(1, 'Bolsa de patatas', 'Sabor queso', 5, 0, 13, 'https://cdn.grupoelcorteingles.es/SGFM/dctm/MEDIA03/201909/11/00120952800199____1__600x600.jpg', 's'),
	(2, 'Botella de agua mineral', 'Muy fresca', 3, 0, 14, 'https://folder.es/41611-large_default/caja-de-35-botellas-de-agua-nestle-aquarel-033l.jpg', 's'),
	(4, 'Cosa misteriosa', 'Muy horrible', 2344, 12, 12, '', 'n');
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `COD_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `CIF_DNI` varchar(50) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(50) DEFAULT NULL,
  `DOMICILIO_SOCIAL` varchar(50) DEFAULT NULL,
  `CIUDAD` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `NICK` varchar(50) NOT NULL,
  `CONTRASEÑA` varchar(50) NOT NULL,
  `ESTADO` enum('s','n') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`COD_CLIENTE`),
  UNIQUE KEY `Index 1` (`NICK`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.clientes: ~5 rows (approximately)
DELETE FROM `clientes`;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`COD_CLIENTE`, `CIF_DNI`, `RAZON_SOCIAL`, `DOMICILIO_SOCIAL`, `CIUDAD`, `TELEFONO`, `EMAIL`, `NICK`, `CONTRASEÑA`, `ESTADO`) VALUES
	(0, 'test', 'sss', 'test', 'test', '34243234', 'aaa@test.com', 'test', 'test', 's'),
	(1, 'anton', '2032030', '2010130', 'dskadaks', '34342234', 'anton@gmail.com', 'antonfernandez', 'asdf', 'n'),
	(2, 'aaaaaa', 'aaaaaaaaaa', 'aaaaaaaaaa', 'aaaaaa', '34223434', 'dfefds@gmail.com', 'aaaaa', 'aaaaa', 'n'),
	(3, 'aaa', 'aaa', 'aaa', 'aaa', '123312123', 'aaa@gmail.com', 'antonio', 'test', 'n'),
	(34, '439422394', 'Vigas y Andamios Jimenez S.L.', 'C/Andrés Montalbán, 23', 'Albatera', '634030210', 'vigasyandamiosjimenez@gmail.com', 'vigasjmnz', '123456', 'n'),
	(35, '342324432', 'Consultas%20Alvarez', 'Mi%20casa', 'Albal', 'fghghffg%40gmail.com', '231123123', 'alvcons', '1234', 'n'),
	(36, 'eeee', 'eeeeeee', 'eeeeeeee', 'eeeeeeeeeeee', 'eeeeee@gmail.com', '3124123', 'eeee', 'eeee', 'n');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `COD_FACTURA` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CLIENTE` int(11) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `DESCUENTO_FACTURA` int(11) DEFAULT NULL,
  `CONCEPTO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_FACTURA`),
  KEY `COD_CLIENTE` (`COD_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.facturas: ~1 rows (approximately)
DELETE FROM `facturas`;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
INSERT INTO `facturas` (`COD_FACTURA`, `COD_CLIENTE`, `FECHA`, `DESCUENTO_FACTURA`, `CONCEPTO`) VALUES
	(24, 0, '2020-05-17 19:42:31', 0, 'dsad');
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.lineas_albaran
CREATE TABLE IF NOT EXISTS `lineas_albaran` (
  `NUM_LINEA_ALBARAN` int(11) NOT NULL,
  `COD_CLIENTE` int(11) NOT NULL,
  `COD_ALBARAN` int(11) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `DESCUENTO` int(11) DEFAULT NULL,
  `IVA` int(11) DEFAULT NULL,
  `NUM_LINEA_PEDIDO` int(11) NOT NULL DEFAULT 0,
  `COD_PEDIDO` int(11) NOT NULL,
  `COD_ARTICULO` int(11) DEFAULT NULL,
  `COD_USUARIO_GESTION` int(11) DEFAULT 0,
  PRIMARY KEY (`COD_ALBARAN`,`NUM_LINEA_ALBARAN`),
  KEY `Index 2` (`COD_USUARIO_GESTION`),
  KEY `Index 3` (`NUM_LINEA_PEDIDO`,`COD_PEDIDO`),
  KEY `COD_ARTICULO` (`COD_ARTICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.lineas_albaran: ~10 rows (approximately)
DELETE FROM `lineas_albaran`;
/*!40000 ALTER TABLE `lineas_albaran` DISABLE KEYS */;
INSERT INTO `lineas_albaran` (`NUM_LINEA_ALBARAN`, `COD_CLIENTE`, `COD_ALBARAN`, `PRECIO`, `CANTIDAD`, `DESCUENTO`, `IVA`, `NUM_LINEA_PEDIDO`, `COD_PEDIDO`, `COD_ARTICULO`, `COD_USUARIO_GESTION`) VALUES
	(0, 1, 28, 211, 12, 0, 14, 0, 16, 1, 1),
	(0, 0, 29, 215, 5, 0, 14, 0, 17, 1, 1),
	(1, 0, 30, 6, 2, 0, 14, 1, 17, 2, 1),
	(0, 0, 31, 20, 4, 0, 14, 0, 18, 1, 1),
	(1, 0, 32, 6, 2, 0, 14, 1, 18, 2, 1),
	(1, 0, 34, 18, 6, 0, 14, 0, 19, 2, 1),
	(1, 0, 36, 12, 4, 0, 14, 0, 20, 2, 1),
	(0, 0, 37, 10, 2, 0, 14, 0, 21, 1, 1),
	(0, 34, 38, 20, 4, 0, 14, 0, 22, 1, 1),
	(1, 34, 39, 6, 2, 0, 14, 1, 22, 2, 1);
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
  `IVA` int(11) DEFAULT NULL,
  `COD_USUARIO_GESTION` int(11) DEFAULT 0,
  PRIMARY KEY (`NUM_LINEA_FACTURA`,`COD_FACTURA`),
  KEY `Index 2` (`COD_USUARIO_GESTION`),
  KEY `COD_ARTICULO` (`COD_ARTICULO`),
  KEY `Index 3` (`NUM_LINEA_ALBARAN`,`COD_ALBARAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.lineas_facturas: ~7 rows (approximately)
DELETE FROM `lineas_facturas`;
/*!40000 ALTER TABLE `lineas_facturas` DISABLE KEYS */;
INSERT INTO `lineas_facturas` (`NUM_LINEA_FACTURA`, `COD_ALBARAN`, `COD_CLIENTE`, `COD_FACTURA`, `NUM_LINEA_ALBARAN`, `COD_ARTICULO`, `PRECIO`, `CANTIDAD`, `DESCUENTO`, `IVA`, `COD_USUARIO_GESTION`) VALUES
	(0, 29, 0, 24, 0, 1, 215, 5, 0, 14, 1),
	(1, 30, 0, 24, 1, 2, 6, 2, 0, 14, 1),
	(2, 32, 0, 24, 1, 2, 6, 2, 0, 14, 1),
	(3, 36, 0, 24, 1, 2, 12, 4, 0, 14, 1);
/*!40000 ALTER TABLE `lineas_facturas` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.lineas_pedidos
CREATE TABLE IF NOT EXISTS `lineas_pedidos` (
  `NUM_LINEA_PEDIDO` int(11) NOT NULL DEFAULT 0,
  `COD_CLIENTE` int(11) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `COD_USUARIO_GESTION` int(11) DEFAULT 0,
  `COD_PEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ARTICULO` int(11) DEFAULT NULL,
  PRIMARY KEY (`NUM_LINEA_PEDIDO`,`COD_PEDIDO`),
  KEY `Index 2` (`COD_PEDIDO`),
  KEY `Index 3` (`COD_ARTICULO`),
  KEY `Index 4` (`COD_USUARIO_GESTION`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.lineas_pedidos: ~11 rows (approximately)
DELETE FROM `lineas_pedidos`;
/*!40000 ALTER TABLE `lineas_pedidos` DISABLE KEYS */;
INSERT INTO `lineas_pedidos` (`NUM_LINEA_PEDIDO`, `COD_CLIENTE`, `PRECIO`, `CANTIDAD`, `COD_USUARIO_GESTION`, `COD_PEDIDO`, `COD_ARTICULO`) VALUES
	(0, 0, 6, 2, 1, 15, 2),
	(0, 1, 720, 12, 1, 16, 1),
	(0, 0, 75, 5, 1, 17, 1),
	(0, 0, 20, 4, 1, 18, 1),
	(0, 0, 18, 6, 1, 19, 2),
	(0, 0, 12, 4, 1, 20, 2),
	(0, 0, 10, 2, 1, 21, 1),
	(0, 34, 20, 4, NULL, 22, 1),
	(0, 34, 12, 4, 1, 23, 2),
	(1, 0, 6, 2, 1, 17, 2),
	(1, 0, 6, 2, 1, 18, 2),
	(1, 0, 5, 1, 1, 19, 1),
	(1, 0, 45, 9, 1, 20, 1),
	(1, 34, 6, 2, NULL, 22, 2),
	(1, 34, 12, 4, NULL, 23, 2);
/*!40000 ALTER TABLE `lineas_pedidos` ENABLE KEYS */;

-- Dumping structure for table trabajo_daw.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `COD_PEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CLIENTE` int(11) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `GENERADO_POR_CLIENTE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_PEDIDO`),
  KEY `COD_CLIENTE` (`COD_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.pedidos: ~7 rows (approximately)
DELETE FROM `pedidos`;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`COD_PEDIDO`, `COD_CLIENTE`, `FECHA`, `GENERADO_POR_CLIENTE`) VALUES
	(15, 0, '2020-05-14 14:32:26', 'NO'),
	(16, 1, '2020-05-14 21:12:58', 'SI'),
	(17, 0, '2020-05-15 15:20:44', 'NO'),
	(18, 0, '2020-05-17 13:48:57', 'NO'),
	(19, 0, '2020-05-17 13:49:10', 'NO'),
	(20, 0, '2020-05-17 13:49:18', 'NO'),
	(21, 0, '2020-05-17 13:49:22', 'NO'),
	(22, 34, '2020-05-17 18:49:32', 'SI'),
	(23, 34, '2020-05-17 18:49:39', 'SI');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table trabajo_daw.solicitudes: ~0 rows (approximately)
DELETE FROM `solicitudes`;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
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

-- Dumping data for table trabajo_daw.usuarios_gestion: ~0 rows (approximately)
DELETE FROM `usuarios_gestion`;
/*!40000 ALTER TABLE `usuarios_gestion` DISABLE KEYS */;
INSERT INTO `usuarios_gestion` (`COD_USUARIO_GESTION`, `NOMBRE`, `NICK`, `CONTRASEÑA`) VALUES
	(1, 'test', 'test', 'test');
/*!40000 ALTER TABLE `usuarios_gestion` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
