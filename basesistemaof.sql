-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2026 at 06:01 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemaof`
--

-- --------------------------------------------------------

--
-- Table structure for table `alcance`
--

CREATE TABLE `alcance` (
  `id_alcance` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `fecha_alcance` date DEFAULT NULL,
  `unid_med` varchar(30) DEFAULT NULL,
  `desc_alcance` varchar(254) DEFAULT NULL,
  `cant_alcance` decimal(15,2) DEFAULT NULL,
  `cost_unit` decimal(15,2) DEFAULT NULL,
  `cost_mater` decimal(15,2) DEFAULT NULL,
  `cost_mobra` decimal(15,2) DEFAULT NULL,
  `cost_otros` decimal(15,2) DEFAULT NULL,
  `cost_isv` decimal(15,2) DEFAULT NULL,
  `cost_subtot` decimal(15,2) DEFAULT NULL,
  `cost_impre` decimal(15,2) DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL,
  `porc_util` decimal(10,2) DEFAULT NULL,
  `valor_util` decimal(15,2) DEFAULT NULL,
  `precio_subtot` decimal(15,2) DEFAULT NULL,
  `precio_isv` decimal(15,2) DEFAULT NULL,
  `precio_total` decimal(15,2) DEFAULT NULL,
  `oferta_subtot` decimal(15,2) DEFAULT NULL,
  `oferta_isv` decimal(15,2) DEFAULT NULL,
  `oferta_total` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alcance`
--

INSERT INTO `alcance` (`id_alcance`, `id_proy`, `cod_proy`, `id_linea`, `fecha_alcance`, `unid_med`, `desc_alcance`, `cant_alcance`, `cost_unit`, `cost_mater`, `cost_mobra`, `cost_otros`, `cost_isv`, `cost_subtot`, `cost_impre`, `cost_total`, `porc_util`, `valor_util`, `precio_subtot`, `precio_isv`, `precio_total`, `oferta_subtot`, `oferta_isv`, `oferta_total`) VALUES
(00014, 00015, 'PI-POLARIS', 00004, '2025-10-07', 'global', 'Reparaciones, mantenimiento y pintura en sucursal', 1.00, 0.00, 64113.00, 51250.00, 0.00, NULL, 115363.00, NULL, 115363.00, 82.29, 94927.00, 210290.00, 0.00, 210290.00, NULL, NULL, NULL),
(00015, 00015, 'PI-POLARIS', 00004, '2026-03-05', 'contrato', 'Impremeabilización', 1.00, 0.00, 5000.00, 5000.00, 1000.00, NULL, 11000.00, NULL, 11000.00, 83.00, 9130.00, 20130.00, 0.00, 20130.00, NULL, NULL, NULL),
(00016, 00015, 'PI-POLARIS', 00004, '2026-03-24', 'Contrato', 'Obra Gris', 1.00, 0.00, 25000.00, 15000.00, 2000.00, NULL, 42000.00, NULL, 42000.00, 80.95, 34000.00, 76000.00, 0.00, 76000.00, NULL, NULL, NULL),
(00017, 00016, 'BACTEG0001', 00001, '2026-03-24', 'Contrato', 'AAAAAAAAAAAA', 1.00, 0.00, 5000.00, 5000.00, 2000.00, NULL, 12000.00, NULL, 12000.00, 75.00, 9000.00, 21000.00, 0.00, 21000.00, NULL, NULL, NULL),
(00018, 00016, 'BACTEG0001', 00001, '2026-03-24', 'Unidad', 'DAMDKAMSKLDMAKLMKLDMAKLD', 1.00, 0.00, 10000.00, 5000.00, 3000.00, NULL, 18000.00, NULL, 18000.00, 80.00, 14400.00, 32400.00, 0.00, 32400.00, NULL, NULL, NULL),
(00021, 00017, 'BCHSPS-02', 00006, '2026-04-23', 'GLOBAL', 'Demolición y construcción de muro perimetral incluye verja metálica', 1.00, 0.00, 256780.00, 307460.00, 37991.80, NULL, 602231.80, NULL, 602231.80, 62.22, 374708.63, 976940.43, 0.00, 976940.43, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id_clie` int(5) UNSIGNED ZEROFILL NOT NULL,
  `nom_clie` varchar(100) NOT NULL,
  `rtn_clie` varchar(100) DEFAULT NULL,
  `contacto_clie` varchar(100) DEFAULT NULL,
  `dir_clie` varchar(254) DEFAULT NULL,
  `tel_clie` varchar(20) DEFAULT NULL,
  `email_clie` varchar(100) DEFAULT NULL,
  `fecha_ing` date DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') DEFAULT 'Activo',
  `saldo_ant` decimal(15,2) DEFAULT '0.00',
  `cargos` decimal(15,2) DEFAULT '0.00',
  `abonos` decimal(15,2) DEFAULT '0.00',
  `saldo_act` decimal(15,2) DEFAULT '0.00',
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_clie`, `nom_clie`, `rtn_clie`, `contacto_clie`, `dir_clie`, `tel_clie`, `email_clie`, `fecha_ing`, `estatus`, `saldo_ant`, `cargos`, `abonos`, `saldo_act`, `fecha_hora`) VALUES
(00001, 'INVERSIONES IRIDIO', '08019015722330', 'CIPRESES', 'Tegucigalpa M.D.C.', '', '', '2025-03-24', 'Activo', 0.00, 0.00, 0.00, 0.00, NULL),
(00002, 'INVERSIONES COBALTO', '08019015722318', 'COBALTO', 'Tegucigalpa M.D.C.', '', '', '2025-03-24', 'Activo', 0.00, 0.00, 0.00, 0.00, NULL),
(00003, 'INVERSIONES TITANIO', '08019015722351', '', 'Tegucigalpa M.D.C.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-25 03:57:42'),
(00004, 'INVERSIONES ATIMA', '08019017958274', '', 'Tegucigalpa M.D.C.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-25 04:21:00'),
(00005, 'INVERSIONES NAOS', '08019023502584', '', 'Tegucigalpa M.D.C.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-25 04:26:57'),
(00006, 'GRUPO DEWARE S.A.', '03019008133451', 'DEWARE', 'Tegucigalpa M.D.C.', '', '', '2025-05-25', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-25 23:55:53'),
(00007, 'BANCO CENTRAL DE HONDURAS', '08019995284049', '', 'Centro Cívico Gubernamental, Tegucigalpa, Honduras', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:13:14'),
(00008, 'BAC CREDOMATIC', '08019995222486', '', 'Boulevard Suyapa, Avenida Costa Rica, frente a Emisoras Unidas.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:16:31'),
(00009, 'ROTULOS PROFESIONALES S.A. DE C.V.', '08019003245467', '', 'Carretera a Aldea Mateo Km 6, Tegucigalpa, Honduras.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:17:55'),
(00010, 'CONDOMIO METROPOLIS', '08019012498249', '', 'Blv Suyapa Fte Emisoras Unidas Tegucigalpa, Honduras', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:18:57'),
(00011, 'CONDOMINIOS MORAZAN', '08019015722382', '', 'Boulevard Morazán de Tegucigalpa, Honduras, frente a la Cooperación Española', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:19:56'),
(00012, 'CONDOMINIO ATENEA', '08019014648645', '', 'Blv Suyapa Fte Emisoras Unidas Tegucigalpa, Honduras', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:21:06'),
(00013, 'INVERSIONES CELAQUE', '08019015722362', '', 'Tegucigalpa M.D.C.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:21:55'),
(00014, 'INVERSIONES MORAZAN', '08019013554227', '', 'Tegucigalpa M.D.C.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:52:50'),
(00015, 'ADMINISTRACION Y SERVICIOS  S.A. DE C.V.', '08019004012719', '', 'Boulevard Juan Pablo II, frente al Hotel Real Intercontinental, en la zona de la Calle El Roble', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:53:57'),
(00016, 'INVERSIONES DIACO S. DE R.L.', '08019010298080', '', 'Tegucigalpa M.D.C.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:55:00'),
(00017, 'INVERSIONES M2F', '08019012445574', '', 'Torre Metropolis, Tegucigalpa.', '', '', '2025-05-27', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-05-27 12:57:08'),
(00023, 'POLARIS INTERNACIONAL S DE R.L.', '08019999401562', 'POLARIS', 'San Pedro Sula', '', '', '2025-08-12', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-08-12 14:06:38'),
(00024, 'LOTEHLSA', '08019998381114', 'LOTO', 'Blvrd Juan Pablo II', '', '', '2025-08-14', 'Activo', 0.00, 0.00, 0.00, 0.00, '2025-08-14 18:00:04'),
(00025, 'INVERSIONES ARGON', '08019015722340', '', 'Tegucigalpa M.D.C.', '', '', '2026-04-24', 'Activo', 0.00, 0.00, 0.00, 0.00, '2026-04-24 16:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `compras`
--

CREATE TABLE `compras` (
  `id_comp` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_comp` varchar(10) NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_prov` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_ocompra` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `desc_comp` varchar(254) DEFAULT NULL,
  `fecha_comp` date DEFAULT NULL,
  `subtot_comp` decimal(15,2) DEFAULT NULL,
  `isv_comp` decimal(15,2) DEFAULT NULL,
  `total_comp` decimal(15,2) DEFAULT NULL,
  `id_empresa` int(5) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `costos`
--

CREATE TABLE `costos` (
  `id_costo` int(5) UNSIGNED ZEROFILL NOT NULL,
  `desc_costo` varchar(150) NOT NULL,
  `porc_costo` decimal(15,2) DEFAULT NULL,
  `tipo_costo` enum('Directo','Indirecto') NOT NULL DEFAULT 'Directo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `costos`
--

INSERT INTO `costos` (`id_costo`, `desc_costo`, `porc_costo`, `tipo_costo`) VALUES
(00001, 'Supervisión', 0.00, 'Indirecto'),
(00002, 'Aislamiento Electrico', 0.00, 'Indirecto'),
(00003, 'Equipo de Protección', 0.00, 'Directo'),
(00004, 'Limpieza', 0.00, 'Directo'),
(00005, 'Provisión Administrativa 10.7%', 10.70, 'Indirecto'),
(00006, 'Supervisión Especial', 0.00, 'Indirecto'),
(00007, 'Imprevisto material', 0.00, 'Directo'),
(00008, 'Imprevistos contratistas 10%', 10.00, 'Directo'),
(00009, 'Logistica', 0.00, 'Indirecto');

-- --------------------------------------------------------

--
-- Table structure for table `cotiza`
--

CREATE TABLE `cotiza` (
  `id_cotiza` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_cotiza` varchar(10) NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_clie` int(5) UNSIGNED ZEROFILL NOT NULL,
  `desc_cotiza` varchar(254) DEFAULT NULL,
  `fecha_cotiza` date DEFAULT NULL,
  `val_subtot` decimal(15,2) DEFAULT NULL,
  `val_desc` decimal(15,2) DEFAULT NULL,
  `val_isv` decimal(15,2) DEFAULT NULL,
  `val_total` decimal(15,2) DEFAULT NULL,
  `facturado` enum('Si','No') DEFAULT 'No',
  `id_empresa` int(5) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_bank`
--

CREATE TABLE `cuentas_bank` (
  `id_bank` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_bank` varchar(10) NOT NULL,
  `nom_bank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuentas_bank`
--

INSERT INTO `cuentas_bank` (`id_bank`, `cod_bank`, `nom_bank`) VALUES
(00001, '11101001', 'BAC - 730287621'),
(00002, '11101002', 'BAC - 730438151'),
(00003, '11101003', 'BAC - 730523301  '),
(00004, '11101004', 'BAC - 727629381       '),
(00005, '11101005', 'BAC - 751195391    '),
(00006, '11101006', 'FICOHSA - 200000321134          ');

-- --------------------------------------------------------

--
-- Table structure for table `det_alcance`
--

CREATE TABLE `det_alcance` (
  `corre_movto` int(10) UNSIGNED ZEROFILL NOT NULL,
  `id_alcance` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL DEFAULT '',
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_prod` int(10) UNSIGNED ZEROFILL NOT NULL,
  `desc_movto` varchar(254) DEFAULT NULL,
  `cant_movto` decimal(15,2) DEFAULT NULL,
  `cost_unit` decimal(15,2) DEFAULT NULL,
  `cost_subtot` decimal(15,2) DEFAULT NULL,
  `cost_isv` decimal(15,2) DEFAULT NULL,
  `cost_impre` decimal(15,2) DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL,
  `a_isv` enum('Si','No') DEFAULT 'No',
  `unid_movto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det_costos`
--

CREATE TABLE `det_costos` (
  `id_movcost` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_costo` int(5) UNSIGNED ZEROFILL NOT NULL,
  `desc_movcost` varchar(254) DEFAULT NULL,
  `cant_movcost` decimal(15,2) DEFAULT NULL,
  `cost_unit` decimal(15,2) DEFAULT NULL,
  `cost_subtot` decimal(15,2) DEFAULT NULL,
  `cost_isv` decimal(15,2) DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL,
  `cost_impre` decimal(15,2) DEFAULT NULL,
  `porc_util` decimal(10,2) DEFAULT NULL,
  `valor_util` decimal(15,2) DEFAULT NULL,
  `precio_subtot` decimal(15,2) DEFAULT NULL,
  `precio_isv` decimal(15,2) DEFAULT NULL,
  `precio_total` decimal(15,2) DEFAULT NULL,
  `oferta_subtot` decimal(15,2) DEFAULT NULL,
  `oferta_isv` decimal(15,2) DEFAULT NULL,
  `oferta_total` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_costos`
--

INSERT INTO `det_costos` (`id_movcost`, `id_proy`, `cod_proy`, `id_linea`, `id_costo`, `desc_movcost`, `cant_movcost`, `cost_unit`, `cost_subtot`, `cost_isv`, `cost_total`, `cost_impre`, `porc_util`, `valor_util`, `precio_subtot`, `precio_isv`, `precio_total`, `oferta_subtot`, `oferta_isv`, `oferta_total`) VALUES
(00002, 00014, 'POLBER001', 00002, 00007, 'Imprevisto material 3%', 1.00, 6411.30, 6411.30, 0.00, 6411.30, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00005, 00014, 'POLBER001', 00002, 00008, 'Imprevistos contratistas 10%', 1.00, 5125.00, 5125.00, 0.00, 5125.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00006, 00014, 'POLBER001', 00002, 00009, 'Logistica (Camión + Chofer)', 1.00, 5000.00, 5000.00, 0.00, 5000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00007, 00014, 'POLBER001', 00002, 00005, 'Provisión Administrativa 10.7%', 1.00, 22501.03, 22501.03, 0.00, 22501.03, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00009, 00015, 'PI-POLARIS', 00004, 00006, 'Supervisión Especial', 1.00, 5000.00, 5000.00, 0.00, 5000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00010, 00015, 'PI-POLARIS', 00004, 00005, 'Provisión Administrativa 10.7%', 1.00, 22501.03, 22501.03, 0.00, 22501.03, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00011, 00015, 'PI-POLARIS', 00004, 00007, 'Imprevisto material', 1.00, 5125.00, 5125.00, 0.00, 5125.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00012, 00015, 'PI-POLARIS', 00004, 00004, 'Limpieza', 1.00, 1000.00, 1000.00, 0.00, 1000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00013, 00015, 'PI-POLARIS', 00004, 00002, 'Aislamiento Electrico', 1.00, 5000.00, 5000.00, 0.00, 5000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00014, 00017, 'BCHSPS-02', 00006, 00006, 'Supervisión Especial', 1.00, 48846.60, 48846.60, 0.00, 48846.60, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00015, 00017, 'BCHSPS-02', 00006, 00004, 'Limpieza', 1.00, 8500.00, 8500.00, 0.00, 8500.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00016, 00017, 'BCHSPS-02', 00006, 00003, 'Equipo de Protección', 1.00, 8000.00, 8000.00, 0.00, 8000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00017, 00017, 'BCHSPS-02', 00006, 00005, 'Provisión Administrativa 10.7%', 1.00, 104531.72, 104531.72, 0.00, 104531.72, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `det_cotiza`
--

CREATE TABLE `det_cotiza` (
  `corre_item` int(10) UNSIGNED ZEROFILL NOT NULL,
  `id_cotiza` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_prod` int(10) UNSIGNED ZEROFILL NOT NULL,
  `descrip_item` varchar(254) NOT NULL,
  `umed_item` varchar(30) DEFAULT NULL,
  `cant_item` decimal(15,2) DEFAULT NULL,
  `val_unit` decimal(15,2) DEFAULT NULL,
  `val_subtot` decimal(15,2) DEFAULT NULL,
  `porc_desc` decimal(15,2) DEFAULT NULL,
  `val_desc` decimal(15,2) DEFAULT NULL,
  `val_isv` decimal(15,2) DEFAULT NULL,
  `val_total` decimal(15,2) DEFAULT NULL,
  `a_isv` enum('Si','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det_lineas`
--

CREATE TABLE `det_lineas` (
  `ID_PROY` int(5) UNSIGNED ZEROFILL NOT NULL,
  `ID_LINEA` int(5) UNSIGNED ZEROFILL NOT NULL,
  `COD_PROY` varchar(10) NOT NULL,
  `COST_LINEA` decimal(15,2) DEFAULT NULL,
  `CARGO_LINEA` decimal(15,2) DEFAULT NULL,
  `ABONO_LINEA` decimal(15,2) DEFAULT NULL,
  `SALDO_LINEA` decimal(15,2) DEFAULT NULL,
  `cost_subtot` decimal(15,2) DEFAULT NULL,
  `cost_isv` decimal(15,2) DEFAULT NULL,
  `cost_impre` decimal(15,2) DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL,
  `cost_subIN` decimal(15,2) DEFAULT NULL,
  `cost_isvIN` decimal(15,2) DEFAULT NULL,
  `cost_impreIN` decimal(15,2) DEFAULT NULL,
  `cost_totIN` decimal(15,2) DEFAULT NULL,
  `EST_T01` enum('P','F','R','B') DEFAULT 'R',
  `EST_T02` enum('P','F','R','B') DEFAULT 'R',
  `EST_T03` enum('P','F','R','B') DEFAULT 'R',
  `EST_T04` enum('P','F','R','B') DEFAULT 'R',
  `EST_T05` enum('P','F','R','B') DEFAULT 'R',
  `EST_T06` enum('P','F','R','B') DEFAULT 'R',
  `EST_T07` enum('P','F','R','B') DEFAULT 'R',
  `EST_T08` enum('P','F','R','B') DEFAULT 'R',
  `EST_T09` enum('P','F','R','B') DEFAULT 'R',
  `EST_T10` enum('P','F','R','B') DEFAULT 'R',
  `EST_T11` enum('P','F','R','B') DEFAULT 'R',
  `EST_T12` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T01` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T02` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T03` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T04` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T05` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T06` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T07` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T08` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T09` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T10` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T11` enum('P','F','R','B') DEFAULT 'R',
  `ADI_T12` enum('P','F','R','B') DEFAULT 'R'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_lineas`
--

INSERT INTO `det_lineas` (`ID_PROY`, `ID_LINEA`, `COD_PROY`, `COST_LINEA`, `CARGO_LINEA`, `ABONO_LINEA`, `SALDO_LINEA`, `cost_subtot`, `cost_isv`, `cost_impre`, `cost_total`, `cost_subIN`, `cost_isvIN`, `cost_impreIN`, `cost_totIN`, `EST_T01`, `EST_T02`, `EST_T03`, `EST_T04`, `EST_T05`, `EST_T06`, `EST_T07`, `EST_T08`, `EST_T09`, `EST_T10`, `EST_T11`, `EST_T12`, `ADI_T01`, `ADI_T02`, `ADI_T03`, `ADI_T04`, `ADI_T05`, `ADI_T06`, `ADI_T07`, `ADI_T08`, `ADI_T09`, `ADI_T10`, `ADI_T11`, `ADI_T12`) VALUES
(00014, 00002, 'POLBER001', 319037.33, NULL, NULL, NULL, NULL, 0.00, NULL, 280000.00, 39037.33, NULL, 0.00, 39037.33, 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'),
(00014, 00004, 'POLBER001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'),
(00015, 00004, 'PI-POLARIS', 206989.03, NULL, NULL, NULL, NULL, 0.00, NULL, 168363.00, 38626.03, NULL, 0.00, 38626.03, 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'),
(00015, 00002, 'PI-POLARIS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'),
(00016, 00001, 'BACTEG0001', 30000.00, NULL, NULL, NULL, NULL, 0.00, NULL, 30000.00, 0.00, NULL, 0.00, 0.00, 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'),
(00017, 00006, 'BCHSPS-02', 772110.12, NULL, NULL, NULL, NULL, 0.00, NULL, 602231.80, 169878.32, NULL, 0.00, 169878.32, 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `det_ocompra`
--

CREATE TABLE `det_ocompra` (
  `corre_item` int(10) UNSIGNED ZEROFILL NOT NULL,
  `id_ocompra` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_prod` int(10) UNSIGNED ZEROFILL NOT NULL,
  `descrip_item` varchar(254) NOT NULL,
  `umed_item` varchar(30) DEFAULT NULL,
  `cant_item` decimal(15,2) DEFAULT NULL,
  `cost_unit` decimal(15,2) DEFAULT NULL,
  `cost_subtot` decimal(15,2) DEFAULT NULL,
  `cost_isv` decimal(15,2) DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL,
  `a_isv` enum('Si','No') DEFAULT 'No',
  `cant_recib` decimal(15,2) DEFAULT NULL,
  `pend_recib` decimal(15,2) DEFAULT NULL,
  `cant_usada` decimal(15,2) DEFAULT NULL,
  `cant_actual` decimal(15,2) DEFAULT NULL,
  `estatus_item` enum('Pendiente','Anticipo','Completo') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_ocompra`
--

INSERT INTO `det_ocompra` (`corre_item`, `id_ocompra`, `id_proy`, `cod_proy`, `id_linea`, `id_prod`, `descrip_item`, `umed_item`, `cant_item`, `cost_unit`, `cost_subtot`, `cost_isv`, `cost_total`, `a_isv`, `cant_recib`, `pend_recib`, `cant_usada`, `cant_actual`, `estatus_item`) VALUES
(0000000001, 00002, 00014, 'POLBER001', 00002, 0000000006, 'Canal Furring con pestaña', 'Unidad', 500.00, 27.33, 13665.00, 0.00, 13665.00, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000002, 00002, 00014, 'POLBER001', 00002, 0000000002, 'Contratistas', 'Unidad', 100.00, 301.51, 30151.00, 0.00, 30151.00, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000003, 00004, 00015, 'PI-POLARIS', 00004, 0000000006, 'Canal Furring con pestaña', 'Unidad', 10.00, 27.33, 273.30, 0.00, 273.30, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000004, 00004, 00015, 'PI-POLARIS', 00004, 0000000011, 'Masilla high pro cub 28kg', 'Unidad', 10.00, 396.50, 3965.00, 0.00, 3965.00, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000005, 00004, 00015, 'PI-POLARIS', 00004, 0000000020, 'Poste de 2', 'Unidad', 50.00, 31.95, 1597.50, 239.63, 1837.13, 'Si', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000006, 00004, 00015, 'PI-POLARIS', 00004, 0000000002, 'Contratistas para instalación de equipo', 'Unidad', 1.00, 500.00, 500.00, 0.00, 500.00, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000007, 00005, 00015, 'PI-POLARIS', 00004, 0000000014, 'Tornillos para tabla yeso', 'Unidad', 300.00, 827.33, 0.00, 0.00, 0.00, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000008, 00005, 00015, 'PI-POLARIS', 00004, 0000000013, 'Cinta papel  5cmx90 m LFI', 'Unidad', 100.00, 66.50, 6650.00, 0.00, 6650.00, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000009, 00005, 00015, 'PI-POLARIS', 00004, 0000000007, 'Esquinero metálico 1 1/4x10 LM', 'Unidad', 10.00, 14.91, 149.10, 0.00, 149.10, 'No', NULL, NULL, NULL, NULL, 'Pendiente'),
(0000000010, 00004, 00015, 'PI-POLARIS', 00004, 0000000003, 'Lamina Permabase', 'Unidad', 50.00, 799.00, 39950.00, 0.00, 39950.00, 'No', 50.00, 0.00, 50.00, NULL, 'Completo');

-- --------------------------------------------------------

--
-- Table structure for table `det_oentrega`
--

CREATE TABLE `det_oentrega` (
  `id_oentrega` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_item` int UNSIGNED NOT NULL,
  `cod_prod` int NOT NULL,
  `cant_prod` decimal(15,2) DEFAULT NULL,
  `cant_entrega` decimal(15,2) DEFAULT NULL,
  `pend_entrega` decimal(15,2) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det_planilla`
--

CREATE TABLE `det_planilla` (
  `corre_tra` int(10) UNSIGNED ZEROFILL NOT NULL,
  `id_plan` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `desc_tra` varchar(254) DEFAULT NULL,
  `valor_plan` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_planilla`
--

INSERT INTO `det_planilla` (`corre_tra`, `id_plan`, `id_proy`, `cod_proy`, `id_linea`, `desc_tra`, `valor_plan`) VALUES
(0000000013, 00015, 00015, 'PI-POLARIS', 00004, 'Remodelación y pintura sucursal Bermejo', 8000.00),
(0000000014, 00015, 00015, 'PI-POLARIS', 00004, 'Remodelacion y pintura sucursal Bermejo', 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` int(5) UNSIGNED ZEROFILL NOT NULL,
  `nom_empresa` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`id_empresa`, `nom_empresa`) VALUES
(00001, 'SERVICIOS DE CONSTRUCCION O&F S. DE R.L.'),
(00002, 'PINTER S. DE R.L.');

-- --------------------------------------------------------

--
-- Table structure for table `ingenieros`
--

CREATE TABLE `ingenieros` (
  `ID_INGE` int(5) UNSIGNED ZEROFILL NOT NULL,
  `NOM_INGE` varchar(150) NOT NULL,
  `fecha_ing` date DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') DEFAULT 'Activo',
  `CANT_PROY` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingenieros`
--

INSERT INTO `ingenieros` (`ID_INGE`, `NOM_INGE`, `fecha_ing`, `estatus`, `CANT_PROY`) VALUES
(00001, 'DALIA FABIOLA ELVIR RIVERA', '2025-05-26', 'Activo', NULL),
(00002, 'ESTHER ABIGAIL JIMENEZ BAQUEDANO', '2025-05-26', 'Activo', NULL),
(00004, 'CARLOS ORTIZ', '2025-05-26', 'Activo', NULL),
(00005, 'JORGE ALEJANDRO GOMEZ', '2025-05-26', 'Activo', NULL),
(00006, 'ASHLY VELASQUEZ', '2025-05-27', 'Activo', NULL),
(00008, 'LUCIA GABRIELA PORTILLO PINEDA', '2025-10-07', 'Activo', NULL),
(00009, 'SUANY PAOLA MAIRENA NUÑEZ', '2025-10-07', 'Activo', NULL),
(00010, 'AARON WILFREDO BAUTISTA', '2025-10-07', 'Activo', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lineas`
--

CREATE TABLE `lineas` (
  `ID_LINEA` int(5) UNSIGNED ZEROFILL NOT NULL,
  `NOM_LINEA` varchar(150) NOT NULL,
  `COST_LINEA` decimal(15,2) DEFAULT NULL,
  `UMED_LINEA` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lineas`
--

INSERT INTO `lineas` (`ID_LINEA`, `NOM_LINEA`, `COST_LINEA`, `UMED_LINEA`) VALUES
(00001, 'LINEA DE SERVICIO  TABLA YESO', 0.00, 'LN_TYESO                                          '),
(00002, 'LINEA DE  SERVICIO  DE PINTURA', 0.00, 'LN_PINT'),
(00003, 'LINEA DE SERVICIO DE PULIDO', NULL, 'LIN-SELL                                          '),
(00004, 'REMODELACION', NULL, '                                                  '),
(00005, 'IMPERMEABILIZACION', NULL, '                                                  '),
(00006, 'INFRAESTRUCTURA', NULL, '                                                  '),
(00007, 'LIMPIEZA', NULL, '                                                  ');

-- --------------------------------------------------------

--
-- Table structure for table `mano_obra`
--

CREATE TABLE `mano_obra` (
  `id_mo` int(11) UNSIGNED ZEROFILL NOT NULL,
  `desc_mo` varchar(254) NOT NULL,
  `cost_unit` decimal(15,2) NOT NULL,
  `unid_med` varchar(25) DEFAULT NULL,
  `a_isv` enum('Si','No') DEFAULT 'No',
  `val_isv` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orden_entrega`
--

CREATE TABLE `orden_entrega` (
  `id_oentrega` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_ocompra` int UNSIGNED NOT NULL,
  `fecha_oentrega` date NOT NULL,
  `total_oentrega` decimal(10,2) DEFAULT NULL,
  `id_inge` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ord_compras`
--

CREATE TABLE `ord_compras` (
  `id_ocompra` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_ocompra` varchar(10) NOT NULL,
  `id_proy` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_proy` varchar(10) NOT NULL,
  `id_linea` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_prov` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_inge` int(5) UNSIGNED ZEROFILL NOT NULL,
  `fecha_orden` date DEFAULT NULL,
  `cost_subtot` decimal(15,2) DEFAULT NULL,
  `cost_isv` decimal(15,2) DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL,
  `estatus_orden` enum('Pendiente','Aprobada','Anticipo','Cancelada') DEFAULT 'Pendiente',
  `forma_pago` enum('Contado','Credito') DEFAULT 'Credito',
  `estatus_aprob` enum('Si','No') DEFAULT 'No',
  `fecha_aprob` date DEFAULT NULL,
  `nom_aprob` varchar(100) DEFAULT NULL,
  `nom_solicita` varchar(100) DEFAULT NULL,
  `id_empresa` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `abonos` decimal(15,2) DEFAULT '0.00',
  `saldo_act` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ord_compras`
--

INSERT INTO `ord_compras` (`id_ocompra`, `cod_ocompra`, `id_proy`, `cod_proy`, `id_linea`, `id_prov`, `id_inge`, `fecha_orden`, `cost_subtot`, `cost_isv`, `cost_total`, `estatus_orden`, `forma_pago`, `estatus_aprob`, `fecha_aprob`, `nom_aprob`, `nom_solicita`, `id_empresa`, `abonos`, `saldo_act`) VALUES
(00001, 'OC-00001', 00014, 'POLBER001', 00002, 00003, 00001, '2025-10-06', 0.00, 0.00, 0.00, 'Pendiente', 'Credito', 'No', NULL, NULL, 'aaaqa', 00001, 0.00, 0.00),
(00002, 'OC-00002', 00014, 'POLBER001', 00002, 00001, 00004, '2025-10-06', 43816.00, 0.00, 43816.00, 'Pendiente', 'Credito', 'No', NULL, NULL, ',sdlf,lñsd,lñf', 00001, 0.00, 0.00),
(00003, 'OC-00001', 00015, 'PI-POLARIS', 00004, 00005, 00001, '2026-03-05', 0.00, 0.00, 0.00, 'Pendiente', 'Credito', 'No', NULL, NULL, 'Juan Peres', 00001, 0.00, 0.00),
(00004, 'OC-00004', 00015, 'PI-POLARIS', 00004, 00001, 00001, '2026-03-05', 46285.80, 239.63, 46525.43, 'Pendiente', 'Credito', 'Si', '2026-03-05', 'Administrador', 'Juan Perez', 00001, 0.00, 0.00),
(00005, 'OC-00005', 00015, 'PI-POLARIS', 00004, 00001, 00006, '2026-03-24', 6799.10, 0.00, 6799.10, 'Pendiente', 'Credito', 'Si', '2026-03-24', 'Administrador', 'aaaaa', 00001, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `planilla`
--

CREATE TABLE `planilla` (
  `id_plan` int(5) UNSIGNED ZEROFILL NOT NULL,
  `cod_plan` varchar(10) NOT NULL,
  `desc_plan` varchar(254) DEFAULT NULL,
  `cta_bank` varchar(100) DEFAULT NULL,
  `fecha_plan` date DEFAULT NULL,
  `total_plan` decimal(15,2) DEFAULT NULL,
  `autoriza` varchar(100) DEFAULT NULL,
  `id_empresa` int(5) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `planilla`
--

INSERT INTO `planilla` (`id_plan`, `cod_plan`, `desc_plan`, `cta_bank`, `fecha_plan`, `total_plan`, `autoriza`, `id_empresa`) VALUES
(00015, 'PLA-00001', 'PLanilla 21/6/25', 'BAC - 730287621', '2025-10-07', 28000.00, 'Lucia', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_prod` int(10) UNSIGNED ZEROFILL NOT NULL,
  `id_tipo` int(5) UNSIGNED ZEROFILL NOT NULL DEFAULT '00000',
  `cod_prod` varchar(25) NOT NULL,
  `nom_prod` varchar(254) NOT NULL,
  `cod_prov` int(5) UNSIGNED ZEROFILL NOT NULL DEFAULT '00000',
  `descrip` varchar(254) DEFAULT NULL,
  `cost_unit` decimal(15,2) DEFAULT NULL,
  `unid_med` varchar(25) NOT NULL,
  `estatus` enum('Activo','Inactivo') DEFAULT 'Activo',
  `a_isv` enum('Si','No') DEFAULT 'No',
  `val_isv` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_prod`, `id_tipo`, `cod_prod`, `nom_prod`, `cod_prov`, `descrip`, `cost_unit`, `unid_med`, `estatus`, `a_isv`, `val_isv`) VALUES
(0000000001, 00001, 'MT-PC-001', 'Materiales y Productos Varios', 00001, 'Ninguna', 0.00, 'Unidad', 'Activo', 'Si', 0.00),
(0000000002, 00002, 'MO001', 'Contratistas', 00001, '', 301.51, 'Unidad', 'Activo', 'No', 0.00),
(0000000003, 00001, 'TY-013', 'Lamina Permabase', 00001, NULL, 799.00, 'Unidad', 'Activo', 'No', 0.00),
(0000000004, 00001, 'TY-014', 'Angulo 1x1x10 LM', 00001, NULL, 10.73, 'Unidad', 'Activo', 'No', 0.00),
(0000000005, 00001, 'TY-015', 'Canaleta de Carga CRC 0.60', 00001, NULL, 44.06, 'Unidad', 'Activo', 'No', 0.00),
(0000000006, 00001, 'TY-016', 'Canal Furring con pestaña', 00001, NULL, 27.33, 'Unidad', 'Activo', 'No', 0.00),
(0000000007, 00001, 'TY-017', 'Esquinero metálico 1 1/4x10 LM', 00001, NULL, 14.91, 'Unidad', 'Activo', 'No', 0.00),
(0000000008, 00001, 'TY-018', 'Tornillo 1 1/4 PF YR', 00001, NULL, 0.25, 'Unidad', 'Activo', 'No', 0.00),
(0000000009, 00001, 'TY-019', 'Lana de vidrio R11 C/KRAFT', 00001, NULL, 1568.16, 'Unidad', 'Activo', 'No', 0.00),
(0000000010, 00001, 'TY-011', 'lamina regular ', 00001, NULL, 221.99, 'Unidad', 'Activo', 'No', 0.00),
(0000000011, 00001, 'TY-012', 'Masilla high pro cub 28kg', 00001, NULL, 396.50, 'Unidad', 'Activo', 'No', 0.00),
(0000000012, 00001, 'TY-013', 'Masilla secado Rapido 45min', 00001, NULL, 323.05, 'Unidad', 'Activo', 'No', 0.00),
(0000000013, 00001, 'TY-014', 'Cinta papel  5cmx90 m LFI', 00001, NULL, 66.50, 'Unidad', 'Activo', 'No', 0.00),
(0000000014, 00001, 'TY-015', 'Tabla Denglas Gold', 00001, NULL, 827.33, 'Unidad', 'Activo', 'No', 0.00),
(0000000015, 00001, 'TY-016', 'Lana de vidrio', 00001, NULL, 1589.54, 'Unidad', 'Activo', 'No', 0.00),
(0000000016, 00001, 'TY-017', 'LM sky cross tee', 00001, NULL, 6.28, 'Unidad', 'Activo', 'No', 0.00),
(0000000017, 00001, 'TY-018', 'LM sky main tee', 00001, NULL, 40.85, 'Unidad', 'Activo', 'No', 0.00),
(0000000018, 00001, 'TY-019', 'LM sky angulo p/ cielo bla', 00001, NULL, 21.47, 'Unidad', 'Activo', 'No', 0.00),
(0000000019, 00001, 'TY-020', 'Cielo Concorde', 00000, NULL, 92.43, 'unidad', 'Activo', 'No', 0.00),
(0000000020, 00001, 'TY-031', 'Poste de 2', 00001, NULL, 31.95, 'Unidad', 'Activo', 'No', 0.00),
(0000000021, 00001, 'TY-032', 'solera de 2', 00001, NULL, 27.57, 'Unidad', 'Activo', 'No', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id_prov` int(5) UNSIGNED ZEROFILL NOT NULL,
  `nom_prov` varchar(100) NOT NULL,
  `rtn_prov` varchar(100) DEFAULT NULL,
  `contacto_prov` varchar(100) DEFAULT NULL,
  `dir_prov` varchar(254) DEFAULT NULL,
  `tel_prov` varchar(20) DEFAULT NULL,
  `email_prov` varchar(100) DEFAULT NULL,
  `fecha_ing` date DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `saldo_ant` decimal(15,2) DEFAULT NULL,
  `cargos` decimal(15,2) DEFAULT NULL,
  `abonos` decimal(15,2) DEFAULT NULL,
  `saldo_act` decimal(15,2) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id_prov`, `nom_prov`, `rtn_prov`, `contacto_prov`, `dir_prov`, `tel_prov`, `email_prov`, `fecha_ing`, `estatus`, `saldo_ant`, `cargos`, `abonos`, `saldo_act`, `fecha_hora`) VALUES
(00001, 'PROVEEDORES VARIOS', '000000000000', '', '', '', '', '2025-05-26', 'Activo', NULL, NULL, NULL, NULL, '2025-05-26 12:34:59'),
(00002, 'GSQ HONDURAS INTERNACIONAL S.A. (SUR)', '08019002279851', '', '', '', '', '2025-05-26', 'Activo', NULL, NULL, NULL, NULL, '2025-05-26 12:36:23'),
(00003, 'DISTRIBUIDORA DE MATERIALES S. DE R.L. DE C.V.', '05119998390898', '', '', '', '', '2025-05-26', 'Activo', NULL, NULL, NULL, NULL, '2025-05-26 12:37:56'),
(00004, 'PINTUCO DE HONDURAS S.A.', '05019995108436', '', '', '', '', '2025-05-26', 'Activo', NULL, NULL, NULL, NULL, '2025-05-26 12:38:56'),
(00005, 'POLARIS INTERNACIONAL S. DE R.L.', '08019999401562', '', '', '', '', '2025-08-11', 'Activo', NULL, NULL, NULL, NULL, '2025-08-11 22:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE `proyectos` (
  `ID_PROY` int(5) UNSIGNED ZEROFILL NOT NULL,
  `COD_PROY` varchar(10) NOT NULL,
  `NOM_PROY` varchar(100) NOT NULL,
  `DESC_PROY` varchar(254) DEFAULT '',
  `ID_CLIE` int(5) UNSIGNED ZEROFILL NOT NULL,
  `FECHA_INI` date DEFAULT NULL,
  `FECHA_FIN` date DEFAULT NULL,
  `ID_EMPRESA` int(5) UNSIGNED ZEROFILL NOT NULL,
  `ID_INGE` int(5) UNSIGNED ZEROFILL NOT NULL,
  `FEC_INIRES` date DEFAULT NULL,
  `FEC_FINRES` date DEFAULT NULL,
  `NOM_INGE2` varchar(150) DEFAULT NULL,
  `NOM_INGE3` varchar(150) DEFAULT NULL,
  `NOM_FACTURAR` varchar(150) DEFAULT NULL,
  `RTN_FACTURAR` varchar(20) DEFAULT NULL,
  `VALOR_PROY` decimal(15,2) DEFAULT NULL,
  `CARGO_PROY` decimal(15,2) DEFAULT NULL,
  `ABONO_PROY` decimal(15,2) DEFAULT NULL,
  `ACTUAL_PROY` decimal(15,2) DEFAULT NULL,
  `DIRECC_PROY` varchar(254) DEFAULT NULL,
  `ACTIVO` enum('Activo','Inactivo') DEFAULT 'Activo',
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyectos`
--

INSERT INTO `proyectos` (`ID_PROY`, `COD_PROY`, `NOM_PROY`, `DESC_PROY`, `ID_CLIE`, `FECHA_INI`, `FECHA_FIN`, `ID_EMPRESA`, `ID_INGE`, `FEC_INIRES`, `FEC_FINRES`, `NOM_INGE2`, `NOM_INGE3`, `NOM_FACTURAR`, `RTN_FACTURAR`, `VALOR_PROY`, `CARGO_PROY`, `ABONO_PROY`, `ACTUAL_PROY`, `DIRECC_PROY`, `ACTIVO`, `fecha_hora`) VALUES
(00017, 'BCHSPS-02', 'BCH SPS - MURO', 'Demolición y construcción de muro perimetral incluye verja metalica', 00007, '2026-01-01', '2026-04-23', 00001, 00010, '2026-01-01', '2026-04-23', 'LUCIA GABRIELA PORTILLO PINEDA', 'SUANY PAOLA MAIRENA NUÑEZ', NULL, NULL, 0.00, NULL, NULL, NULL, 'Barrio El Centro, 5ta Avenida, 3ra Calle', 'Activo', '2026-04-23 15:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `sof_acciones`
--

CREATE TABLE `sof_acciones` (
  `id_accion` int UNSIGNED NOT NULL,
  `cod_accion` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_accion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_accion` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Catálogo de acciones disponibles por módulo';

--
-- Dumping data for table `sof_acciones`
--

INSERT INTO `sof_acciones` (`id_accion`, `cod_accion`, `nom_accion`, `desc_accion`) VALUES
(1, 'VER', 'Ver', NULL),
(2, 'CREAR', 'Crear', NULL),
(3, 'EDITAR', 'Editar', NULL),
(4, 'ELIMINAR', 'Eliminar', NULL),
(5, 'APROBAR', 'Aprobar', NULL),
(6, 'IMPRIMIR', 'Imprimir', NULL),
(7, 'EXPORTAR', 'Exportar', NULL),
(8, 'ANULAR', 'Anular', NULL),
(9, 'CERRAR', 'Cerrar', NULL),
(10, 'REABRIR', 'Reabrir', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sof_audit_logs`
--

CREATE TABLE `sof_audit_logs` (
  `id_log` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_modulo` int UNSIGNED DEFAULT NULL,
  `accion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dato_anterior` text COLLATE utf8mb4_unicode_ci,
  `dato_nuevo` text COLLATE utf8mb4_unicode_ci,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bitácora de acciones del sistema';

-- --------------------------------------------------------

--
-- Table structure for table `sof_configuracion`
--

CREATE TABLE `sof_configuracion` (
  `id_config` int UNSIGNED NOT NULL,
  `clave` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` text COLLATE utf8mb4_unicode_ci,
  `descripcion` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'GENERAL',
  `fecha_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Configuración general del sistema';

--
-- Dumping data for table `sof_configuracion`
--

INSERT INTO `sof_configuracion` (`id_config`, `clave`, `valor`, `descripcion`, `grupo`, `fecha_update`) VALUES
(1, 'SISTEMA_NOMBRE', 'SistemaOF', 'Nombre del sistema', 'GENERAL', '2026-05-13 03:50:03'),
(2, 'SISTEMA_VERSION', '1.0.0', 'Versión actual', 'GENERAL', '2026-05-13 03:50:03'),
(3, 'MONEDA', 'HNL', 'Moneda base del sistema', 'GENERAL', '2026-05-13 03:50:03'),
(4, 'ISV_PORCENTAJE', '15', 'Porcentaje de ISV aplicado', 'FINANZAS', '2026-05-13 03:50:03'),
(5, 'SESSION_TIMEOUT', '120', 'Tiempo de sesión en minutos', 'SEGURIDAD', '2026-05-13 03:50:03'),
(6, 'EMAIL_FROM', '', 'Correo remitente del sistema', 'NOTIFICACIONES', '2026-05-13 03:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `sof_modulos`
--

CREATE TABLE `sof_modulos` (
  `id_modulo` int UNSIGNED NOT NULL,
  `cod_modulo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_modulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_modulo` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta_modulo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int DEFAULT '0',
  `estatus` enum('Activo','Inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `fecha_ing` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Módulos del sistema';

--
-- Dumping data for table `sof_modulos`
--

INSERT INTO `sof_modulos` (`id_modulo`, `cod_modulo`, `nom_modulo`, `desc_modulo`, `icono`, `ruta_modulo`, `orden`, `estatus`, `fecha_ing`) VALUES
(1, 'SEGURIDAD', 'Seguridad', NULL, 'lock', '/admin/seguridad', 1, 'Activo', '2026-05-13 03:50:03'),
(2, 'DASHBOARD', 'Dashboard', NULL, 'home', '/dashboard', 2, 'Activo', '2026-05-13 03:50:03'),
(3, 'CLIENTES', 'Clientes', NULL, 'users', '/clientes', 3, 'Activo', '2026-05-13 03:50:03'),
(4, 'PROVEEDORES', 'Proveedores', NULL, 'truck', '/proveedores', 4, 'Activo', '2026-05-13 03:50:03'),
(5, 'EMPRESAS', 'Empresas', NULL, 'building', '/empresas', 5, 'Activo', '2026-05-13 03:50:03'),
(6, 'INGENIEROS', 'Ingenieros', NULL, 'hard-hat', '/ingenieros', 6, 'Activo', '2026-05-13 03:50:03'),
(7, 'LINEAS', 'Líneas', NULL, 'layers', '/lineas', 7, 'Activo', '2026-05-13 03:50:03'),
(8, 'PRODUCTOS', 'Productos y Servicios', NULL, 'box', '/productos', 8, 'Activo', '2026-05-13 03:50:03'),
(9, 'PROYECTOS', 'Proyectos', NULL, 'briefcase', '/proyectos', 9, 'Activo', '2026-05-13 03:50:03'),
(10, 'ALCANCES', 'Alcances y Costos', NULL, 'calculator', '/alcances', 10, 'Activo', '2026-05-13 03:50:03'),
(11, 'COTIZACIONES', 'Cotizaciones', NULL, 'file-text', '/cotizaciones', 11, 'Activo', '2026-05-13 03:50:03'),
(12, 'COMPRAS', 'Compras', NULL, 'shopping-cart', '/compras', 12, 'Activo', '2026-05-13 03:50:03'),
(13, 'ENTREGAS', 'Entregas', NULL, 'package', '/entregas', 13, 'Activo', '2026-05-13 03:50:03'),
(14, 'PLANILLAS', 'Planillas', NULL, 'credit-card', '/planillas', 14, 'Activo', '2026-05-13 03:50:03'),
(15, 'REPORTES', 'Reportes', NULL, 'bar-chart-2', '/reportes', 15, 'Activo', '2026-05-13 03:50:03'),
(16, 'CONFIGURACION', 'Configuración', NULL, 'settings', '/configuracion', 16, 'Activo', '2026-05-13 03:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `sof_password_resets`
--

CREATE TABLE `sof_password_resets` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usado` tinyint(1) NOT NULL DEFAULT '0',
  `expira_en` datetime NOT NULL,
  `fecha_ing` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tokens para recuperación de contraseña';

-- --------------------------------------------------------

--
-- Table structure for table `sof_roles`
--

CREATE TABLE `sof_roles` (
  `id_rol` int UNSIGNED NOT NULL,
  `nom_rol` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_rol` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `es_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_ing` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Roles del sistema';

--
-- Dumping data for table `sof_roles`
--

INSERT INTO `sof_roles` (`id_rol`, `nom_rol`, `desc_rol`, `estatus`, `es_superadmin`, `fecha_ing`) VALUES
(1, 'Superadmin', 'Control total del sistema', 'Activo', 1, '2026-05-13 03:50:03'),
(2, 'Gerencia', 'Acceso gerencial y aprobaciones', 'Activo', 0, '2026-05-13 03:50:03'),
(3, 'Administrador', 'Administración operativa completa', 'Activo', 0, '2026-05-13 03:50:03'),
(4, 'Compras', 'Gestión de compras y órdenes', 'Activo', 0, '2026-05-13 03:50:03'),
(5, 'Ingeniería', 'Gestión de proyectos y alcances', 'Activo', 0, '2026-05-13 03:50:03'),
(6, 'Finanzas', 'Control financiero y planillas', 'Activo', 0, '2026-05-13 03:50:03'),
(7, 'Cotizaciones', 'Creación y gestión de cotizaciones', 'Activo', 0, '2026-05-13 03:50:03'),
(8, 'Consulta', 'Solo lectura del sistema', 'Activo', 0, '2026-05-13 03:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `sof_role_permissions`
--

CREATE TABLE `sof_role_permissions` (
  `id` int UNSIGNED NOT NULL,
  `id_rol` int UNSIGNED NOT NULL,
  `id_modulo` int UNSIGNED NOT NULL,
  `id_accion` int UNSIGNED NOT NULL,
  `permitido` tinyint(1) NOT NULL DEFAULT '1',
  `asignado_por` int UNSIGNED DEFAULT NULL,
  `fecha_ing` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Permisos por rol, módulo y acción';

-- --------------------------------------------------------

--
-- Table structure for table `sof_users`
--

CREATE TABLE `sof_users` (
  `id_user` int UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_usuario` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` enum('Activo','Inactivo','Suspendido','Bloqueado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `id_empresa` int UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL,
  `creado_por` int UNSIGNED DEFAULT NULL,
  `fecha_ing` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `observaciones` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Usuarios del sistema SistemaOF';

-- --------------------------------------------------------

--
-- Table structure for table `sof_user_roles`
--

CREATE TABLE `sof_user_roles` (
  `id` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `id_rol` int UNSIGNED NOT NULL,
  `asignado_por` int UNSIGNED DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relación usuarios y roles (N:N)';

-- --------------------------------------------------------

--
-- Table structure for table `sof_user_sessions`
--

CREATE TABLE `sof_user_sessions` (
  `id_session` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_activity` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_inicio` datetime DEFAULT CURRENT_TIMESTAMP,
  `activa` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sesiones activas del sistema';

-- --------------------------------------------------------

--
-- Table structure for table `tipos`
--

CREATE TABLE `tipos` (
  `id_tipo` int(5) UNSIGNED ZEROFILL NOT NULL,
  `desc_tipo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipos`
--

INSERT INTO `tipos` (`id_tipo`, `desc_tipo`) VALUES
(00001, 'PRODUCTOS / MATERIALES '),
(00002, 'MANO DE OBRA / SERVICIOS');

-- --------------------------------------------------------

--
-- Table structure for table `tip_movtos`
--

CREATE TABLE `tip_movtos` (
  `ID_MOVTO` int(5) UNSIGNED ZEROFILL NOT NULL,
  `DESC_MOVTO` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `username` varchar(20) NOT NULL,
  `id_user` int(5) UNSIGNED ZEROFILL NOT NULL,
  `clave` varchar(20) NOT NULL,
  `nombre_usuario` varchar(100) DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `Fecha_ing` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lista de Usuarios del Sistema';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alcance`
--
ALTER TABLE `alcance`
  ADD PRIMARY KEY (`id_alcance`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_clie`),
  ADD KEY `nom_clie` (`nom_clie`);

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_comp`) USING BTREE;

--
-- Indexes for table `costos`
--
ALTER TABLE `costos`
  ADD PRIMARY KEY (`id_costo`);

--
-- Indexes for table `cotiza`
--
ALTER TABLE `cotiza`
  ADD PRIMARY KEY (`id_cotiza`) USING BTREE;

--
-- Indexes for table `cuentas_bank`
--
ALTER TABLE `cuentas_bank`
  ADD PRIMARY KEY (`id_bank`) USING BTREE;

--
-- Indexes for table `det_alcance`
--
ALTER TABLE `det_alcance`
  ADD PRIMARY KEY (`corre_movto`);

--
-- Indexes for table `det_costos`
--
ALTER TABLE `det_costos`
  ADD PRIMARY KEY (`id_movcost`) USING BTREE;

--
-- Indexes for table `det_cotiza`
--
ALTER TABLE `det_cotiza`
  ADD PRIMARY KEY (`corre_item`) USING BTREE;

--
-- Indexes for table `det_ocompra`
--
ALTER TABLE `det_ocompra`
  ADD PRIMARY KEY (`corre_item`);

--
-- Indexes for table `det_oentrega`
--
ALTER TABLE `det_oentrega`
  ADD PRIMARY KEY (`id_oentrega`);

--
-- Indexes for table `det_planilla`
--
ALTER TABLE `det_planilla`
  ADD PRIMARY KEY (`corre_tra`) USING BTREE;

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indexes for table `ingenieros`
--
ALTER TABLE `ingenieros`
  ADD PRIMARY KEY (`ID_INGE`);

--
-- Indexes for table `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`ID_LINEA`) USING BTREE;

--
-- Indexes for table `mano_obra`
--
ALTER TABLE `mano_obra`
  ADD PRIMARY KEY (`id_mo`);

--
-- Indexes for table `orden_entrega`
--
ALTER TABLE `orden_entrega`
  ADD PRIMARY KEY (`id_oentrega`);

--
-- Indexes for table `ord_compras`
--
ALTER TABLE `ord_compras`
  ADD PRIMARY KEY (`id_ocompra`);

--
-- Indexes for table `planilla`
--
ALTER TABLE `planilla`
  ADD PRIMARY KEY (`id_plan`) USING BTREE;

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_prod`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_prov`);

--
-- Indexes for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`ID_PROY`),
  ADD UNIQUE KEY `COD_PROY` (`COD_PROY`);

--
-- Indexes for table `sof_acciones`
--
ALTER TABLE `sof_acciones`
  ADD PRIMARY KEY (`id_accion`),
  ADD UNIQUE KEY `cod_accion` (`cod_accion`);

--
-- Indexes for table `sof_audit_logs`
--
ALTER TABLE `sof_audit_logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_modulo` (`id_modulo`),
  ADD KEY `idx_fecha` (`fecha_hora`);

--
-- Indexes for table `sof_configuracion`
--
ALTER TABLE `sof_configuracion`
  ADD PRIMARY KEY (`id_config`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indexes for table `sof_modulos`
--
ALTER TABLE `sof_modulos`
  ADD PRIMARY KEY (`id_modulo`),
  ADD UNIQUE KEY `cod_modulo` (`cod_modulo`);

--
-- Indexes for table `sof_password_resets`
--
ALTER TABLE `sof_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_token` (`token`(20));

--
-- Indexes for table `sof_roles`
--
ALTER TABLE `sof_roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nom_rol` (`nom_rol`);

--
-- Indexes for table `sof_role_permissions`
--
ALTER TABLE `sof_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rol_modulo_accion` (`id_rol`,`id_modulo`,`id_accion`);

--
-- Indexes for table `sof_users`
--
ALTER TABLE `sof_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sof_user_roles`
--
ALTER TABLE `sof_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_rol` (`id_user`,`id_rol`);

--
-- Indexes for table `sof_user_sessions`
--
ALTER TABLE `sof_user_sessions`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_activa` (`activa`);

--
-- Indexes for table `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `tip_movtos`
--
ALTER TABLE `tip_movtos`
  ADD PRIMARY KEY (`ID_MOVTO`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alcance`
--
ALTER TABLE `alcance`
  MODIFY `id_alcance` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_clie` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id_comp` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `costos`
--
ALTER TABLE `costos`
  MODIFY `id_costo` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cotiza`
--
ALTER TABLE `cotiza`
  MODIFY `id_cotiza` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuentas_bank`
--
ALTER TABLE `cuentas_bank`
  MODIFY `id_bank` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `det_alcance`
--
ALTER TABLE `det_alcance`
  MODIFY `corre_movto` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `det_costos`
--
ALTER TABLE `det_costos`
  MODIFY `id_movcost` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `det_cotiza`
--
ALTER TABLE `det_cotiza`
  MODIFY `corre_item` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_ocompra`
--
ALTER TABLE `det_ocompra`
  MODIFY `corre_item` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `det_planilla`
--
ALTER TABLE `det_planilla`
  MODIFY `corre_tra` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id_empresa` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ingenieros`
--
ALTER TABLE `ingenieros`
  MODIFY `ID_INGE` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lineas`
--
ALTER TABLE `lineas`
  MODIFY `ID_LINEA` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mano_obra`
--
ALTER TABLE `mano_obra`
  MODIFY `id_mo` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orden_entrega`
--
ALTER TABLE `orden_entrega`
  MODIFY `id_oentrega` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ord_compras`
--
ALTER TABLE `ord_compras`
  MODIFY `id_ocompra` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `planilla`
--
ALTER TABLE `planilla`
  MODIFY `id_plan` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_prod` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_prov` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `ID_PROY` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sof_acciones`
--
ALTER TABLE `sof_acciones`
  MODIFY `id_accion` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sof_audit_logs`
--
ALTER TABLE `sof_audit_logs`
  MODIFY `id_log` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sof_configuracion`
--
ALTER TABLE `sof_configuracion`
  MODIFY `id_config` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sof_modulos`
--
ALTER TABLE `sof_modulos`
  MODIFY `id_modulo` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sof_password_resets`
--
ALTER TABLE `sof_password_resets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sof_roles`
--
ALTER TABLE `sof_roles`
  MODIFY `id_rol` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sof_role_permissions`
--
ALTER TABLE `sof_role_permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sof_users`
--
ALTER TABLE `sof_users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sof_user_roles`
--
ALTER TABLE `sof_user_roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id_tipo` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tip_movtos`
--
ALTER TABLE `tip_movtos`
  MODIFY `ID_MOVTO` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
