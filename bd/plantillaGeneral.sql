-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2023 at 03:18 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jolumabd`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id_clientes` bigint UNSIGNED NOT NULL,
  `id_tipo_documento` bigint UNSIGNED NOT NULL,
  `cliente_razonsocial` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_numero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_direccion_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_fecha` datetime NOT NULL,
  `cliente_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `id_tipo_documento`, `cliente_razonsocial`, `cliente_nombre`, `cliente_numero`, `cliente_correo`, `cliente_direccion`, `cliente_direccion_2`, `cliente_telefono`, `cliente_fecha`, `cliente_estado`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-28 00:51:01', 1, NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-28 00:51:01', 1, NULL, NULL),
(3, 2, '', 'Anonimo', '11111111', 'anonimo@gmail.com', 'Calle S/n', '', '999999999', '2021-03-26 00:00:00', 1, NULL, NULL),
(4, 2, '', 'CARLOS MIGUEL MORI LOPEZ ', '41668647', '', '', '', '', '2022-10-09 15:14:08', 1, NULL, NULL),
(5, 2, '', 'NEIL STEVE DIAZ GUIMAK', '45752881', '', '', '', '', '2022-10-11 16:44:14', 1, NULL, NULL),
(6, 4, 'MINISTERIO DE TRANSPORTES Y COMUNICACIONES', '', '20131379944', '', 'JR. ZORRITOS NRO. 1203', '', '', '2022-10-12 08:34:51', 1, NULL, NULL),
(7, 4, 'MINISTERIO DE EDUCACION', '', '20131370998', '', 'CAL. DEL COMERCIO NRO. 193', '', '', '2022-10-12 09:17:17', 1, NULL, NULL),
(8, 4, 'JOSE RICARDO DEL CASTILLO URRELO', '', '10052717537', '', 'AV. COLONIAL 910', '', '', '2022-10-13 10:31:23', 1, NULL, NULL),
(9, 4, 'WURTH PERU S.A.C.', '', '20348687191', '', 'AV. LOS INGENIEROS NRO. 142 URB. IND.STA.RAQUEL II ETAPA', '', '', '2022-10-14 10:58:03', 1, NULL, NULL),
(10, 4, 'MUNDO LEGACY MMV E.I.R.L.', '', '20608314211', '', 'CAL. LA PRINCIPAL LT. 22 MZ. 17 A.H. SAN PABLO DE LA LUZ', '', '', '2022-10-15 15:03:36', 1, NULL, NULL),
(11, 2, '', 'MILAGROS LILIANA RAMIREZ NAVARRO', '44316112', '', 'URB. CESAR CALVO DE ARAUJO F-1 PAMPACHICA', '', '', '2022-10-16 16:09:52', 1, NULL, NULL),
(12, 4, 'GERARDO GENARO GONZALES PINEDO', '', '10409079672', '', 'LAS FLORES 438', '', '', '2022-10-18 15:11:08', 1, NULL, NULL),
(13, 4, 'AQUARIUS CONSULTING S.A.C.', '', '20503271592', '', 'CAL. COLLASUYO NRO. 186 URB. LOS AYLLUS', '', '', '2022-10-19 15:23:24', 1, NULL, NULL),
(14, 4, 'GEAN MARCOS RIOS RIOS', '', '10612284399', '', 'RICARDO PALMA 762', '', '', '2022-10-21 15:26:19', 1, NULL, NULL),
(15, 4, 'TELESERVICIOS SELVA E.I.R.L.', '', '20600106750', '', 'JR. CONDAMINE NRO. 147 P.J. SERAFIN FILOMENO', '', '', '2022-10-22 14:26:05', 1, NULL, NULL),
(16, 2, '', 'CUELLAR BAUTISTA JOSE ELOY', '09367073', '', '', '', '', '2022-10-22 15:08:01', 1, NULL, NULL),
(17, 4, 'COMUNIDAD CAMPESINA DE SAN JUAN MIRAFLOR', '', '20103962391', '', 'CAL. LAS ORQUIDEAS NRO. S/N', '', '', '2022-10-22 15:58:13', 1, NULL, NULL),
(18, 4, 'CONSORCIO SUPERVISOR PALMA', '', '20609454602', '', 'JR. FANNING NRO. 1241 P.J. BERMUDEZ', '', '', '2022-10-23 15:26:35', 1, NULL, NULL),
(19, 4, 'CENDIPP', '', '20137894107', '', 'Pablo Rosell 530', '', '', '2022-10-25 13:35:56', 1, NULL, NULL),
(20, 4, 'CONSORCIO SELVA VERDE', '', '20610018506', '', 'JR. ULISES REATEGUI NRO. 409', '', '', '2022-10-25 16:07:47', 1, NULL, NULL),
(21, 2, '', 'ANONIMO', '42362260', '', '', '', '', '2022-10-27 13:40:04', 1, NULL, NULL),
(22, 4, 'GONZALES PINEDO GERARDO GENARO', '', '10409074672', '', 'Las  flores 438  SAN JUAN.', '', '', '2022-10-27 15:02:07', 1, NULL, NULL),
(23, 4, 'CHARAPA TOURS ', '', '20606787937', '', 'OTR. CALLE NAUTA NRO. 298 OTR. URB', '', '', '2022-10-31 14:33:31', 1, NULL, NULL),
(24, 4, 'AEROPUERTO DEL PERU', '', '20514513172', '', 'JIRON DOMENICOS MURELLI 110 PISO 5- SAN BORJA', '', '', '2022-11-03 14:31:15', 1, NULL, NULL),
(25, 4, 'COMERCIAL IQUITOS S A', '', '20103845913', '', 'CAL. ALMIRANTE GRAU NRO. 1144', '', '', '2022-11-04 13:01:09', 1, NULL, NULL),
(26, 4, 'GRUPO INMOBILIARIO E & Z E.I.R.L.', '', '20602188575', '', 'AV. ABELARDO QUIÑONES NRO. 4018 DPTO. 2', '', '', '2022-11-04 14:30:31', 1, NULL, NULL),
(27, 4, 'COMERCIO SERVICIOS E INDUSTRIAS A Y P S.A.C.', '', '20602311385', '', 'CAL. LAS BEGONIAS NRO. SN', '', '', '2022-11-05 16:06:21', 1, NULL, NULL),
(28, 4, 'MENDEZ DEL AGUILA JUAN ALFONSO', '', '10061032393', '', 'Calle Morona   421.', '', '', '2022-11-11 12:41:57', 1, NULL, NULL),
(29, 4, 'LORETO ASFALTOS EIRL', '', '20567113257', '', 'CAL. ASUNCION NRO. 132', '', '', '2022-11-15 14:40:15', 1, NULL, NULL),
(30, 4, 'HALEMA S.A.C.', '', '20123316658', '', 'AV. VIRREY CONDE DE LEMOS NRO. 231 URB. LA COLONIAL', '', '', '2022-11-17 14:51:46', 1, NULL, NULL),
(31, 2, '', 'RAMIREZ VASQUEZ LUIS ALBERTO', '43702737', '', '', '', '', '2022-11-20 12:44:13', 1, NULL, NULL),
(32, 4, 'CHARITYVISION INTERNATIONAL, INC', '', '20604020965', '', 'AV. SAN BORJA NORTE NRO. 852 DPTO. 302', '', '', '2022-11-20 16:21:53', 1, NULL, NULL),
(33, 4, 'PAUL ALEXIS GARCIA TAFUR', '', '10707925657', '', 'JR. MAYNAS 204', '', '', '2022-11-24 12:20:21', 1, NULL, NULL),
(34, 4, 'ROCA S.A.C.', '', '20101337261', '', 'AV. MANUEL OLGUIN NRO. 325 INT. 1006 URB. LOS GRANADOS', '', '', '2022-11-24 14:18:15', 1, NULL, NULL),
(35, 4, 'AMBAR BRISETTE ORBE TORRES', '', '10704274586', '', 'PSJ. ANGAMOS  LOTE150', '', '', '2022-11-29 13:22:35', 1, NULL, NULL),
(36, 4, 'SERVICIOS GENERALES LOMY EIRL', '', '20606249790', '', 'URB. JUAN PABLO SEGUNDO MOD. 22 DPTO 102 SAN JUAN', '', '', '2022-12-01 12:43:21', 1, NULL, NULL),
(37, 4, 'PROSEGUR TECNOLOGIA PERU S.A', '', '20514431281', '', 'AV. LOS PROCERES  250 SANTIAGO DE SURCO LIMA.', '', '', '2022-12-02 13:47:56', 1, NULL, NULL),
(38, 2, '', 'FLORES RIOS CARMEN RAQUEL', '73669957', '', '', '', '', '2022-12-04 14:29:43', 1, NULL, NULL),
(39, 4, 'CLEVAC S.A.C.', '', '20601530610', '', 'CAL. SIN NOMBRE LT. 03 MZ. J ASC. DE PRO.LOT.S.RUST.LA ENSE', '', '', '2022-12-04 16:03:12', 1, NULL, NULL),
(40, 2, '', 'GUEVARA PEÑA AUGUSTO', '05412942', '', '', '', '', '2022-12-09 15:43:35', 1, NULL, NULL),
(41, 4, 'SANTANDER BRUNETT CARLOS ENRIQUE', '', '10082073049', '', 'URB. SANTA SOFIA - SANTA TERESA B-7', '', '', '2022-12-10 14:03:37', 1, NULL, NULL),
(42, 2, '', 'VEGA BARDALES KARINA RAQUEL', '45024679', '', '', '', '', '2022-12-21 12:04:24', 1, NULL, NULL),
(43, 4, 'MUÑOZ ZEA KAREN TELMA', '', '10704406105', '', 'SARGENTO LORES 321', '', '', '2022-12-25 12:21:32', 1, NULL, NULL),
(44, 4, 'COMERCIAL TEKA S.A.C.', '', '20608843591', '', 'CAL. CALLE VIRGEN DE LA PUERTA LT. 07 MZ. F A.H. ELIAN KARP', '', '', '2022-12-25 17:15:18', 1, NULL, NULL),
(45, 2, '', 'BURGA LOPEZ LORENA STEPHANI', '71291272', '', '', '', '', '2022-12-29 15:36:06', 1, NULL, NULL),
(46, 4, 'MAS FRIO PERU S.A.C. - MAS FRIO S.A.C.', '', '20601469619', '', 'LT. 7 MZ. J APV. AYACUCHO 1RA ENTRADA', '', '', '2022-12-30 16:53:00', 1, NULL, NULL),
(47, 2, '', 'ROMMEL ADRIEL REYNEL DAVILA', '46501740', '', '', '', '', '2023-01-01 14:34:35', 1, NULL, NULL),
(48, 4, 'CAJA MUNICIPAL DE AHORRO Y CREDITO DE MAYNAS S.A.', '', '20103845328', '', 'JR. PROSPERO NRO. 791', '', '', '2023-01-03 14:14:48', 1, NULL, NULL),
(49, 4, 'AQUARIUM SHALY EXOCTIC FISH L.T.D EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA', '', '20608651668', '', 'CAL. ELICEO REATEGUI LT. 18 DPTO. LORE MZ. Q A.H. 9 DE ABRIL', '', '', '2023-01-04 16:43:51', 1, NULL, NULL),
(50, 4, 'GREEN LAND LOGISTICA Y SOLUCIONES AMBIENTALES E.I.R.L.', '', '20600587171', '', 'CAL. MICAELA BASTIDAS LT. 16 DPTO. 02 MZ. E', '', '', '2023-01-04 17:39:04', 1, NULL, NULL),
(51, 4, 'CABALLERO CONTRATISTAS GENERALES E.I.R.L.', '', '20528115897', '', 'AV. PRINCIPAL NRO. S/N ---- VILLA SARAMIRIZA', '', '', '2023-01-10 14:31:05', 1, NULL, NULL),
(52, 2, '', 'ORBEGOSO GOMEZ MILAGROS ASUNCION', '42276073', '', '', '', '', '2023-01-15 14:02:47', 1, NULL, NULL),
(53, 4, 'GERENCIA REGIONAL DE DESARROLLO AGRARIO Y RIEGO', '', '20408454531', '', 'CAL. RICARDO PALMA NRO. 113', '', '', '2023-01-26 13:34:45', 1, NULL, NULL),
(54, 2, '', 'REATEGUI DE SOUZA DE ALMANZA ROSA GUILLERMINA', '23886070', '', '', '', '', '2023-01-29 14:49:49', 1, NULL, NULL),
(55, 4, 'CONSORCIO CETPRO PUTUMAYO LORETO', '', '20609349485', '', 'CAL. MORONA NRO. 577', '', '', '2023-02-01 09:42:41', 1, NULL, NULL),
(56, 4, 'DIR. REG. DE TRANSP.COM.VIV.CONS.LORETO', '', '20408632146', '', 'AV. QUIÑONEZ NRO. 3.5', '', '', '2023-02-04 14:01:31', 1, NULL, NULL),
(57, 4, 'SOCIEDAD APOSTOLICA SANTA MARIA', '', '20177560449', '', 'AV. PEDRO MIOTA NRO. 313', '', '', '2023-02-04 14:41:24', 1, NULL, NULL),
(58, 4, 'INSTITUTO NACIONAL DE SALUD', '', '20131263130', '', 'AV. DEFENSORES DEL MORRO NRO. 2268', '', '', '2023-02-04 16:49:48', 1, NULL, NULL),
(60, 2, NULL, 'DEYVIN MAURICIO JESUS NOLORBE', '74077979', 'reynaalfredo421@gmail.com', NULL, NULL, '956449198', '2023-08-15 17:34:51', 1, NULL, NULL),
(61, 2, NULL, 'EDER ALFREDO APAGUEÑO REYNA', '74077975', 'reynaalfredo421@gmail.com', NULL, NULL, '956449198', '2023-08-16 17:34:59', 1, NULL, NULL),
(62, 2, 'ANTHONY MIGUEL VASQUEZ PEZO', 'ANTHONY MIGUEL VASQUEZ PEZO', '70426133', NULL, NULL, NULL, NULL, '2023-08-19 09:36:29', 1, NULL, NULL),
(63, 4, 'BUFEO TEC S.A.C.', NULL, '20604352429', NULL, 'PJ. LOS CLAVELES LT. 11 DPTO. A MZ. M OTR. LOS CLAVELES', NULL, NULL, '2023-09-05 13:45:03', 1, NULL, NULL),
(64, 2, NULL, 'LUIS ANTONIO SALAZAR BARTRA', '71106432', 'reynaalfredo421@gmail.com', NULL, NULL, '956449198', '2023-09-13 11:39:19', 1, NULL, NULL),
(65, 2, NULL, 'CARLOS MARCELINO LOJA ALEMAN', '07736421', 'lojacarlos@hotmail.com', NULL, NULL, '2062610376', '2023-09-13 11:46:51', 1, NULL, NULL),
(66, 4, 'APAGUEÑO REYNA EDER ALFREDO', 'APAGUEÑO REYNA EDER ALFREDO', '10740779759', NULL, 'Calle Las Américas#457\r\nLoreto', NULL, '956449198', '2023-10-27 16:19:38', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` bigint UNSIGNED NOT NULL,
  `contacto_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto_valor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto_estado` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `contacto_nombre`, `contacto_valor`, `contacto_estado`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', '#', 1, '2023-07-20 18:20:43', '2023-07-20 18:20:43'),
(3, 'Youtube', '#', 1, '2023-07-20 18:20:43', '2023-07-20 18:20:43'),
(4, ' Instagram', '#', 1, '2023-07-20 18:20:43', '2023-07-20 18:20:43'),
(6, 'Atención en Oficina', 'Lunes - Viernes: 8:00 am - 06:00 pm <br > <i class=\"fa-solid fa-clock me-3\"></i> Sábados : 8:00 am - 1:00 pm', 1, '2023-07-20 18:20:43', '2023-07-20 18:20:43'),
(7, 'Direccíon', 'Jirón Putumayo 1598, Iquitos - Perú', 1, '2023-07-20 18:20:43', '2023-07-20 18:20:43'),
(8, 'Telefono_1', '980 375 965', 1, NULL, NULL),
(9, 'Telefono_2', '965 023 682', 1, NULL, NULL),
(10, 'WhatsApp1', '51 980 375 965', 1, NULL, NULL),
(11, 'WhatsApp2', '51 965 023 682', 1, NULL, NULL),
(12, 'Correo Electronico1', 'ventas@miskyselva.com', 1, NULL, NULL),
(13, 'Correo Electronico2', 'servicioalcliente@miskyselva.com', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` bigint UNSIGNED NOT NULL,
  `empresa_razon_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_nombrecomercial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_ruc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_domiciliofiscal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_pais` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_departamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_provincia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_distrito` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_ubigeo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_telefono1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_telefono2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_celular1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_celular2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_foto_ticket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_usuario_sol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_clave_sol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `empresa_razon_social`, `empresa_nombrecomercial`, `empresa_descripcion`, `empresa_ruc`, `empresa_domiciliofiscal`, `empresa_pais`, `empresa_departamento`, `empresa_provincia`, `empresa_distrito`, `empresa_ubigeo`, `empresa_telefono1`, `empresa_telefono2`, `empresa_celular1`, `empresa_celular2`, `empresa_foto`, `empresa_foto_ticket`, `empresa_correo`, `empresa_usuario_sol`, `empresa_clave_sol`, `empresa_estado`, `created_at`, `updated_at`) VALUES
(1, 'MISKI SELVA SOCIEDAD COMERCIAL DE RESPONSABILIDAD LIMITADA', 'MISKY SELVA', 'MISKY SELVA', '20607850179', 'JR. PUTUMAYO NRO. 1598 P.J. PROLONGACION PUTUMAYO ', 'PE', 'LORETO ', 'MAYNAS ', 'IQUITOS', '160101', NULL, NULL, NULL, NULL, 'inicio/img/logo.png', 'inicio/img/logo.png', NULL, 'MISKIBUF', 'Miskibufeo1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `envio_resumen`
--

CREATE TABLE `envio_resumen` (
  `id_envio_resumen` bigint UNSIGNED NOT NULL,
  `id_empresa` bigint UNSIGNED NOT NULL,
  `envio_resumen_fecha` date NOT NULL,
  `envio_resumen_serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_correlativo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_nombreXML` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_nombreCDR` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envio_resumen_estado` tinyint NOT NULL,
  `envio_resumen_estadosunat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_estadosunat_consulta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envio_resumen_ticket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_sunat_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `envio_resumen`
--

INSERT INTO `envio_resumen` (`id_envio_resumen`, `id_empresa`, `envio_resumen_fecha`, `envio_resumen_serie`, `envio_resumen_correlativo`, `envio_resumen_nombreXML`, `envio_resumen_nombreCDR`, `envio_resumen_estado`, `envio_resumen_estadosunat`, `envio_resumen_estadosunat_consulta`, `envio_resumen_ticket`, `envio_sunat_datetime`, `created_at`, `updated_at`) VALUES
(42, 1, '2023-10-27', '20231027', '1', 'ApiFacturacion/xml/20607850179-RC-20231027-1.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698428339040', '2023-10-27 12:46:24', '2023-10-27 17:46:24', '2023-10-27 17:46:24'),
(43, 1, '2023-10-27', '20231027', '2', 'ApiFacturacion/xml/20607850179-RC-20231027-2.XML', 'ApiFacturacion/cdr/R-20607850179-RC-20231027-2.XML', 1, 'TICKET ENVIADO', 'El Resumen diario RC-20231027-2, ha sido aceptado', '1698428507669', '2023-10-27 12:49:13', '2023-10-27 17:49:13', '2023-10-27 17:49:13'),
(44, 1, '2023-10-27', '20231027', '3', 'ApiFacturacion/xml/20607850179-RC-20231027-3.XML', 'ApiFacturacion/cdr/R-20607850179-RC-20231027-3.XML', 1, 'TICKET ENVIADO', 'El Resumen diario RC-20231027-3, ha sido aceptado', '1698428676986', '2023-10-27 12:52:02', '2023-10-27 17:52:02', '2023-10-27 17:52:02'),
(45, 1, '2023-10-27', '20231027', '4', 'ApiFacturacion/xml/20607850179-RC-20231027-4.XML', 'ApiFacturacion/cdr/R-20607850179-RC-20231027-4.XML', 1, 'TICKET ENVIADO', 'El Resumen diario RC-20231027-4, ha sido aceptado', '1698444786772', '2023-10-27 17:20:32', '2023-10-27 22:20:32', '2023-10-27 22:20:32'),
(46, 1, '2023-10-30', '20231030', '1', 'ApiFacturacion/xml/20607850179-RC-20231030-1.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698674729264', '2023-10-30 09:13:26', '2023-10-30 14:13:27', '2023-10-30 14:13:27'),
(47, 1, '2023-10-30', '20231030', '2', 'ApiFacturacion/xml/20607850179-RC-20231030-2.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698674953774', '2023-10-30 09:16:42', '2023-10-30 14:16:42', '2023-10-30 14:16:42'),
(48, 1, '2023-10-30', '20231030', '3', 'ApiFacturacion/xml/20607850179-RC-20231030-3.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698675112258', '2023-10-30 09:19:44', '2023-10-30 14:19:44', '2023-10-30 14:19:44'),
(49, 1, '2023-10-30', '20231030', '4', 'ApiFacturacion/xml/20607850179-RC-20231030-4.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698676508409', '2023-10-30 09:42:42', '2023-10-30 14:42:42', '2023-10-30 14:42:42'),
(50, 1, '2023-10-30', '20231030', '5', 'ApiFacturacion/xml/20607850179-RC-20231030-5.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698676734673', '2023-10-30 09:46:27', '2023-10-30 14:46:27', '2023-10-30 14:46:27'),
(51, 1, '2023-10-30', '20231030', '6', 'ApiFacturacion/xml/20607850179-RC-20231030-6.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698678407951', '2023-10-30 10:14:16', '2023-10-30 15:14:16', '2023-10-30 15:14:16'),
(52, 1, '2023-10-30', '20231030', '7', 'ApiFacturacion/xml/20607850179-RC-20231030-7.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698679207524', '2023-10-30 10:27:36', '2023-10-30 15:27:36', '2023-10-30 15:27:36'),
(53, 1, '2023-10-30', '20231030', '8', 'ApiFacturacion/xml/20607850179-RC-20231030-8.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698679350324', '2023-10-30 10:29:59', '2023-10-30 15:29:59', '2023-10-30 15:29:59'),
(54, 1, '2023-10-30', '20231030', '9', 'ApiFacturacion/xml/20607850179-RC-20231030-9.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698679433110', '2023-10-30 10:31:22', '2023-10-30 15:31:22', '2023-10-30 15:31:22'),
(55, 1, '2023-10-30', '20231030', '10', 'ApiFacturacion/xml/20607850179-RC-20231030-10.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698679541942', '2023-10-30 10:33:10', '2023-10-30 15:33:10', '2023-10-30 15:33:10'),
(56, 1, '2023-10-31', '20231031', '1', 'ApiFacturacion/xml/20607850179-RC-20231031-1.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698764637953', '2023-10-31 10:11:24', '2023-10-31 15:11:25', '2023-10-31 15:11:25'),
(57, 1, '2023-10-31', '20231031', '2', 'ApiFacturacion/xml/20607850179-RC-20231031-2.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698765065188', '2023-10-31 10:18:24', '2023-10-31 15:18:24', '2023-10-31 15:18:24'),
(58, 1, '2023-10-31', '20231031', '3', 'ApiFacturacion/xml/20607850179-RC-20231031-3.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698765315099', '2023-10-31 10:22:34', '2023-10-31 15:22:34', '2023-10-31 15:22:34'),
(59, 1, '2023-10-31', '20231031', '4', 'ApiFacturacion/xml/20607850179-RC-20231031-4.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698766316366', '2023-10-31 10:39:16', '2023-10-31 15:39:16', '2023-10-31 15:39:16'),
(60, 1, '2023-10-31', '20231031', '5', 'ApiFacturacion/xml/20607850179-RC-20231031-5.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698766853755', '2023-10-31 10:48:13', '2023-10-31 15:48:13', '2023-10-31 15:48:13'),
(61, 1, '2023-10-31', '20231031', '6', 'ApiFacturacion/xml/20607850179-RC-20231031-6.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698766900511', '2023-10-31 10:49:00', '2023-10-31 15:49:00', '2023-10-31 15:49:00'),
(62, 1, '2023-10-31', '20231031', '7', 'ApiFacturacion/xml/20607850179-RC-20231031-7.XML', NULL, 1, 'TICKET ENVIADO', NULL, '1698767173134', '2023-10-31 10:53:32', '2023-10-31 15:53:32', '2023-10-31 15:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `envio_resumen_detalle`
--

CREATE TABLE `envio_resumen_detalle` (
  `id_envio_resumen_detalle` bigint UNSIGNED NOT NULL,
  `id_envio_resumen` bigint UNSIGNED NOT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `envio_resumen_detalle_condicion` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `envio_resumen_detalle`
--

INSERT INTO `envio_resumen_detalle` (`id_envio_resumen_detalle`, `id_envio_resumen`, `id_venta`, `envio_resumen_detalle_condicion`, `created_at`, `updated_at`) VALUES
(52, 42, 30, 1, '2023-10-27 17:46:24', '2023-10-27 17:46:24'),
(53, 43, 33, 1, '2023-10-27 17:49:13', '2023-10-27 17:49:13'),
(54, 44, 34, 1, '2023-10-27 17:52:02', '2023-10-27 17:52:02'),
(55, 45, 36, 1, '2023-10-27 22:20:32', '2023-10-27 22:20:32'),
(56, 45, 38, 1, '2023-10-27 22:20:32', '2023-10-27 22:20:32'),
(57, 45, 39, 1, '2023-10-27 22:20:32', '2023-10-27 22:20:32'),
(58, 46, 41, 1, '2023-10-30 14:13:29', '2023-10-30 14:13:29'),
(59, 47, 42, 1, '2023-10-30 14:16:42', '2023-10-30 14:16:42'),
(60, 48, 43, 1, '2023-10-30 14:19:55', '2023-10-30 14:19:55'),
(61, 49, 44, 1, '2023-10-30 14:42:46', '2023-10-30 14:42:46'),
(62, 50, 45, 1, '2023-10-30 14:46:50', '2023-10-30 14:46:50'),
(63, 51, 47, 1, '2023-10-30 15:14:16', '2023-10-30 15:14:16'),
(64, 52, 48, 1, '2023-10-30 15:27:36', '2023-10-30 15:27:36'),
(65, 53, 48, 1, '2023-10-30 15:29:59', '2023-10-30 15:29:59'),
(66, 54, 48, 1, '2023-10-30 15:31:22', '2023-10-30 15:31:22'),
(67, 55, 48, 1, '2023-10-30 15:33:10', '2023-10-30 15:33:10'),
(68, 56, 66, 1, '2023-10-31 15:11:36', '2023-10-31 15:11:36'),
(69, 57, 66, 1, '2023-10-31 15:18:25', '2023-10-31 15:18:25'),
(70, 58, 66, 1, '2023-10-31 15:22:34', '2023-10-31 15:22:34'),
(71, 59, 66, 1, '2023-10-31 15:39:16', '2023-10-31 15:39:16'),
(72, 60, 66, 1, '2023-10-31 15:48:13', '2023-10-31 15:48:13'),
(73, 61, 66, 1, '2023-10-31 15:49:00', '2023-10-31 15:49:00'),
(74, 62, 66, 1, '2023-10-31 15:53:32', '2023-10-31 15:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medida`
--

CREATE TABLE `medida` (
  `id_medida` bigint UNSIGNED NOT NULL,
  `medida_codigo_unidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `medida_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `medida_activo` tinyint NOT NULL,
  `medida_grupo` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medida`
--

INSERT INTO `medida` (`id_medida`, `medida_codigo_unidad`, `medida_nombre`, `medida_activo`, `medida_grupo`, `created_at`, `updated_at`) VALUES
(1, '4A', 'BOBINAS         ', 0, NULL, NULL, NULL),
(2, 'BJ', 'BALDE                                             ', 0, NULL, NULL, NULL),
(3, 'BLL', 'BARRILES                                          ', 0, NULL, NULL, NULL),
(4, 'BG', 'BOLSA                                             ', 0, NULL, NULL, NULL),
(5, 'BO', 'BOTELLAS                                          ', 0, NULL, NULL, NULL),
(6, 'BX', 'CAJA                                              ', 0, NULL, NULL, NULL),
(7, 'CT', 'CARTONES                                          ', 0, NULL, NULL, NULL),
(8, 'CMK', 'CENTIMETRO CUADRADO                               ', 0, NULL, NULL, NULL),
(9, 'CMQ', 'CENTIMETRO CUBICO                                 ', 0, NULL, NULL, NULL),
(10, 'CMT', 'CENTIMETRO LINEAL                                 ', 0, NULL, NULL, NULL),
(11, 'CEN', 'CIENTO DE UNIDADES                                ', 0, NULL, NULL, NULL),
(12, 'CY', 'CILINDRO                                          ', 0, NULL, NULL, NULL),
(13, 'CJ', 'CONOS                                             ', 0, NULL, NULL, NULL),
(14, 'DZN', 'DOCENA                                            ', 0, NULL, NULL, NULL),
(15, 'DZP', 'DOCENA POR 10**6                                  ', 0, NULL, NULL, NULL),
(16, 'BE', 'FARDO                                             ', 0, NULL, NULL, NULL),
(17, 'GLI', 'GALON INGLES (4,545956L)', 0, NULL, NULL, NULL),
(18, 'GRM', 'GRAMO                                             ', 1, 1, NULL, NULL),
(19, 'GRO', 'GRUESA                                            ', 0, NULL, NULL, NULL),
(20, 'HLT', 'HECTOLITRO                                        ', 0, NULL, NULL, NULL),
(21, 'LEF', 'HOJA                                              ', 0, NULL, NULL, NULL),
(22, 'SET', 'JUEGO                                             ', 0, NULL, NULL, NULL),
(23, 'KGM', 'KILOGRAMO                                         ', 1, 1, NULL, NULL),
(24, 'KTM', 'KILOMETRO                                         ', 0, NULL, NULL, NULL),
(25, 'KWH', 'KILOVATIO HORA                                    ', 0, NULL, NULL, NULL),
(26, 'KT', 'KIT                                               ', 0, NULL, NULL, NULL),
(27, 'CA', 'LATAS                                             ', 0, NULL, NULL, NULL),
(28, 'LBR', 'LIBRAS                                            ', 0, NULL, NULL, NULL),
(29, 'LTR', 'LITRO                                             ', 1, 2, NULL, NULL),
(30, 'MWH', 'MEGAWATT HORA                                     ', 0, NULL, NULL, NULL),
(31, 'MTR', 'METRO                                             ', 0, NULL, NULL, NULL),
(32, 'MTK', 'METRO CUADRADO                                    ', 0, NULL, NULL, NULL),
(33, 'MTQ', 'METRO CUBICO                                      ', 0, NULL, NULL, NULL),
(34, 'MGM', 'MILIGRAMOS                                        ', 0, NULL, NULL, NULL),
(35, 'MLT', 'MILILITRO                                         ', 1, 2, NULL, NULL),
(36, 'MMT', 'MILIMETRO                                         ', 0, NULL, NULL, NULL),
(37, 'MMK', 'MILIMETRO CUADRADO                                ', 0, NULL, NULL, NULL),
(38, 'MMQ', 'MILIMETRO CUBICO                                  ', 0, NULL, NULL, NULL),
(39, 'MLL', 'MILLARES                                          ', 0, NULL, NULL, NULL),
(40, 'UM', 'MILLON DE UNIDADES                                ', 0, NULL, NULL, NULL),
(41, 'ONZ', 'ONZAS                                             ', 1, 2, NULL, NULL),
(42, 'PF', 'PALETAS                                           ', 0, NULL, NULL, NULL),
(43, 'PK', 'PAQUETE                                           ', 0, NULL, NULL, NULL),
(44, 'PR', 'PAR                                               ', 0, NULL, NULL, NULL),
(45, 'FOT', 'PIES                                              ', 0, NULL, NULL, NULL),
(46, 'FTK', 'PIES CUADRADOS                                    ', 0, NULL, NULL, NULL),
(47, 'FTQ', 'PIES CUBICOS                                      ', 0, NULL, NULL, NULL),
(48, 'C62', 'PIEZAS                                            ', 0, NULL, NULL, NULL),
(49, 'PG', 'PLACAS                                            ', 0, NULL, NULL, NULL),
(50, 'ST', 'PLIEGO                                            ', 0, NULL, NULL, NULL),
(51, 'INH', 'PULGADAS                                          ', 0, NULL, NULL, NULL),
(52, 'RM', 'RESMA                                             ', 0, NULL, NULL, NULL),
(53, 'DR', 'TAMBOR                                            ', 0, NULL, NULL, NULL),
(54, 'STN', 'TONELADA CORTA                                    ', 0, NULL, NULL, NULL),
(55, 'LTN', 'TONELADA LARGA                                    ', 0, NULL, NULL, NULL),
(56, 'TNE', 'TONELADAS                                         ', 0, NULL, NULL, NULL),
(57, 'TU', 'TUBOS                                             ', 0, NULL, NULL, NULL),
(58, 'NIU', 'UNIDAD (BIENES)                                   ', 1, NULL, NULL, NULL),
(59, 'ZZ', 'UNIDAD (SERVICIOS) ', 0, NULL, NULL, NULL),
(60, 'GLL', 'US GALON (3,7843 L)', 0, NULL, NULL, NULL),
(61, 'YRD', 'YARDA                                             ', 0, NULL, NULL, NULL),
(62, 'YDK', 'YARDA CUADRADA                                    ', 0, NULL, NULL, NULL),
(63, 'SACOS', 'SACOS', 1, NULL, NULL, NULL),
(64, 'ROLLOS', 'ROLLOS', 1, NULL, NULL, NULL),
(65, 'BOTELLON', 'BOTELLON', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id_menu` bigint UNSIGNED NOT NULL,
  `menu_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_controlador` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_icono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_orden` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_mostrar` tinyint NOT NULL,
  `menu_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id_menu`, `menu_nombre`, `menu_controlador`, `menu_icono`, `menu_orden`, `menu_mostrar`, `menu_estado`, `created_at`, `updated_at`) VALUES
(1, 'Configuracion', 'configuracion', 'bx bx-cog', '1', 1, 1, NULL, '2023-12-30 14:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_06_13_133850_create_permission_tables', 1),
(7, '2023_06_13_150844_create_empresa_table', 1),
(8, '2023_06_13_150911_create_persona_table', 1),
(9, '2023_06_13_152950_create_menus_table', 1),
(10, '2023_06_13_153320_create_submenu_table', 1),
(11, '2023_06_14_133623_create_opciones_table', 2),
(12, '2023_06_14_213443_create_tipo_documento_table', 3),
(13, '2023_07_20_152047_create_banner_inicio_table', 4),
(14, '2023_07_20_164415_create_nosotros_descripcion_table', 5),
(15, '2023_07_20_171428_create_nosotros_fotografia_table', 6),
(16, '2023_07_20_180248_create_contacto_table', 7),
(17, '2023_07_20_204909_create_nosotros_valores_table', 8),
(18, '2023_07_20_212855_create_clientes_miski_table', 9),
(19, '2023_07_20_222759_create_distribuidor_table', 10),
(20, '2023_07_21_132506_create_curiosidades_table', 11),
(21, '2023_07_21_152838_create_almacen_table', 12),
(22, '2023_07_21_172701_create_medida_table', 13),
(23, '2023_07_21_180427_create_recursos_table', 14),
(24, '2023_07_22_154406_create_ins_distribucion_table', 15),
(25, '2023_07_22_154429_create_ins_log_table', 15),
(26, '2023_07_23_143023_create_categoria_table', 16),
(27, '2023_07_24_033406_create_receta_table', 17),
(28, '2023_07_24_033447_create_producto_table', 17),
(29, '2023_07_24_140007_create_tipo_afectacion_table', 17),
(30, '2023_07_24_142606_create_tipo_ncreditos_table', 18),
(31, '2023_07_24_142622_create_tipo_ndebito_table', 18),
(32, '2023_07_24_144120_create_grupo_table', 19),
(33, '2023_07_24_144359_create_recetas_table', 20),
(34, '2023_07_24_144430_create_producto_table', 20),
(35, '2023_07_24_144456_create_producto_precios_table', 20),
(36, '2023_07_24_144524_create_detalle_recetas_table', 20),
(37, '2023_07_26_003931_create_proveedores_table', 21),
(38, '2023_07_26_135347_create_tipo_venta_table', 22),
(39, '2023_07_26_140835_create_tipo_pago_table', 23),
(40, '2023_07_26_212640_create_caja_numero_table', 24),
(41, '2023_07_26_213239_create_turno_table', 24),
(42, '2023_07_26_213724_create_caja_table', 24),
(43, '2023_07_27_001314_create_movimientos_productos_table', 25),
(44, '2023_07_27_001402_create_movimientos_productos_detalle_table', 25),
(45, '2023_07_27_171338_create_movimientos_caja_table', 26),
(46, '2023_07_27_210154_create_monedas_table', 27),
(47, '2023_07_28_044747_create_serie_table', 28),
(48, '2023_07_28_054319_create_clientes_table', 29),
(49, '2023_08_07_171859_create_tipo_cambio_table', 30),
(50, '2023_08_11_162110_create_agencias_table', 31),
(51, '2023_08_16_125915_create_imagenes_productos_table', 32),
(52, '2023_08_17_093650_create_formas_pago_table', 33),
(53, '2023_09_02_122953_create_nutrientes_table', 34),
(54, '2023_09_04_170139_create_nutrientes_productos_table', 35),
(55, '2023_09_05_135325_create_productos_distribuidores_table', 36),
(56, '2023_09_05_191115_create_recursos_nutrientes_table', 37);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `monedas`
--

CREATE TABLE `monedas` (
  `id_moneda` bigint UNSIGNED NOT NULL,
  `moneda` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrstandar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `simbolo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monedas`
--

INSERT INTO `monedas` (`id_moneda`, `moneda`, `abreviado`, `abrstandar`, `simbolo`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'SOLES', 'sol', 'PEN', 'S/', 1, NULL, NULL),
(2, 'DÓLARES', 'dol', 'USD', '$', 1, NULL, NULL),
(3, 'EUROS', 'eur', 'EUR', 'E', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` bigint UNSIGNED NOT NULL,
  `oferta_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oferta_nombre_in` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_fecha_inicio` date NOT NULL,
  `oferta_hora_inicio` time NOT NULL,
  `oferta_fecha_cierre` date NOT NULL,
  `oferta_hora_cierre` time NOT NULL,
  `oferta_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oferta_descuento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_estado` tinyint NOT NULL,
  `oferta_tipo` tinyint DEFAULT NULL COMMENT '1 descuento por producto 2 paquete de productos',
  `oferta_total_` decimal(10,2) DEFAULT NULL,
  `oferta_restar_cantidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_total_paquete` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `oferta_nombre`, `oferta_nombre_in`, `oferta_fecha_inicio`, `oferta_hora_inicio`, `oferta_fecha_cierre`, `oferta_hora_cierre`, `oferta_foto`, `oferta_descuento`, `oferta_estado`, `oferta_tipo`, `oferta_total_`, `oferta_restar_cantidad`, `oferta_total_paquete`, `created_at`, `updated_at`) VALUES
(1, '3 Tabasco 1 nectar Gratis', '3 Tabasco 1 nectar Free', '2023-11-02', '05:18:00', '2023-11-03', '14:19:00', 'pagina/oferta/1698946702-fondo1jpg.webp', NULL, 0, 2, '65.00', '5', '60.00', NULL, '2023-11-02 17:38:23'),
(2, 'Linea Pica Puro con 20%', 'Pure Pica Line with 20%', '2023-11-02', '09:42:00', '2023-11-04', '11:42:00', 'pagina/oferta/1698943410-Captura de pantalla (3).webp', '20', 1, 1, NULL, NULL, '0.00', NULL, NULL),
(3, '3 Tabasco 1 nectar Gratis', 'Pure Pica Line with 20%', '2023-11-02', '02:39:00', '2023-11-04', '14:39:00', 'pagina/oferta/1698946782-fondo1jpg.webp', NULL, 1, 2, '45.00', '8.5', '45.00', NULL, '2023-11-03 10:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `oferta_detalle`
--

CREATE TABLE `oferta_detalle` (
  `id_oferta_detalle` bigint UNSIGNED NOT NULL,
  `id_oferta` bigint UNSIGNED NOT NULL,
  `id_producto` bigint UNSIGNED NOT NULL,
  `oferta_detalle_precio_publico` decimal(10,2) NOT NULL,
  `oferta_detalle_precio_mayorista` decimal(10,2) NOT NULL,
  `oferta_detalle_cantidad` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_detalle_precio` decimal(10,2) DEFAULT NULL,
  `oferta_detalle_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oferta_detalle`
--

INSERT INTO `oferta_detalle` (`id_oferta_detalle`, `id_oferta`, `id_producto`, `oferta_detalle_precio_publico`, `oferta_detalle_precio_mayorista`, `oferta_detalle_cantidad`, `oferta_detalle_precio`, `oferta_detalle_estado`, `created_at`, `updated_at`) VALUES
(12, 3, 7, '0.00', '0.00', '1', '0.00', 1, NULL, NULL),
(3, 2, 9, '12.00', '9.60', '0', '0.00', 1, NULL, NULL),
(4, 2, 11, '12.00', '9.60', '0', '0.00', 1, NULL, NULL),
(5, 2, 10, '12.00', '9.60', '0', '0.00', 1, NULL, NULL),
(11, 3, 4, '0.00', '0.00', '3', '15.00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `opciones`
--

CREATE TABLE `opciones` (
  `id_opciones` bigint UNSIGNED NOT NULL,
  `id_submenu` bigint UNSIGNED NOT NULL,
  `opciones_funcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opciones_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opciones_orden` tinyint DEFAULT NULL,
  `opciones_mostrar` tinyint DEFAULT NULL,
  `opciones_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opciones`
--

INSERT INTO `opciones` (`id_opciones`, `id_submenu`, `opciones_funcion`, `opciones_nombre`, `opciones_orden`, `opciones_mostrar`, `opciones_estado`, `created_at`, `updated_at`) VALUES
(2, 1, 'gestion_de_menu', 'GESTION DE MENU', 1, 1, 1, '2023-07-19 19:06:25', '2023-07-19 19:06:25'),
(3, 7, 'gestion_de_submenu', 'GESTION DE SUBMENÚ', 1, 1, 1, '2023-07-19 20:30:06', '2023-07-19 20:30:06'),
(4, 8, 'gestion_de_opcion', 'GESTION DE OPCIÓN', 1, 1, 1, '2023-07-19 20:57:10', '2023-07-19 20:57:10'),
(5, 4, 'gestion_de_usuarios', 'GESTION DE USUARIOS', 1, 1, 1, '2023-07-19 22:37:16', '2023-07-19 22:37:16'),
(6, 5, 'gestion_de_roles', 'GESTIÓN DE ROLES', 1, 1, 1, '2023-07-19 22:41:34', '2023-07-19 22:41:34'),
(7, 6, 'gestion_de_permisos', 'GESTIÓN DE PERMISOS', 1, 1, 1, '2023-07-19 23:16:21', '2023-07-19 23:16:21'),
(65, 48, 'listar_iconos', 'LISTA DE ICONOS', 1, 1, 1, '2023-12-30 15:07:38', '2023-12-30 15:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `id_menu` int DEFAULT NULL,
  `id_submenu` int DEFAULT NULL,
  `id_opciones` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permiso_estado` int DEFAULT '1',
  `permiso_grupo` tinyint DEFAULT NULL COMMENT 'controladores 1 , submenus 2, opciones 3',
  `permiso_grupo_grupo` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `id_menu`, `id_submenu`, `id_opciones`, `name`, `guard_name`, `permiso_estado`, `permiso_grupo`, `permiso_grupo_grupo`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'configuracion', 'web', 1, 1, 1, NULL, '2023-07-08 19:54:25'),
(2, NULL, 1, NULL, 'menus', 'web', 1, 2, 1, NULL, NULL),
(3, NULL, 4, NULL, 'usuarios', 'web', 1, 2, 4, '2023-06-14 20:56:44', '2023-06-14 20:56:44'),
(4, NULL, 5, NULL, 'roles', 'web', 1, 2, 5, '2023-06-14 21:01:40', '2023-06-14 21:01:40'),
(6, NULL, 6, NULL, 'permisos', 'web', 1, 2, 6, '2023-06-15 19:49:44', '2023-06-15 19:49:44'),
(7, NULL, 7, NULL, 'submenu', 'web', 1, 2, 7, '2023-07-08 17:49:16', '2023-07-08 17:49:16'),
(8, NULL, NULL, 2, 'gestion_de_menu', 'web', 1, 3, 2, '2023-07-19 19:06:25', '2023-07-19 19:06:25'),
(9, NULL, NULL, 3, 'gestion_de_submenu', 'web', 1, 3, 3, '2023-07-19 20:30:06', '2023-07-19 20:30:06'),
(10, NULL, 8, NULL, 'opciones', 'web', 1, 2, 8, '2023-07-19 20:43:39', '2023-07-19 20:43:39'),
(11, NULL, NULL, 4, 'gestion_de_opcion', 'web', 1, 3, 4, '2023-07-19 20:57:10', '2023-07-19 20:57:10'),
(12, NULL, NULL, NULL, 'crear_menu', 'web', 1, 4, 2, '2023-07-19 21:58:14', '2023-07-19 21:58:14'),
(13, NULL, NULL, NULL, 'listar_datos_menu', 'web', 1, 4, 2, '2023-07-19 22:00:57', '2023-07-19 22:00:57'),
(21, NULL, NULL, NULL, 'deshabilitar_menu', 'web', 1, 4, 2, '2023-07-19 22:22:04', '2023-07-19 22:22:04'),
(22, NULL, NULL, 5, 'gestion_de_usuarios', 'web', 1, 3, 5, '2023-07-19 22:37:16', '2023-07-19 22:37:16'),
(23, NULL, NULL, 6, 'gestion_de_roles', 'web', 1, 3, 6, '2023-07-19 22:41:34', '2023-07-19 22:41:34'),
(24, NULL, NULL, 7, 'gestion_de_permisos', 'web', 1, 3, 7, '2023-07-19 23:16:21', '2023-07-19 23:16:21'),
(25, NULL, NULL, NULL, 'crear_usuarios', 'web', 1, 4, 5, '2023-07-19 23:19:19', '2023-07-19 23:19:19'),
(26, NULL, NULL, NULL, 'listar_datos_usuario', 'web', 1, 4, 5, '2023-07-19 23:19:30', '2023-07-19 23:19:30'),
(27, NULL, NULL, NULL, 'deshabilitar_usuario', 'web', 1, 4, 5, '2023-07-19 23:19:34', '2023-07-19 23:19:34'),
(28, NULL, NULL, NULL, 'crear_rol', 'web', 1, 4, 6, '2023-07-19 23:20:05', '2023-07-19 23:20:05'),
(29, NULL, NULL, NULL, 'listar_datos_rol', 'web', 1, 4, 6, '2023-07-19 23:20:15', '2023-07-19 23:20:15'),
(30, NULL, NULL, NULL, 'deshabilitar_rol', 'web', 1, 4, 6, '2023-07-19 23:20:21', '2023-07-19 23:20:21'),
(31, NULL, NULL, NULL, 'crear_permisos_rol', 'web', 1, 4, 6, '2023-07-19 23:21:26', '2023-07-19 23:21:26'),
(32, NULL, NULL, NULL, 'crear_permisos', 'web', 1, 4, 7, '2023-07-19 23:21:40', '2023-07-19 23:21:40'),
(33, NULL, NULL, NULL, 'listar_datos_permisos_por_rol', 'web', 1, 4, 6, '2023-07-19 23:22:01', '2023-07-19 23:22:01'),
(34, NULL, NULL, NULL, 'deshabilitar_permiso', 'web', 1, 4, 7, '2023-07-19 23:22:18', '2023-07-19 23:22:18'),
(35, NULL, NULL, NULL, 'eliminar_permiso', 'web', 1, 4, 4, '2023-07-19 23:22:54', '2023-07-19 23:22:54'),
(36, NULL, NULL, NULL, 'crear_opciones', 'web', 1, 4, 4, '2023-07-19 23:23:01', '2023-07-19 23:23:01'),
(37, NULL, NULL, NULL, 'listar_acciones_opciones', 'web', 1, 4, 4, '2023-07-19 23:23:08', '2023-07-19 23:23:08'),
(38, NULL, NULL, NULL, 'deshabilitar_opcion', 'web', 1, 4, 4, '2023-07-19 23:23:25', '2023-07-19 23:23:25'),
(39, NULL, NULL, NULL, 'crear_permisos_opciones', 'web', 1, 4, 4, '2023-07-20 03:40:04', '2023-07-20 03:40:04'),
(40, NULL, NULL, NULL, 'crear_submenu', 'web', 1, 4, 3, '2023-07-20 03:40:40', '2023-07-20 03:40:40'),
(41, NULL, NULL, NULL, 'listar_datos_submenu', 'web', 1, 4, 3, '2023-07-20 03:40:58', '2023-07-20 03:40:58'),
(42, NULL, NULL, NULL, 'deshabilitar_submenu', 'web', 1, 4, 3, '2023-07-20 03:41:02', '2023-07-20 03:41:02'),
(48, NULL, NULL, NULL, 'listar_datos_opciones', 'web', 1, 4, 4, '2023-07-20 04:12:21', '2023-07-20 04:12:21'),
(268, NULL, 48, NULL, 'iconos', 'web', 1, 2, 48, '2023-12-30 15:04:21', '2023-12-30 15:04:21'),
(269, NULL, NULL, 65, 'listar_iconos', 'web', 1, 3, 65, '2023-12-30 15:07:38', '2023-12-30 15:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `id_persona` bigint UNSIGNED NOT NULL,
  `id_empresa` bigint UNSIGNED NOT NULL,
  `persona_nombre` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_apellido_paterno` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_apellido_materno` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_tipo_documento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_dni` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_nacionalidad` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_estado_civil` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_direccion` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_discapacidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_job` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_nacimiento` date DEFAULT NULL,
  `persona_sexo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_telefono` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_telefono_2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_hijos` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_departamento` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_provincia` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_distrito` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_adicional` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_afp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_cuspp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_afiliac` date DEFAULT NULL,
  `persona_blacklist` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_number_account` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_bank_alt` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_number_account_alt` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_bank_cts` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_account_cts` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_cv` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_empleado` tinyint DEFAULT NULL,
  `person_codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`id_persona`, `id_empresa`, `persona_nombre`, `persona_apellido_paterno`, `persona_apellido_materno`, `persona_email`, `persona_tipo_documento`, `persona_dni`, `persona_nacionalidad`, `persona_estado_civil`, `persona_direccion`, `persona_discapacidad`, `persona_job`, `persona_nacimiento`, `persona_sexo`, `persona_telefono`, `persona_telefono_2`, `persona_foto`, `persona_hijos`, `persona_departamento`, `persona_provincia`, `persona_distrito`, `persona_adicional`, `persona_afp`, `persona_cuspp`, `persona_afiliac`, `persona_blacklist`, `persona_bank`, `persona_number_account`, `persona_bank_alt`, `persona_number_account_alt`, `persona_bank_cts`, `persona_account_cts`, `persona_cv`, `persona_empleado`, `person_codigo`, `persona_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Eder Alfredo', 'Apagueño', 'Reyna', 'reynaalfredo421@gmail.com', '2', '74077975', NULL, NULL, NULL, NULL, NULL, '2004-02-21', NULL, '956449198', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5465468498484948das', 1, NULL, '2023-11-15 17:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol_descripcion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_estado` int DEFAULT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `rol_descripcion`, `rol_estado`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'Tiene acceso a la gestión total del sistema', 1, 'web', NULL, '2023-06-15 19:33:58'),
(2, 'admin', 'Gestión del sistema', 1, 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(48, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(78, 1),
(81, 1),
(91, 1),
(102, 1),
(106, 1),
(107, 1),
(108, 1),
(111, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(130, 1),
(136, 1),
(140, 1),
(150, 1),
(154, 1),
(157, 1),
(169, 1),
(178, 1),
(190, 1),
(191, 1),
(194, 1),
(197, 1),
(198, 1),
(218, 1),
(219, 1),
(223, 1),
(227, 1),
(230, 1),
(232, 1),
(236, 1),
(237, 1),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(249, 1),
(267, 1),
(268, 1),
(269, 1),
(43, 2),
(44, 2),
(45, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(78, 2),
(81, 2),
(91, 2),
(102, 2),
(106, 2),
(107, 2),
(108, 2),
(111, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(127, 2),
(128, 2),
(130, 2),
(136, 2),
(140, 2),
(150, 2),
(154, 2),
(157, 2),
(169, 2),
(178, 2);

-- --------------------------------------------------------

--
-- Table structure for table `submenu`
--

CREATE TABLE `submenu` (
  `id_submenu` bigint UNSIGNED NOT NULL,
  `id_menu` bigint UNSIGNED NOT NULL,
  `submenu_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_funcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_mostrar` tinyint NOT NULL,
  `submenu_orden` int NOT NULL,
  `submenu_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submenu`
--

INSERT INTO `submenu` (`id_submenu`, `id_menu`, `submenu_nombre`, `submenu_funcion`, `submenu_mostrar`, `submenu_orden`, `submenu_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Menus', 'menus', 1, 1, 1, NULL, '2023-12-30 14:57:30'),
(4, 1, 'Usuarios', 'usuarios', 1, 2, 1, '2023-06-14 20:56:44', '2023-06-14 20:56:44'),
(5, 1, 'Roles', 'roles', 1, 3, 1, '2023-06-14 21:01:40', '2023-06-14 21:01:40'),
(6, 1, 'Permisos', 'permisos', 1, 4, 1, '2023-06-15 19:49:44', '2023-07-08 17:46:08'),
(7, 1, 'Submenu', 'submenu', 0, 4, 1, '2023-07-08 17:49:16', '2023-07-08 17:49:16'),
(8, 1, 'Opciones', 'opciones', 0, 6, 1, '2023-07-19 20:43:39', '2023-07-19 20:43:39'),
(48, 1, 'Iconos', 'iconos', 1, 5, 1, '2023-12-30 15:04:21', '2023-12-30 15:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `id_tipo_afectacion` bigint UNSIGNED NOT NULL,
  `codigo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_afectacion` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_afectacion` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_afectacion` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_afectacion`
--

INSERT INTO `tipo_afectacion` (`id_tipo_afectacion`, `codigo`, `descripcion`, `codigo_afectacion`, `nombre_afectacion`, `tipo_afectacion`, `created_at`, `updated_at`) VALUES
(1, '10', 'OP. GRAVADAS', '1000', 'IGV', 'VAT', NULL, NULL),
(2, '20', 'OP. EXONERADAS', '9997', 'EXO', 'VAT', NULL, NULL),
(3, '30', 'OP. INAFECTAS', '9998', 'INA', 'FRE', NULL, NULL),
(4, '21', 'OP. GRATUITAS', '9996', 'GRA', 'FRE', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` bigint UNSIGNED NOT NULL,
  `tipodocumento_codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_identidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_identidad_abr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `tipodocumento_codigo`, `tipo_documento_identidad`, `tipo_documento_identidad_abr`, `tipo_documento_estado`, `created_at`, `updated_at`) VALUES
(1, '0', 'DOC.TRIB.NO.DOM.SIN.RUC', '-', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58'),
(2, '1', 'Documento Nacional de Identidad', 'DNI', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58'),
(3, '4', 'Carnet de extranjería', 'EXTR', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58'),
(4, '6', 'Registro Unico de Contributentes', 'RUC', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58'),
(5, '7', 'Pasaporte', 'PAS', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58'),
(6, 'A', 'Cédula Diplomática de identidad', 'CDI', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58'),
(7, 'B', 'DOC.IDENT.PAIS.RESIDENCIA-NO.D', 'NO', 1, '2023-06-14 21:40:49', '2023-06-14 21:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_ncreditos`
--

CREATE TABLE `tipo_ncreditos` (
  `id_tipo_ncreditos` bigint UNSIGNED NOT NULL,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_nota_descripcion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_ncreditos`
--

INSERT INTO `tipo_ncreditos` (`id_tipo_ncreditos`, `codigo`, `tipo_nota_descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, '01', 'Anulación de la operacion', 0, NULL, NULL),
(2, '02', 'Anulación por error en el RUC', 0, NULL, NULL),
(3, '03', 'Corrección por error en la descripcion', 0, NULL, NULL),
(4, '04', 'Descuento Global', 0, NULL, NULL),
(5, '05', 'Descuento por ítem', 0, NULL, NULL),
(6, '06', 'Devolución total', 0, NULL, NULL),
(7, '07', 'Devolución por ítem', 0, NULL, NULL),
(8, '08', 'Bonificación', 0, NULL, NULL),
(9, '09', 'Disminición en el valor', 0, NULL, NULL),
(10, '10', 'Otros conceptos', 0, NULL, NULL),
(11, '11', 'Ajustes de operaciones de exportacion', 0, NULL, NULL),
(12, '12', 'Ajustes afectos al IVAP', 0, NULL, NULL),
(13, '13', 'Corrección del monto neto pendiente de pago y/o la(s) fechas(s) de vencimiento del pago \r\núnico o de las cuotas y/o los montos correspondientes a cada', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_ndebitos`
--

CREATE TABLE `tipo_ndebitos` (
  `id_tipo_ndebitos` bigint UNSIGNED NOT NULL,
  `codigo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_nota_descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_ndebitos`
--

INSERT INTO `tipo_ndebitos` (`id_tipo_ndebitos`, `codigo`, `tipo_nota_descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, '01', 'Intereses por mora', 0, NULL, NULL),
(2, '02', 'Aumento en el valor', 0, NULL, NULL),
(3, '03', 'Penalidades / Otros conceptos', 0, NULL, NULL),
(4, '10', 'Ajustes de operaciones de exportación', 0, NULL, NULL),
(5, '11', 'Ajustes afectos al IVAP', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id_tipo_pago` bigint UNSIGNED NOT NULL,
  `tipo_pago_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_pago_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_tipo_pago`, `tipo_pago_nombre`, `tipo_pago_estado`, `created_at`, `updated_at`) VALUES
(1, 'EFECTIVO', 1, '2023-07-26 14:11:41', '2023-07-26 14:11:47'),
(2, 'TARJETA', 1, '2023-07-26 14:11:41', '2023-07-26 14:11:41'),
(3, 'TRANSFERENCIA YAPE', 1, '2023-07-26 14:11:41', '2023-07-26 14:11:41'),
(4, 'TRANSFERENCIA PLIN', 1, '2023-07-26 14:11:41', '2023-07-26 14:11:41'),
(5, 'TRANSFERENCIA OTROS', 1, '2023-07-26 14:11:41', '2023-07-26 14:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_venta`
--

CREATE TABLE `tipo_venta` (
  `id_tipo_venta` bigint UNSIGNED NOT NULL,
  `tipo_venta_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_venta_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_venta`
--

INSERT INTO `tipo_venta` (`id_tipo_venta`, `tipo_venta_nombre`, `tipo_venta_estado`, `created_at`, `updated_at`) VALUES
(1, 'Boleta', 1, NULL, NULL),
(2, 'Factura', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transacciones`
--

CREATE TABLE `transacciones` (
  `id_transaccion` bigint NOT NULL,
  `id_venta` bigint NOT NULL,
  `transaccion_codigo` char(6) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `transaccion_tipo_pago` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `transaccion_total_pago` float(10,2) NOT NULL,
  `vads_capture_delay` int DEFAULT NULL,
  `vads_trans_status` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_card_brand` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_card_number` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_payment_certificate` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_ctx_mode` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_currency` char(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_effective_amount` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_effective_currency` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_trans_date` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_trans_uuid` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_hash` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_url_check_src` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `transaccion_creacion` datetime NOT NULL,
  `transaccion_cierre` datetime DEFAULT NULL,
  `transaccion_mt` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `transacciones`
--

INSERT INTO `transacciones` (`id_transaccion`, `id_venta`, `transaccion_codigo`, `transaccion_tipo_pago`, `transaccion_total_pago`, `vads_capture_delay`, `vads_trans_status`, `vads_card_brand`, `vads_card_number`, `vads_payment_certificate`, `vads_ctx_mode`, `vads_currency`, `vads_effective_amount`, `vads_effective_currency`, `vads_trans_date`, `vads_trans_uuid`, `vads_hash`, `vads_url_check_src`, `transaccion_creacion`, `transaccion_cierre`, `transaccion_mt`) VALUES
(116, 1870, '100116', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 18:51:35', NULL, '187064DA77B6'),
(117, 1871, '100117', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 18:56:41', NULL, '187164DA78E9'),
(118, 1872, '100118', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:00:47', NULL, '187264DA79DF'),
(119, 1873, '100119', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:03:09', NULL, '187364DA7A6D'),
(120, 1874, '100120', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:03:37', NULL, '187464DA7A89'),
(121, 1875, '100121', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:04:15', NULL, '187564DA7AAF'),
(122, 1876, '100122', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:05:06', NULL, '187664DA7AE2'),
(123, 1877, '100123', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:21:21', NULL, '187764DA7EB1'),
(124, 1878, '100124', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:54:12', NULL, '187864DA8664'),
(125, 1879, '100125', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 19:54:47', NULL, '187964DA8687'),
(126, 1880, '100126', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:00:12', NULL, '188064DA87CC'),
(127, 1881, '100127', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:04:09', NULL, '188164DA88B9'),
(128, 1882, '100128', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:08:55', NULL, '188264DA89D7'),
(129, 1883, '100129', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:11:44', NULL, '188364DA8A80'),
(130, 1884, '100130', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:12:54', NULL, '188464DA8AC6'),
(131, 1885, '100131', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:14:34', NULL, '188564DA8B2A'),
(132, 1886, '100132', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:17:03', NULL, '188664DA8BBF'),
(133, 1887, '100133', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:20:37', NULL, '188764DA8C95'),
(134, 1888, '100134', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:22:11', NULL, '188864DA8CF3'),
(135, 1889, '100135', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:24:21', NULL, '188964DA8D75'),
(136, 1890, '100136', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:26:06', NULL, '189064DA8DDE'),
(137, 1891, '100137', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:26:52', NULL, '189164DA8E0C'),
(138, 1892, '100138', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:32:01', NULL, '189264DA8F41'),
(139, 1893, '100139', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:32:58', NULL, '189364DA8F7A'),
(140, 1894, '100140', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:45:55', NULL, '189464DA9283'),
(141, 1895, '100141', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:47:45', NULL, '189564DA92F1'),
(142, 1896, '100142', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 20:49:53', NULL, '189664DA9371'),
(143, 1897, '100143', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:03:15', NULL, '189764DAA4A3'),
(144, 1898, '100144', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:04:57', NULL, '189864DAA509'),
(145, 1899, '100145', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:06:47', NULL, '189964DAA577'),
(146, 1900, '100146', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:08:15', NULL, '190064DAA5CF'),
(147, 1901, '100147', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:08:58', NULL, '190164DAA5FA'),
(148, 1902, '100148', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:38:27', NULL, '190264DAACE2'),
(149, 1903, '100149', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:44:29', NULL, '190364DAAE4D'),
(150, 1904, '100150', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:44:54', NULL, '190464DAAE66'),
(151, 1905, '100151', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 22:45:19', NULL, '190564DAAE7F'),
(152, 1906, '100152', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 17:48:17', NULL, '190664DAAF31'),
(153, 1907, '100153', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 17:48:53', NULL, '190764DAAF55'),
(154, 1908, '100154', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-14 17:49:22', NULL, '190864DAAF72'),
(155, 1909, '100155', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-15 16:03:17', NULL, '190964DBE815'),
(156, 1910, '100156', 'ONLINE', 24.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-15 17:31:21', NULL, '191064DBFCB9'),
(157, 1911, '100157', 'ONLINE', 24.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-15 17:34:54', NULL, '191164DBFD8E'),
(158, 1913, '100158', 'ONLINE', 87.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-16 17:35:57', NULL, '191364DD4F4D'),
(159, 1914, '100159', 'ONLINE', 153.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-16 18:04:52', NULL, '191464DD5614'),
(160, 1920, '100160', 'ONLINE', 84.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-19 10:05:26', NULL, '192064E0DA36'),
(161, 1921, '100161', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-19 10:09:47', NULL, '192164E0DB3B'),
(162, 1922, '100162', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-19 10:12:09', NULL, '192264E0DBC9'),
(163, 3, '100163', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-18 17:18:27', NULL, '3653059B3'),
(164, 4, '100164', 'ONLINE', 72.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-18 17:24:16', NULL, '465305B10'),
(165, 5, '100165', 'ONLINE', 72.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-18 17:27:24', NULL, '565305BCC'),
(166, 6, '100166', 'ONLINE', 72.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-19 10:05:43', NULL, '6653145C7'),
(167, 7, '100167', 'ONLINE', 96.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-19 11:30:45', NULL, '7653159B5'),
(168, 8, '100168', 'ONLINE', 60.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-19 14:15:25', NULL, '86531804D'),
(169, 9, '100169', 'ONLINE', 144.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-19 16:00:30', NULL, '9653198EE'),
(170, 10, '100170', 'ONLINE', 60.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-19 16:05:35', NULL, '1065319A1F'),
(171, 19, '100171', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-20 13:49:58', NULL, '196532CBD6'),
(172, 22, '100172', 'ONLINE', 156.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-20 15:02:49', NULL, '226532DCE8'),
(173, 40, '100173', 'ONLINE', 84.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-28 08:22:43', NULL, '40653D0B23'),
(174, 49, '100174', 'ONLINE', 144.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 10:56:33', NULL, '49653FD231'),
(175, 50, '100175', 'ONLINE', 144.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 10:58:15', NULL, '50653FD297'),
(176, 51, '100176', 'ONLINE', 144.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 12:00:26', NULL, '51653FE12A'),
(177, 52, '100177', 'ONLINE', 144.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 12:01:20', NULL, '52653FE160'),
(178, 56, '100178', 'ONLINE', 30.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 12:12:49', NULL, '56653FE411'),
(179, 57, '100179', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 12:18:03', NULL, '57653FE54B'),
(180, 58, '100180', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 12:32:38', NULL, '58653FE8B6'),
(181, 59, '100181', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 12:37:07', NULL, '59653FE9C3'),
(182, 60, '100182', 'ONLINE', 72.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 13:38:55', NULL, '60653FF83F'),
(183, 61, '100183', 'ONLINE', 72.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 14:00:42', NULL, '61653FFD5A'),
(184, 62, '100184', 'ONLINE', 60.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 14:24:37', NULL, '62654002F5'),
(185, 63, '100185', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 16:18:38', NULL, '6365401DAE'),
(186, 64, '100186', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 16:19:45', NULL, '6465401DF1'),
(187, 65, '100187', 'ONLINE', 15.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-30 16:21:57', NULL, '6565401E74'),
(188, 67, '100188', 'ONLINE', 111.10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-03 05:24:31', NULL, '676544CA5F'),
(189, 68, '100189', 'ONLINE', 69.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-03 07:01:22', NULL, '686544E112'),
(190, 71, '100190', 'ONLINE', 57.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-03 07:12:25', NULL, '716544E3A9'),
(191, 72, '100191', 'ONLINE', 12.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-03 08:50:16', NULL, '726544FA98');

-- --------------------------------------------------------

--
-- Table structure for table `ubigeo_peru_departments`
--

CREATE TABLE `ubigeo_peru_departments` (
  `id` varchar(2) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ubigeo_peru_departments`
--

INSERT INTO `ubigeo_peru_departments` (`id`, `name`) VALUES
('01', 'Amazonas'),
('02', 'Áncash'),
('03', 'Apurímac'),
('04', 'Arequipa'),
('05', 'Ayacucho'),
('06', 'Cajamarca'),
('07', 'Callao'),
('08', 'Cusco'),
('09', 'Huancavelica'),
('10', 'Huánuco'),
('11', 'Ica'),
('12', 'Junín'),
('13', 'La Libertad'),
('14', 'Lambayeque'),
('15', 'Lima'),
('16', 'Loreto'),
('17', 'Madre de Dios'),
('18', 'Moquegua'),
('19', 'Pasco'),
('20', 'Piura'),
('21', 'Puno'),
('22', 'San Martín'),
('23', 'Tacna'),
('24', 'Tumbes'),
('25', 'Ucayali');

-- --------------------------------------------------------

--
-- Table structure for table `ubigeo_peru_districts`
--

CREATE TABLE `ubigeo_peru_districts` (
  `id` varchar(6) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `province_id` varchar(4) DEFAULT NULL,
  `department_id` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ubigeo_peru_districts`
--

INSERT INTO `ubigeo_peru_districts` (`id`, `name`, `province_id`, `department_id`) VALUES
('010101', 'Chachapoyas', '0101', '01'),
('010102', 'Asunción', '0101', '01'),
('010103', 'Balsas', '0101', '01'),
('010104', 'Cheto', '0101', '01'),
('010105', 'Chiliquin', '0101', '01'),
('010106', 'Chuquibamba', '0101', '01'),
('010107', 'Granada', '0101', '01'),
('010108', 'Huancas', '0101', '01'),
('010109', 'La Jalca', '0101', '01'),
('010110', 'Leimebamba', '0101', '01'),
('010111', 'Levanto', '0101', '01'),
('010112', 'Magdalena', '0101', '01'),
('010113', 'Mariscal Castilla', '0101', '01'),
('010114', 'Molinopampa', '0101', '01'),
('010115', 'Montevideo', '0101', '01'),
('010116', 'Olleros', '0101', '01'),
('010117', 'Quinjalca', '0101', '01'),
('010118', 'San Francisco de Daguas', '0101', '01'),
('010119', 'San Isidro de Maino', '0101', '01'),
('010120', 'Soloco', '0101', '01'),
('010121', 'Sonche', '0101', '01'),
('010201', 'Bagua', '0102', '01'),
('010202', 'Aramango', '0102', '01'),
('010203', 'Copallin', '0102', '01'),
('010204', 'El Parco', '0102', '01'),
('010205', 'Imaza', '0102', '01'),
('010206', 'La Peca', '0102', '01'),
('010301', 'Jumbilla', '0103', '01'),
('010302', 'Chisquilla', '0103', '01'),
('010303', 'Churuja', '0103', '01'),
('010304', 'Corosha', '0103', '01'),
('010305', 'Cuispes', '0103', '01'),
('010306', 'Florida', '0103', '01'),
('010307', 'Jazan', '0103', '01'),
('010308', 'Recta', '0103', '01'),
('010309', 'San Carlos', '0103', '01'),
('010310', 'Shipasbamba', '0103', '01'),
('010311', 'Valera', '0103', '01'),
('010312', 'Yambrasbamba', '0103', '01'),
('010401', 'Nieva', '0104', '01'),
('010402', 'El Cenepa', '0104', '01'),
('010403', 'Río Santiago', '0104', '01'),
('010501', 'Lamud', '0105', '01'),
('010502', 'Camporredondo', '0105', '01'),
('010503', 'Cocabamba', '0105', '01'),
('010504', 'Colcamar', '0105', '01'),
('010505', 'Conila', '0105', '01'),
('010506', 'Inguilpata', '0105', '01'),
('010507', 'Longuita', '0105', '01'),
('010508', 'Lonya Chico', '0105', '01'),
('010509', 'Luya', '0105', '01'),
('010510', 'Luya Viejo', '0105', '01'),
('010511', 'María', '0105', '01'),
('010512', 'Ocalli', '0105', '01'),
('010513', 'Ocumal', '0105', '01'),
('010514', 'Pisuquia', '0105', '01'),
('010515', 'Providencia', '0105', '01'),
('010516', 'San Cristóbal', '0105', '01'),
('010517', 'San Francisco de Yeso', '0105', '01'),
('010518', 'San Jerónimo', '0105', '01'),
('010519', 'San Juan de Lopecancha', '0105', '01'),
('010520', 'Santa Catalina', '0105', '01'),
('010521', 'Santo Tomas', '0105', '01'),
('010522', 'Tingo', '0105', '01'),
('010523', 'Trita', '0105', '01'),
('010601', 'San Nicolás', '0106', '01'),
('010602', 'Chirimoto', '0106', '01'),
('010603', 'Cochamal', '0106', '01'),
('010604', 'Huambo', '0106', '01'),
('010605', 'Limabamba', '0106', '01'),
('010606', 'Longar', '0106', '01'),
('010607', 'Mariscal Benavides', '0106', '01'),
('010608', 'Milpuc', '0106', '01'),
('010609', 'Omia', '0106', '01'),
('010610', 'Santa Rosa', '0106', '01'),
('010611', 'Totora', '0106', '01'),
('010612', 'Vista Alegre', '0106', '01'),
('010701', 'Bagua Grande', '0107', '01'),
('010702', 'Cajaruro', '0107', '01'),
('010703', 'Cumba', '0107', '01'),
('010704', 'El Milagro', '0107', '01'),
('010705', 'Jamalca', '0107', '01'),
('010706', 'Lonya Grande', '0107', '01'),
('010707', 'Yamon', '0107', '01'),
('020101', 'Huaraz', '0201', '02'),
('020102', 'Cochabamba', '0201', '02'),
('020103', 'Colcabamba', '0201', '02'),
('020104', 'Huanchay', '0201', '02'),
('020105', 'Independencia', '0201', '02'),
('020106', 'Jangas', '0201', '02'),
('020107', 'La Libertad', '0201', '02'),
('020108', 'Olleros', '0201', '02'),
('020109', 'Pampas Grande', '0201', '02'),
('020110', 'Pariacoto', '0201', '02'),
('020111', 'Pira', '0201', '02'),
('020112', 'Tarica', '0201', '02'),
('020201', 'Aija', '0202', '02'),
('020202', 'Coris', '0202', '02'),
('020203', 'Huacllan', '0202', '02'),
('020204', 'La Merced', '0202', '02'),
('020205', 'Succha', '0202', '02'),
('020301', 'Llamellin', '0203', '02'),
('020302', 'Aczo', '0203', '02'),
('020303', 'Chaccho', '0203', '02'),
('020304', 'Chingas', '0203', '02'),
('020305', 'Mirgas', '0203', '02'),
('020306', 'San Juan de Rontoy', '0203', '02'),
('020401', 'Chacas', '0204', '02'),
('020402', 'Acochaca', '0204', '02'),
('020501', 'Chiquian', '0205', '02'),
('020502', 'Abelardo Pardo Lezameta', '0205', '02'),
('020503', 'Antonio Raymondi', '0205', '02'),
('020504', 'Aquia', '0205', '02'),
('020505', 'Cajacay', '0205', '02'),
('020506', 'Canis', '0205', '02'),
('020507', 'Colquioc', '0205', '02'),
('020508', 'Huallanca', '0205', '02'),
('020509', 'Huasta', '0205', '02'),
('020510', 'Huayllacayan', '0205', '02'),
('020511', 'La Primavera', '0205', '02'),
('020512', 'Mangas', '0205', '02'),
('020513', 'Pacllon', '0205', '02'),
('020514', 'San Miguel de Corpanqui', '0205', '02'),
('020515', 'Ticllos', '0205', '02'),
('020601', 'Carhuaz', '0206', '02'),
('020602', 'Acopampa', '0206', '02'),
('020603', 'Amashca', '0206', '02'),
('020604', 'Anta', '0206', '02'),
('020605', 'Ataquero', '0206', '02'),
('020606', 'Marcara', '0206', '02'),
('020607', 'Pariahuanca', '0206', '02'),
('020608', 'San Miguel de Aco', '0206', '02'),
('020609', 'Shilla', '0206', '02'),
('020610', 'Tinco', '0206', '02'),
('020611', 'Yungar', '0206', '02'),
('020701', 'San Luis', '0207', '02'),
('020702', 'San Nicolás', '0207', '02'),
('020703', 'Yauya', '0207', '02'),
('020801', 'Casma', '0208', '02'),
('020802', 'Buena Vista Alta', '0208', '02'),
('020803', 'Comandante Noel', '0208', '02'),
('020804', 'Yautan', '0208', '02'),
('020901', 'Corongo', '0209', '02'),
('020902', 'Aco', '0209', '02'),
('020903', 'Bambas', '0209', '02'),
('020904', 'Cusca', '0209', '02'),
('020905', 'La Pampa', '0209', '02'),
('020906', 'Yanac', '0209', '02'),
('020907', 'Yupan', '0209', '02'),
('021001', 'Huari', '0210', '02'),
('021002', 'Anra', '0210', '02'),
('021003', 'Cajay', '0210', '02'),
('021004', 'Chavin de Huantar', '0210', '02'),
('021005', 'Huacachi', '0210', '02'),
('021006', 'Huacchis', '0210', '02'),
('021007', 'Huachis', '0210', '02'),
('021008', 'Huantar', '0210', '02'),
('021009', 'Masin', '0210', '02'),
('021010', 'Paucas', '0210', '02'),
('021011', 'Ponto', '0210', '02'),
('021012', 'Rahuapampa', '0210', '02'),
('021013', 'Rapayan', '0210', '02'),
('021014', 'San Marcos', '0210', '02'),
('021015', 'San Pedro de Chana', '0210', '02'),
('021016', 'Uco', '0210', '02'),
('021101', 'Huarmey', '0211', '02'),
('021102', 'Cochapeti', '0211', '02'),
('021103', 'Culebras', '0211', '02'),
('021104', 'Huayan', '0211', '02'),
('021105', 'Malvas', '0211', '02'),
('021201', 'Caraz', '0212', '02'),
('021202', 'Huallanca', '0212', '02'),
('021203', 'Huata', '0212', '02'),
('021204', 'Huaylas', '0212', '02'),
('021205', 'Mato', '0212', '02'),
('021206', 'Pamparomas', '0212', '02'),
('021207', 'Pueblo Libre', '0212', '02'),
('021208', 'Santa Cruz', '0212', '02'),
('021209', 'Santo Toribio', '0212', '02'),
('021210', 'Yuracmarca', '0212', '02'),
('021301', 'Piscobamba', '0213', '02'),
('021302', 'Casca', '0213', '02'),
('021303', 'Eleazar Guzmán Barron', '0213', '02'),
('021304', 'Fidel Olivas Escudero', '0213', '02'),
('021305', 'Llama', '0213', '02'),
('021306', 'Llumpa', '0213', '02'),
('021307', 'Lucma', '0213', '02'),
('021308', 'Musga', '0213', '02'),
('021401', 'Ocros', '0214', '02'),
('021402', 'Acas', '0214', '02'),
('021403', 'Cajamarquilla', '0214', '02'),
('021404', 'Carhuapampa', '0214', '02'),
('021405', 'Cochas', '0214', '02'),
('021406', 'Congas', '0214', '02'),
('021407', 'Llipa', '0214', '02'),
('021408', 'San Cristóbal de Rajan', '0214', '02'),
('021409', 'San Pedro', '0214', '02'),
('021410', 'Santiago de Chilcas', '0214', '02'),
('021501', 'Cabana', '0215', '02'),
('021502', 'Bolognesi', '0215', '02'),
('021503', 'Conchucos', '0215', '02'),
('021504', 'Huacaschuque', '0215', '02'),
('021505', 'Huandoval', '0215', '02'),
('021506', 'Lacabamba', '0215', '02'),
('021507', 'Llapo', '0215', '02'),
('021508', 'Pallasca', '0215', '02'),
('021509', 'Pampas', '0215', '02'),
('021510', 'Santa Rosa', '0215', '02'),
('021511', 'Tauca', '0215', '02'),
('021601', 'Pomabamba', '0216', '02'),
('021602', 'Huayllan', '0216', '02'),
('021603', 'Parobamba', '0216', '02'),
('021604', 'Quinuabamba', '0216', '02'),
('021701', 'Recuay', '0217', '02'),
('021702', 'Catac', '0217', '02'),
('021703', 'Cotaparaco', '0217', '02'),
('021704', 'Huayllapampa', '0217', '02'),
('021705', 'Llacllin', '0217', '02'),
('021706', 'Marca', '0217', '02'),
('021707', 'Pampas Chico', '0217', '02'),
('021708', 'Pararin', '0217', '02'),
('021709', 'Tapacocha', '0217', '02'),
('021710', 'Ticapampa', '0217', '02'),
('021801', 'Chimbote', '0218', '02'),
('021802', 'Cáceres del Perú', '0218', '02'),
('021803', 'Coishco', '0218', '02'),
('021804', 'Macate', '0218', '02'),
('021805', 'Moro', '0218', '02'),
('021806', 'Nepeña', '0218', '02'),
('021807', 'Samanco', '0218', '02'),
('021808', 'Santa', '0218', '02'),
('021809', 'Nuevo Chimbote', '0218', '02'),
('021901', 'Sihuas', '0219', '02'),
('021902', 'Acobamba', '0219', '02'),
('021903', 'Alfonso Ugarte', '0219', '02'),
('021904', 'Cashapampa', '0219', '02'),
('021905', 'Chingalpo', '0219', '02'),
('021906', 'Huayllabamba', '0219', '02'),
('021907', 'Quiches', '0219', '02'),
('021908', 'Ragash', '0219', '02'),
('021909', 'San Juan', '0219', '02'),
('021910', 'Sicsibamba', '0219', '02'),
('022001', 'Yungay', '0220', '02'),
('022002', 'Cascapara', '0220', '02'),
('022003', 'Mancos', '0220', '02'),
('022004', 'Matacoto', '0220', '02'),
('022005', 'Quillo', '0220', '02'),
('022006', 'Ranrahirca', '0220', '02'),
('022007', 'Shupluy', '0220', '02'),
('022008', 'Yanama', '0220', '02'),
('030101', 'Abancay', '0301', '03'),
('030102', 'Chacoche', '0301', '03'),
('030103', 'Circa', '0301', '03'),
('030104', 'Curahuasi', '0301', '03'),
('030105', 'Huanipaca', '0301', '03'),
('030106', 'Lambrama', '0301', '03'),
('030107', 'Pichirhua', '0301', '03'),
('030108', 'San Pedro de Cachora', '0301', '03'),
('030109', 'Tamburco', '0301', '03'),
('030201', 'Andahuaylas', '0302', '03'),
('030202', 'Andarapa', '0302', '03'),
('030203', 'Chiara', '0302', '03'),
('030204', 'Huancarama', '0302', '03'),
('030205', 'Huancaray', '0302', '03'),
('030206', 'Huayana', '0302', '03'),
('030207', 'Kishuara', '0302', '03'),
('030208', 'Pacobamba', '0302', '03'),
('030209', 'Pacucha', '0302', '03'),
('030210', 'Pampachiri', '0302', '03'),
('030211', 'Pomacocha', '0302', '03'),
('030212', 'San Antonio de Cachi', '0302', '03'),
('030213', 'San Jerónimo', '0302', '03'),
('030214', 'San Miguel de Chaccrampa', '0302', '03'),
('030215', 'Santa María de Chicmo', '0302', '03'),
('030216', 'Talavera', '0302', '03'),
('030217', 'Tumay Huaraca', '0302', '03'),
('030218', 'Turpo', '0302', '03'),
('030219', 'Kaquiabamba', '0302', '03'),
('030220', 'José María Arguedas', '0302', '03'),
('030301', 'Antabamba', '0303', '03'),
('030302', 'El Oro', '0303', '03'),
('030303', 'Huaquirca', '0303', '03'),
('030304', 'Juan Espinoza Medrano', '0303', '03'),
('030305', 'Oropesa', '0303', '03'),
('030306', 'Pachaconas', '0303', '03'),
('030307', 'Sabaino', '0303', '03'),
('030401', 'Chalhuanca', '0304', '03'),
('030402', 'Capaya', '0304', '03'),
('030403', 'Caraybamba', '0304', '03'),
('030404', 'Chapimarca', '0304', '03'),
('030405', 'Colcabamba', '0304', '03'),
('030406', 'Cotaruse', '0304', '03'),
('030407', 'Ihuayllo', '0304', '03'),
('030408', 'Justo Apu Sahuaraura', '0304', '03'),
('030409', 'Lucre', '0304', '03'),
('030410', 'Pocohuanca', '0304', '03'),
('030411', 'San Juan de Chacña', '0304', '03'),
('030412', 'Sañayca', '0304', '03'),
('030413', 'Soraya', '0304', '03'),
('030414', 'Tapairihua', '0304', '03'),
('030415', 'Tintay', '0304', '03'),
('030416', 'Toraya', '0304', '03'),
('030417', 'Yanaca', '0304', '03'),
('030501', 'Tambobamba', '0305', '03'),
('030502', 'Cotabambas', '0305', '03'),
('030503', 'Coyllurqui', '0305', '03'),
('030504', 'Haquira', '0305', '03'),
('030505', 'Mara', '0305', '03'),
('030506', 'Challhuahuacho', '0305', '03'),
('030601', 'Chincheros', '0306', '03'),
('030602', 'Anco_Huallo', '0306', '03'),
('030603', 'Cocharcas', '0306', '03'),
('030604', 'Huaccana', '0306', '03'),
('030605', 'Ocobamba', '0306', '03'),
('030606', 'Ongoy', '0306', '03'),
('030607', 'Uranmarca', '0306', '03'),
('030608', 'Ranracancha', '0306', '03'),
('030609', 'Rocchacc', '0306', '03'),
('030610', 'El Porvenir', '0306', '03'),
('030611', 'Los Chankas', '0306', '03'),
('030701', 'Chuquibambilla', '0307', '03'),
('030702', 'Curpahuasi', '0307', '03'),
('030703', 'Gamarra', '0307', '03'),
('030704', 'Huayllati', '0307', '03'),
('030705', 'Mamara', '0307', '03'),
('030706', 'Micaela Bastidas', '0307', '03'),
('030707', 'Pataypampa', '0307', '03'),
('030708', 'Progreso', '0307', '03'),
('030709', 'San Antonio', '0307', '03'),
('030710', 'Santa Rosa', '0307', '03'),
('030711', 'Turpay', '0307', '03'),
('030712', 'Vilcabamba', '0307', '03'),
('030713', 'Virundo', '0307', '03'),
('030714', 'Curasco', '0307', '03'),
('040101', 'Arequipa', '0401', '04'),
('040102', 'Alto Selva Alegre', '0401', '04'),
('040103', 'Cayma', '0401', '04'),
('040104', 'Cerro Colorado', '0401', '04'),
('040105', 'Characato', '0401', '04'),
('040106', 'Chiguata', '0401', '04'),
('040107', 'Jacobo Hunter', '0401', '04'),
('040108', 'La Joya', '0401', '04'),
('040109', 'Mariano Melgar', '0401', '04'),
('040110', 'Miraflores', '0401', '04'),
('040111', 'Mollebaya', '0401', '04'),
('040112', 'Paucarpata', '0401', '04'),
('040113', 'Pocsi', '0401', '04'),
('040114', 'Polobaya', '0401', '04'),
('040115', 'Quequeña', '0401', '04'),
('040116', 'Sabandia', '0401', '04'),
('040117', 'Sachaca', '0401', '04'),
('040118', 'San Juan de Siguas', '0401', '04'),
('040119', 'San Juan de Tarucani', '0401', '04'),
('040120', 'Santa Isabel de Siguas', '0401', '04'),
('040121', 'Santa Rita de Siguas', '0401', '04'),
('040122', 'Socabaya', '0401', '04'),
('040123', 'Tiabaya', '0401', '04'),
('040124', 'Uchumayo', '0401', '04'),
('040125', 'Vitor', '0401', '04'),
('040126', 'Yanahuara', '0401', '04'),
('040127', 'Yarabamba', '0401', '04'),
('040128', 'Yura', '0401', '04'),
('040129', 'José Luis Bustamante Y Rivero', '0401', '04'),
('040201', 'Camaná', '0402', '04'),
('040202', 'José María Quimper', '0402', '04'),
('040203', 'Mariano Nicolás Valcárcel', '0402', '04'),
('040204', 'Mariscal Cáceres', '0402', '04'),
('040205', 'Nicolás de Pierola', '0402', '04'),
('040206', 'Ocoña', '0402', '04'),
('040207', 'Quilca', '0402', '04'),
('040208', 'Samuel Pastor', '0402', '04'),
('040301', 'Caravelí', '0403', '04'),
('040302', 'Acarí', '0403', '04'),
('040303', 'Atico', '0403', '04'),
('040304', 'Atiquipa', '0403', '04'),
('040305', 'Bella Unión', '0403', '04'),
('040306', 'Cahuacho', '0403', '04'),
('040307', 'Chala', '0403', '04'),
('040308', 'Chaparra', '0403', '04'),
('040309', 'Huanuhuanu', '0403', '04'),
('040310', 'Jaqui', '0403', '04'),
('040311', 'Lomas', '0403', '04'),
('040312', 'Quicacha', '0403', '04'),
('040313', 'Yauca', '0403', '04'),
('040401', 'Aplao', '0404', '04'),
('040402', 'Andagua', '0404', '04'),
('040403', 'Ayo', '0404', '04'),
('040404', 'Chachas', '0404', '04'),
('040405', 'Chilcaymarca', '0404', '04'),
('040406', 'Choco', '0404', '04'),
('040407', 'Huancarqui', '0404', '04'),
('040408', 'Machaguay', '0404', '04'),
('040409', 'Orcopampa', '0404', '04'),
('040410', 'Pampacolca', '0404', '04'),
('040411', 'Tipan', '0404', '04'),
('040412', 'Uñon', '0404', '04'),
('040413', 'Uraca', '0404', '04'),
('040414', 'Viraco', '0404', '04'),
('040501', 'Chivay', '0405', '04'),
('040502', 'Achoma', '0405', '04'),
('040503', 'Cabanaconde', '0405', '04'),
('040504', 'Callalli', '0405', '04'),
('040505', 'Caylloma', '0405', '04'),
('040506', 'Coporaque', '0405', '04'),
('040507', 'Huambo', '0405', '04'),
('040508', 'Huanca', '0405', '04'),
('040509', 'Ichupampa', '0405', '04'),
('040510', 'Lari', '0405', '04'),
('040511', 'Lluta', '0405', '04'),
('040512', 'Maca', '0405', '04'),
('040513', 'Madrigal', '0405', '04'),
('040514', 'San Antonio de Chuca', '0405', '04'),
('040515', 'Sibayo', '0405', '04'),
('040516', 'Tapay', '0405', '04'),
('040517', 'Tisco', '0405', '04'),
('040518', 'Tuti', '0405', '04'),
('040519', 'Yanque', '0405', '04'),
('040520', 'Majes', '0405', '04'),
('040601', 'Chuquibamba', '0406', '04'),
('040602', 'Andaray', '0406', '04'),
('040603', 'Cayarani', '0406', '04'),
('040604', 'Chichas', '0406', '04'),
('040605', 'Iray', '0406', '04'),
('040606', 'Río Grande', '0406', '04'),
('040607', 'Salamanca', '0406', '04'),
('040608', 'Yanaquihua', '0406', '04'),
('040701', 'Mollendo', '0407', '04'),
('040702', 'Cocachacra', '0407', '04'),
('040703', 'Dean Valdivia', '0407', '04'),
('040704', 'Islay', '0407', '04'),
('040705', 'Mejia', '0407', '04'),
('040706', 'Punta de Bombón', '0407', '04'),
('040801', 'Cotahuasi', '0408', '04'),
('040802', 'Alca', '0408', '04'),
('040803', 'Charcana', '0408', '04'),
('040804', 'Huaynacotas', '0408', '04'),
('040805', 'Pampamarca', '0408', '04'),
('040806', 'Puyca', '0408', '04'),
('040807', 'Quechualla', '0408', '04'),
('040808', 'Sayla', '0408', '04'),
('040809', 'Tauria', '0408', '04'),
('040810', 'Tomepampa', '0408', '04'),
('040811', 'Toro', '0408', '04'),
('050101', 'Ayacucho', '0501', '05'),
('050102', 'Acocro', '0501', '05'),
('050103', 'Acos Vinchos', '0501', '05'),
('050104', 'Carmen Alto', '0501', '05'),
('050105', 'Chiara', '0501', '05'),
('050106', 'Ocros', '0501', '05'),
('050107', 'Pacaycasa', '0501', '05'),
('050108', 'Quinua', '0501', '05'),
('050109', 'San José de Ticllas', '0501', '05'),
('050110', 'San Juan Bautista', '0501', '05'),
('050111', 'Santiago de Pischa', '0501', '05'),
('050112', 'Socos', '0501', '05'),
('050113', 'Tambillo', '0501', '05'),
('050114', 'Vinchos', '0501', '05'),
('050115', 'Jesús Nazareno', '0501', '05'),
('050116', 'Andrés Avelino Cáceres Dorregaray', '0501', '05'),
('050201', 'Cangallo', '0502', '05'),
('050202', 'Chuschi', '0502', '05'),
('050203', 'Los Morochucos', '0502', '05'),
('050204', 'María Parado de Bellido', '0502', '05'),
('050205', 'Paras', '0502', '05'),
('050206', 'Totos', '0502', '05'),
('050301', 'Sancos', '0503', '05'),
('050302', 'Carapo', '0503', '05'),
('050303', 'Sacsamarca', '0503', '05'),
('050304', 'Santiago de Lucanamarca', '0503', '05'),
('050401', 'Huanta', '0504', '05'),
('050402', 'Ayahuanco', '0504', '05'),
('050403', 'Huamanguilla', '0504', '05'),
('050404', 'Iguain', '0504', '05'),
('050405', 'Luricocha', '0504', '05'),
('050406', 'Santillana', '0504', '05'),
('050407', 'Sivia', '0504', '05'),
('050408', 'Llochegua', '0504', '05'),
('050409', 'Canayre', '0504', '05'),
('050410', 'Uchuraccay', '0504', '05'),
('050411', 'Pucacolpa', '0504', '05'),
('050412', 'Chaca', '0504', '05'),
('050501', 'San Miguel', '0505', '05'),
('050502', 'Anco', '0505', '05'),
('050503', 'Ayna', '0505', '05'),
('050504', 'Chilcas', '0505', '05'),
('050505', 'Chungui', '0505', '05'),
('050506', 'Luis Carranza', '0505', '05'),
('050507', 'Santa Rosa', '0505', '05'),
('050508', 'Tambo', '0505', '05'),
('050509', 'Samugari', '0505', '05'),
('050510', 'Anchihuay', '0505', '05'),
('050511', 'Oronccoy', '0505', '05'),
('050601', 'Puquio', '0506', '05'),
('050602', 'Aucara', '0506', '05'),
('050603', 'Cabana', '0506', '05'),
('050604', 'Carmen Salcedo', '0506', '05'),
('050605', 'Chaviña', '0506', '05'),
('050606', 'Chipao', '0506', '05'),
('050607', 'Huac-Huas', '0506', '05'),
('050608', 'Laramate', '0506', '05'),
('050609', 'Leoncio Prado', '0506', '05'),
('050610', 'Llauta', '0506', '05'),
('050611', 'Lucanas', '0506', '05'),
('050612', 'Ocaña', '0506', '05'),
('050613', 'Otoca', '0506', '05'),
('050614', 'Saisa', '0506', '05'),
('050615', 'San Cristóbal', '0506', '05'),
('050616', 'San Juan', '0506', '05'),
('050617', 'San Pedro', '0506', '05'),
('050618', 'San Pedro de Palco', '0506', '05'),
('050619', 'Sancos', '0506', '05'),
('050620', 'Santa Ana de Huaycahuacho', '0506', '05'),
('050621', 'Santa Lucia', '0506', '05'),
('050701', 'Coracora', '0507', '05'),
('050702', 'Chumpi', '0507', '05'),
('050703', 'Coronel Castañeda', '0507', '05'),
('050704', 'Pacapausa', '0507', '05'),
('050705', 'Pullo', '0507', '05'),
('050706', 'Puyusca', '0507', '05'),
('050707', 'San Francisco de Ravacayco', '0507', '05'),
('050708', 'Upahuacho', '0507', '05'),
('050801', 'Pausa', '0508', '05'),
('050802', 'Colta', '0508', '05'),
('050803', 'Corculla', '0508', '05'),
('050804', 'Lampa', '0508', '05'),
('050805', 'Marcabamba', '0508', '05'),
('050806', 'Oyolo', '0508', '05'),
('050807', 'Pararca', '0508', '05'),
('050808', 'San Javier de Alpabamba', '0508', '05'),
('050809', 'San José de Ushua', '0508', '05'),
('050810', 'Sara Sara', '0508', '05'),
('050901', 'Querobamba', '0509', '05'),
('050902', 'Belén', '0509', '05'),
('050903', 'Chalcos', '0509', '05'),
('050904', 'Chilcayoc', '0509', '05'),
('050905', 'Huacaña', '0509', '05'),
('050906', 'Morcolla', '0509', '05'),
('050907', 'Paico', '0509', '05'),
('050908', 'San Pedro de Larcay', '0509', '05'),
('050909', 'San Salvador de Quije', '0509', '05'),
('050910', 'Santiago de Paucaray', '0509', '05'),
('050911', 'Soras', '0509', '05'),
('051001', 'Huancapi', '0510', '05'),
('051002', 'Alcamenca', '0510', '05'),
('051003', 'Apongo', '0510', '05'),
('051004', 'Asquipata', '0510', '05'),
('051005', 'Canaria', '0510', '05'),
('051006', 'Cayara', '0510', '05'),
('051007', 'Colca', '0510', '05'),
('051008', 'Huamanquiquia', '0510', '05'),
('051009', 'Huancaraylla', '0510', '05'),
('051010', 'Hualla', '0510', '05'),
('051011', 'Sarhua', '0510', '05'),
('051012', 'Vilcanchos', '0510', '05'),
('051101', 'Vilcas Huaman', '0511', '05'),
('051102', 'Accomarca', '0511', '05'),
('051103', 'Carhuanca', '0511', '05'),
('051104', 'Concepción', '0511', '05'),
('051105', 'Huambalpa', '0511', '05'),
('051106', 'Independencia', '0511', '05'),
('051107', 'Saurama', '0511', '05'),
('051108', 'Vischongo', '0511', '05'),
('060101', 'Cajamarca', '0601', '06'),
('060102', 'Asunción', '0601', '06'),
('060103', 'Chetilla', '0601', '06'),
('060104', 'Cospan', '0601', '06'),
('060105', 'Encañada', '0601', '06'),
('060106', 'Jesús', '0601', '06'),
('060107', 'Llacanora', '0601', '06'),
('060108', 'Los Baños del Inca', '0601', '06'),
('060109', 'Magdalena', '0601', '06'),
('060110', 'Matara', '0601', '06'),
('060111', 'Namora', '0601', '06'),
('060112', 'San Juan', '0601', '06'),
('060201', 'Cajabamba', '0602', '06'),
('060202', 'Cachachi', '0602', '06'),
('060203', 'Condebamba', '0602', '06'),
('060204', 'Sitacocha', '0602', '06'),
('060301', 'Celendín', '0603', '06'),
('060302', 'Chumuch', '0603', '06'),
('060303', 'Cortegana', '0603', '06'),
('060304', 'Huasmin', '0603', '06'),
('060305', 'Jorge Chávez', '0603', '06'),
('060306', 'José Gálvez', '0603', '06'),
('060307', 'Miguel Iglesias', '0603', '06'),
('060308', 'Oxamarca', '0603', '06'),
('060309', 'Sorochuco', '0603', '06'),
('060310', 'Sucre', '0603', '06'),
('060311', 'Utco', '0603', '06'),
('060312', 'La Libertad de Pallan', '0603', '06'),
('060401', 'Chota', '0604', '06'),
('060402', 'Anguia', '0604', '06'),
('060403', 'Chadin', '0604', '06'),
('060404', 'Chiguirip', '0604', '06'),
('060405', 'Chimban', '0604', '06'),
('060406', 'Choropampa', '0604', '06'),
('060407', 'Cochabamba', '0604', '06'),
('060408', 'Conchan', '0604', '06'),
('060409', 'Huambos', '0604', '06'),
('060410', 'Lajas', '0604', '06'),
('060411', 'Llama', '0604', '06'),
('060412', 'Miracosta', '0604', '06'),
('060413', 'Paccha', '0604', '06'),
('060414', 'Pion', '0604', '06'),
('060415', 'Querocoto', '0604', '06'),
('060416', 'San Juan de Licupis', '0604', '06'),
('060417', 'Tacabamba', '0604', '06'),
('060418', 'Tocmoche', '0604', '06'),
('060419', 'Chalamarca', '0604', '06'),
('060501', 'Contumaza', '0605', '06'),
('060502', 'Chilete', '0605', '06'),
('060503', 'Cupisnique', '0605', '06'),
('060504', 'Guzmango', '0605', '06'),
('060505', 'San Benito', '0605', '06'),
('060506', 'Santa Cruz de Toledo', '0605', '06'),
('060507', 'Tantarica', '0605', '06'),
('060508', 'Yonan', '0605', '06'),
('060601', 'Cutervo', '0606', '06'),
('060602', 'Callayuc', '0606', '06'),
('060603', 'Choros', '0606', '06'),
('060604', 'Cujillo', '0606', '06'),
('060605', 'La Ramada', '0606', '06'),
('060606', 'Pimpingos', '0606', '06'),
('060607', 'Querocotillo', '0606', '06'),
('060608', 'San Andrés de Cutervo', '0606', '06'),
('060609', 'San Juan de Cutervo', '0606', '06'),
('060610', 'San Luis de Lucma', '0606', '06'),
('060611', 'Santa Cruz', '0606', '06'),
('060612', 'Santo Domingo de la Capilla', '0606', '06'),
('060613', 'Santo Tomas', '0606', '06'),
('060614', 'Socota', '0606', '06'),
('060615', 'Toribio Casanova', '0606', '06'),
('060701', 'Bambamarca', '0607', '06'),
('060702', 'Chugur', '0607', '06'),
('060703', 'Hualgayoc', '0607', '06'),
('060801', 'Jaén', '0608', '06'),
('060802', 'Bellavista', '0608', '06'),
('060803', 'Chontali', '0608', '06'),
('060804', 'Colasay', '0608', '06'),
('060805', 'Huabal', '0608', '06'),
('060806', 'Las Pirias', '0608', '06'),
('060807', 'Pomahuaca', '0608', '06'),
('060808', 'Pucara', '0608', '06'),
('060809', 'Sallique', '0608', '06'),
('060810', 'San Felipe', '0608', '06'),
('060811', 'San José del Alto', '0608', '06'),
('060812', 'Santa Rosa', '0608', '06'),
('060901', 'San Ignacio', '0609', '06'),
('060902', 'Chirinos', '0609', '06'),
('060903', 'Huarango', '0609', '06'),
('060904', 'La Coipa', '0609', '06'),
('060905', 'Namballe', '0609', '06'),
('060906', 'San José de Lourdes', '0609', '06'),
('060907', 'Tabaconas', '0609', '06'),
('061001', 'Pedro Gálvez', '0610', '06'),
('061002', 'Chancay', '0610', '06'),
('061003', 'Eduardo Villanueva', '0610', '06'),
('061004', 'Gregorio Pita', '0610', '06'),
('061005', 'Ichocan', '0610', '06'),
('061006', 'José Manuel Quiroz', '0610', '06'),
('061007', 'José Sabogal', '0610', '06'),
('061101', 'San Miguel', '0611', '06'),
('061102', 'Bolívar', '0611', '06'),
('061103', 'Calquis', '0611', '06'),
('061104', 'Catilluc', '0611', '06'),
('061105', 'El Prado', '0611', '06'),
('061106', 'La Florida', '0611', '06'),
('061107', 'Llapa', '0611', '06'),
('061108', 'Nanchoc', '0611', '06'),
('061109', 'Niepos', '0611', '06'),
('061110', 'San Gregorio', '0611', '06'),
('061111', 'San Silvestre de Cochan', '0611', '06'),
('061112', 'Tongod', '0611', '06'),
('061113', 'Unión Agua Blanca', '0611', '06'),
('061201', 'San Pablo', '0612', '06'),
('061202', 'San Bernardino', '0612', '06'),
('061203', 'San Luis', '0612', '06'),
('061204', 'Tumbaden', '0612', '06'),
('061301', 'Santa Cruz', '0613', '06'),
('061302', 'Andabamba', '0613', '06'),
('061303', 'Catache', '0613', '06'),
('061304', 'Chancaybaños', '0613', '06'),
('061305', 'La Esperanza', '0613', '06'),
('061306', 'Ninabamba', '0613', '06'),
('061307', 'Pulan', '0613', '06'),
('061308', 'Saucepampa', '0613', '06'),
('061309', 'Sexi', '0613', '06'),
('061310', 'Uticyacu', '0613', '06'),
('061311', 'Yauyucan', '0613', '06'),
('070101', 'Callao', '0701', '07'),
('070102', 'Bellavista', '0701', '07'),
('070103', 'Carmen de la Legua Reynoso', '0701', '07'),
('070104', 'La Perla', '0701', '07'),
('070105', 'La Punta', '0701', '07'),
('070106', 'Ventanilla', '0701', '07'),
('070107', 'Mi Perú', '0701', '07'),
('080101', 'Cusco', '0801', '08'),
('080102', 'Ccorca', '0801', '08'),
('080103', 'Poroy', '0801', '08'),
('080104', 'San Jerónimo', '0801', '08'),
('080105', 'San Sebastian', '0801', '08'),
('080106', 'Santiago', '0801', '08'),
('080107', 'Saylla', '0801', '08'),
('080108', 'Wanchaq', '0801', '08'),
('080201', 'Acomayo', '0802', '08'),
('080202', 'Acopia', '0802', '08'),
('080203', 'Acos', '0802', '08'),
('080204', 'Mosoc Llacta', '0802', '08'),
('080205', 'Pomacanchi', '0802', '08'),
('080206', 'Rondocan', '0802', '08'),
('080207', 'Sangarara', '0802', '08'),
('080301', 'Anta', '0803', '08'),
('080302', 'Ancahuasi', '0803', '08'),
('080303', 'Cachimayo', '0803', '08'),
('080304', 'Chinchaypujio', '0803', '08'),
('080305', 'Huarocondo', '0803', '08'),
('080306', 'Limatambo', '0803', '08'),
('080307', 'Mollepata', '0803', '08'),
('080308', 'Pucyura', '0803', '08'),
('080309', 'Zurite', '0803', '08'),
('080401', 'Calca', '0804', '08'),
('080402', 'Coya', '0804', '08'),
('080403', 'Lamay', '0804', '08'),
('080404', 'Lares', '0804', '08'),
('080405', 'Pisac', '0804', '08'),
('080406', 'San Salvador', '0804', '08'),
('080407', 'Taray', '0804', '08'),
('080408', 'Yanatile', '0804', '08'),
('080501', 'Yanaoca', '0805', '08'),
('080502', 'Checca', '0805', '08'),
('080503', 'Kunturkanki', '0805', '08'),
('080504', 'Langui', '0805', '08'),
('080505', 'Layo', '0805', '08'),
('080506', 'Pampamarca', '0805', '08'),
('080507', 'Quehue', '0805', '08'),
('080508', 'Tupac Amaru', '0805', '08'),
('080601', 'Sicuani', '0806', '08'),
('080602', 'Checacupe', '0806', '08'),
('080603', 'Combapata', '0806', '08'),
('080604', 'Marangani', '0806', '08'),
('080605', 'Pitumarca', '0806', '08'),
('080606', 'San Pablo', '0806', '08'),
('080607', 'San Pedro', '0806', '08'),
('080608', 'Tinta', '0806', '08'),
('080701', 'Santo Tomas', '0807', '08'),
('080702', 'Capacmarca', '0807', '08'),
('080703', 'Chamaca', '0807', '08'),
('080704', 'Colquemarca', '0807', '08'),
('080705', 'Livitaca', '0807', '08'),
('080706', 'Llusco', '0807', '08'),
('080707', 'Quiñota', '0807', '08'),
('080708', 'Velille', '0807', '08'),
('080801', 'Espinar', '0808', '08'),
('080802', 'Condoroma', '0808', '08'),
('080803', 'Coporaque', '0808', '08'),
('080804', 'Ocoruro', '0808', '08'),
('080805', 'Pallpata', '0808', '08'),
('080806', 'Pichigua', '0808', '08'),
('080807', 'Suyckutambo', '0808', '08'),
('080808', 'Alto Pichigua', '0808', '08'),
('080901', 'Santa Ana', '0809', '08'),
('080902', 'Echarate', '0809', '08'),
('080903', 'Huayopata', '0809', '08'),
('080904', 'Maranura', '0809', '08'),
('080905', 'Ocobamba', '0809', '08'),
('080906', 'Quellouno', '0809', '08'),
('080907', 'Kimbiri', '0809', '08'),
('080908', 'Santa Teresa', '0809', '08'),
('080909', 'Vilcabamba', '0809', '08'),
('080910', 'Pichari', '0809', '08'),
('080911', 'Inkawasi', '0809', '08'),
('080912', 'Villa Virgen', '0809', '08'),
('080913', 'Villa Kintiarina', '0809', '08'),
('080914', 'Megantoni', '0809', '08'),
('081001', 'Paruro', '0810', '08'),
('081002', 'Accha', '0810', '08'),
('081003', 'Ccapi', '0810', '08'),
('081004', 'Colcha', '0810', '08'),
('081005', 'Huanoquite', '0810', '08'),
('081006', 'Omachaç', '0810', '08'),
('081007', 'Paccaritambo', '0810', '08'),
('081008', 'Pillpinto', '0810', '08'),
('081009', 'Yaurisque', '0810', '08'),
('081101', 'Paucartambo', '0811', '08'),
('081102', 'Caicay', '0811', '08'),
('081103', 'Challabamba', '0811', '08'),
('081104', 'Colquepata', '0811', '08'),
('081105', 'Huancarani', '0811', '08'),
('081106', 'Kosñipata', '0811', '08'),
('081201', 'Urcos', '0812', '08'),
('081202', 'Andahuaylillas', '0812', '08'),
('081203', 'Camanti', '0812', '08'),
('081204', 'Ccarhuayo', '0812', '08'),
('081205', 'Ccatca', '0812', '08'),
('081206', 'Cusipata', '0812', '08'),
('081207', 'Huaro', '0812', '08'),
('081208', 'Lucre', '0812', '08'),
('081209', 'Marcapata', '0812', '08'),
('081210', 'Ocongate', '0812', '08'),
('081211', 'Oropesa', '0812', '08'),
('081212', 'Quiquijana', '0812', '08'),
('081301', 'Urubamba', '0813', '08'),
('081302', 'Chinchero', '0813', '08'),
('081303', 'Huayllabamba', '0813', '08'),
('081304', 'Machupicchu', '0813', '08'),
('081305', 'Maras', '0813', '08'),
('081306', 'Ollantaytambo', '0813', '08'),
('081307', 'Yucay', '0813', '08'),
('090101', 'Huancavelica', '0901', '09'),
('090102', 'Acobambilla', '0901', '09'),
('090103', 'Acoria', '0901', '09'),
('090104', 'Conayca', '0901', '09'),
('090105', 'Cuenca', '0901', '09'),
('090106', 'Huachocolpa', '0901', '09'),
('090107', 'Huayllahuara', '0901', '09'),
('090108', 'Izcuchaca', '0901', '09'),
('090109', 'Laria', '0901', '09'),
('090110', 'Manta', '0901', '09'),
('090111', 'Mariscal Cáceres', '0901', '09'),
('090112', 'Moya', '0901', '09'),
('090113', 'Nuevo Occoro', '0901', '09'),
('090114', 'Palca', '0901', '09'),
('090115', 'Pilchaca', '0901', '09'),
('090116', 'Vilca', '0901', '09'),
('090117', 'Yauli', '0901', '09'),
('090118', 'Ascensión', '0901', '09'),
('090119', 'Huando', '0901', '09'),
('090201', 'Acobamba', '0902', '09'),
('090202', 'Andabamba', '0902', '09'),
('090203', 'Anta', '0902', '09'),
('090204', 'Caja', '0902', '09'),
('090205', 'Marcas', '0902', '09'),
('090206', 'Paucara', '0902', '09'),
('090207', 'Pomacocha', '0902', '09'),
('090208', 'Rosario', '0902', '09'),
('090301', 'Lircay', '0903', '09'),
('090302', 'Anchonga', '0903', '09'),
('090303', 'Callanmarca', '0903', '09'),
('090304', 'Ccochaccasa', '0903', '09'),
('090305', 'Chincho', '0903', '09'),
('090306', 'Congalla', '0903', '09'),
('090307', 'Huanca-Huanca', '0903', '09'),
('090308', 'Huayllay Grande', '0903', '09'),
('090309', 'Julcamarca', '0903', '09'),
('090310', 'San Antonio de Antaparco', '0903', '09'),
('090311', 'Santo Tomas de Pata', '0903', '09'),
('090312', 'Secclla', '0903', '09'),
('090401', 'Castrovirreyna', '0904', '09'),
('090402', 'Arma', '0904', '09'),
('090403', 'Aurahua', '0904', '09'),
('090404', 'Capillas', '0904', '09'),
('090405', 'Chupamarca', '0904', '09'),
('090406', 'Cocas', '0904', '09'),
('090407', 'Huachos', '0904', '09'),
('090408', 'Huamatambo', '0904', '09'),
('090409', 'Mollepampa', '0904', '09'),
('090410', 'San Juan', '0904', '09'),
('090411', 'Santa Ana', '0904', '09'),
('090412', 'Tantara', '0904', '09'),
('090413', 'Ticrapo', '0904', '09'),
('090501', 'Churcampa', '0905', '09'),
('090502', 'Anco', '0905', '09'),
('090503', 'Chinchihuasi', '0905', '09'),
('090504', 'El Carmen', '0905', '09'),
('090505', 'La Merced', '0905', '09'),
('090506', 'Locroja', '0905', '09'),
('090507', 'Paucarbamba', '0905', '09'),
('090508', 'San Miguel de Mayocc', '0905', '09'),
('090509', 'San Pedro de Coris', '0905', '09'),
('090510', 'Pachamarca', '0905', '09'),
('090511', 'Cosme', '0905', '09'),
('090601', 'Huaytara', '0906', '09'),
('090602', 'Ayavi', '0906', '09'),
('090603', 'Córdova', '0906', '09'),
('090604', 'Huayacundo Arma', '0906', '09'),
('090605', 'Laramarca', '0906', '09'),
('090606', 'Ocoyo', '0906', '09'),
('090607', 'Pilpichaca', '0906', '09'),
('090608', 'Querco', '0906', '09'),
('090609', 'Quito-Arma', '0906', '09'),
('090610', 'San Antonio de Cusicancha', '0906', '09'),
('090611', 'San Francisco de Sangayaico', '0906', '09'),
('090612', 'San Isidro', '0906', '09'),
('090613', 'Santiago de Chocorvos', '0906', '09'),
('090614', 'Santiago de Quirahuara', '0906', '09'),
('090615', 'Santo Domingo de Capillas', '0906', '09'),
('090616', 'Tambo', '0906', '09'),
('090701', 'Pampas', '0907', '09'),
('090702', 'Acostambo', '0907', '09'),
('090703', 'Acraquia', '0907', '09'),
('090704', 'Ahuaycha', '0907', '09'),
('090705', 'Colcabamba', '0907', '09'),
('090706', 'Daniel Hernández', '0907', '09'),
('090707', 'Huachocolpa', '0907', '09'),
('090709', 'Huaribamba', '0907', '09'),
('090710', 'Ñahuimpuquio', '0907', '09'),
('090711', 'Pazos', '0907', '09'),
('090713', 'Quishuar', '0907', '09'),
('090714', 'Salcabamba', '0907', '09'),
('090715', 'Salcahuasi', '0907', '09'),
('090716', 'San Marcos de Rocchac', '0907', '09'),
('090717', 'Surcubamba', '0907', '09'),
('090718', 'Tintay Puncu', '0907', '09'),
('090719', 'Quichuas', '0907', '09'),
('090720', 'Andaymarca', '0907', '09'),
('090721', 'Roble', '0907', '09'),
('090722', 'Pichos', '0907', '09'),
('090723', 'Santiago de Tucuma', '0907', '09'),
('100101', 'Huanuco', '1001', '10'),
('100102', 'Amarilis', '1001', '10'),
('100103', 'Chinchao', '1001', '10'),
('100104', 'Churubamba', '1001', '10'),
('100105', 'Margos', '1001', '10'),
('100106', 'Quisqui (Kichki)', '1001', '10'),
('100107', 'San Francisco de Cayran', '1001', '10'),
('100108', 'San Pedro de Chaulan', '1001', '10'),
('100109', 'Santa María del Valle', '1001', '10'),
('100110', 'Yarumayo', '1001', '10'),
('100111', 'Pillco Marca', '1001', '10'),
('100112', 'Yacus', '1001', '10'),
('100113', 'San Pablo de Pillao', '1001', '10'),
('100201', 'Ambo', '1002', '10'),
('100202', 'Cayna', '1002', '10'),
('100203', 'Colpas', '1002', '10'),
('100204', 'Conchamarca', '1002', '10'),
('100205', 'Huacar', '1002', '10'),
('100206', 'San Francisco', '1002', '10'),
('100207', 'San Rafael', '1002', '10'),
('100208', 'Tomay Kichwa', '1002', '10'),
('100301', 'La Unión', '1003', '10'),
('100307', 'Chuquis', '1003', '10'),
('100311', 'Marías', '1003', '10'),
('100313', 'Pachas', '1003', '10'),
('100316', 'Quivilla', '1003', '10'),
('100317', 'Ripan', '1003', '10'),
('100321', 'Shunqui', '1003', '10'),
('100322', 'Sillapata', '1003', '10'),
('100323', 'Yanas', '1003', '10'),
('100401', 'Huacaybamba', '1004', '10'),
('100402', 'Canchabamba', '1004', '10'),
('100403', 'Cochabamba', '1004', '10'),
('100404', 'Pinra', '1004', '10'),
('100501', 'Llata', '1005', '10'),
('100502', 'Arancay', '1005', '10'),
('100503', 'Chavín de Pariarca', '1005', '10'),
('100504', 'Jacas Grande', '1005', '10'),
('100505', 'Jircan', '1005', '10'),
('100506', 'Miraflores', '1005', '10'),
('100507', 'Monzón', '1005', '10'),
('100508', 'Punchao', '1005', '10'),
('100509', 'Puños', '1005', '10'),
('100510', 'Singa', '1005', '10'),
('100511', 'Tantamayo', '1005', '10'),
('100601', 'Rupa-Rupa', '1006', '10'),
('100602', 'Daniel Alomía Robles', '1006', '10'),
('100603', 'Hermílio Valdizan', '1006', '10'),
('100604', 'José Crespo y Castillo', '1006', '10'),
('100605', 'Luyando', '1006', '10'),
('100606', 'Mariano Damaso Beraun', '1006', '10'),
('100607', 'Pucayacu', '1006', '10'),
('100608', 'Castillo Grande', '1006', '10'),
('100609', 'Pueblo Nuevo', '1006', '10'),
('100610', 'Santo Domingo de Anda', '1006', '10'),
('100701', 'Huacrachuco', '1007', '10'),
('100702', 'Cholon', '1007', '10'),
('100703', 'San Buenaventura', '1007', '10'),
('100704', 'La Morada', '1007', '10'),
('100705', 'Santa Rosa de Alto Yanajanca', '1007', '10'),
('100801', 'Panao', '1008', '10'),
('100802', 'Chaglla', '1008', '10'),
('100803', 'Molino', '1008', '10'),
('100804', 'Umari', '1008', '10'),
('100901', 'Puerto Inca', '1009', '10'),
('100902', 'Codo del Pozuzo', '1009', '10'),
('100903', 'Honoria', '1009', '10'),
('100904', 'Tournavista', '1009', '10'),
('100905', 'Yuyapichis', '1009', '10'),
('101001', 'Jesús', '1010', '10'),
('101002', 'Baños', '1010', '10'),
('101003', 'Jivia', '1010', '10'),
('101004', 'Queropalca', '1010', '10'),
('101005', 'Rondos', '1010', '10'),
('101006', 'San Francisco de Asís', '1010', '10'),
('101007', 'San Miguel de Cauri', '1010', '10'),
('101101', 'Chavinillo', '1011', '10'),
('101102', 'Cahuac', '1011', '10'),
('101103', 'Chacabamba', '1011', '10'),
('101104', 'Aparicio Pomares', '1011', '10'),
('101105', 'Jacas Chico', '1011', '10'),
('101106', 'Obas', '1011', '10'),
('101107', 'Pampamarca', '1011', '10'),
('101108', 'Choras', '1011', '10'),
('110101', 'Ica', '1101', '11'),
('110102', 'La Tinguiña', '1101', '11'),
('110103', 'Los Aquijes', '1101', '11'),
('110104', 'Ocucaje', '1101', '11'),
('110105', 'Pachacutec', '1101', '11'),
('110106', 'Parcona', '1101', '11'),
('110107', 'Pueblo Nuevo', '1101', '11'),
('110108', 'Salas', '1101', '11'),
('110109', 'San José de Los Molinos', '1101', '11'),
('110110', 'San Juan Bautista', '1101', '11'),
('110111', 'Santiago', '1101', '11'),
('110112', 'Subtanjalla', '1101', '11'),
('110113', 'Tate', '1101', '11'),
('110114', 'Yauca del Rosario', '1101', '11'),
('110201', 'Chincha Alta', '1102', '11'),
('110202', 'Alto Laran', '1102', '11'),
('110203', 'Chavin', '1102', '11'),
('110204', 'Chincha Baja', '1102', '11'),
('110205', 'El Carmen', '1102', '11'),
('110206', 'Grocio Prado', '1102', '11'),
('110207', 'Pueblo Nuevo', '1102', '11'),
('110208', 'San Juan de Yanac', '1102', '11'),
('110209', 'San Pedro de Huacarpana', '1102', '11'),
('110210', 'Sunampe', '1102', '11'),
('110211', 'Tambo de Mora', '1102', '11'),
('110301', 'Nasca', '1103', '11'),
('110302', 'Changuillo', '1103', '11'),
('110303', 'El Ingenio', '1103', '11'),
('110304', 'Marcona', '1103', '11'),
('110305', 'Vista Alegre', '1103', '11'),
('110401', 'Palpa', '1104', '11'),
('110402', 'Llipata', '1104', '11'),
('110403', 'Río Grande', '1104', '11'),
('110404', 'Santa Cruz', '1104', '11'),
('110405', 'Tibillo', '1104', '11'),
('110501', 'Pisco', '1105', '11'),
('110502', 'Huancano', '1105', '11'),
('110503', 'Humay', '1105', '11'),
('110504', 'Independencia', '1105', '11'),
('110505', 'Paracas', '1105', '11'),
('110506', 'San Andrés', '1105', '11'),
('110507', 'San Clemente', '1105', '11'),
('110508', 'Tupac Amaru Inca', '1105', '11'),
('120101', 'Huancayo', '1201', '12'),
('120104', 'Carhuacallanga', '1201', '12'),
('120105', 'Chacapampa', '1201', '12'),
('120106', 'Chicche', '1201', '12'),
('120107', 'Chilca', '1201', '12'),
('120108', 'Chongos Alto', '1201', '12'),
('120111', 'Chupuro', '1201', '12'),
('120112', 'Colca', '1201', '12'),
('120113', 'Cullhuas', '1201', '12'),
('120114', 'El Tambo', '1201', '12'),
('120116', 'Huacrapuquio', '1201', '12'),
('120117', 'Hualhuas', '1201', '12'),
('120119', 'Huancan', '1201', '12'),
('120120', 'Huasicancha', '1201', '12'),
('120121', 'Huayucachi', '1201', '12'),
('120122', 'Ingenio', '1201', '12'),
('120124', 'Pariahuanca', '1201', '12'),
('120125', 'Pilcomayo', '1201', '12'),
('120126', 'Pucara', '1201', '12'),
('120127', 'Quichuay', '1201', '12'),
('120128', 'Quilcas', '1201', '12'),
('120129', 'San Agustín', '1201', '12'),
('120130', 'San Jerónimo de Tunan', '1201', '12'),
('120132', 'Saño', '1201', '12'),
('120133', 'Sapallanga', '1201', '12'),
('120134', 'Sicaya', '1201', '12'),
('120135', 'Santo Domingo de Acobamba', '1201', '12'),
('120136', 'Viques', '1201', '12'),
('120201', 'Concepción', '1202', '12'),
('120202', 'Aco', '1202', '12'),
('120203', 'Andamarca', '1202', '12'),
('120204', 'Chambara', '1202', '12'),
('120205', 'Cochas', '1202', '12'),
('120206', 'Comas', '1202', '12'),
('120207', 'Heroínas Toledo', '1202', '12'),
('120208', 'Manzanares', '1202', '12'),
('120209', 'Mariscal Castilla', '1202', '12'),
('120210', 'Matahuasi', '1202', '12'),
('120211', 'Mito', '1202', '12'),
('120212', 'Nueve de Julio', '1202', '12'),
('120213', 'Orcotuna', '1202', '12'),
('120214', 'San José de Quero', '1202', '12'),
('120215', 'Santa Rosa de Ocopa', '1202', '12'),
('120301', 'Chanchamayo', '1203', '12'),
('120302', 'Perene', '1203', '12'),
('120303', 'Pichanaqui', '1203', '12'),
('120304', 'San Luis de Shuaro', '1203', '12'),
('120305', 'San Ramón', '1203', '12'),
('120306', 'Vitoc', '1203', '12'),
('120401', 'Jauja', '1204', '12'),
('120402', 'Acolla', '1204', '12'),
('120403', 'Apata', '1204', '12'),
('120404', 'Ataura', '1204', '12'),
('120405', 'Canchayllo', '1204', '12'),
('120406', 'Curicaca', '1204', '12'),
('120407', 'El Mantaro', '1204', '12'),
('120408', 'Huamali', '1204', '12'),
('120409', 'Huaripampa', '1204', '12'),
('120410', 'Huertas', '1204', '12'),
('120411', 'Janjaillo', '1204', '12'),
('120412', 'Julcán', '1204', '12'),
('120413', 'Leonor Ordóñez', '1204', '12'),
('120414', 'Llocllapampa', '1204', '12'),
('120415', 'Marco', '1204', '12'),
('120416', 'Masma', '1204', '12'),
('120417', 'Masma Chicche', '1204', '12'),
('120418', 'Molinos', '1204', '12'),
('120419', 'Monobamba', '1204', '12'),
('120420', 'Muqui', '1204', '12'),
('120421', 'Muquiyauyo', '1204', '12'),
('120422', 'Paca', '1204', '12'),
('120423', 'Paccha', '1204', '12'),
('120424', 'Pancan', '1204', '12'),
('120425', 'Parco', '1204', '12'),
('120426', 'Pomacancha', '1204', '12'),
('120427', 'Ricran', '1204', '12'),
('120428', 'San Lorenzo', '1204', '12'),
('120429', 'San Pedro de Chunan', '1204', '12'),
('120430', 'Sausa', '1204', '12'),
('120431', 'Sincos', '1204', '12'),
('120432', 'Tunan Marca', '1204', '12'),
('120433', 'Yauli', '1204', '12'),
('120434', 'Yauyos', '1204', '12'),
('120501', 'Junin', '1205', '12'),
('120502', 'Carhuamayo', '1205', '12'),
('120503', 'Ondores', '1205', '12'),
('120504', 'Ulcumayo', '1205', '12'),
('120601', 'Satipo', '1206', '12'),
('120602', 'Coviriali', '1206', '12'),
('120603', 'Llaylla', '1206', '12'),
('120604', 'Mazamari', '1206', '12'),
('120605', 'Pampa Hermosa', '1206', '12'),
('120606', 'Pangoa', '1206', '12'),
('120607', 'Río Negro', '1206', '12'),
('120608', 'Río Tambo', '1206', '12'),
('120609', 'Vizcatan del Ene', '1206', '12'),
('120701', 'Tarma', '1207', '12'),
('120702', 'Acobamba', '1207', '12'),
('120703', 'Huaricolca', '1207', '12'),
('120704', 'Huasahuasi', '1207', '12'),
('120705', 'La Unión', '1207', '12'),
('120706', 'Palca', '1207', '12'),
('120707', 'Palcamayo', '1207', '12'),
('120708', 'San Pedro de Cajas', '1207', '12'),
('120709', 'Tapo', '1207', '12'),
('120801', 'La Oroya', '1208', '12'),
('120802', 'Chacapalpa', '1208', '12'),
('120803', 'Huay-Huay', '1208', '12'),
('120804', 'Marcapomacocha', '1208', '12'),
('120805', 'Morococha', '1208', '12'),
('120806', 'Paccha', '1208', '12'),
('120807', 'Santa Bárbara de Carhuacayan', '1208', '12'),
('120808', 'Santa Rosa de Sacco', '1208', '12'),
('120809', 'Suitucancha', '1208', '12'),
('120810', 'Yauli', '1208', '12'),
('120901', 'Chupaca', '1209', '12'),
('120902', 'Ahuac', '1209', '12'),
('120903', 'Chongos Bajo', '1209', '12'),
('120904', 'Huachac', '1209', '12'),
('120905', 'Huamancaca Chico', '1209', '12'),
('120906', 'San Juan de Iscos', '1209', '12'),
('120907', 'San Juan de Jarpa', '1209', '12'),
('120908', 'Tres de Diciembre', '1209', '12'),
('120909', 'Yanacancha', '1209', '12'),
('130101', 'Trujillo', '1301', '13'),
('130102', 'El Porvenir', '1301', '13'),
('130103', 'Florencia de Mora', '1301', '13'),
('130104', 'Huanchaco', '1301', '13'),
('130105', 'La Esperanza', '1301', '13'),
('130106', 'Laredo', '1301', '13'),
('130107', 'Moche', '1301', '13'),
('130108', 'Poroto', '1301', '13'),
('130109', 'Salaverry', '1301', '13'),
('130110', 'Simbal', '1301', '13'),
('130111', 'Victor Larco Herrera', '1301', '13'),
('130201', 'Ascope', '1302', '13'),
('130202', 'Chicama', '1302', '13'),
('130203', 'Chocope', '1302', '13'),
('130204', 'Magdalena de Cao', '1302', '13'),
('130205', 'Paijan', '1302', '13'),
('130206', 'Rázuri', '1302', '13'),
('130207', 'Santiago de Cao', '1302', '13'),
('130208', 'Casa Grande', '1302', '13'),
('130301', 'Bolívar', '1303', '13'),
('130302', 'Bambamarca', '1303', '13'),
('130303', 'Condormarca', '1303', '13'),
('130304', 'Longotea', '1303', '13'),
('130305', 'Uchumarca', '1303', '13'),
('130306', 'Ucuncha', '1303', '13'),
('130401', 'Chepen', '1304', '13'),
('130402', 'Pacanga', '1304', '13'),
('130403', 'Pueblo Nuevo', '1304', '13'),
('130501', 'Julcan', '1305', '13'),
('130502', 'Calamarca', '1305', '13'),
('130503', 'Carabamba', '1305', '13'),
('130504', 'Huaso', '1305', '13'),
('130601', 'Otuzco', '1306', '13'),
('130602', 'Agallpampa', '1306', '13'),
('130604', 'Charat', '1306', '13'),
('130605', 'Huaranchal', '1306', '13'),
('130606', 'La Cuesta', '1306', '13'),
('130608', 'Mache', '1306', '13'),
('130610', 'Paranday', '1306', '13'),
('130611', 'Salpo', '1306', '13'),
('130613', 'Sinsicap', '1306', '13'),
('130614', 'Usquil', '1306', '13'),
('130701', 'San Pedro de Lloc', '1307', '13'),
('130702', 'Guadalupe', '1307', '13'),
('130703', 'Jequetepeque', '1307', '13'),
('130704', 'Pacasmayo', '1307', '13'),
('130705', 'San José', '1307', '13'),
('130801', 'Tayabamba', '1308', '13'),
('130802', 'Buldibuyo', '1308', '13'),
('130803', 'Chillia', '1308', '13'),
('130804', 'Huancaspata', '1308', '13'),
('130805', 'Huaylillas', '1308', '13'),
('130806', 'Huayo', '1308', '13'),
('130807', 'Ongon', '1308', '13'),
('130808', 'Parcoy', '1308', '13'),
('130809', 'Pataz', '1308', '13'),
('130810', 'Pias', '1308', '13'),
('130811', 'Santiago de Challas', '1308', '13'),
('130812', 'Taurija', '1308', '13'),
('130813', 'Urpay', '1308', '13'),
('130901', 'Huamachuco', '1309', '13'),
('130902', 'Chugay', '1309', '13'),
('130903', 'Cochorco', '1309', '13'),
('130904', 'Curgos', '1309', '13'),
('130905', 'Marcabal', '1309', '13'),
('130906', 'Sanagoran', '1309', '13'),
('130907', 'Sarin', '1309', '13'),
('130908', 'Sartimbamba', '1309', '13'),
('131001', 'Santiago de Chuco', '1310', '13'),
('131002', 'Angasmarca', '1310', '13'),
('131003', 'Cachicadan', '1310', '13'),
('131004', 'Mollebamba', '1310', '13'),
('131005', 'Mollepata', '1310', '13'),
('131006', 'Quiruvilca', '1310', '13'),
('131007', 'Santa Cruz de Chuca', '1310', '13'),
('131008', 'Sitabamba', '1310', '13'),
('131101', 'Cascas', '1311', '13'),
('131102', 'Lucma', '1311', '13'),
('131103', 'Marmot', '1311', '13'),
('131104', 'Sayapullo', '1311', '13'),
('131201', 'Viru', '1312', '13'),
('131202', 'Chao', '1312', '13'),
('131203', 'Guadalupito', '1312', '13'),
('140101', 'Chiclayo', '1401', '14'),
('140102', 'Chongoyape', '1401', '14'),
('140103', 'Eten', '1401', '14'),
('140104', 'Eten Puerto', '1401', '14'),
('140105', 'José Leonardo Ortiz', '1401', '14'),
('140106', 'La Victoria', '1401', '14'),
('140107', 'Lagunas', '1401', '14'),
('140108', 'Monsefu', '1401', '14'),
('140109', 'Nueva Arica', '1401', '14'),
('140110', 'Oyotun', '1401', '14'),
('140111', 'Picsi', '1401', '14'),
('140112', 'Pimentel', '1401', '14'),
('140113', 'Reque', '1401', '14'),
('140114', 'Santa Rosa', '1401', '14'),
('140115', 'Saña', '1401', '14'),
('140116', 'Cayalti', '1401', '14'),
('140117', 'Patapo', '1401', '14'),
('140118', 'Pomalca', '1401', '14'),
('140119', 'Pucala', '1401', '14'),
('140120', 'Tuman', '1401', '14'),
('140201', 'Ferreñafe', '1402', '14'),
('140202', 'Cañaris', '1402', '14'),
('140203', 'Incahuasi', '1402', '14'),
('140204', 'Manuel Antonio Mesones Muro', '1402', '14'),
('140205', 'Pitipo', '1402', '14'),
('140206', 'Pueblo Nuevo', '1402', '14'),
('140301', 'Lambayeque', '1403', '14'),
('140302', 'Chochope', '1403', '14'),
('140303', 'Illimo', '1403', '14'),
('140304', 'Jayanca', '1403', '14'),
('140305', 'Mochumi', '1403', '14'),
('140306', 'Morrope', '1403', '14'),
('140307', 'Motupe', '1403', '14'),
('140308', 'Olmos', '1403', '14'),
('140309', 'Pacora', '1403', '14'),
('140310', 'Salas', '1403', '14'),
('140311', 'San José', '1403', '14'),
('140312', 'Tucume', '1403', '14'),
('150101', 'Lima', '1501', '15'),
('150102', 'Ancón', '1501', '15'),
('150103', 'Ate', '1501', '15'),
('150104', 'Barranco', '1501', '15'),
('150105', 'Breña', '1501', '15'),
('150106', 'Carabayllo', '1501', '15'),
('150107', 'Chaclacayo', '1501', '15'),
('150108', 'Chorrillos', '1501', '15'),
('150109', 'Cieneguilla', '1501', '15'),
('150110', 'Comas', '1501', '15'),
('150111', 'El Agustino', '1501', '15'),
('150112', 'Independencia', '1501', '15'),
('150113', 'Jesús María', '1501', '15'),
('150114', 'La Molina', '1501', '15'),
('150115', 'La Victoria', '1501', '15'),
('150116', 'Lince', '1501', '15'),
('150117', 'Los Olivos', '1501', '15'),
('150118', 'Lurigancho', '1501', '15'),
('150119', 'Lurin', '1501', '15'),
('150120', 'Magdalena del Mar', '1501', '15'),
('150121', 'Pueblo Libre', '1501', '15'),
('150122', 'Miraflores', '1501', '15'),
('150123', 'Pachacamac', '1501', '15'),
('150124', 'Pucusana', '1501', '15'),
('150125', 'Puente Piedra', '1501', '15'),
('150126', 'Punta Hermosa', '1501', '15'),
('150127', 'Punta Negra', '1501', '15'),
('150128', 'Rímac', '1501', '15'),
('150129', 'San Bartolo', '1501', '15'),
('150130', 'San Borja', '1501', '15'),
('150131', 'San Isidro', '1501', '15'),
('150132', 'San Juan de Lurigancho', '1501', '15'),
('150133', 'San Juan de Miraflores', '1501', '15'),
('150134', 'San Luis', '1501', '15'),
('150135', 'San Martín de Porres', '1501', '15'),
('150136', 'San Miguel', '1501', '15'),
('150137', 'Santa Anita', '1501', '15'),
('150138', 'Santa María del Mar', '1501', '15'),
('150139', 'Santa Rosa', '1501', '15'),
('150140', 'Santiago de Surco', '1501', '15'),
('150141', 'Surquillo', '1501', '15'),
('150142', 'Villa El Salvador', '1501', '15'),
('150143', 'Villa María del Triunfo', '1501', '15'),
('150201', 'Barranca', '1502', '15'),
('150202', 'Paramonga', '1502', '15'),
('150203', 'Pativilca', '1502', '15'),
('150204', 'Supe', '1502', '15'),
('150205', 'Supe Puerto', '1502', '15'),
('150301', 'Cajatambo', '1503', '15'),
('150302', 'Copa', '1503', '15'),
('150303', 'Gorgor', '1503', '15'),
('150304', 'Huancapon', '1503', '15'),
('150305', 'Manas', '1503', '15'),
('150401', 'Canta', '1504', '15'),
('150402', 'Arahuay', '1504', '15'),
('150403', 'Huamantanga', '1504', '15'),
('150404', 'Huaros', '1504', '15'),
('150405', 'Lachaqui', '1504', '15'),
('150406', 'San Buenaventura', '1504', '15'),
('150407', 'Santa Rosa de Quives', '1504', '15');
INSERT INTO `ubigeo_peru_districts` (`id`, `name`, `province_id`, `department_id`) VALUES
('150501', 'San Vicente de Cañete', '1505', '15'),
('150502', 'Asia', '1505', '15'),
('150503', 'Calango', '1505', '15'),
('150504', 'Cerro Azul', '1505', '15'),
('150505', 'Chilca', '1505', '15'),
('150506', 'Coayllo', '1505', '15'),
('150507', 'Imperial', '1505', '15'),
('150508', 'Lunahuana', '1505', '15'),
('150509', 'Mala', '1505', '15'),
('150510', 'Nuevo Imperial', '1505', '15'),
('150511', 'Pacaran', '1505', '15'),
('150512', 'Quilmana', '1505', '15'),
('150513', 'San Antonio', '1505', '15'),
('150514', 'San Luis', '1505', '15'),
('150515', 'Santa Cruz de Flores', '1505', '15'),
('150516', 'Zúñiga', '1505', '15'),
('150601', 'Huaral', '1506', '15'),
('150602', 'Atavillos Alto', '1506', '15'),
('150603', 'Atavillos Bajo', '1506', '15'),
('150604', 'Aucallama', '1506', '15'),
('150605', 'Chancay', '1506', '15'),
('150606', 'Ihuari', '1506', '15'),
('150607', 'Lampian', '1506', '15'),
('150608', 'Pacaraos', '1506', '15'),
('150609', 'San Miguel de Acos', '1506', '15'),
('150610', 'Santa Cruz de Andamarca', '1506', '15'),
('150611', 'Sumbilca', '1506', '15'),
('150612', 'Veintisiete de Noviembre', '1506', '15'),
('150701', 'Matucana', '1507', '15'),
('150702', 'Antioquia', '1507', '15'),
('150703', 'Callahuanca', '1507', '15'),
('150704', 'Carampoma', '1507', '15'),
('150705', 'Chicla', '1507', '15'),
('150706', 'Cuenca', '1507', '15'),
('150707', 'Huachupampa', '1507', '15'),
('150708', 'Huanza', '1507', '15'),
('150709', 'Huarochiri', '1507', '15'),
('150710', 'Lahuaytambo', '1507', '15'),
('150711', 'Langa', '1507', '15'),
('150712', 'Laraos', '1507', '15'),
('150713', 'Mariatana', '1507', '15'),
('150714', 'Ricardo Palma', '1507', '15'),
('150715', 'San Andrés de Tupicocha', '1507', '15'),
('150716', 'San Antonio', '1507', '15'),
('150717', 'San Bartolomé', '1507', '15'),
('150718', 'San Damian', '1507', '15'),
('150719', 'San Juan de Iris', '1507', '15'),
('150720', 'San Juan de Tantaranche', '1507', '15'),
('150721', 'San Lorenzo de Quinti', '1507', '15'),
('150722', 'San Mateo', '1507', '15'),
('150723', 'San Mateo de Otao', '1507', '15'),
('150724', 'San Pedro de Casta', '1507', '15'),
('150725', 'San Pedro de Huancayre', '1507', '15'),
('150726', 'Sangallaya', '1507', '15'),
('150727', 'Santa Cruz de Cocachacra', '1507', '15'),
('150728', 'Santa Eulalia', '1507', '15'),
('150729', 'Santiago de Anchucaya', '1507', '15'),
('150730', 'Santiago de Tuna', '1507', '15'),
('150731', 'Santo Domingo de Los Olleros', '1507', '15'),
('150732', 'Surco', '1507', '15'),
('150801', 'Huacho', '1508', '15'),
('150802', 'Ambar', '1508', '15'),
('150803', 'Caleta de Carquin', '1508', '15'),
('150804', 'Checras', '1508', '15'),
('150805', 'Hualmay', '1508', '15'),
('150806', 'Huaura', '1508', '15'),
('150807', 'Leoncio Prado', '1508', '15'),
('150808', 'Paccho', '1508', '15'),
('150809', 'Santa Leonor', '1508', '15'),
('150810', 'Santa María', '1508', '15'),
('150811', 'Sayan', '1508', '15'),
('150812', 'Vegueta', '1508', '15'),
('150901', 'Oyon', '1509', '15'),
('150902', 'Andajes', '1509', '15'),
('150903', 'Caujul', '1509', '15'),
('150904', 'Cochamarca', '1509', '15'),
('150905', 'Navan', '1509', '15'),
('150906', 'Pachangara', '1509', '15'),
('151001', 'Yauyos', '1510', '15'),
('151002', 'Alis', '1510', '15'),
('151003', 'Allauca', '1510', '15'),
('151004', 'Ayaviri', '1510', '15'),
('151005', 'Azángaro', '1510', '15'),
('151006', 'Cacra', '1510', '15'),
('151007', 'Carania', '1510', '15'),
('151008', 'Catahuasi', '1510', '15'),
('151009', 'Chocos', '1510', '15'),
('151010', 'Cochas', '1510', '15'),
('151011', 'Colonia', '1510', '15'),
('151012', 'Hongos', '1510', '15'),
('151013', 'Huampara', '1510', '15'),
('151014', 'Huancaya', '1510', '15'),
('151015', 'Huangascar', '1510', '15'),
('151016', 'Huantan', '1510', '15'),
('151017', 'Huañec', '1510', '15'),
('151018', 'Laraos', '1510', '15'),
('151019', 'Lincha', '1510', '15'),
('151020', 'Madean', '1510', '15'),
('151021', 'Miraflores', '1510', '15'),
('151022', 'Omas', '1510', '15'),
('151023', 'Putinza', '1510', '15'),
('151024', 'Quinches', '1510', '15'),
('151025', 'Quinocay', '1510', '15'),
('151026', 'San Joaquín', '1510', '15'),
('151027', 'San Pedro de Pilas', '1510', '15'),
('151028', 'Tanta', '1510', '15'),
('151029', 'Tauripampa', '1510', '15'),
('151030', 'Tomas', '1510', '15'),
('151031', 'Tupe', '1510', '15'),
('151032', 'Viñac', '1510', '15'),
('151033', 'Vitis', '1510', '15'),
('160101', 'Iquitos', '1601', '16'),
('160102', 'Alto Nanay', '1601', '16'),
('160103', 'Fernando Lores', '1601', '16'),
('160104', 'Indiana', '1601', '16'),
('160105', 'Las Amazonas', '1601', '16'),
('160106', 'Mazan', '1601', '16'),
('160107', 'Napo', '1601', '16'),
('160108', 'Punchana', '1601', '16'),
('160110', 'Torres Causana', '1601', '16'),
('160112', 'Belén', '1601', '16'),
('160113', 'San Juan Bautista', '1601', '16'),
('160201', 'Yurimaguas', '1602', '16'),
('160202', 'Balsapuerto', '1602', '16'),
('160205', 'Jeberos', '1602', '16'),
('160206', 'Lagunas', '1602', '16'),
('160210', 'Santa Cruz', '1602', '16'),
('160211', 'Teniente Cesar López Rojas', '1602', '16'),
('160301', 'Nauta', '1603', '16'),
('160302', 'Parinari', '1603', '16'),
('160303', 'Tigre', '1603', '16'),
('160304', 'Trompeteros', '1603', '16'),
('160305', 'Urarinas', '1603', '16'),
('160401', 'Ramón Castilla', '1604', '16'),
('160402', 'Pebas', '1604', '16'),
('160403', 'Yavari', '1604', '16'),
('160404', 'San Pablo', '1604', '16'),
('160501', 'Requena', '1605', '16'),
('160502', 'Alto Tapiche', '1605', '16'),
('160503', 'Capelo', '1605', '16'),
('160504', 'Emilio San Martín', '1605', '16'),
('160505', 'Maquia', '1605', '16'),
('160506', 'Puinahua', '1605', '16'),
('160507', 'Saquena', '1605', '16'),
('160508', 'Soplin', '1605', '16'),
('160509', 'Tapiche', '1605', '16'),
('160510', 'Jenaro Herrera', '1605', '16'),
('160511', 'Yaquerana', '1605', '16'),
('160601', 'Contamana', '1606', '16'),
('160602', 'Inahuaya', '1606', '16'),
('160603', 'Padre Márquez', '1606', '16'),
('160604', 'Pampa Hermosa', '1606', '16'),
('160605', 'Sarayacu', '1606', '16'),
('160606', 'Vargas Guerra', '1606', '16'),
('160701', 'Barranca', '1607', '16'),
('160702', 'Cahuapanas', '1607', '16'),
('160703', 'Manseriche', '1607', '16'),
('160704', 'Morona', '1607', '16'),
('160705', 'Pastaza', '1607', '16'),
('160706', 'Andoas', '1607', '16'),
('160801', 'Putumayo', '1608', '16'),
('160802', 'Rosa Panduro', '1608', '16'),
('160803', 'Teniente Manuel Clavero', '1608', '16'),
('160804', 'Yaguas', '1608', '16'),
('170101', 'Tambopata', '1701', '17'),
('170102', 'Inambari', '1701', '17'),
('170103', 'Las Piedras', '1701', '17'),
('170104', 'Laberinto', '1701', '17'),
('170201', 'Manu', '1702', '17'),
('170202', 'Fitzcarrald', '1702', '17'),
('170203', 'Madre de Dios', '1702', '17'),
('170204', 'Huepetuhe', '1702', '17'),
('170301', 'Iñapari', '1703', '17'),
('170302', 'Iberia', '1703', '17'),
('170303', 'Tahuamanu', '1703', '17'),
('180101', 'Moquegua', '1801', '18'),
('180102', 'Carumas', '1801', '18'),
('180103', 'Cuchumbaya', '1801', '18'),
('180104', 'Samegua', '1801', '18'),
('180105', 'San Cristóbal', '1801', '18'),
('180106', 'Torata', '1801', '18'),
('180201', 'Omate', '1802', '18'),
('180202', 'Chojata', '1802', '18'),
('180203', 'Coalaque', '1802', '18'),
('180204', 'Ichuña', '1802', '18'),
('180205', 'La Capilla', '1802', '18'),
('180206', 'Lloque', '1802', '18'),
('180207', 'Matalaque', '1802', '18'),
('180208', 'Puquina', '1802', '18'),
('180209', 'Quinistaquillas', '1802', '18'),
('180210', 'Ubinas', '1802', '18'),
('180211', 'Yunga', '1802', '18'),
('180301', 'Ilo', '1803', '18'),
('180302', 'El Algarrobal', '1803', '18'),
('180303', 'Pacocha', '1803', '18'),
('190101', 'Chaupimarca', '1901', '19'),
('190102', 'Huachon', '1901', '19'),
('190103', 'Huariaca', '1901', '19'),
('190104', 'Huayllay', '1901', '19'),
('190105', 'Ninacaca', '1901', '19'),
('190106', 'Pallanchacra', '1901', '19'),
('190107', 'Paucartambo', '1901', '19'),
('190108', 'San Francisco de Asís de Yarusyacan', '1901', '19'),
('190109', 'Simon Bolívar', '1901', '19'),
('190110', 'Ticlacayan', '1901', '19'),
('190111', 'Tinyahuarco', '1901', '19'),
('190112', 'Vicco', '1901', '19'),
('190113', 'Yanacancha', '1901', '19'),
('190201', 'Yanahuanca', '1902', '19'),
('190202', 'Chacayan', '1902', '19'),
('190203', 'Goyllarisquizga', '1902', '19'),
('190204', 'Paucar', '1902', '19'),
('190205', 'San Pedro de Pillao', '1902', '19'),
('190206', 'Santa Ana de Tusi', '1902', '19'),
('190207', 'Tapuc', '1902', '19'),
('190208', 'Vilcabamba', '1902', '19'),
('190301', 'Oxapampa', '1903', '19'),
('190302', 'Chontabamba', '1903', '19'),
('190303', 'Huancabamba', '1903', '19'),
('190304', 'Palcazu', '1903', '19'),
('190305', 'Pozuzo', '1903', '19'),
('190306', 'Puerto Bermúdez', '1903', '19'),
('190307', 'Villa Rica', '1903', '19'),
('190308', 'Constitución', '1903', '19'),
('200101', 'Piura', '2001', '20'),
('200104', 'Castilla', '2001', '20'),
('200105', 'Catacaos', '2001', '20'),
('200107', 'Cura Mori', '2001', '20'),
('200108', 'El Tallan', '2001', '20'),
('200109', 'La Arena', '2001', '20'),
('200110', 'La Unión', '2001', '20'),
('200111', 'Las Lomas', '2001', '20'),
('200114', 'Tambo Grande', '2001', '20'),
('200115', 'Veintiseis de Octubre', '2001', '20'),
('200201', 'Ayabaca', '2002', '20'),
('200202', 'Frias', '2002', '20'),
('200203', 'Jilili', '2002', '20'),
('200204', 'Lagunas', '2002', '20'),
('200205', 'Montero', '2002', '20'),
('200206', 'Pacaipampa', '2002', '20'),
('200207', 'Paimas', '2002', '20'),
('200208', 'Sapillica', '2002', '20'),
('200209', 'Sicchez', '2002', '20'),
('200210', 'Suyo', '2002', '20'),
('200301', 'Huancabamba', '2003', '20'),
('200302', 'Canchaque', '2003', '20'),
('200303', 'El Carmen de la Frontera', '2003', '20'),
('200304', 'Huarmaca', '2003', '20'),
('200305', 'Lalaquiz', '2003', '20'),
('200306', 'San Miguel de El Faique', '2003', '20'),
('200307', 'Sondor', '2003', '20'),
('200308', 'Sondorillo', '2003', '20'),
('200401', 'Chulucanas', '2004', '20'),
('200402', 'Buenos Aires', '2004', '20'),
('200403', 'Chalaco', '2004', '20'),
('200404', 'La Matanza', '2004', '20'),
('200405', 'Morropon', '2004', '20'),
('200406', 'Salitral', '2004', '20'),
('200407', 'San Juan de Bigote', '2004', '20'),
('200408', 'Santa Catalina de Mossa', '2004', '20'),
('200409', 'Santo Domingo', '2004', '20'),
('200410', 'Yamango', '2004', '20'),
('200501', 'Paita', '2005', '20'),
('200502', 'Amotape', '2005', '20'),
('200503', 'Arenal', '2005', '20'),
('200504', 'Colan', '2005', '20'),
('200505', 'La Huaca', '2005', '20'),
('200506', 'Tamarindo', '2005', '20'),
('200507', 'Vichayal', '2005', '20'),
('200601', 'Sullana', '2006', '20'),
('200602', 'Bellavista', '2006', '20'),
('200603', 'Ignacio Escudero', '2006', '20'),
('200604', 'Lancones', '2006', '20'),
('200605', 'Marcavelica', '2006', '20'),
('200606', 'Miguel Checa', '2006', '20'),
('200607', 'Querecotillo', '2006', '20'),
('200608', 'Salitral', '2006', '20'),
('200701', 'Pariñas', '2007', '20'),
('200702', 'El Alto', '2007', '20'),
('200703', 'La Brea', '2007', '20'),
('200704', 'Lobitos', '2007', '20'),
('200705', 'Los Organos', '2007', '20'),
('200706', 'Mancora', '2007', '20'),
('200801', 'Sechura', '2008', '20'),
('200802', 'Bellavista de la Unión', '2008', '20'),
('200803', 'Bernal', '2008', '20'),
('200804', 'Cristo Nos Valga', '2008', '20'),
('200805', 'Vice', '2008', '20'),
('200806', 'Rinconada Llicuar', '2008', '20'),
('210101', 'Puno', '2101', '21'),
('210102', 'Acora', '2101', '21'),
('210103', 'Amantani', '2101', '21'),
('210104', 'Atuncolla', '2101', '21'),
('210105', 'Capachica', '2101', '21'),
('210106', 'Chucuito', '2101', '21'),
('210107', 'Coata', '2101', '21'),
('210108', 'Huata', '2101', '21'),
('210109', 'Mañazo', '2101', '21'),
('210110', 'Paucarcolla', '2101', '21'),
('210111', 'Pichacani', '2101', '21'),
('210112', 'Plateria', '2101', '21'),
('210113', 'San Antonio', '2101', '21'),
('210114', 'Tiquillaca', '2101', '21'),
('210115', 'Vilque', '2101', '21'),
('210201', 'Azángaro', '2102', '21'),
('210202', 'Achaya', '2102', '21'),
('210203', 'Arapa', '2102', '21'),
('210204', 'Asillo', '2102', '21'),
('210205', 'Caminaca', '2102', '21'),
('210206', 'Chupa', '2102', '21'),
('210207', 'José Domingo Choquehuanca', '2102', '21'),
('210208', 'Muñani', '2102', '21'),
('210209', 'Potoni', '2102', '21'),
('210210', 'Saman', '2102', '21'),
('210211', 'San Anton', '2102', '21'),
('210212', 'San José', '2102', '21'),
('210213', 'San Juan de Salinas', '2102', '21'),
('210214', 'Santiago de Pupuja', '2102', '21'),
('210215', 'Tirapata', '2102', '21'),
('210301', 'Macusani', '2103', '21'),
('210302', 'Ajoyani', '2103', '21'),
('210303', 'Ayapata', '2103', '21'),
('210304', 'Coasa', '2103', '21'),
('210305', 'Corani', '2103', '21'),
('210306', 'Crucero', '2103', '21'),
('210307', 'Ituata', '2103', '21'),
('210308', 'Ollachea', '2103', '21'),
('210309', 'San Gaban', '2103', '21'),
('210310', 'Usicayos', '2103', '21'),
('210401', 'Juli', '2104', '21'),
('210402', 'Desaguadero', '2104', '21'),
('210403', 'Huacullani', '2104', '21'),
('210404', 'Kelluyo', '2104', '21'),
('210405', 'Pisacoma', '2104', '21'),
('210406', 'Pomata', '2104', '21'),
('210407', 'Zepita', '2104', '21'),
('210501', 'Ilave', '2105', '21'),
('210502', 'Capazo', '2105', '21'),
('210503', 'Pilcuyo', '2105', '21'),
('210504', 'Santa Rosa', '2105', '21'),
('210505', 'Conduriri', '2105', '21'),
('210601', 'Huancane', '2106', '21'),
('210602', 'Cojata', '2106', '21'),
('210603', 'Huatasani', '2106', '21'),
('210604', 'Inchupalla', '2106', '21'),
('210605', 'Pusi', '2106', '21'),
('210606', 'Rosaspata', '2106', '21'),
('210607', 'Taraco', '2106', '21'),
('210608', 'Vilque Chico', '2106', '21'),
('210701', 'Lampa', '2107', '21'),
('210702', 'Cabanilla', '2107', '21'),
('210703', 'Calapuja', '2107', '21'),
('210704', 'Nicasio', '2107', '21'),
('210705', 'Ocuviri', '2107', '21'),
('210706', 'Palca', '2107', '21'),
('210707', 'Paratia', '2107', '21'),
('210708', 'Pucara', '2107', '21'),
('210709', 'Santa Lucia', '2107', '21'),
('210710', 'Vilavila', '2107', '21'),
('210801', 'Ayaviri', '2108', '21'),
('210802', 'Antauta', '2108', '21'),
('210803', 'Cupi', '2108', '21'),
('210804', 'Llalli', '2108', '21'),
('210805', 'Macari', '2108', '21'),
('210806', 'Nuñoa', '2108', '21'),
('210807', 'Orurillo', '2108', '21'),
('210808', 'Santa Rosa', '2108', '21'),
('210809', 'Umachiri', '2108', '21'),
('210901', 'Moho', '2109', '21'),
('210902', 'Conima', '2109', '21'),
('210903', 'Huayrapata', '2109', '21'),
('210904', 'Tilali', '2109', '21'),
('211001', 'Putina', '2110', '21'),
('211002', 'Ananea', '2110', '21'),
('211003', 'Pedro Vilca Apaza', '2110', '21'),
('211004', 'Quilcapuncu', '2110', '21'),
('211005', 'Sina', '2110', '21'),
('211101', 'Juliaca', '2111', '21'),
('211102', 'Cabana', '2111', '21'),
('211103', 'Cabanillas', '2111', '21'),
('211104', 'Caracoto', '2111', '21'),
('211105', 'San Miguel', '2111', '21'),
('211201', 'Sandia', '2112', '21'),
('211202', 'Cuyocuyo', '2112', '21'),
('211203', 'Limbani', '2112', '21'),
('211204', 'Patambuco', '2112', '21'),
('211205', 'Phara', '2112', '21'),
('211206', 'Quiaca', '2112', '21'),
('211207', 'San Juan del Oro', '2112', '21'),
('211208', 'Yanahuaya', '2112', '21'),
('211209', 'Alto Inambari', '2112', '21'),
('211210', 'San Pedro de Putina Punco', '2112', '21'),
('211301', 'Yunguyo', '2113', '21'),
('211302', 'Anapia', '2113', '21'),
('211303', 'Copani', '2113', '21'),
('211304', 'Cuturapi', '2113', '21'),
('211305', 'Ollaraya', '2113', '21'),
('211306', 'Tinicachi', '2113', '21'),
('211307', 'Unicachi', '2113', '21'),
('220101', 'Moyobamba', '2201', '22'),
('220102', 'Calzada', '2201', '22'),
('220103', 'Habana', '2201', '22'),
('220104', 'Jepelacio', '2201', '22'),
('220105', 'Soritor', '2201', '22'),
('220106', 'Yantalo', '2201', '22'),
('220201', 'Bellavista', '2202', '22'),
('220202', 'Alto Biavo', '2202', '22'),
('220203', 'Bajo Biavo', '2202', '22'),
('220204', 'Huallaga', '2202', '22'),
('220205', 'San Pablo', '2202', '22'),
('220206', 'San Rafael', '2202', '22'),
('220301', 'San José de Sisa', '2203', '22'),
('220302', 'Agua Blanca', '2203', '22'),
('220303', 'San Martín', '2203', '22'),
('220304', 'Santa Rosa', '2203', '22'),
('220305', 'Shatoja', '2203', '22'),
('220401', 'Saposoa', '2204', '22'),
('220402', 'Alto Saposoa', '2204', '22'),
('220403', 'El Eslabón', '2204', '22'),
('220404', 'Piscoyacu', '2204', '22'),
('220405', 'Sacanche', '2204', '22'),
('220406', 'Tingo de Saposoa', '2204', '22'),
('220501', 'Lamas', '2205', '22'),
('220502', 'Alonso de Alvarado', '2205', '22'),
('220503', 'Barranquita', '2205', '22'),
('220504', 'Caynarachi', '2205', '22'),
('220505', 'Cuñumbuqui', '2205', '22'),
('220506', 'Pinto Recodo', '2205', '22'),
('220507', 'Rumisapa', '2205', '22'),
('220508', 'San Roque de Cumbaza', '2205', '22'),
('220509', 'Shanao', '2205', '22'),
('220510', 'Tabalosos', '2205', '22'),
('220511', 'Zapatero', '2205', '22'),
('220601', 'Juanjuí', '2206', '22'),
('220602', 'Campanilla', '2206', '22'),
('220603', 'Huicungo', '2206', '22'),
('220604', 'Pachiza', '2206', '22'),
('220605', 'Pajarillo', '2206', '22'),
('220701', 'Picota', '2207', '22'),
('220702', 'Buenos Aires', '2207', '22'),
('220703', 'Caspisapa', '2207', '22'),
('220704', 'Pilluana', '2207', '22'),
('220705', 'Pucacaca', '2207', '22'),
('220706', 'San Cristóbal', '2207', '22'),
('220707', 'San Hilarión', '2207', '22'),
('220708', 'Shamboyacu', '2207', '22'),
('220709', 'Tingo de Ponasa', '2207', '22'),
('220710', 'Tres Unidos', '2207', '22'),
('220801', 'Rioja', '2208', '22'),
('220802', 'Awajun', '2208', '22'),
('220803', 'Elías Soplin Vargas', '2208', '22'),
('220804', 'Nueva Cajamarca', '2208', '22'),
('220805', 'Pardo Miguel', '2208', '22'),
('220806', 'Posic', '2208', '22'),
('220807', 'San Fernando', '2208', '22'),
('220808', 'Yorongos', '2208', '22'),
('220809', 'Yuracyacu', '2208', '22'),
('220901', 'Tarapoto', '2209', '22'),
('220902', 'Alberto Leveau', '2209', '22'),
('220903', 'Cacatachi', '2209', '22'),
('220904', 'Chazuta', '2209', '22'),
('220905', 'Chipurana', '2209', '22'),
('220906', 'El Porvenir', '2209', '22'),
('220907', 'Huimbayoc', '2209', '22'),
('220908', 'Juan Guerra', '2209', '22'),
('220909', 'La Banda de Shilcayo', '2209', '22'),
('220910', 'Morales', '2209', '22'),
('220911', 'Papaplaya', '2209', '22'),
('220912', 'San Antonio', '2209', '22'),
('220913', 'Sauce', '2209', '22'),
('220914', 'Shapaja', '2209', '22'),
('221001', 'Tocache', '2210', '22'),
('221002', 'Nuevo Progreso', '2210', '22'),
('221003', 'Polvora', '2210', '22'),
('221004', 'Shunte', '2210', '22'),
('221005', 'Uchiza', '2210', '22'),
('230101', 'Tacna', '2301', '23'),
('230102', 'Alto de la Alianza', '2301', '23'),
('230103', 'Calana', '2301', '23'),
('230104', 'Ciudad Nueva', '2301', '23'),
('230105', 'Inclan', '2301', '23'),
('230106', 'Pachia', '2301', '23'),
('230107', 'Palca', '2301', '23'),
('230108', 'Pocollay', '2301', '23'),
('230109', 'Sama', '2301', '23'),
('230110', 'Coronel Gregorio Albarracín Lanchipa', '2301', '23'),
('230111', 'La Yarada los Palos', '2301', '23'),
('230201', 'Candarave', '2302', '23'),
('230202', 'Cairani', '2302', '23'),
('230203', 'Camilaca', '2302', '23'),
('230204', 'Curibaya', '2302', '23'),
('230205', 'Huanuara', '2302', '23'),
('230206', 'Quilahuani', '2302', '23'),
('230301', 'Locumba', '2303', '23'),
('230302', 'Ilabaya', '2303', '23'),
('230303', 'Ite', '2303', '23'),
('230401', 'Tarata', '2304', '23'),
('230402', 'Héroes Albarracín', '2304', '23'),
('230403', 'Estique', '2304', '23'),
('230404', 'Estique-Pampa', '2304', '23'),
('230405', 'Sitajara', '2304', '23'),
('230406', 'Susapaya', '2304', '23'),
('230407', 'Tarucachi', '2304', '23'),
('230408', 'Ticaco', '2304', '23'),
('240101', 'Tumbes', '2401', '24'),
('240102', 'Corrales', '2401', '24'),
('240103', 'La Cruz', '2401', '24'),
('240104', 'Pampas de Hospital', '2401', '24'),
('240105', 'San Jacinto', '2401', '24'),
('240106', 'San Juan de la Virgen', '2401', '24'),
('240201', 'Zorritos', '2402', '24'),
('240202', 'Casitas', '2402', '24'),
('240203', 'Canoas de Punta Sal', '2402', '24'),
('240301', 'Zarumilla', '2403', '24'),
('240302', 'Aguas Verdes', '2403', '24'),
('240303', 'Matapalo', '2403', '24'),
('240304', 'Papayal', '2403', '24'),
('250101', 'Calleria', '2501', '25'),
('250102', 'Campoverde', '2501', '25'),
('250103', 'Iparia', '2501', '25'),
('250104', 'Masisea', '2501', '25'),
('250105', 'Yarinacocha', '2501', '25'),
('250106', 'Nueva Requena', '2501', '25'),
('250107', 'Manantay', '2501', '25'),
('250201', 'Raymondi', '2502', '25'),
('250202', 'Sepahua', '2502', '25'),
('250203', 'Tahuania', '2502', '25'),
('250204', 'Yurua', '2502', '25'),
('250301', 'Padre Abad', '2503', '25'),
('250302', 'Irazola', '2503', '25'),
('250303', 'Curimana', '2503', '25'),
('250304', 'Neshuya', '2503', '25'),
('250305', 'Alexander Von Humboldt', '2503', '25'),
('250401', 'Purus', '2504', '25');

-- --------------------------------------------------------

--
-- Table structure for table `ubigeo_peru_provinces`
--

CREATE TABLE `ubigeo_peru_provinces` (
  `id` varchar(4) NOT NULL,
  `name` varchar(45) NOT NULL,
  `department_id` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ubigeo_peru_provinces`
--

INSERT INTO `ubigeo_peru_provinces` (`id`, `name`, `department_id`) VALUES
('0101', 'Chachapoyas', '01'),
('0102', 'Bagua', '01'),
('0103', 'Bongará', '01'),
('0104', 'Condorcanqui', '01'),
('0105', 'Luya', '01'),
('0106', 'Rodríguez de Mendoza', '01'),
('0107', 'Utcubamba', '01'),
('0201', 'Huaraz', '02'),
('0202', 'Aija', '02'),
('0203', 'Antonio Raymondi', '02'),
('0204', 'Asunción', '02'),
('0205', 'Bolognesi', '02'),
('0206', 'Carhuaz', '02'),
('0207', 'Carlos Fermín Fitzcarrald', '02'),
('0208', 'Casma', '02'),
('0209', 'Corongo', '02'),
('0210', 'Huari', '02'),
('0211', 'Huarmey', '02'),
('0212', 'Huaylas', '02'),
('0213', 'Mariscal Luzuriaga', '02'),
('0214', 'Ocros', '02'),
('0215', 'Pallasca', '02'),
('0216', 'Pomabamba', '02'),
('0217', 'Recuay', '02'),
('0218', 'Santa', '02'),
('0219', 'Sihuas', '02'),
('0220', 'Yungay', '02'),
('0301', 'Abancay', '03'),
('0302', 'Andahuaylas', '03'),
('0303', 'Antabamba', '03'),
('0304', 'Aymaraes', '03'),
('0305', 'Cotabambas', '03'),
('0306', 'Chincheros', '03'),
('0307', 'Grau', '03'),
('0401', 'Arequipa', '04'),
('0402', 'Camaná', '04'),
('0403', 'Caravelí', '04'),
('0404', 'Castilla', '04'),
('0405', 'Caylloma', '04'),
('0406', 'Condesuyos', '04'),
('0407', 'Islay', '04'),
('0408', 'La Uniòn', '04'),
('0501', 'Huamanga', '05'),
('0502', 'Cangallo', '05'),
('0503', 'Huanca Sancos', '05'),
('0504', 'Huanta', '05'),
('0505', 'La Mar', '05'),
('0506', 'Lucanas', '05'),
('0507', 'Parinacochas', '05'),
('0508', 'Pàucar del Sara Sara', '05'),
('0509', 'Sucre', '05'),
('0510', 'Víctor Fajardo', '05'),
('0511', 'Vilcas Huamán', '05'),
('0601', 'Cajamarca', '06'),
('0602', 'Cajabamba', '06'),
('0603', 'Celendín', '06'),
('0604', 'Chota', '06'),
('0605', 'Contumazá', '06'),
('0606', 'Cutervo', '06'),
('0607', 'Hualgayoc', '06'),
('0608', 'Jaén', '06'),
('0609', 'San Ignacio', '06'),
('0610', 'San Marcos', '06'),
('0611', 'San Miguel', '06'),
('0612', 'San Pablo', '06'),
('0613', 'Santa Cruz', '06'),
('0701', 'Prov. Const. del Callao', '07'),
('0801', 'Cusco', '08'),
('0802', 'Acomayo', '08'),
('0803', 'Anta', '08'),
('0804', 'Calca', '08'),
('0805', 'Canas', '08'),
('0806', 'Canchis', '08'),
('0807', 'Chumbivilcas', '08'),
('0808', 'Espinar', '08'),
('0809', 'La Convención', '08'),
('0810', 'Paruro', '08'),
('0811', 'Paucartambo', '08'),
('0812', 'Quispicanchi', '08'),
('0813', 'Urubamba', '08'),
('0901', 'Huancavelica', '09'),
('0902', 'Acobamba', '09'),
('0903', 'Angaraes', '09'),
('0904', 'Castrovirreyna', '09'),
('0905', 'Churcampa', '09'),
('0906', 'Huaytará', '09'),
('0907', 'Tayacaja', '09'),
('1001', 'Huánuco', '10'),
('1002', 'Ambo', '10'),
('1003', 'Dos de Mayo', '10'),
('1004', 'Huacaybamba', '10'),
('1005', 'Huamalíes', '10'),
('1006', 'Leoncio Prado', '10'),
('1007', 'Marañón', '10'),
('1008', 'Pachitea', '10'),
('1009', 'Puerto Inca', '10'),
('1010', 'Lauricocha ', '10'),
('1011', 'Yarowilca ', '10'),
('1101', 'Ica ', '11'),
('1102', 'Chincha ', '11'),
('1103', 'Nasca ', '11'),
('1104', 'Palpa ', '11'),
('1105', 'Pisco ', '11'),
('1201', 'Huancayo ', '12'),
('1202', 'Concepción ', '12'),
('1203', 'Chanchamayo ', '12'),
('1204', 'Jauja ', '12'),
('1205', 'Junín ', '12'),
('1206', 'Satipo ', '12'),
('1207', 'Tarma ', '12'),
('1208', 'Yauli ', '12'),
('1209', 'Chupaca ', '12'),
('1301', 'Trujillo ', '13'),
('1302', 'Ascope ', '13'),
('1303', 'Bolívar ', '13'),
('1304', 'Chepén ', '13'),
('1305', 'Julcán ', '13'),
('1306', 'Otuzco ', '13'),
('1307', 'Pacasmayo ', '13'),
('1308', 'Pataz ', '13'),
('1309', 'Sánchez Carrión ', '13'),
('1310', 'Santiago de Chuco ', '13'),
('1311', 'Gran Chimú ', '13'),
('1312', 'Virú ', '13'),
('1401', 'Chiclayo ', '14'),
('1402', 'Ferreñafe ', '14'),
('1403', 'Lambayeque ', '14'),
('1501', 'Lima ', '15'),
('1502', 'Barranca ', '15'),
('1503', 'Cajatambo ', '15'),
('1504', 'Canta ', '15'),
('1505', 'Cañete ', '15'),
('1506', 'Huaral ', '15'),
('1507', 'Huarochirí ', '15'),
('1508', 'Huaura ', '15'),
('1509', 'Oyón ', '15'),
('1510', 'Yauyos ', '15'),
('1601', 'Maynas ', '16'),
('1602', 'Alto Amazonas ', '16'),
('1603', 'Loreto ', '16'),
('1604', 'Mariscal Ramón Castilla ', '16'),
('1605', 'Requena ', '16'),
('1606', 'Ucayali ', '16'),
('1607', 'Datem del Marañón ', '16'),
('1608', 'Putumayo', '16'),
('1701', 'Tambopata ', '17'),
('1702', 'Manu ', '17'),
('1703', 'Tahuamanu ', '17'),
('1801', 'Mariscal Nieto ', '18'),
('1802', 'General Sánchez Cerro ', '18'),
('1803', 'Ilo ', '18'),
('1901', 'Pasco ', '19'),
('1902', 'Daniel Alcides Carrión ', '19'),
('1903', 'Oxapampa ', '19'),
('2001', 'Piura ', '20'),
('2002', 'Ayabaca ', '20'),
('2003', 'Huancabamba ', '20'),
('2004', 'Morropón ', '20'),
('2005', 'Paita ', '20'),
('2006', 'Sullana ', '20'),
('2007', 'Talara ', '20'),
('2008', 'Sechura ', '20'),
('2101', 'Puno ', '21'),
('2102', 'Azángaro ', '21'),
('2103', 'Carabaya ', '21'),
('2104', 'Chucuito ', '21'),
('2105', 'El Collao ', '21'),
('2106', 'Huancané ', '21'),
('2107', 'Lampa ', '21'),
('2108', 'Melgar ', '21'),
('2109', 'Moho ', '21'),
('2110', 'San Antonio de Putina ', '21'),
('2111', 'San Román ', '21'),
('2112', 'Sandia ', '21'),
('2113', 'Yunguyo ', '21'),
('2201', 'Moyobamba ', '22'),
('2202', 'Bellavista ', '22'),
('2203', 'El Dorado ', '22'),
('2204', 'Huallaga ', '22'),
('2205', 'Lamas ', '22'),
('2206', 'Mariscal Cáceres ', '22'),
('2207', 'Picota ', '22'),
('2208', 'Rioja ', '22'),
('2209', 'San Martín ', '22'),
('2210', 'Tocache ', '22'),
('2301', 'Tacna ', '23'),
('2302', 'Candarave ', '23'),
('2303', 'Jorge Basadre ', '23'),
('2304', 'Tarata ', '23'),
('2401', 'Tumbes ', '24'),
('2402', 'Contralmirante Villar ', '24'),
('2403', 'Zarumilla ', '24'),
('2501', 'Coronel Portillo ', '25'),
('2502', 'Atalaya ', '25'),
('2503', 'Padre Abad ', '25'),
('2504', 'Purús', '25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` bigint UNSIGNED NOT NULL,
  `nombre_users` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_fotografia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_persona` bigint DEFAULT NULL,
  `users_estado` tinyint DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nombre_users`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `username`, `user_fotografia`, `id_persona`, `users_estado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'reynaalfredo421@gmail.com', NULL, '$2y$10$PguwZg.k8bCjqmvyH8Z9BuaLgKJv4QcVhtkO6QFwUbcnMR08VlNq2', NULL, NULL, NULL, 'superadmin', 'usuarios/1703949274-a9b2674e-c733-4d91-9edd-bbb29c8c7362.webp', 1, 1, 'dTOhjv8lIQ5OFVJa0NNghmASNoCSHzdvFyBQhPMHFkPL5QoA58F0z1dFuxbG', '2023-06-13 22:56:32', '2023-12-30 15:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` bigint NOT NULL,
  `id_caja_numero` bigint NOT NULL,
  `id_empresa` bigint NOT NULL DEFAULT '1',
  `id_users` bigint DEFAULT NULL,
  `id_clientes` bigint NOT NULL,
  `id_tipo_pago` bigint NOT NULL DEFAULT '3',
  `id_moneda` bigint NOT NULL DEFAULT '1',
  `venta_tipo_campo` decimal(10,2) DEFAULT NULL COMMENT 'aca se guardara el tipo de cambio',
  `venta_condicion_resumen` tinyint NOT NULL DEFAULT '1' COMMENT '1-Registro, 2-Actualizar, 3-baja',
  `venta_tipo_envio` tinyint NOT NULL DEFAULT '0' COMMENT '1-directo, 2-resumen diario',
  `venta_direccion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_tipo` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `venta_serie` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_correlativo` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `venta_descuento_global` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalgratuita` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalexonerada` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalinafecta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalgravada` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totaligv` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_incluye_igv` tinyint NOT NULL DEFAULT '1',
  `venta_totaldescuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_icbper` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_pago_cliente` decimal(10,2) DEFAULT NULL,
  `venta_vuelto` decimal(10,2) DEFAULT NULL,
  `venta_fecha` datetime NOT NULL,
  `venta_observacion` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tipo_documento_modificar` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `serie_modificar` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `correlativo_modificar` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_codigo_motivo_nota` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_estado_sunat` tinyint NOT NULL DEFAULT '0',
  `venta_fecha_envio` datetime DEFAULT NULL,
  `venta_rutaXML` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_rutaCDR` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_respuesta_sunat` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_fecha_de_baja` date DEFAULT NULL,
  `anulado_sunat` tinyint NOT NULL DEFAULT '0',
  `venta_cancelar` tinyint(1) NOT NULL DEFAULT '1',
  `venta_seriecorrelativo_notaventa` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '	Aqui se llena cuando se edita una nota de venta',
  `venta_codigo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cambiar_concepto` tinyint NOT NULL DEFAULT '1' COMMENT '1 es NO, 2 es SI',
  `concepto_nuevo` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tipo_venta` tinyint DEFAULT NULL COMMENT '1 si la venta es en tienda , 2 en web',
  `venta_estado_venta` tinyint DEFAULT '0',
  `id_formas_pago` bigint NOT NULL,
  `venta_estado_pago` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_caja_numero`, `id_empresa`, `id_users`, `id_clientes`, `id_tipo_pago`, `id_moneda`, `venta_tipo_campo`, `venta_condicion_resumen`, `venta_tipo_envio`, `venta_direccion`, `venta_tipo`, `venta_serie`, `venta_correlativo`, `venta_descuento_global`, `venta_totalgratuita`, `venta_totalexonerada`, `venta_totalinafecta`, `venta_totalgravada`, `venta_totaligv`, `venta_incluye_igv`, `venta_totaldescuento`, `venta_icbper`, `venta_total`, `venta_pago_cliente`, `venta_vuelto`, `venta_fecha`, `venta_observacion`, `tipo_documento_modificar`, `serie_modificar`, `correlativo_modificar`, `venta_codigo_motivo_nota`, `venta_estado_sunat`, `venta_fecha_envio`, `venta_rutaXML`, `venta_rutaCDR`, `venta_respuesta_sunat`, `venta_fecha_de_baja`, `anulado_sunat`, `venta_cancelar`, `venta_seriecorrelativo_notaventa`, `venta_codigo`, `cambiar_concepto`, `concepto_nuevo`, `tipo_venta`, `venta_estado_venta`, `id_formas_pago`, `venta_estado_pago`, `created_at`, `updated_at`) VALUES
(74, 2, 1, 1, 3, 1, 1, '0.00', 1, 0, NULL, '03', 'B002', '2', '0.00', '0.00', '7.00', '0.00', '0.00', '0.00', 1, '0.00', '0.00', '7.00', '10.00', '3.00', '2023-11-14 11:55:34', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1699980934.1913', 1, NULL, 0, 1, 1, 2, '2023-11-14 16:55:34', '2023-11-14 16:55:34'),
(75, 1, 1, 1, 61, 1, 1, '0.00', 1, 0, NULL, '03', 'B001', '30', '0.00', '0.00', '45.00', '0.00', '0.00', '0.00', 1, '0.00', '0.00', '45.00', '45.00', '0.00', '2023-11-18 10:30:49', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1700321449.0693', 1, NULL, 0, 1, 2, 0, '2023-11-18 15:30:49', '2023-11-18 15:30:49'),
(76, 1, 1, 1, 3, 1, 1, '0.00', 1, 0, NULL, '03', 'B001', '31', '0.00', '0.00', '60.00', '0.00', '0.00', '0.00', 1, '0.00', '0.00', '60.00', '100.00', '40.00', '2023-11-28 21:11:16', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1701223876.2111', 1, NULL, 0, 1, 2, 0, '2023-11-29 02:11:16', '2023-11-29 02:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `ventas_anulados`
--

CREATE TABLE `ventas_anulados` (
  `id_venta_anulado` bigint UNSIGNED NOT NULL,
  `venta_anulado_fecha` date NOT NULL,
  `venta_anulado_serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_anulado_correlativo` int NOT NULL,
  `venta_anulacion_ticket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_anulado_rutaXML` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_anulado_rutaCDR` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_anulado_estado_sunat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `id_users` bigint UNSIGNED NOT NULL,
  `venta_anulado_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `venta_anulado_estado` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ventas_anulados`
--

INSERT INTO `ventas_anulados` (`id_venta_anulado`, `venta_anulado_fecha`, `venta_anulado_serie`, `venta_anulado_correlativo`, `venta_anulacion_ticket`, `venta_anulado_rutaXML`, `venta_anulado_rutaCDR`, `venta_anulado_estado_sunat`, `id_venta`, `id_users`, `venta_anulado_datetime`, `venta_anulado_estado`, `created_at`, `updated_at`) VALUES
(1, '2023-10-27', 'F001', 4, NULL, NULL, NULL, NULL, 37, 1, '2023-10-27 16:56:23', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ventas_cuotas`
--

CREATE TABLE `ventas_cuotas` (
  `id_ventas_cuotas` bigint UNSIGNED NOT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `id_tipo_pago` bigint UNSIGNED NOT NULL,
  `id_formas_pago` bigint UNSIGNED NOT NULL,
  `venta_cuota_numero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_cuota_importe` decimal(10,2) NOT NULL,
  `venta_cuota_fecha` date NOT NULL,
  `venta_cuota_estado` tinyint NOT NULL,
  `venta_cuota_pago` tinyint NOT NULL COMMENT 'este campo sera para saber si se pago la cuota o no 1 pago 0 no pago',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ventas_cuotas`
--

INSERT INTO `ventas_cuotas` (`id_ventas_cuotas`, `id_venta`, `id_tipo_pago`, `id_formas_pago`, `venta_cuota_numero`, `venta_cuota_importe`, `venta_cuota_fecha`, `venta_cuota_estado`, `venta_cuota_pago`, `created_at`, `updated_at`) VALUES
(1, 18, 1, 2, '1', '20.00', '2023-10-21', 1, 0, NULL, NULL),
(2, 18, 1, 2, '2', '25.00', '2023-11-19', 1, 0, NULL, NULL),
(3, 36, 1, 2, '1', '30.00', '2023-10-28', 1, 0, NULL, NULL),
(4, 36, 1, 2, '2', '30.00', '2023-11-28', 1, 0, NULL, NULL),
(5, 39, 1, 2, '1', '50.00', '2023-10-28', 1, 0, NULL, NULL),
(6, 39, 1, 2, '2', '50.00', '2023-11-26', 1, 0, NULL, NULL),
(7, 39, 1, 2, '3', '30.00', '2023-12-26', 1, 0, NULL, NULL),
(8, 75, 1, 2, '1', '20.00', '2023-11-19', 1, 0, NULL, NULL),
(9, 75, 1, 2, '2', '25.00', '2023-12-17', 1, 0, NULL, NULL),
(10, 76, 1, 2, '1', '20.00', '2023-11-29', 1, 0, NULL, NULL),
(11, 76, 1, 2, '2', '10.00', '2023-12-27', 1, 0, NULL, NULL),
(12, 76, 1, 2, '3', '30.00', '2024-02-14', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id_venta_detalle` bigint NOT NULL,
  `id_venta` bigint NOT NULL,
  `id_producto` bigint NOT NULL,
  `venta_detalle_valor_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_precio_unitario` decimal(10,2) NOT NULL,
  `venta_detalle_nombre_producto` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `venta_detalle_cantidad` double NOT NULL,
  `venta_detalle_total_igv` decimal(10,2) NOT NULL,
  `venta_detalle_porcentaje_igv` decimal(10,2) NOT NULL DEFAULT '0.18',
  `venta_detalle_total_icbper` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_valor_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_importe_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_producto_precios` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ventas_detalle`
--

INSERT INTO `ventas_detalle` (`id_venta_detalle`, `id_venta`, `id_producto`, `venta_detalle_valor_unitario`, `venta_detalle_precio_unitario`, `venta_detalle_nombre_producto`, `venta_detalle_cantidad`, `venta_detalle_total_igv`, `venta_detalle_porcentaje_igv`, `venta_detalle_total_icbper`, `venta_detalle_valor_total`, `venta_detalle_importe_total`, `id_producto_precios`, `created_at`, `updated_at`) VALUES
(84, 74, 7, '3.50', '3.50', 'NECTAR DE COCONA', 2, '0.00', '0.18', '0.00', '7.00', '7.00', 10, '2023-11-14 16:55:34', '2023-11-14 16:55:34'),
(85, 75, 4, '15.00', '15.00', 'AJI  CHARAPITA TIPO TABASCO', 3, '0.00', '0.18', '0.00', '45.00', '45.00', 17, '2023-11-18 15:30:49', '2023-11-18 15:30:49'),
(86, 76, 4, '15.00', '15.00', 'AJI  CHARAPITA TIPO TABASCO', 4, '0.00', '0.18', '0.00', '60.00', '60.00', 17, '2023-11-29 02:11:16', '2023-11-29 02:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `ventas_detalle_pagos`
--

CREATE TABLE `ventas_detalle_pagos` (
  `id_venta_detalle_pago` bigint NOT NULL,
  `id_venta` bigint NOT NULL,
  `id_tipo_pago` bigint NOT NULL,
  `venta_detalle_pago_monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_pago_estado` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ventas_detalle_pagos`
--

INSERT INTO `ventas_detalle_pagos` (`id_venta_detalle_pago`, `id_venta`, `id_tipo_pago`, `venta_detalle_pago_monto`, `venta_detalle_pago_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '60.00', 1, '2023-10-11 16:44:47', '2023-10-11 16:44:47'),
(2, 3, 2, '15.00', 1, '2023-10-18 22:18:27', '2023-10-18 22:18:27'),
(3, 4, 2, '72.00', 1, '2023-10-18 22:24:16', '2023-10-18 22:24:16'),
(4, 5, 2, '72.00', 1, '2023-10-18 22:27:24', '2023-10-18 22:27:24'),
(5, 6, 2, '72.00', 1, '2023-10-19 15:05:43', '2023-10-19 15:05:43'),
(6, 7, 2, '96.00', 1, '2023-10-19 16:30:45', '2023-10-19 16:30:45'),
(7, 8, 2, '60.00', 1, '2023-10-19 19:15:25', '2023-10-19 19:15:25'),
(8, 9, 2, '144.00', 1, '2023-10-19 21:00:30', '2023-10-19 21:00:30'),
(9, 10, 2, '60.00', 1, '2023-10-19 21:05:35', '2023-10-19 21:05:35'),
(10, 11, 1, '60.00', 1, '2023-10-20 15:52:25', '2023-10-20 15:52:25'),
(11, 12, 1, '10.50', 1, '2023-10-20 16:57:33', '2023-10-20 16:57:33'),
(12, 13, 1, '10.50', 1, '2023-10-20 16:57:49', '2023-10-20 16:57:49'),
(13, 14, 1, '10.50', 1, '2023-10-20 16:59:16', '2023-10-20 16:59:16'),
(14, 15, 1, '10.50', 1, '2023-10-20 17:00:26', '2023-10-20 17:00:26'),
(15, 16, 1, '30.00', 1, '2023-10-20 17:04:30', '2023-10-20 17:04:30'),
(16, 17, 1, '30.00', 1, '2023-10-20 17:05:42', '2023-10-20 17:05:42'),
(17, 18, 1, '45.00', 1, '2023-10-20 17:22:32', '2023-10-20 17:22:32'),
(18, 19, 2, '15.00', 1, '2023-10-20 18:49:58', '2023-10-20 18:49:58'),
(19, 20, 2, '243.00', 1, '2023-10-20 19:44:04', '2023-10-20 19:44:04'),
(20, 21, 2, '243.00', 1, '2023-10-20 19:47:12', '2023-10-20 19:47:12'),
(21, 22, 2, '156.00', 1, '2023-10-20 20:02:39', '2023-10-20 20:02:39'),
(22, 23, 1, '45.00', 1, '2023-10-24 09:54:26', '2023-10-24 09:54:26'),
(23, 24, 1, '45.00', 1, '2023-10-24 09:55:07', '2023-10-24 09:55:07'),
(24, 25, 1, '45.00', 1, '2023-10-24 09:55:29', '2023-10-24 09:55:29'),
(25, 26, 1, '45.00', 1, '2023-10-24 09:56:06', '2023-10-24 09:56:06'),
(26, 27, 1, '15.00', 1, '2023-10-26 16:50:42', '2023-10-26 16:50:42'),
(27, 28, 1, '30.00', 1, '2023-10-26 17:29:01', '2023-10-26 17:29:01'),
(28, 29, 1, '15.00', 1, '2023-10-26 18:15:15', '2023-10-26 18:15:15'),
(29, 30, 1, '72.00', 1, '2023-10-27 15:24:03', '2023-10-27 15:24:03'),
(30, 31, 1, '15.00', 1, '2023-10-27 16:35:33', '2023-10-27 16:35:33'),
(31, 32, 1, '120.00', 1, '2023-10-27 16:40:06', '2023-10-27 16:40:06'),
(32, 33, 1, '30.00', 1, '2023-10-27 17:49:02', '2023-10-27 17:49:02'),
(33, 34, 1, '60.00', 1, '2023-10-27 17:51:47', '2023-10-27 17:51:47'),
(34, 35, 1, '267.00', 1, '2023-10-27 18:02:08', '2023-10-27 18:02:08'),
(35, 36, 1, '60.00', 1, '2023-10-27 20:32:01', '2023-10-27 20:32:01'),
(36, 37, 1, '10.00', 1, '2023-10-27 21:19:38', '2023-10-27 21:19:38'),
(37, 37, 3, '35.00', 1, '2023-10-27 21:19:38', '2023-10-27 21:19:38'),
(38, 38, 1, '168.00', 1, '2023-10-27 22:16:22', '2023-10-27 22:16:22'),
(39, 39, 1, '130.00', 1, '2023-10-27 22:18:04', '2023-10-27 22:18:04'),
(40, 40, 2, '84.00', 1, '2023-10-28 13:22:43', '2023-10-28 13:22:43'),
(41, 41, 1, '60.00', 1, '2023-10-30 14:11:53', '2023-10-30 14:11:53'),
(42, 42, 1, '35.00', 1, '2023-10-30 14:16:28', '2023-10-30 14:16:28'),
(43, 43, 1, '144.00', 1, '2023-10-30 14:17:22', '2023-10-30 14:17:22'),
(44, 44, 1, '30.00', 1, '2023-10-30 14:42:05', '2023-10-30 14:42:05'),
(45, 45, 1, '15.00', 1, '2023-10-30 14:46:04', '2023-10-30 14:46:04'),
(46, 46, 1, '15.00', 1, '2023-10-30 14:50:51', '2023-10-30 14:50:51'),
(47, 47, 1, '30.00', 1, '2023-10-30 15:13:51', '2023-10-30 15:13:51'),
(48, 48, 1, '15.00', 1, '2023-10-30 15:24:19', '2023-10-30 15:24:19'),
(49, 49, 2, '144.00', 1, '2023-10-30 15:56:32', '2023-10-30 15:56:32'),
(50, 50, 2, '144.00', 1, '2023-10-30 15:58:11', '2023-10-30 15:58:11'),
(51, 51, 2, '144.00', 1, '2023-10-30 17:00:26', '2023-10-30 17:00:26'),
(52, 52, 2, '144.00', 1, '2023-10-30 17:01:19', '2023-10-30 17:01:19'),
(53, 56, 2, '30.00', 1, '2023-10-30 17:12:49', '2023-10-30 17:12:49'),
(54, 57, 2, '15.00', 1, '2023-10-30 17:18:03', '2023-10-30 17:18:03'),
(55, 58, 2, '15.00', 1, '2023-10-30 17:32:38', '2023-10-30 17:32:38'),
(56, 59, 2, '15.00', 1, '2023-10-30 17:37:07', '2023-10-30 17:37:07'),
(57, 60, 2, '72.00', 1, '2023-10-30 18:38:55', '2023-10-30 18:38:55'),
(58, 61, 2, '72.00', 1, '2023-10-30 19:00:42', '2023-10-30 19:00:42'),
(59, 62, 2, '60.00', 1, '2023-10-30 19:24:37', '2023-10-30 19:24:37'),
(60, 63, 2, '15.00', 1, '2023-10-30 21:18:38', '2023-10-30 21:18:38'),
(61, 64, 2, '15.00', 1, '2023-10-30 21:19:45', '2023-10-30 21:19:45'),
(62, 65, 2, '15.00', 1, '2023-10-30 21:21:54', '2023-10-30 21:21:54'),
(63, 66, 1, '15.00', 1, '2023-10-31 15:08:05', '2023-10-31 15:08:05'),
(64, 67, 2, '111.10', 1, '2023-11-03 10:24:31', '2023-11-03 10:24:31'),
(65, 68, 2, '69.00', 1, '2023-11-03 12:01:22', '2023-11-03 12:01:22'),
(66, 71, 2, '57.00', 1, '2023-11-03 12:12:25', '2023-11-03 12:12:25'),
(67, 72, 2, '12.00', 1, '2023-11-03 13:50:16', '2023-11-03 13:50:16'),
(68, 73, 1, '15.00', 1, '2023-11-14 14:24:18', '2023-11-14 14:24:18'),
(69, 74, 1, '7.00', 1, '2023-11-14 16:55:34', '2023-11-14 16:55:34'),
(70, 75, 1, '45.00', 1, '2023-11-18 15:30:49', '2023-11-18 15:30:49'),
(71, 76, 1, '60.00', 1, '2023-11-29 02:11:16', '2023-11-29 02:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `venta_web`
--

CREATE TABLE `venta_web` (
  `id_venta_web` bigint UNSIGNED NOT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `venta_web_tipo_entrega` tinyint DEFAULT NULL COMMENT '1 es para recojo en local 2 para delivery',
  `venta_web_tipo_destino` tinyint DEFAULT NULL COMMENT '1 es para Provincias en local 2 para extranjeros',
  `id_pais` bigint DEFAULT NULL,
  `id_departamento` int DEFAULT NULL,
  `id_provincia` int DEFAULT NULL,
  `id_distritos` int DEFAULT NULL,
  `venta_web_direccion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_otros_datos` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tipo_documento` bigint DEFAULT NULL,
  `venta_web_numdoc_receptor` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_nombre_receptor` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_correo_receptor` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_telefono_receptor` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_estado` tinyint NOT NULL,
  `venta_web_estado_pedido` tinyint DEFAULT NULL COMMENT '0 pendiente de confirmacion 1 confirmacion y pendiente de entrega o envio ,2 enviado , 3 entregado',
  `venta_web_codigotranslado` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_documentotransferencia` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_fecha_enviado` datetime DEFAULT NULL,
  `id_agencias` bigint DEFAULT NULL,
  `id_usuarios_misky` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venta_web`
--

INSERT INTO `venta_web` (`id_venta_web`, `id_venta`, `venta_web_tipo_entrega`, `venta_web_tipo_destino`, `id_pais`, `id_departamento`, `id_provincia`, `id_distritos`, `venta_web_direccion`, `venta_web_otros_datos`, `id_tipo_documento`, `venta_web_numdoc_receptor`, `venta_web_nombre_receptor`, `venta_web_correo_receptor`, `venta_web_telefono_receptor`, `venta_web_estado`, `venta_web_estado_pedido`, `venta_web_codigotranslado`, `venta_web_documentotransferencia`, `venta_web_fecha_enviado`, `id_agencias`, `id_usuarios_misky`, `created_at`, `updated_at`) VALUES
(23, 58, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(24, 59, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(25, 60, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(26, 61, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(27, 62, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(28, 63, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(29, 64, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(30, 65, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(31, 67, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(32, 68, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(33, 69, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(34, 70, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(35, 71, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(36, 72, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visualizacion`
--

CREATE TABLE `visualizacion` (
  `id_visualizacion` bigint UNSIGNED NOT NULL,
  `visualizacion_tipo` int NOT NULL COMMENT 'cuando se guarda cero es vista homer y cuando se guarda distinto es habitacion',
  `visualizacion_fecha` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visualizacion`
--

INSERT INTO `visualizacion` (`id_visualizacion`, `visualizacion_tipo`, `visualizacion_fecha`, `created_at`, `updated_at`) VALUES
(95, 0, '2023-11-13 15:14:54', NULL, NULL),
(96, 0, '2023-11-13 15:25:54', NULL, NULL),
(97, 9, '2023-11-13 15:26:02', NULL, NULL),
(98, 10, '2023-11-13 15:26:03', NULL, NULL),
(99, 11, '2023-11-13 15:26:04', NULL, NULL),
(100, 4, '2023-11-13 15:26:05', NULL, NULL),
(101, 9, '2023-11-13 15:27:54', NULL, NULL),
(102, 9, '2023-11-13 15:27:55', NULL, NULL),
(103, 0, '2023-11-14 15:52:14', NULL, NULL),
(104, 0, '2023-11-14 16:05:29', NULL, NULL),
(105, 0, '2023-11-15 09:52:35', NULL, NULL),
(106, 0, '2023-11-15 10:28:58', NULL, NULL),
(107, 0, '2023-11-15 10:46:41', NULL, NULL),
(108, 0, '2023-11-15 12:40:06', NULL, NULL),
(109, 0, '2023-11-15 12:42:37', NULL, NULL),
(110, 0, '2023-11-15 12:56:17', NULL, NULL),
(111, 0, '2023-11-15 14:41:25', NULL, NULL),
(112, 0, '2023-11-15 14:41:33', NULL, NULL),
(113, 0, '2023-11-28 21:09:21', NULL, NULL),
(114, 4, '2023-12-27 09:21:12', NULL, NULL),
(115, 4, '2023-12-27 10:10:51', NULL, NULL),
(116, 0, '2023-12-27 10:10:56', NULL, NULL),
(117, 11, '2023-12-27 10:11:04', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_clientes`),
  ADD KEY `clientes_id_tipo_documento_foreign` (`id_tipo_documento`);

--
-- Indexes for table `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indexes for table `envio_resumen`
--
ALTER TABLE `envio_resumen`
  ADD PRIMARY KEY (`id_envio_resumen`),
  ADD KEY `envio_resumen_id_sucursal_foreign` (`id_empresa`);

--
-- Indexes for table `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  ADD PRIMARY KEY (`id_envio_resumen_detalle`),
  ADD KEY `envio_resumen_detalle_id_envio_resumen_foreign` (`id_envio_resumen`),
  ADD KEY `envio_resumen_detalle_id_ventas_foreign` (`id_venta`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`id_medida`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`id_moneda`);

--
-- Indexes for table `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id_oferta`);

--
-- Indexes for table `oferta_detalle`
--
ALTER TABLE `oferta_detalle`
  ADD PRIMARY KEY (`id_oferta_detalle`),
  ADD KEY `oferta_detalle_id_oferta_foreign` (`id_oferta`),
  ADD KEY `oferta_detalle_id_producto_foreign` (`id_producto`);

--
-- Indexes for table `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_opciones`),
  ADD KEY `opciones_id_submenu_foreign` (`id_submenu`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `persona_id_empresa_foreign` (`id_empresa`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`id_submenu`),
  ADD KEY `submenu_id_menu_foreign` (`id_menu`);

--
-- Indexes for table `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  ADD PRIMARY KEY (`id_tipo_afectacion`);

--
-- Indexes for table `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indexes for table `tipo_ncreditos`
--
ALTER TABLE `tipo_ncreditos`
  ADD PRIMARY KEY (`id_tipo_ncreditos`);

--
-- Indexes for table `tipo_ndebitos`
--
ALTER TABLE `tipo_ndebitos`
  ADD PRIMARY KEY (`id_tipo_ndebitos`);

--
-- Indexes for table `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id_tipo_pago`);

--
-- Indexes for table `tipo_venta`
--
ALTER TABLE `tipo_venta`
  ADD PRIMARY KEY (`id_tipo_venta`);

--
-- Indexes for table `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id_transaccion`);

--
-- Indexes for table `ubigeo_peru_departments`
--
ALTER TABLE `ubigeo_peru_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ubigeo_peru_districts`
--
ALTER TABLE `ubigeo_peru_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ubigeo_peru_provinces`
--
ALTER TABLE `ubigeo_peru_provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_usuario` (`id_users`),
  ADD KEY `id_moneda` (`id_moneda`),
  ADD KEY `id_cliente` (`id_clientes`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_formas_pago` (`id_formas_pago`);

--
-- Indexes for table `ventas_anulados`
--
ALTER TABLE `ventas_anulados`
  ADD PRIMARY KEY (`id_venta_anulado`),
  ADD KEY `ventas_anulados_id_ventas_foreign` (`id_venta`),
  ADD KEY `ventas_anulados_id_users_foreign` (`id_users`);

--
-- Indexes for table `ventas_cuotas`
--
ALTER TABLE `ventas_cuotas`
  ADD PRIMARY KEY (`id_ventas_cuotas`);

--
-- Indexes for table `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD PRIMARY KEY (`id_venta_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_comanda_detalle` (`id_producto`);

--
-- Indexes for table `ventas_detalle_pagos`
--
ALTER TABLE `ventas_detalle_pagos`
  ADD PRIMARY KEY (`id_venta_detalle_pago`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`);

--
-- Indexes for table `venta_web`
--
ALTER TABLE `venta_web`
  ADD PRIMARY KEY (`id_venta_web`);

--
-- Indexes for table `visualizacion`
--
ALTER TABLE `visualizacion`
  ADD PRIMARY KEY (`id_visualizacion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_clientes` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `envio_resumen`
--
ALTER TABLE `envio_resumen`
  MODIFY `id_envio_resumen` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  MODIFY `id_envio_resumen_detalle` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medida`
--
ALTER TABLE `medida`
  MODIFY `id_medida` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id_moneda` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oferta_detalle`
--
ALTER TABLE `oferta_detalle`
  MODIFY `id_oferta_detalle` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_opciones` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id_submenu` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  MODIFY `id_tipo_afectacion` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tipo_ncreditos`
--
ALTER TABLE `tipo_ncreditos`
  MODIFY `id_tipo_ncreditos` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tipo_ndebitos`
--
ALTER TABLE `tipo_ndebitos`
  MODIFY `id_tipo_ndebitos` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipo_pago` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipo_venta`
--
ALTER TABLE `tipo_venta`
  MODIFY `id_tipo_venta` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id_transaccion` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `ventas_anulados`
--
ALTER TABLE `ventas_anulados`
  MODIFY `id_venta_anulado` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ventas_cuotas`
--
ALTER TABLE `ventas_cuotas`
  MODIFY `id_ventas_cuotas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id_venta_detalle` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `ventas_detalle_pagos`
--
ALTER TABLE `ventas_detalle_pagos`
  MODIFY `id_venta_detalle_pago` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `venta_web`
--
ALTER TABLE `venta_web`
  MODIFY `id_venta_web` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `visualizacion`
--
ALTER TABLE `visualizacion`
  MODIFY `id_visualizacion` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_id_tipo_documento_foreign` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opciones`
--
ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_id_submenu_foreign` FOREIGN KEY (`id_submenu`) REFERENCES `submenu` (`id_submenu`);

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `submenu_id_menu_foreign` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
