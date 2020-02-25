-- phpMyAdmin SQL Dumpa
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2020 at 11:15 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trabajo_daw`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesos`
--

CREATE TABLE `accesos` (
  `ID_ACCESO` varchar(50) NOT NULL,
  `FECHA_HORA_ACCESO` datetime DEFAULT NULL,
  `FECHA_HORA_SALIDA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accesos`
--

INSERT INTO `accesos` (`ID_ACCESO`, `FECHA_HORA_ACCESO`, `FECHA_HORA_SALIDA`) VALUES
('', NULL, NULL),
('-- -----------------------------------------------', NULL, NULL),
('-- Data exporting was unselected.', NULL, NULL),
('-- HeidiSQL Version:             10.3.0.5771', NULL, NULL),
('-- Host:                         127.0.0.1', NULL, NULL),
('-- Server OS:                    Win64', NULL, NULL),
('-- Server version:               10.4.11-MariaDB -', NULL, NULL),
('/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY', '0000-00-00 00:00:00', NULL),
('/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KE', '0000-00-00 00:00:00', NULL),
('/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER', '0000-00-00 00:00:00', NULL),
('/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'N', '0000-00-00 00:00:00', NULL),
('/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_S', '0000-00-00 00:00:00', NULL),
('/*!40101 SET NAMES utf8 */', '0000-00-00 00:00:00', NULL),
('/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, \'\') */', '0000-00-00 00:00:00', NULL),
('/*!50503 SET NAMES utf8mb4 */', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `albaranes`
--

CREATE TABLE `albaranes` (
  `COD_ALBARAN` varchar(50) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `GENERADO_DE_PEDIDO` varchar(50) DEFAULT NULL,
  `CONCEPTO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `articulos`
--

CREATE TABLE `articulos` (
  `COD_ARTICULO` varchar(50) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(50) DEFAULT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `DESCUENTO` int(3) DEFAULT NULL,
  `%_IVA` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `COD_CLIENTE` varchar(50) NOT NULL,
  `CIF_DNI` varchar(50) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(50) DEFAULT NULL,
  `DOMICILIO_SOCIAL` varchar(50) DEFAULT NULL,
  `CIUDAD` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(50) DEFAULT NULL,
  `NICK` varchar(50) NOT NULL,
  `CONTRASEÑA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `facturas`
--

CREATE TABLE `facturas` (
  `COD_FACTURA` varchar(50) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `DESCUENTO_FACTURA` int(11) DEFAULT NULL,
  `CONCEPTO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lineas_albaran`
--

CREATE TABLE `lineas_albaran` (
  `NUM_ALBARAN` int(11) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `DESCUENTO` int(11) DEFAULT NULL,
  `%_IVA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lineas_facturas`
--

CREATE TABLE `lineas_facturas` (
  `NUM_LINEA_FACTURA` int(11) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `DESCUENTO` int(11) DEFAULT NULL,
  `%_IVA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `NUM_LINEA_PEDIDO` varchar(50) NOT NULL,
  `PRECIO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `COD_PEDIDO` varchar(50) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  `GENERADO_POR_CLIENTE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `solicitudes`
--

CREATE TABLE `solicitudes` (
  `ID_SOLICITUD` varchar(10) NOT NULL,
  `CIF_DNI` varchar(9) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(200) DEFAULT NULL,
  `DOMICILIO_SOCIAL` varchar(200) DEFAULT NULL,
  `CIUDAD` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(30) DEFAULT NULL,
  `NICK` varchar(30) NOT NULL,
  `CONTRASEÑA` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_gestion`
--

CREATE TABLE `usuarios_gestion` (
  `COD_USUARIO_GESTION` varchar(50) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `NICK` varchar(50) NOT NULL,
  `CONTRASEÑA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`ID_ACCESO`);

--
-- Indexes for table `albaranes`
--
ALTER TABLE `albaranes`
  ADD PRIMARY KEY (`COD_ALBARAN`);

--
-- Indexes for table `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`COD_ARTICULO`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`COD_CLIENTE`),
  ADD UNIQUE KEY `Index 1` (`NICK`);

--
-- Indexes for table `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`COD_FACTURA`);

--
-- Indexes for table `lineas_albaran`
--
ALTER TABLE `lineas_albaran`
  ADD PRIMARY KEY (`NUM_ALBARAN`);

--
-- Indexes for table `lineas_facturas`
--
ALTER TABLE `lineas_facturas`
  ADD PRIMARY KEY (`NUM_LINEA_FACTURA`);

--
-- Indexes for table `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`NUM_LINEA_PEDIDO`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`COD_PEDIDO`);

--
-- Indexes for table `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`ID_SOLICITUD`),
  ADD UNIQUE KEY `NICK` (`NICK`);

--
-- Indexes for table `usuarios_gestion`
--
ALTER TABLE `usuarios_gestion`
  ADD PRIMARY KEY (`COD_USUARIO_GESTION`),
  ADD UNIQUE KEY `Index 1` (`NICK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
