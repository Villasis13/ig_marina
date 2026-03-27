-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2024 at 01:57 AM
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
-- Database: `emy_pet`
--

-- --------------------------------------------------------

--
-- Table structure for table `almacen`
--

CREATE TABLE `almacen` (
  `id_almacen` bigint UNSIGNED NOT NULL,
  `almacen_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `almacen_capacidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `almacen_direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `almacen_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `almacen`
--

INSERT INTO `almacen` (`id_almacen`, `almacen_nombre`, `almacen_capacidad`, `almacen_direccion`, `almacen_estado`, `created_at`, `updated_at`) VALUES
(1, 'Almacen enbutidos', '100', 'calle las americas #457', 0, NULL, NULL),
(2, 'Almacen Principal', '100', 'Calle Las Americas #457', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caja`
--

CREATE TABLE `caja` (
  `id_caja` bigint UNSIGNED NOT NULL,
  `id_caja_numero` bigint UNSIGNED NOT NULL,
  `caja_fecha` date NOT NULL,
  `id_users_apertura` bigint NOT NULL,
  `caja_apertura` decimal(10,2) NOT NULL,
  `caja_fecha_apertura` datetime NOT NULL,
  `id_users_cierre` bigint DEFAULT NULL,
  `caja_cierre` decimal(10,2) DEFAULT NULL,
  `caja_cierre_dolar` decimal(10,2) DEFAULT NULL,
  `caja_fecha_cierre` datetime DEFAULT NULL,
  `caja_estado` tinyint DEFAULT NULL,
  `caja_rendicion` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `caja`
--

INSERT INTO `caja` (`id_caja`, `id_caja_numero`, `caja_fecha`, `id_users_apertura`, `caja_apertura`, `caja_fecha_apertura`, `id_users_cierre`, `caja_cierre`, `caja_cierre_dolar`, `caja_fecha_cierre`, `caja_estado`, `caja_rendicion`, `created_at`, `updated_at`) VALUES
(17, 1, '2024-04-14', 1, '0.00', '2024-04-14 17:58:19', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caja_numero`
--

CREATE TABLE `caja_numero` (
  `id_caja_numero` bigint UNSIGNED NOT NULL,
  `caja_numero_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caja_numero_impresora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caja_numero_estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `caja_numero`
--

INSERT INTO `caja_numero` (`id_caja_numero`, `caja_numero_nombre`, `caja_numero_impresora`, `caja_numero_estado`, `created_at`, `updated_at`) VALUES
(1, 'Caja 1', 'Ticketera', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_ca` bigint UNSIGNED NOT NULL,
  `id_fa` bigint UNSIGNED NOT NULL,
  `ca_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ca_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_ca`, `id_fa`, `ca_nombre`, `ca_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juguetes', 1, NULL, NULL),
(2, 2, 'Gatos', 1, NULL, NULL),
(3, 3, 'Platos', 1, NULL, NULL),
(4, 4, 'Spray', 1, NULL, NULL),
(5, 5, 'Alimentos transportador', 1, NULL, NULL),
(6, 6, 'Arnes', 1, NULL, NULL),
(7, 7, 'Camas', 1, NULL, NULL),
(8, 8, 'Higiene', 1, NULL, NULL),
(9, 9, 'Medicina', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id_clientes` bigint UNSIGNED NOT NULL,
  `id_tipo_documento` bigint UNSIGNED NOT NULL,
  `cliente_razonsocial` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_numero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_direccion_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_fecha` datetime NOT NULL,
  `cliente_estado` tinyint NOT NULL,
  `cliente_codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `id_tipo_documento`, `cliente_razonsocial`, `cliente_nombre`, `cliente_numero`, `cliente_correo`, `cliente_direccion`, `cliente_direccion_2`, `cliente_telefono`, `cliente_fecha`, `cliente_estado`, `cliente_codigo`, `created_at`, `updated_at`) VALUES
(3, 2, 'Cliente General', 'Cliente General', '11111111', NULL, NULL, NULL, NULL, '2024-04-05 14:37:19', 1, '1712345839.0604', NULL, NULL),
(4, 2, 'APAGUEÑO REYNA EDER ALFREDO', 'APAGUEÑO REYNA EDER ALFREDO', '74077975', NULL, NULL, NULL, NULL, '2024-04-14 19:00:22', 1, '1713139222.4354', NULL, NULL),
(5, 4, 'APAGUEÑO REYNA EDER ALFREDO', 'APAGUEÑO REYNA EDER ALFREDO', '10740779759', NULL, NULL, NULL, NULL, '2024-04-14 19:11:27', 1, '1713139887.995', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` bigint UNSIGNED NOT NULL,
  `contacto_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto_valor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `empresa_razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_nombrecomercial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_ruc` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_domiciliofiscal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_pais` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_departamento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_provincia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_distrito` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_ubigeo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_telefono1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_telefono2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_celular1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_celular2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_foto_ticket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_usuario_sol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_clave_sol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_ruta_certificado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_clave_certificado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_ubigeo` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `empresa_razon_social`, `empresa_nombrecomercial`, `empresa_descripcion`, `empresa_ruc`, `empresa_domiciliofiscal`, `empresa_pais`, `empresa_departamento`, `empresa_provincia`, `empresa_distrito`, `empresa_ubigeo`, `empresa_telefono1`, `empresa_telefono2`, `empresa_celular1`, `empresa_celular2`, `empresa_foto`, `empresa_foto_ticket`, `empresa_correo`, `empresa_usuario_sol`, `empresa_clave_sol`, `empresa_estado`, `empresa_ruta_certificado`, `empresa_clave_certificado`, `id_ubigeo`, `created_at`, `updated_at`) VALUES
(1, 'HHK SOLUTIONS E.I.R.L.', 'EMY\'S PETS', 'EMY\'S PETS', '20612115592', 'MZA. W LOTE. 1 A.F. LOS LEONES DE LA FRAGATA', 'PE', 'LIMA ', 'LIMA ', 'SAN JUAN DE LURIGANCHO', '160101', NULL, NULL, NULL, NULL, 'logo_empresa.png', 'logo_empresa.png', NULL, 'EDEREMYS', 'EMYSeder21', '1', 'ApiFacturacion/certificado.pfx', 'T5VuRZpZ8KzBy2V', 1311, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `envio_resumen`
--

CREATE TABLE `envio_resumen` (
  `id_envio_resumen` bigint UNSIGNED NOT NULL,
  `id_empresa` bigint UNSIGNED NOT NULL,
  `envio_resumen_fecha` date NOT NULL,
  `envio_resumen_serie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_correlativo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_nombreXML` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_nombreCDR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envio_resumen_estado` tinyint NOT NULL,
  `envio_resumen_estadosunat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_resumen_estadosunat_consulta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envio_resumen_ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `envio_sunat_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `familias`
--

CREATE TABLE `familias` (
  `id_fa` bigint UNSIGNED NOT NULL,
  `fa_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fa_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `familias`
--

INSERT INTO `familias` (`id_fa`, `fa_nombre`, `fa_estado`, `created_at`, `updated_at`) VALUES
(1, 'JUGUETE', 1, NULL, NULL),
(2, 'GATOS', 1, NULL, NULL),
(3, 'PLATOS', 1, NULL, NULL),
(4, 'SPRAY', 1, NULL, NULL),
(5, 'Alimentos Transportador', 1, NULL, NULL),
(6, 'ARNES', 1, NULL, NULL),
(7, 'Camas', 1, NULL, NULL),
(8, 'Higiene', 1, NULL, NULL),
(9, 'Medicina', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medida`
--

CREATE TABLE `medida` (
  `id_medida` bigint UNSIGNED NOT NULL,
  `medida_codigo_unidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medida_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `menu_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_controlador` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_icono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_orden` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_mostrar` tinyint NOT NULL,
  `menu_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id_menu`, `menu_nombre`, `menu_controlador`, `menu_icono`, `menu_orden`, `menu_mostrar`, `menu_estado`, `created_at`, `updated_at`) VALUES
(1, 'Configuracion', 'configuracion', 'bx bx-cog', '1', 1, 1, NULL, '2023-12-30 14:50:22'),
(13, 'Gestion de negocio', 'Gestion', 'fa fa-chart-simple', '2', 1, 1, '2024-01-14 16:30:15', '2024-01-14 16:30:15'),
(14, 'Logistica', 'logistica', 'fa fa-chart-line', '3', 1, 1, '2024-01-15 01:45:19', '2024-01-15 01:45:19'),
(15, 'Gestion de ventas', 'Gestionventas', 'bx bx-cart', '4', 1, 1, '2024-02-02 03:17:44', '2024-02-02 03:17:44'),
(16, 'Facturacion', 'facturacion', 'bx bx-coin-stack', '5', 1, 1, '2024-02-16 01:22:22', '2024-02-16 01:22:22'),
(17, 'Reporte', 'reporte', 'bx bx-pie-chart', '6', 1, 1, '2024-02-18 11:01:21', '2024-02-18 11:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(56, '2023_09_05_191115_create_recursos_nutrientes_table', 37),
(58, '2024_01_14_133357_create_familias_table', 38),
(59, '2024_01_14_133837_create_categorias_table', 38),
(61, '2024_01_20_181609_create_productos_table', 39);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `monedas`
--

CREATE TABLE `monedas` (
  `id_moneda` bigint UNSIGNED NOT NULL,
  `moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrstandar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `simbolo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `movimientos_productos`
--

CREATE TABLE `movimientos_productos` (
  `id_movimientos_productos` bigint UNSIGNED NOT NULL,
  `movimientos_productos_fecha` date NOT NULL,
  `id_users` bigint UNSIGNED NOT NULL,
  `movimientos_productos_fecha_creacion` datetime NOT NULL,
  `movimientos_productos_tipo` tinyint NOT NULL COMMENT '1 ingreso , 2 salida',
  `movimientos_productos_estado` tinyint NOT NULL,
  `movimientos_productos_motivo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimientos_productos`
--

INSERT INTO `movimientos_productos` (`id_movimientos_productos`, `movimientos_productos_fecha`, `id_users`, `movimientos_productos_fecha_creacion`, `movimientos_productos_tipo`, `movimientos_productos_estado`, `movimientos_productos_motivo`, `created_at`, `updated_at`) VALUES
(1, '2024-04-14', 1, '2024-04-14 19:28:56', 2, 1, 'E', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movimientos_productos_detalle`
--

CREATE TABLE `movimientos_productos_detalle` (
  `id_movimientos_productos_detalle` bigint UNSIGNED NOT NULL,
  `id_movimientos_productos` bigint UNSIGNED NOT NULL,
  `id_pro` bigint UNSIGNED NOT NULL,
  `movimientos_productos_detalle_cantidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `movimientos_productos_detalle_estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimientos_productos_detalle`
--

INSERT INTO `movimientos_productos_detalle` (`id_movimientos_productos_detalle`, `id_movimientos_productos`, `id_pro`, `movimientos_productos_detalle_cantidad`, `movimientos_productos_detalle_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 13, '1', '1', NULL, NULL),
(2, 1, 14, '1', '1', NULL, NULL),
(3, 1, 15, '1', '1', NULL, NULL),
(4, 1, 16, '1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` bigint UNSIGNED NOT NULL,
  `oferta_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oferta_nombre_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_fecha_inicio` date NOT NULL,
  `oferta_hora_inicio` time NOT NULL,
  `oferta_fecha_cierre` date NOT NULL,
  `oferta_hora_cierre` time NOT NULL,
  `oferta_foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oferta_descuento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_estado` tinyint NOT NULL,
  `oferta_tipo` tinyint DEFAULT NULL COMMENT '1 descuento por producto 2 paquete de productos',
  `oferta_total_` decimal(10,2) DEFAULT NULL,
  `oferta_restar_cantidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_total_paquete` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `oferta_detalle_cantidad` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oferta_detalle_precio` decimal(10,2) DEFAULT NULL,
  `oferta_detalle_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opciones`
--

CREATE TABLE `opciones` (
  `id_opciones` bigint UNSIGNED NOT NULL,
  `id_submenu` bigint UNSIGNED NOT NULL,
  `opciones_funcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opciones_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(65, 48, 'listar_iconos', 'LISTA DE ICONOS', 1, 1, 1, '2023-12-30 15:07:38', '2023-12-30 15:07:38'),
(66, 49, 'gestion_de_proveedores', 'GESTION DE PROVEEDORES', 1, 1, 1, '2024-01-14 16:31:23', '2024-01-14 16:33:30'),
(67, 49, 'reporte_de_proveedores', 'REPORTE DE PROVEEDORES', 2, 1, 0, '2024-01-14 16:32:03', '2024-01-14 16:33:38'),
(68, 50, 'gestion_de_familias', 'GESTION DE FAMILIAS', 1, 1, 1, '2024-01-14 16:36:32', '2024-01-14 19:24:08'),
(69, 51, 'gestion_de_categorias', 'GESTION DE CATEGORIAS', 1, 1, 1, '2024-01-15 00:51:43', '2024-01-15 00:51:43'),
(70, 52, 'gestionar_almacen', 'GESTIONAR ALMACEN', 1, 1, 0, '2024-01-15 01:46:30', '2024-01-15 01:46:30'),
(71, 52, 'productos', 'PRODUCTOS', 2, 1, 1, '2024-01-15 01:46:59', '2024-01-15 01:46:59'),
(72, 53, 'registro_de_compra', 'REGISTRO DE COMPRA', 1, 1, 1, '2024-01-15 01:48:42', '2024-01-15 01:48:42'),
(73, 53, 'historial_de_compras', 'HISTORIAL DE COMPRAS', 2, 1, 1, '2024-01-15 01:49:05', '2024-01-15 01:49:05'),
(74, 54, 'gestion_orden_compra', 'ORDEN DE COMPRA', 1, 1, 1, '2024-01-28 16:52:44', '2024-01-28 16:52:44'),
(75, 55, 'movimientos_de_productos', 'MOVIMIENTO DE PRODUCTOS', 1, 1, 1, '2024-02-02 03:19:03', '2024-02-02 03:19:03'),
(76, 56, 'gestion_de_ventas', 'GESTIÓN DE VENTAS', 1, 1, 1, '2024-02-02 03:21:32', '2024-02-02 03:21:32'),
(77, 57, 'informacion_de_la_venta', 'INFORMACION DE LA VENTA', 1, 1, 1, '2024-02-14 13:39:04', '2024-02-14 13:39:04'),
(78, 58, 'gestionar_pendientes_declarar', 'PENDIENTES DE DECLARAR', 1, 1, 1, '2024-02-16 01:25:16', '2024-02-16 01:25:16'),
(79, 58, 'resumen_diario_new', 'RESUMEN DIARIO', 1, 0, 1, '2024-02-16 01:25:44', '2024-02-16 01:25:44'),
(80, 59, 'gestionar_historial_ventas_sunat', 'HISTORIAL VENTAS SUNAT', 1, 1, 1, '2024-02-16 01:28:58', '2024-02-16 01:28:58'),
(81, 59, 'gestionar_historial_resumen_diario', 'HISTORIAL RESUMEN DIARIO', 2, 1, 1, '2024-02-16 01:29:11', '2024-02-16 01:29:11'),
(82, 59, 'gestionar_historial_bajas_de_facturas', 'HISTORIAL BAJAS DE FACTURA', 3, 1, 1, '2024-02-16 01:29:26', '2024-02-16 01:29:26'),
(83, 60, 'informacion_de_resumen', 'INFORMACION DE RESUMEN', 1, 1, 1, '2024-02-16 03:18:40', '2024-02-16 03:18:40'),
(84, 62, 'reporte_de_caja', 'REPORTE DE CAJA', 1, 1, 1, '2024-02-18 11:06:52', '2024-02-18 11:06:52'),
(85, 63, 'reporte_por_productos', 'REPORTE POR PRODUCTO', 1, 1, 1, '2024-02-18 11:14:51', '2024-02-18 11:14:51'),
(86, 64, 'reporte_ventas', 'REPORTE VENTAS', 1, 1, 1, '2024-02-18 11:23:40', '2024-02-18 11:23:47'),
(87, 61, 'generar_nota_', 'GENERAR NOTA', 1, 1, 1, '2024-02-18 11:48:48', '2024-02-18 11:48:48'),
(88, 65, 'proveedores__reporte', 'PROVEEDORES', 1, 1, 1, '2024-02-21 03:36:45', '2024-02-21 03:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `orden_compra`
--

CREATE TABLE `orden_compra` (
  `id_orden_compra` bigint UNSIGNED NOT NULL,
  `id_solicitante` bigint UNSIGNED NOT NULL,
  `id_aprobacion` bigint UNSIGNED DEFAULT NULL,
  `id_proveedores` bigint UNSIGNED NOT NULL,
  `id_sede` bigint UNSIGNED DEFAULT NULL,
  `id_tipo_pago` bigint UNSIGNED DEFAULT NULL,
  `id_almacen` bigint DEFAULT NULL,
  `orden_compra_observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_fecha_aprob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden_compra_activo` int DEFAULT NULL,
  `orden_compra_numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden_compra_estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden_compra_fecha` datetime NOT NULL,
  `orden_compra_tipo_doc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_numero_doc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_doc_adjuntado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_fecha_emision_doc` date DEFAULT NULL,
  `orden_compra_doc_cuotas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_fecha_recibida` datetime DEFAULT NULL,
  `orden_compra_usuario_recibido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_total` decimal(10,2) DEFAULT NULL,
  `orden_compra_num_document` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_nom_prove` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra_flete` decimal(10,2) DEFAULT '0.00' COMMENT 'se agrego eso para saber cuanto es el total del flete gasto',
  `orden_compra_gastos_operativos` decimal(10,2) DEFAULT '0.00' COMMENT 'se agrego para sacer el total del gasto operativo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orden_compra`
--

INSERT INTO `orden_compra` (`id_orden_compra`, `id_solicitante`, `id_aprobacion`, `id_proveedores`, `id_sede`, `id_tipo_pago`, `id_almacen`, `orden_compra_observacion`, `orden_compra_fecha_aprob`, `orden_compra_titulo`, `orden_compra_activo`, `orden_compra_numero`, `orden_compra_estado`, `orden_compra_fecha`, `orden_compra_tipo_doc`, `orden_compra_numero_doc`, `orden_compra_doc_adjuntado`, `orden_compra_fecha_emision_doc`, `orden_compra_doc_cuotas`, `orden_compra_fecha_recibida`, `orden_compra_usuario_recibido`, `orden_compra_codigo`, `orden_compra_total`, `orden_compra_num_document`, `orden_compra_nom_prove`, `orden_compra_flete`, `orden_compra_gastos_operativos`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, NULL, 'dsa', '2024-04-14 19:41:02', 'Registro de Compra', 0, '100001', '1', '2024-04-14 19:41:02', 'BOLETA', 'DSADSASD', 'sin-fotografia.png', '2024-01-20', NULL, '2024-04-14 19:41:02', '1', '1713141662.4925', '10.00', NULL, NULL, '0.00', '0.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orden_compra_detalle`
--

CREATE TABLE `orden_compra_detalle` (
  `id_detalle_compra` bigint UNSIGNED NOT NULL,
  `id_orden_compra` bigint UNSIGNED NOT NULL,
  `id_pro` bigint UNSIGNED NOT NULL,
  `detalle_orden_nombre_producto` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle_compra_cantidad` double(8,2) NOT NULL,
  `detalle_compra_cantidad_recibida` double(8,2) DEFAULT NULL,
  `detalle_compra_precio_compra` decimal(10,2) NOT NULL,
  `detalle_compra_total_pedido` decimal(10,2) NOT NULL,
  `detalle_compra_tipo_moneda` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle_compra_tipo_cambio` decimal(10,5) DEFAULT NULL,
  `detalle_compra_total_dolares` decimal(10,2) DEFAULT NULL,
  `detalle_compra_total_pagado` decimal(10,2) DEFAULT NULL,
  `detalle_compra_estado` tinyint NOT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `flete` decimal(10,2) DEFAULT NULL,
  `gasto` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orden_compra_detalle`
--

INSERT INTO `orden_compra_detalle` (`id_detalle_compra`, `id_orden_compra`, `id_pro`, `detalle_orden_nombre_producto`, `detalle_compra_cantidad`, `detalle_compra_cantidad_recibida`, `detalle_compra_precio_compra`, `detalle_compra_total_pedido`, `detalle_compra_tipo_moneda`, `detalle_compra_tipo_cambio`, `detalle_compra_total_dolares`, `detalle_compra_total_pagado`, `detalle_compra_estado`, `peso`, `flete`, `gasto`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Lentes con elastico-Perro ', 2.00, 2.00, '5.00', '10.00', NULL, NULL, NULL, '10.00', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(269, NULL, NULL, 65, 'listar_iconos', 'web', 1, 3, 65, '2023-12-30 15:07:38', '2023-12-30 15:07:38'),
(270, 13, NULL, NULL, 'Gestion', 'web', 1, 1, 13, '2024-01-14 16:30:15', '2024-01-14 16:30:15'),
(271, NULL, 49, NULL, 'proveedores', 'web', 1, 2, 49, '2024-01-14 16:30:37', '2024-01-14 16:30:37'),
(272, NULL, NULL, 66, 'gestion_de_proveedores', 'web', 1, 3, 66, '2024-01-14 16:31:23', '2024-01-14 16:33:30'),
(273, NULL, NULL, 67, 'reporte_de_proveedores', 'web', 1, 3, 67, '2024-01-14 16:32:03', '2024-01-14 16:33:38'),
(274, NULL, 50, NULL, 'familias', 'web', 1, 2, 50, '2024-01-14 16:34:43', '2024-01-14 18:30:15'),
(275, NULL, NULL, 68, 'gestion_de_familias', 'web', 1, 3, 68, '2024-01-14 16:36:32', '2024-01-14 19:24:08'),
(276, NULL, NULL, NULL, 'guardar_proveedor', 'web', 1, 4, 66, '2024-01-14 17:51:27', '2024-01-14 17:51:27'),
(277, NULL, NULL, NULL, 'listar_datos_proveedor', 'web', 1, 4, 66, '2024-01-14 18:01:03', '2024-01-14 18:01:03'),
(278, NULL, NULL, NULL, 'proveedores_excel', 'web', 1, 4, 66, '2024-01-14 18:15:40', '2024-01-14 18:15:40'),
(279, NULL, NULL, NULL, 'guardar_familia', 'web', 1, 4, 68, '2024-01-14 19:26:52', '2024-01-14 19:26:52'),
(280, NULL, 51, NULL, 'categoria', 'web', 1, 2, 51, '2024-01-15 00:50:16', '2024-01-15 00:50:16'),
(281, NULL, NULL, 69, 'gestion_de_categorias', 'web', 1, 3, 69, '2024-01-15 00:51:43', '2024-01-15 00:51:43'),
(282, NULL, NULL, NULL, 'guardar_categoria', 'web', 1, 4, 69, '2024-01-15 01:17:37', '2024-01-15 01:17:37'),
(283, 14, NULL, NULL, 'logistica', 'web', 1, 1, 14, '2024-01-15 01:45:19', '2024-01-15 01:45:19'),
(284, NULL, 52, NULL, 'gestionar_productos', 'web', 1, 2, 52, '2024-01-15 01:45:46', '2024-01-15 02:10:03'),
(285, NULL, 53, NULL, 'compras', 'web', 1, 2, 53, '2024-01-15 01:46:03', '2024-01-15 01:46:03'),
(286, NULL, NULL, 70, 'gestionar_almacen', 'web', 1, 3, 70, '2024-01-15 01:46:30', '2024-01-15 01:46:30'),
(287, NULL, NULL, 71, 'productos', 'web', 1, 3, 71, '2024-01-15 01:46:59', '2024-01-15 01:46:59'),
(288, NULL, NULL, 72, 'registro_de_compra', 'web', 1, 3, 72, '2024-01-15 01:48:42', '2024-01-15 01:48:42'),
(289, NULL, NULL, 73, 'historial_de_compras', 'web', 1, 3, 73, '2024-01-15 01:49:05', '2024-01-15 01:49:05'),
(290, NULL, NULL, NULL, 'guardar_producto', 'web', 1, 4, 71, '2024-01-21 01:29:42', '2024-01-21 01:29:42'),
(291, NULL, NULL, NULL, 'listar_datos_productos', 'web', 1, 4, 71, '2024-01-21 01:43:56', '2024-01-21 01:43:56'),
(292, NULL, NULL, NULL, 'buscador_productos', 'web', 1, 4, 72, '2024-01-21 02:52:47', '2024-01-21 02:52:47'),
(293, NULL, NULL, NULL, 'crear_orden_compra', 'web', 1, 4, 72, '2024-01-25 03:19:08', '2024-01-25 03:19:08'),
(294, NULL, NULL, NULL, 'historial_orden_compra', 'web', 1, 4, 73, '2024-01-28 16:32:40', '2024-01-28 16:32:40'),
(295, NULL, 54, NULL, 'ordenCompraDetalle', 'web', 1, 2, 54, '2024-01-28 16:51:40', '2024-01-28 16:51:40'),
(296, NULL, NULL, 74, 'gestion_orden_compra', 'web', 1, 3, 74, '2024-01-28 16:52:44', '2024-01-28 16:52:44'),
(297, NULL, NULL, NULL, 'compras_pdf', 'web', 1, 4, 73, '2024-02-01 03:53:47', '2024-02-01 03:53:47'),
(298, 15, NULL, NULL, 'Gestionventas', 'web', 1, 1, 15, '2024-02-02 03:17:44', '2024-02-02 03:17:44'),
(299, NULL, 55, NULL, 'movimientos', 'web', 1, 2, 55, '2024-02-02 03:18:12', '2024-02-02 03:18:12'),
(300, NULL, NULL, 75, 'movimientos_de_productos', 'web', 1, 3, 75, '2024-02-02 03:19:03', '2024-02-02 03:19:03'),
(301, NULL, 56, NULL, 'realizar_ventas', 'web', 1, 2, 56, '2024-02-02 03:20:55', '2024-02-02 03:20:55'),
(302, NULL, NULL, 76, 'gestion_de_ventas', 'web', 1, 3, 76, '2024-02-02 03:21:32', '2024-02-02 03:21:32'),
(303, NULL, NULL, NULL, 'orden_compra_historial_excel', 'web', 1, 4, 73, '2024-02-04 22:23:39', '2024-02-04 22:23:39'),
(304, NULL, NULL, NULL, 'buscar_movimientos_productos', 'web', 1, 4, 75, '2024-02-04 23:08:51', '2024-02-04 23:08:51'),
(305, NULL, NULL, NULL, 'buscar_productos', 'web', 1, 4, 75, '2024-02-04 23:19:16', '2024-02-04 23:19:16'),
(306, NULL, NULL, NULL, 'realizar_movimientos', 'web', 1, 4, 75, '2024-02-07 01:55:04', '2024-02-07 01:55:04'),
(307, NULL, NULL, NULL, 'detalle_movimientos_productos', 'web', 1, 4, 75, '2024-02-07 02:22:09', '2024-02-07 02:22:09'),
(308, NULL, NULL, NULL, 'consultar_serie', 'web', 1, 4, 76, '2024-02-09 02:51:14', '2024-02-09 02:51:14'),
(309, NULL, NULL, NULL, 'generar_venta', 'web', 1, 4, 76, '2024-02-11 17:09:37', '2024-02-11 17:09:37'),
(310, NULL, 57, NULL, 'venta_detalle', 'web', 1, 2, 57, '2024-02-14 13:38:04', '2024-02-14 13:38:04'),
(311, NULL, NULL, 77, 'informacion_de_la_venta', 'web', 1, 3, 77, '2024-02-14 13:39:04', '2024-02-14 13:39:04'),
(312, NULL, NULL, NULL, 'imprimir_ticket_pdf', 'web', 1, 4, 77, '2024-02-15 03:42:05', '2024-02-15 03:42:05'),
(313, NULL, NULL, NULL, 'imprimir_ticketera_venta', 'web', 1, 4, 77, '2024-02-15 03:42:09', '2024-02-15 03:42:09'),
(314, NULL, NULL, NULL, 'enviarComprobanteporCorreo', 'web', 1, 4, 77, '2024-02-15 04:01:45', '2024-02-15 04:01:45'),
(315, 16, NULL, NULL, 'facturacion', 'web', 1, 1, 16, '2024-02-16 01:22:22', '2024-02-16 01:22:22'),
(316, NULL, 58, NULL, 'pendiente_declarar', 'web', 1, 2, 58, '2024-02-16 01:23:12', '2024-02-16 01:23:12'),
(317, NULL, 59, NULL, 'historial_envios', 'web', 1, 2, 59, '2024-02-16 01:23:40', '2024-02-16 01:23:40'),
(318, NULL, 60, NULL, 'detalle_resumen', 'web', 1, 2, 60, '2024-02-16 01:24:46', '2024-02-16 01:24:46'),
(319, NULL, 61, NULL, 'generar_nota', 'web', 1, 2, 61, '2024-02-16 01:24:57', '2024-02-16 01:24:57'),
(320, NULL, NULL, 78, 'gestionar_pendientes_declarar', 'web', 1, 3, 78, '2024-02-16 01:25:16', '2024-02-16 01:25:16'),
(321, NULL, NULL, 79, 'resumen_diario_new', 'web', 1, 3, 79, '2024-02-16 01:25:44', '2024-02-16 01:25:44'),
(322, NULL, NULL, NULL, 'crear_xml_enviar_sunat', 'web', 1, 4, 78, '2024-02-16 01:26:00', '2024-02-16 01:26:00'),
(323, NULL, NULL, NULL, 'anular_boleta_cambiarestado', 'web', 1, 4, 78, '2024-02-16 01:26:06', '2024-02-16 01:26:06'),
(324, NULL, NULL, NULL, 'cambiarestado_enviado', 'web', 1, 4, 78, '2024-02-16 01:26:14', '2024-02-16 01:26:14'),
(325, NULL, NULL, NULL, 'crear_enviar_resumen_sunat', 'web', 1, 4, 79, '2024-02-16 01:26:31', '2024-02-16 01:26:31'),
(326, NULL, NULL, 80, 'gestionar_historial_ventas_sunat', 'web', 1, 3, 80, '2024-02-16 01:28:58', '2024-02-16 01:28:58'),
(327, NULL, NULL, 81, 'gestionar_historial_resumen_diario', 'web', 1, 3, 81, '2024-02-16 01:29:11', '2024-02-16 01:29:11'),
(328, NULL, NULL, 82, 'gestionar_historial_bajas_de_facturas', 'web', 1, 3, 82, '2024-02-16 01:29:26', '2024-02-16 01:29:26'),
(329, NULL, NULL, NULL, 'consultar_ticket_resumen', 'web', 1, 4, 81, '2024-02-16 01:29:43', '2024-02-16 01:29:43'),
(330, NULL, NULL, 83, 'informacion_de_resumen', 'web', 1, 3, 83, '2024-02-16 03:18:40', '2024-02-16 03:18:40'),
(331, 17, NULL, NULL, 'reporte', 'web', 1, 1, 17, '2024-02-18 11:01:21', '2024-02-18 11:01:21'),
(332, NULL, 62, NULL, 'ventas_por_caja', 'web', 1, 2, 62, '2024-02-18 11:03:55', '2024-02-18 11:03:55'),
(333, NULL, 63, NULL, 'reporte_de_productos', 'web', 1, 2, 63, '2024-02-18 11:04:32', '2024-02-18 11:04:32'),
(334, NULL, 64, NULL, 'reporte_de_ventas', 'web', 1, 2, 64, '2024-02-18 11:05:57', '2024-02-18 11:05:57'),
(335, NULL, NULL, 84, 'reporte_de_caja', 'web', 1, 3, 84, '2024-02-18 11:06:52', '2024-02-18 11:06:52'),
(336, NULL, NULL, 85, 'reporte_por_productos', 'web', 1, 3, 85, '2024-02-18 11:14:51', '2024-02-18 11:14:51'),
(337, NULL, NULL, 86, 'reporte_ventas', 'web', 1, 3, 86, '2024-02-18 11:23:40', '2024-02-18 11:23:40'),
(338, NULL, NULL, 87, 'generar_nota_', 'web', 1, 3, 87, '2024-02-18 11:48:48', '2024-02-18 11:48:48'),
(339, NULL, NULL, NULL, 'tipo_nota_descripcion', 'web', 1, 4, 87, '2024-02-18 12:14:17', '2024-02-18 12:14:17'),
(342, NULL, NULL, NULL, 'generar_nota_re', 'web', 1, 4, 87, '2024-02-18 13:44:43', '2024-02-18 13:44:43'),
(343, NULL, 65, NULL, 'proveedores_reporte', 'web', 1, 2, 65, '2024-02-21 03:23:27', '2024-02-21 03:23:27'),
(344, NULL, NULL, 88, 'proveedores__reporte', 'web', 1, 3, 88, '2024-02-21 03:36:45', '2024-02-21 03:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `id_persona` bigint UNSIGNED NOT NULL,
  `id_empresa` bigint UNSIGNED NOT NULL,
  `persona_nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_apellido_paterno` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_apellido_materno` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_tipo_documento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_dni` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_nacionalidad` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_estado_civil` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_direccion` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_discapacidad` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_job` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_nacimiento` date DEFAULT NULL,
  `persona_sexo` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_telefono` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_telefono_2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_hijos` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_departamento` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_provincia` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_distrito` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_adicional` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_afp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_cuspp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_afiliac` date DEFAULT NULL,
  `persona_blacklist` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_number_account` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_bank_alt` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_number_account_alt` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_bank_cts` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_account_cts` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_cv` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_empleado` tinyint DEFAULT NULL,
  `person_codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`id_persona`, `id_empresa`, `persona_nombre`, `persona_apellido_paterno`, `persona_apellido_materno`, `persona_email`, `persona_tipo_documento`, `persona_dni`, `persona_nacionalidad`, `persona_estado_civil`, `persona_direccion`, `persona_discapacidad`, `persona_job`, `persona_nacimiento`, `persona_sexo`, `persona_telefono`, `persona_telefono_2`, `persona_foto`, `persona_hijos`, `persona_departamento`, `persona_provincia`, `persona_distrito`, `persona_adicional`, `persona_afp`, `persona_cuspp`, `persona_afiliac`, `persona_blacklist`, `persona_bank`, `persona_number_account`, `persona_bank_alt`, `persona_number_account_alt`, `persona_bank_cts`, `persona_account_cts`, `persona_cv`, `persona_empleado`, `person_codigo`, `persona_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Eder Alfredo', 'Apagueño', 'Reyna', 'reynaalfredo421@gmail.com', '2', '74077975', NULL, NULL, NULL, NULL, NULL, '2004-02-21', NULL, '956449198', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5465468498484948das', 1, NULL, '2023-11-15 17:16:10'),
(4, 1, 'KAREN PAMELA', 'DAVILA', 'TALEXIO', 'karenpamela@emyspets.com', '2', '46701256', NULL, NULL, NULL, NULL, NULL, '2000-02-21', NULL, '902675298', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '1708829172.3808', 1, '2024-02-25 02:46:12', '2024-02-25 02:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_pro` bigint UNSIGNED NOT NULL,
  `id_ca` bigint UNSIGNED NOT NULL,
  `id_medida` bigint UNSIGNED NOT NULL,
  `id_tipo_afectacion` bigint UNSIGNED NOT NULL,
  `pro_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_presentacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_medida` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_precio_valor` decimal(10,2) DEFAULT NULL,
  `pro_precio_uni` decimal(10,2) DEFAULT NULL,
  `pro_precio_valor_ma` decimal(10,2) DEFAULT NULL,
  `pro_precio_uni_ma` decimal(10,2) DEFAULT NULL,
  `pro_porcen_igv` decimal(10,2) NOT NULL,
  `pro_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_stock` int DEFAULT NULL,
  `pro_estado` tinyint DEFAULT NULL,
  `impuesto_bolsa` tinyint DEFAULT NULL COMMENT '0 no es bolsa 1 es bolsa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_pro`, `id_ca`, `id_medida`, `id_tipo_afectacion`, `pro_nombre`, `pro_codigo`, `pro_descripcion`, `pro_presentacion`, `pro_medida`, `pro_precio_valor`, `pro_precio_uni`, `pro_precio_valor_ma`, `pro_precio_uni_ma`, `pro_porcen_igv`, `pro_foto`, `pro_stock`, `pro_estado`, `impuesto_bolsa`, `created_at`, `updated_at`) VALUES
(1, 1, 58, 1, 'Lentes con elastico-Perro ', '8,76966E+11', '', '17 cm aprox ', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 2, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(2, 1, 58, 1, 'Lentes para gato 8 cm', '8,76966E+11', '', '8 cm aprox ', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 0, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(3, 1, 58, 1, 'Lentes para gato 11 cm', '8,76966E+11', '', '11 cm aprox ', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 6, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(4, 1, 58, 1, 'Pollo toy Chico', '8,76966E+11', '', 'Chico', '', '1.69', '2.00', '0.85', '1.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(5, 1, 58, 1, 'Pollo toy  Mediano', '8,76966E+11', '', 'Mediano', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(6, 1, 58, 1, 'Pollo a la brasa Mediano', '8,76966E+11', '', 'Mediano', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(7, 1, 58, 1, 'Pollo a la brasa Grande', '8,76966E+11', '', 'Grande', '', '3.39', '4.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(8, 1, 58, 1, 'Muslo de pollo toy', 'J7104', NULL, NULL, NULL, '1.69', '2.00', '1.13', '1.33', '1.18', '', 0, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(9, 1, 58, 1, 'Hueso Mancuerna Chico', 'J7103', '', 'Chico', '', '1.69', '2.00', '0.85', '1.00', '1.18', '', 0, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(10, 1, 58, 1, 'Hueso Mancuerna  Mediano', 'J3025', '', 'Mediano', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 8, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(11, 1, 58, 1, 'Hueso color natural huellita ', '8,76966E+11', '', '', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(12, 1, 58, 1, 'Pelota toy erizo Grande', ' J3071', '', 'Grande', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(13, 1, 58, 1, 'Juguete soga c/pelota tenis JF1004 ', '8,76966E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 6, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(14, 1, 58, 1, 'Juguete soga c/pelota tenis F1005', '8,76966E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 6, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(15, 1, 58, 1, 'Juguete soga c/pelota tenis JF1011', '8,76966E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 6, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(16, 1, 58, 1, 'Juguete soga c/pelota tenis JF1012', '8,76966E+11', '', '', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 6, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(17, 1, 58, 1, 'Pelota dura c/soga solo rojo ', '8,76966E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 8, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(18, 1, 58, 1, 'Ancla de jebe c/soga ', '8,76966E+11', '', '', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(19, 1, 58, 1, 'Pelota de caucho Chico', '8,76966E+11', '', 'Chico', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(20, 1, 58, 1, 'Pelota de caucho Mediano', '8,76966E+11', '', 'Mediano', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(21, 1, 58, 1, 'Pelota de caucho Grande', '8,76966E+11', '', 'Grande', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(22, 1, 58, 1, 'Pelota de caucho con puas Chico', '8,76966E+11', '', 'Chico', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(23, 1, 58, 1, 'Pelota de caucho con puas Mediano', '8,76966E+11', '', 'Mediano', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(24, 1, 58, 1, 'Pelota de caucho con puas Grande', '8,76966E+11', '', 'Grande', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(25, 1, 58, 1, 'Pelota lumininosa ', '8,76966E+11', '', '', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(26, 1, 58, 1, 'Pelota de goma solida  indestructible Chico', '8,76966E+11', '', 'Chico', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(27, 1, 58, 1, 'Pelota de goma solida  indestructible Mediano', '8,76966E+11', '', 'Mediano', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(28, 1, 58, 1, 'Pelota de goma solida  indestructible Grande', '8,76966E+11', '', 'Grande', '', '9.32', '11.00', '9.32', '11.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(29, 1, 58, 1, 'Aro de jebe c/puas ', '8,76966E+11', '', 'chico 10 cm ', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(30, 1, 58, 1, 'Hueso de jebe c/soga 40 cm aprox ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(31, 1, 58, 1, 'Aro con puas c/soga ', '8,76966E+11', '', '23 cm aprox ', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(32, 1, 58, 1, 'Estrella de jebe c/soga ', '8,76966E+11', '', '22 cm * 8 cm aprox ', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(33, 1, 58, 1, 'Dona de jebe c/soga ', '8,76966E+11', '', '22 cm * 8 cm aprox ', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(34, 1, 58, 1, 'Hueso jebe c/cascabel ', '8,76966E+11', '', '15 cm ', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(35, 1, 58, 1, 'Hueso de jebe chillon', '8,76966E+11', '', '13 cm ', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(36, 1, 58, 1, 'Pelota huella de jebe ', '8,76966E+11', '', '6.5 cm ', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(37, 1, 58, 1, 'Juguete ovalada de jebe ', '8,76966E+11', '', 'XSC-083', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(38, 1, 58, 1, 'Pelota ovalada de jebe ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(39, 1, 58, 1, 'Helado con sonido ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(41, 2, 58, 1, 'Pescado con Catnip ', '8,76966E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(42, 2, 58, 1, 'Bola de Catnip tortuga ', '8,76966E+11', '', '', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(43, 2, 58, 1, 'Bola de Catnip ', '8,76966E+11', '', '', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(44, 2, 58, 1, 'Pelota trenzada Chico', '8,76966E+11', '', 'Chico', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(45, 2, 58, 1, 'Pelota trenzada Mediano', '8,76966E+11', '', 'Mediano', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(46, 2, 58, 1, 'Pelota trenzada Grande', '8,76966E+11', '', 'Grande', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(47, 2, 58, 1, 'Varita Brillo ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(48, 2, 58, 1, 'Varita de Gato 1 ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(49, 2, 58, 1, 'Varita de Gato 2 ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(50, 2, 58, 1, 'Cilindro ara?ador Chico', '8,76966E+11', '', 'Chico', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(51, 2, 58, 1, 'Cilindro ara?ador Grande', '8,76966E+11', '', 'Grande', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(52, 2, 58, 1, 'Poste ara?ador Chico', '8,76966E+11', '', 'Chico', '', '17.80', '21.00', '17.80', '21.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(53, 2, 58, 1, 'Poste ara?ador Grande', '8,76966E+11', '', 'Grande', '', '25.42', '30.00', '25.42', '30.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(54, 2, 58, 1, 'Perlas Neutralizador de olor Limon', '8,76966E+11', '', 'Limon', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(55, 2, 58, 1, 'Perlas Neutralizador de olor Jazmin', '8,76966E+11', '', 'Jazmin ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(56, 2, 58, 1, 'Perlas Neutralizador de olor Manzana', '8,76966E+11', '', 'Manzana ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(57, 2, 58, 1, 'Perlas Neutralizador de olor Rosa', '8,76966E+11', '', 'Rosa ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(58, 2, 58, 1, 'Perlas Neutralizador de olor Carbon', '8,76966E+11', '', 'Carbon ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(59, 2, 58, 1, 'Ara?ador doble asiento ', '8,76966E+11', '', '', '', '66.10', '78.00', '66.10', '78.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(60, 2, 58, 1, 'Ara?ador doble asiento dona Chico', '8,76966E+11', '', 'Chico ', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(61, 2, 58, 1, 'Ara?ador doble asiento dona Grande', '8,76966E+11', '', 'Grande ', '', '46.61', '55.00', '46.61', '55.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(62, 2, 58, 1, 'Ara?ador asiento Chico', '8,76966E+11', '', 'Chico ', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(63, 2, 58, 1, 'Ara?ador asiento Grande', '8,76966E+11', '', 'Grande ', '', '45.76', '54.00', '45.76', '54.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(64, 2, 58, 1, 'Ara?ador asiento doble pompon Chico', '8,76966E+11', '', 'Chico ', '', '21.19', '25.00', '21.19', '25.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(65, 2, 58, 1, 'Ara?ador asiento doble pompon Grande', '8,76966E+11', '', 'Grande ', '', '28.81', '34.00', '28.81', '34.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(66, 2, 58, 1, 'Ara?ador cueva con asiento ara?ador ', '8,76966E+11', '', '', '', '72.88', '86.00', '72.88', '86.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(67, 2, 58, 1, 'Ara?ador Cajon ', '8,76966E+11', '', '', '', '74.58', '88.00', '74.58', '88.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(68, 2, 58, 1, 'Ara?ador cubo esquinero ', '8,76966E+11', '', '', '', '96.61', '114.00', '96.61', '114.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(69, 2, 58, 1, 'Ara?ador cilindro con asiento ', '8,76966E+11', '', '', '', '79.66', '94.00', '79.66', '94.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(70, 2, 58, 1, 'Ara?ador cubo cn asiento ', '8,76966E+11', '', '', '', '94.92', '112.00', '94.92', '112.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(71, 2, 58, 1, 'Ara?ador piramide 3 piso ', '8,76966E+11', '', '', '', '83.05', '98.00', '83.05', '98.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(72, 2, 58, 1, 'Rascador Carton 1 ', '8,76966E+11', '', '', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(73, 2, 58, 1, 'Rascador Carton 2', '8,76966E+11', '', '', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(74, 2, 58, 1, 'Juguete interactivo para gato ', '8,76966E+11', '', '', '', '9.32', '11.00', '9.32', '11.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(75, 2, 58, 1, 'Torre de gato ', '8,76966E+11', '', '', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(76, 2, 58, 1, 'Juguete interactivo para gato con plumas ', '8,76966E+11', '', '', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(77, 2, 58, 1, 'Rodillo quita pelusa+ repuesto ', '8,76966E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(78, 2, 58, 1, 'Catnip en frasco ', '8,76966E+11', '', '', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(79, 2, 58, 1, 'Recogedor cat ', '8,76966E+11', '', '', '', '1.69', '2.00', '0.85', '1.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(80, 2, 58, 1, 'Recogedor con dise?o ', '8,76966E+11', '', '', '', '1.69', '2.00', '0.85', '1.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(81, 2, 58, 1, 'Bandeja economica ', '8,76966E+11', '', '', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(82, 2, 58, 1, 'Bandeja economica con tapa ', '8,76966E+11', '', '', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(83, 2, 58, 1, 'Arenero de gato carrito ', '8,76966E+11', '', '', '', '19.49', '23.00', '19.49', '23.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(84, 2, 58, 1, 'Arenero cerrado gatito + recogedor ', '8,76966E+11', '', '', '', '38.14', '45.00', '38.14', '45.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(85, 3, 58, 1, 'Plato de acero colores 22 cm ', '8,76966E+11', '', '', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(86, 3, 58, 1, 'Plato de acero colores 26 cm ', '8,76966E+11', '', '', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(87, 3, 58, 1, 'Plato de acero colores 30 cm ', '8,76966E+11', '', '', '', '9.32', '11.00', '9.32', '11.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(88, 3, 58, 1, 'Bebedero portatil 3 en 1 nunbel ', '8,76966E+11', '', '', '', '13.56', '16.00', '13.56', '16.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(89, 3, 58, 1, 'Plato garra I DOG ', '8,76966E+11', '', '', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(90, 3, 58, 1, 'Plato division garrita ', '8,76966E+11', '', '', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(91, 3, 58, 1, 'Plato doble Chico', '8,76966E+11', '', 'Chico', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(92, 3, 58, 1, 'Plato doble Grande', '8,76966E+11', '', 'Grande', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(93, 3, 58, 1, 'Plato doble anti hormiga ', '8,76966E+11', '', '', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(94, 3, 58, 1, 'Plato rompecabeza ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(95, 3, 58, 1, 'Plato division', '8,76966E+11', '', '', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(96, 3, 58, 1, 'Plato hueso Chico', '8,76966E+11', '', 'Chico', '', '0.85', '1.00', '0.85', '1.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(97, 3, 58, 1, 'Plato corazon ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(98, 3, 58, 1, 'Plato doble pescado ', '8,76966E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(99, 3, 58, 1, 'Plato pelota de futbol gigante ', '8,76966E+11', '', '', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(100, 3, 58, 1, 'Plato estampado Chico', '8,76966E+11', '', 'Chico', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(101, 3, 58, 1, 'Biberon paquete x 12 unid Chico ', '8,76966E+11', '', 'Chico', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(102, 3, 58, 1, 'Biberon paquete x 12 unid Mediano', '8,76966E+11', '', 'Mediano', '', '21.19', '25.00', '21.19', '25.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(103, 3, 58, 1, 'Biberon paquete x 12 unid Grande', '8,76966E+11', '', 'Grande', '', '25.42', '30.00', '25.42', '30.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(104, 3, 58, 1, 'Plato portatil doble ', '8,76966E+11', '', '', '', '13.56', '16.00', '13.56', '16.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(105, 3, 58, 1, 'Plato bambu ', '8,76966E+11', '', '', '', '13.56', '16.00', '13.56', '16.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(106, 3, 58, 1, 'Plato + comedero modelo llave ', '8,76966E+11', '', '', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(107, 3, 58, 1, 'Fuente de agua electrica huellita ', '8,76966E+11', '', '', '', '27.12', '32.00', '27.12', '32.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(108, 3, 58, 1, 'Fuente de agua electrica ', '8,76966E+11', '', '', '', '33.90', '40.00', '33.90', '40.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(109, 3, 58, 1, 'Fuente cuadrado ', '8,76966E+11', '', '', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(110, 3, 58, 1, 'Comedero automatico perro y gato ', '8,76966E+11', '', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(111, 3, 58, 1, 'Bebedero y comedero osito  comedero ', '8,76966E+11', '', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(112, 3, 58, 1, 'Bebedero y comedero osito  Bebedero  ', '8,76966E+11', '', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(113, 3, 58, 1, 'Bebedero y comedero gatito ', '8,76966E+11', '', '', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(114, 3, 58, 1, 'Bebedero y comedero color pastel ', '8,76966E+11', '', '', '', '21.19', '25.00', '21.19', '25.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(115, 3, 58, 1, 'Plato doble gato c/bebedero ', '8,76966E+11', '', '', '', '11.86', '14.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '2024-03-30 04:00:00', '2024-03-30 04:00:00'),
(116, 4, 58, 1, 'Spray amigo dorado + doypay 150 ml ', '8,77E+11', '', '400 ml ', '', '12.71', '15.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(117, 4, 58, 1, 'Spray amigo dorado', '8,77E+11', '', '130 ml ', '', '7.63', '9.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 4, 58, 1, 'Spray K-nino + doypack 150 ml -Duo', '8,77E+11', '', '400 ml ', '', '12.71', '15.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 4, 58, 1, 'Spray K-nino + doypack 150 ml - fresh ', '8,77E+11', '', '400 ml ', '', '12.71', '15.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 4, 58, 1, 'Shampoo amigo c/oferta + doypack ', '8,77E+11', '', '220 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 4, 58, 1, 'Shampoo amigo maximo ', '8,77E+11', '', '300 ml ', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 4, 58, 1, 'Shampoo amigo cachorro ', '8,77E+11', '', '300 ml ', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 4, 58, 1, 'Shampoo Sarnican ', '8,77E+11', '', '300 ml ', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 4, 58, 1, 'Shampoo sachet de 30 ml x 25 unid  Amigo Maximo', '8,77E+11', '', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 4, 58, 1, 'Shampoo sachet de 30 ml x 25 unid Sarnican ', '8,77E+11', '', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 4, 58, 1, 'Shampoo sachet de 30 ml x 25 unid Knino', '8,77E+11', '', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 4, 58, 1, 'Shampoo doypack 150 ml caja x 12 display Amigo maximo ', '8,77E+11', '', '', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 4, 58, 1, 'Shampoo doypack 150 ml caja x 12 display  Sarnican', '8,77E+11', '', '', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 4, 58, 1, 'Shampoo doypack 150 ml caja x 12 display K-nino Duo', '8,77E+11', '', '', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(130, 4, 58, 1, 'Spray practican 300 ml + frasco de talco 100 gr ', '8,77E+11', '', '300 ml ', '', '11.86', '14.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 4, 58, 1, 'Spray practican 300 ml + frasco de shampoo  300 ml', '8,77E+11', '', '300 ml ', '', '13.56', '16.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 4, 58, 1, 'Spray practican cachorro ', '8,77E+11', '', '275 ml ', '', '11.02', '13.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 4, 58, 1, 'Spray  rapidex 250 ml ', '8,77E+11', '', '250 ml ', '', '8.47', '10.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 4, 58, 1, 'Spray  rapidex 500 ml ', '8,77E+11', '', '500 ml ', '', '12.71', '15.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 4, 58, 1, 'Spray efectivon  300 ml + frasco de talco 100 gr ', '8,77E+11', '', '300 ml ', '', '11.86', '14.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 4, 58, 1, 'Spray efectivon 300 ml + frasco de shampoo  300 ml', '8,77E+11', '', '300 ml ', '', '13.56', '16.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 4, 58, 1, 'Shampoo  Sebox ', '8,77E+11', '', '300 ml ', '', '9.32', '11.00', '9.32', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 4, 58, 1, 'Shampoo Derma ', '8,77E+11', '', '300 ml ', '', '9.32', '11.00', '9.32', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 4, 58, 1, 'Shampoo Sanol Preventi ', '8,77E+11', '', '300 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 4, 58, 1, 'Spray copito 30 ml ', '8,77E+11', '', '30 ml ', '', '3.39', '4.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 4, 58, 1, 'Spray copito 60 ml', '8,77E+11', '', '60 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 4, 58, 1, 'Spray copito 120 ml', '8,77E+11', '', '120 ml ', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 4, 58, 1, 'Spray copito 400 ml ', '8,77E+11', '', '400 ml ', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 4, 58, 1, 'Colonia Copito -Koketa ', '8,77E+11', '', '60 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 4, 58, 1, 'Colonia Copito -Romantico ', '8,77E+11', '', '60 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 4, 58, 1, 'Colonia Copito -Seductor ', '8,77E+11', '', '60 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 4, 58, 1, 'Colonia Copito -Baby ', '8,77E+11', '', '60 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 4, 58, 1, 'Shampoo en sachet premiun dog caja de 30 ml x 25 unid', '8,77E+11', 'Piel Sencible ', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 4, 58, 1, 'Shampoo dokys caja de 30 ml x 50 unid Antipulga', '8,77E+11', 'Antipulga ', '', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 4, 58, 1, 'Shampoo dokys frasco de 250 ml  Antipulga', '8,77E+11', 'Antipulga ', '', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 4, 58, 1, 'Shampoo dokys frasco de 400 ml  Antipulga', '8,77E+11', 'Antipulga ', '', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 4, 58, 1, 'Shampoo dokys frasco de 1 Lt Antipulga', '8,77E+11', 'Antipulga ', '', '', '16.95', '20.00', '16.95', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 4, 58, 1, 'Shampoo dokys Galon de 4 Lt Antipulga', '8,77E+11', 'Antipulga ', '', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 4, 58, 1, 'Shampoo dokys caja de 30 ml x 50 unid Aloe', '8,77E+11', 'Aloe ', '', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 4, 58, 1, 'Shampoo dokys frasco de 250 ml  Aloe', '8,77E+11', 'Aloe ', '', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 4, 58, 1, 'Shampoo dokys frasco de 400 ml  Aloe', '8,77E+11', 'Aloe ', '', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 4, 58, 1, 'Shampoo dokys frasco de 1 Lt Aloe', '8,77E+11', 'Aloe ', '', '', '16.95', '20.00', '16.95', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 4, 58, 1, 'Shampoo dokys Galon de 4 Lt Aloe', '8,77E+11', 'Aloe ', '', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 4, 58, 1, 'Matanox caja x 2 frascos de 10 ml ', '8,77E+11', '', '', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(160, 4, 58, 1, 'Matanox ', '8,77E+11', '', '100 ml ', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 4, 58, 1, 'Atomil 180 gr Clasico', '8,77E+11', 'clasico ', '', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 4, 58, 1, 'Atomil 180 gr Perfumado', '8,77E+11', 'Perfumado ', '', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 4, 58, 1, 'Atomil 24 sachet x 50 gr ', '8,77E+11', 'Sachet ', '', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 4, 58, 1, 'Shampoo Medicado 300 ml  Clorhexidina + Clotrimazol ', '8,77E+11', 'Clorhexidina + Clotrimazol ', '', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 4, 58, 1, 'Shampoo Medicado 20 sachet x 50 ml Clorhexidina + Clotrimazol ', '8,77E+11', 'Clorhexidina + Clotrimazol ', '', '', '36.44', '43.00', '36.44', '43.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 4, 58, 1, 'Shampoo vetlinex 20 sachet x 50 ml ', '8,77E+11', 'Pulgoso ', '', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 4, 58, 1, 'Acondicionador  vetlinex 20 sachet x 50 ml ', '8,77E+11', 'Acondicionador ', '', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 4, 58, 1, 'Shampoo vetlinex 20 sachet x 50 ml ', '8,77E+11', 'Vetlinex medicado ', '', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 4, 58, 1, 'Shampoo vetlinex 300 ml Dermasan ', '8,77E+11', 'Dermasan ', '', '', '14.41', '17.00', '14.41', '17.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 4, 58, 1, 'Shampoov hartz de 532 ml Avena ', '8,77E+11', 'Avena ', '', '', '18.64', '22.00', '18.64', '22.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 4, 58, 1, 'Tydy shampoo seco perfumado perro y gato ', '8,77E+11', '', '100 ml ', '', '12.71', '15.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 4, 58, 1, 'Shampoo my doggy hipoalerg?nico  250 ml ', '8,77E+11', '', '250 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 4, 58, 1, 'Shampoo my doggy hipoalerg?nico  Tira x 12 sachet ', '8,77E+11', '', 'Tira x 12 sachet ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 4, 58, 1, 'Shampoo my doggy hipoalerg?nico  Caja x 25 sachet ', '8,77E+11', '', 'Caja x 25 sachet ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 4, 58, 1, 'Shampoo my doggy dermatologico 250 ml ', '8,77E+11', '', '250 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(176, 4, 58, 1, 'Shampoo my doggy dermatologico Tira x 12 sachet ', '8,77E+11', '', 'Tira x 12 sachet ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 4, 58, 1, 'Shampoo my doggy dermatologico Caja x 25 sachet ', '8,77E+11', '', 'Caja x 25 sachet ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 4, 58, 1, 'Shampoo my doggy pelo blanco y claro dermatol?gico  250 ml ', '8,77E+11', '', '250 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 4, 58, 1, 'Shampoo my doggy pelo blanco y claro dermatol?gico Tira x 12 sachet', '8,77E+11', '', 'Tira x 12 sachet ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 4, 58, 1, 'Shampoo my doggy pelo blanco y claro dermatol?gico  Caja x 25 sachet ', '8,77E+11', '', 'Caja x 25 sachet ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 4, 58, 1, 'Shampoo my doggy para gato  300 ml ', '8,77E+11', '', '300 ml ', '', '9.32', '11.00', '9.32', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 4, 58, 1, 'Shampoo my doggy para gato  Tira x 12 sachet ', '8,77E+11', '', 'Tira x 12 sachet ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 4, 58, 1, 'Shampoo my doggy para gato  Caja x 25 sachet ', '8,77E+11', '', 'Caja x 25 sachet ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 4, 58, 1, 'Shampoo my doggy cachorro Tira x 12 sachet ', '8,77E+11', '', 'Tira x 12 sachet ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 4, 58, 1, 'Shampoo my doggy cachorro 250 ml', '8,77E+11', '', '250 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 4, 58, 1, 'Shampoo my doggy fresa Tira x 12 sachet', '8,77E+11', '', 'Tira x 12 sachet ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 4, 58, 1, 'Shampoo my doggy fresa 250 ml ', '8,77E+11', '', '250 ml ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 4, 58, 1, 'Ba?o seco en espuma my doggy 250 ml  Manzana ', '8,77E+11', '', 'Manzana ', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 4, 58, 1, 'Baño seco en espuma my doggy 250 ml Bebé', '8,77E+11', '', 'Bebé ', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 4, 58, 1, 'Baño seco en espuma my doggy 250 ml Frambuesa ', '8,77E+11', '', 'Frambuesa ', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 4, 58, 1, 'Colonia  my doggy 120 ml Bebé ', '8,77E+11', '', 'Bebé ', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 4, 58, 1, 'Colonia  my doggy 120 ml Fresa ', '8,77E+11', '', 'Fresa ', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 4, 58, 1, 'Neutralizador de olor 100 ml ', '8,77E+11', '', '100 ml ', '', '7.63', '9.00', '7.63', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 4, 58, 1, 'Control de olores 100 ml Frambuesa ', '8,77E+11', '', 'Frambuesa ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 4, 58, 1, 'Control de olores 100 ml Manzana ', '8,77E+11', '', 'Manzana ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 4, 58, 1, 'Control de olores 100 ml Bebé ', '8,77E+11', '', 'Bebé ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 4, 58, 1, 'Bin Ladino 10 ml ', '8,77E+11', '', '10 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 4, 58, 1, 'Bin Ladino 20 ml', '8,77E+11', '', '20 ml', '', '6.78', '8.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 4, 58, 1, 'Pega mosca en plato Pqte x 12 unid ', '8,77E+11', '', 'Pqte x 12 unid ', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(200, 4, 58, 1, 'Pega mosca en plato Pqte x 50 unid ', '8,77E+11', '', 'Pqte x 50 unid ', '', '38.98', '46.00', '38.98', '46.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 4, 58, 1, 'Pega mosca en plato Pqte x 100 unid ', '8,77E+11', '', 'Pqte x 100 unid ', '', '76.27', '90.00', '76.27', '90.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 4, 58, 1, 'Chica verano pulguisida ', '8,77E+11', '', '50 sobres x 20 gr ', '', '46.61', '55.00', '46.61', '55.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 4, 58, 1, 'Trome pellets raticida Caja x 40 sobres x 15 gr ', '8,77E+11', '', 'Caja x 40 sobres x 15 gr ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(204, 4, 58, 1, 'Trome pellets raticida Caja x 50 sobres x 30 gr ', '8,77E+11', '', 'Caja x 50 sobres x 30 gr ', '', '67.80', '80.00', '67.80', '80.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 4, 58, 1, 'Trome cebo raticida Caja x 50 sobres x 20 gr ', '8,77E+11', '', 'Caja x 50 sobres x 20 gr ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 4, 58, 1, 'Trome cebo raticida Caja x 50 sobres x 20 gr ', '8,77E+11', '', 'Caja x 50 sobres x 20 gr ', '', '67.80', '80.00', '67.80', '80.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 4, 58, 1, 'El Zorro Pellets raticida 2 en 1 Caja x 40 sobres x 15 gr ', '8,77E+11', '', 'Caja x 40 sobres x 15 gr ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(208, 4, 58, 1, 'El Zorro Pellets raticida 2 en 2 Caja x 50 sobres x 30 gr ', '8,77E+11', '', 'Caja x 50 sobres x 30 gr ', '', '67.80', '80.00', '67.80', '80.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 4, 58, 1, 'El zorro cebo raticida 2 en 1 Caja x 50 sobres x 20 gr ', '8,77E+11', '', 'Caja x 50 sobres x 20 gr ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 4, 58, 1, 'El zorro cebo raticida 2 en 2 Caja x 50 sobres x 40 gr ', '8,77E+11', '', 'Caja x 50 sobres x 40 gr ', '', '67.80', '80.00', '67.80', '80.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 4, 58, 1, 'Rey Pulgon -Cama Perfumado -polvo seco ', '8,77E+11', '', 'Caja x 50 sobres x 20 gr ', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 4, 58, 1, 'Estrella - Game ', '8,77E+11', '', 'Caja x 50 sobres x 20 gr ', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 4, 58, 1, 'Spray peluchin lay 30 ml ', '8,77E+11', '', '30 ml ', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 4, 58, 1, 'Spray peluchin lay 60 ml ', '8,77E+11', '', '60 ml ', '', '3.39', '4.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 4, 58, 1, 'Spray peluchin lay 120 ml ', '8,77E+11', '', '120 ml ', '', '5.08', '6.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 4, 58, 1, 'Gotero peluchin lay 10 ml ', '8,77E+11', '', '10 ml ', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 4, 58, 1, 'Gotero peluchin lay 60 ml ', '8,77E+11', '', '60 ml ', '', '3.39', '4.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 4, 58, 1, 'Gotero peluchin lay 120 ml ', '8,77E+11', '', '120 ml ', '', '5.08', '6.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 4, 58, 1, 'Spray peluchin lay 1 Gl x 4 Lt ', '8,77E+11', '', '1 Gl x 4 Lt ', '', '110.17', '130.00', '110.17', '130.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(220, 4, 58, 1, 'Churre cura herida Gotero 10 ml ', '8,77E+11', '', 'Gotero 10 ml ', '', '2.54', '3.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 4, 58, 1, 'Churre cura herida Gotero 20 ml ', '8,77E+11', '', 'Gotero 20 ml ', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 4, 58, 1, 'Churre cura herida Spray 30 ml ', '8,77E+11', '', 'Spray 30 ml ', '', '4.24', '5.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 4, 58, 1, 'Churre cura herida Spray 60 ml ', '8,77E+11', '', 'Spray 60 ml ', '', '5.08', '6.00', '4.24', '5.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 4, 58, 1, 'Churre cura herida Spray 120 ml ', '8,77E+11', '', 'Spray 120 ml ', '', '6.78', '8.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 4, 58, 1, 'Churre cura herida Pasta 50 ml ', '8,77E+11', '', 'Pasta 50 ml ', '', '5.93', '7.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 4, 58, 1, 'Fiproplus gotero ', '8,77E+11', '', '1 - 10 kg', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 4, 58, 1, 'Fiproplus gotero ', '8,77E+11', '', '11 - 25 kg ', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 4, 58, 1, 'Fiproplus gotero ', '8,77E+11', '', '26 - 45 kg ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(229, 4, 58, 1, 'Spray fiproplus ', '8,77E+11', '', 'spray 110 ml ', '', '11.86', '14.00', '11.86', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(230, 4, 58, 1, 'Spray fiproplus ', '8,77E+11', '', '250 ml ', '', '17.80', '21.00', '17.80', '21.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 4, 58, 1, 'Spray fiproplus ', '8,77E+11', '', 'Galonera 3.8 lt ', '', '94.92', '112.00', '94.92', '112.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 5, 58, 1, 'Leche lacteo caja x 50 unid x 12g  Felino', '8,77E+11', '', 'Felino ', '', '38.98', '46.00', '38.98', '46.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 5, 58, 1, 'Leche lacteo caja x 50 unid x 12g Canino', '8,77E+11', '', 'Canino ', '', '38.98', '46.00', '38.98', '46.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 5, 58, 1, 'Leche lacteo 150 gr Felino ', '8,77E+11', '', 'Felino ', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 5, 58, 1, 'Leche lacteo 150 gr Canino', '8,77E+11', '', 'Canino', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(236, 5, 58, 1, 'Leche 400 gr Sustile ', '8,77E+11', '', 'Sustile ', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 5, 58, 1, 'Leche lacto Vit 120 gr Cat ', '8,77E+11', '', 'Cat ', '', '12.71', '15.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(238, 5, 58, 1, 'Leche lacto Vit 120 gr Dog ', '8,77E+11', '', 'Dog ', '', '12.71', '15.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(239, 5, 58, 1, 'Leche Milk dog 120 gr ', '8,77E+11', '', '', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(240, 5, 58, 1, 'Leche Milk cat 120 gr ', '8,77E+11', '', '', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(241, 5, 58, 1, 'Hueso carnipet x 1 kg ', '8,77E+11', '', '', '', '25.42', '30.00', '25.42', '30.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(242, 5, 58, 1, 'Carnaza salchicha 1/2 kg Natural ', '8,77E+11', '', 'Natural ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(243, 5, 58, 1, 'Carnaza salchicha 1/2 kg tocino ', '8,77E+11', '', 'tocino ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(244, 5, 58, 1, 'Carnaza salchicha 1/2 kg - individual Natural ', '8,77E+11', '', 'Natural ', '', '15.25', '18.00', '15.25', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(245, 5, 58, 1, 'Carnaza piernita  1/2 kg ', '8,77E+11', '', '1/2 kg ', '', '16.10', '19.00', '16.10', '19.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(246, 5, 58, 1, 'Canbo Cordero adulto raza Med y Grande x 15 kg Morado ', '8,77E+11', '', 'Morado ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, 5, 58, 1, 'Canbo Cordero cachorro raza Med y Grande x 15 kg Celeste ', '8,77E+11', '', 'Celeste ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(248, 5, 58, 1, 'Canbo Cordero cachorro raza pequeño x 1 kg Verde ', '8,77E+11', '', 'Verde ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(249, 5, 58, 1, 'Canbo Cordero cachorro raza pequeño x 7 kg Verde ', '8,77E+11', '', 'Verde ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(250, 5, 58, 1, 'Canbo Cordero adulto raza pequeño x 7 kg Naranja ', '8,77E+11', '', 'Naranja ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 5, 58, 1, 'Canbo Gato x 7 kg Urinary ', '8,77E+11', '', 'Urinary ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(252, 5, 58, 1, 'Canbo Gato x 7 kg Sterilized ', '8,77E+11', '', 'Sterilized ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(253, 5, 58, 1, 'Canbo Gato x 7 kg Initial Developmet ', '8,77E+11', '', 'Initial Developmet ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(254, 5, 58, 1, 'Heno de Alfalfa 80 gr ', '8,77E+11', '', '80 gr ', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(255, 5, 58, 1, 'Heno de Alfalfa 1/2 kg ', '8,77E+11', '', '1/2 kg ', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 5, 58, 1, 'Heno de Alfalfa 5 kg ', '8,77E+11', '', '5 kg ', '', '84.75', '100.00', '84.75', '100.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(257, 5, 58, 1, 'Snack Zanahoria 100 gr ', '8,77E+11', '', '100 gr ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(258, 5, 58, 1, 'Viruta para hamster 200 gr', '8,77E+11', NULL, '200 gr', NULL, '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(259, 5, 58, 1, 'Viruta para hamster 5 kg ', '8,77E+11', '', '5 kg ', '', '0.00', '0.00', '0.00', '0.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(260, 5, 58, 1, 'Viruta para hamster 8 kg ', '8,77E+11', '', '8 kg ', '', '16.95', '20.00', '16.95', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(261, 5, 58, 1, 'Comida para hamster 250 gr ', '8,77E+11', '', '250 gr ', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(262, 5, 58, 1, 'Rueda para hamster Chico', '8,77E+11', '', 'Chico', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(263, 5, 58, 1, 'Rueda para hamster Grande ', '8,77E+11', '', 'Grande ', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(264, 5, 58, 1, 'Rueda acrílica para hamster ', '8,77E+11', '', '', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(265, 5, 58, 1, 'Jaula de hamsther castillo', '8,77E+11', '', '', '', '27.12', '32.00', '27.12', '32.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(266, 5, 58, 1, 'Jaula de hamster c/diseño -carita ', '8,77E+11', '', '', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(267, 5, 58, 1, 'jaula de hamster c/diseño -rueda-bebedero ', '8,77E+11', '', '', '', '19.49', '23.00', '19.49', '23.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(268, 5, 58, 1, 'Bañera para pajaritos ', '8,77E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(269, 5, 58, 1, 'Comedero para pajaritos ', '8,77E+11', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(270, 5, 58, 1, 'Nido para pajarito ', '8,77E+11', '', '', '', '1.69', '2.00', '1.69', '2.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(271, 5, 58, 1, 'Bebedero para pajaritos ', '8,77E+11', '', '', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(272, 5, 58, 1, 'Comida de pescado importado ', '8,77E+11', '', '', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(273, 5, 58, 1, 'Comida para tortuga tira x 50 unid (5 gr)', '8,77E+11', '', '', '', '21.19', '25.00', '21.19', '25.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `productos` (`id_pro`, `id_ca`, `id_medida`, `id_tipo_afectacion`, `pro_nombre`, `pro_codigo`, `pro_descripcion`, `pro_presentacion`, `pro_medida`, `pro_precio_valor`, `pro_precio_uni`, `pro_precio_valor_ma`, `pro_precio_uni_ma`, `pro_porcen_igv`, `pro_foto`, `pro_stock`, `pro_estado`, `impuesto_bolsa`, `created_at`, `updated_at`) VALUES
(274, 5, 58, 1, 'Transportador de tela ', '8,77E+11', '', 'T-S ', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(275, 5, 58, 1, 'Transportador de tela ', '8,77E+11', '', 'T-M ', '', '12.71', '15.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(276, 5, 58, 1, 'Transportador de tela ', '8,77E+11', '', 'T-L C/Tapa ', '', '16.95', '20.00', '16.95', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(277, 5, 58, 1, 'Transportador importado con diseño ', '8,77E+11', '', 'T-M ', '', '17.80', '21.00', '17.80', '21.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(278, 5, 58, 1, 'Transportador importado con diseño ', '8,77E+11', '', 'T-L C/Tapa ', '', '18.64', '22.00', '18.64', '22.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(279, 5, 58, 1, 'Mochila transportador de tela ', '8,77E+11', '', '', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(280, 5, 58, 1, 'Mochila transparente C/Capsula ', '8,77E+11', '', '', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(281, 5, 58, 1, 'Capsula con diseño ', '8,77E+11', '', '', '', '31.36', '37.00', '31.36', '37.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(282, 5, 58, 1, 'Mochila transparente ', '8,77E+11', '', '', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(283, 5, 58, 1, 'Bariquenel economico ', '8,77E+11', '', 'L-50', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(284, 5, 58, 1, 'Bariquenel economico ', '8,77E+11', '', 'L-60', '', '45.76', '54.00', '45.76', '54.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(285, 6, 58, 1, 'plancha placa x 12 unid  fosforecente ', '8,77E+11', '', '', '', '15.25', '18.00', '0.00', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(286, 6, 58, 1, 'Collar especial T-S', '8,77E+11', '', 'T-S', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(287, 6, 58, 1, 'Collar especial T-M', '8,77E+11', '', 'T-M', '', '11.86', '14.00', '0.00', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(288, 6, 58, 1, 'Collar especial T-L', '8,77E+11', '', 'T-L', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(289, 6, 58, 1, 'Collar especial T-XL', '8,77E+11', '', 'T-XL', '', '14.41', '17.00', '0.00', '17.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(290, 6, 58, 1, 'Collar con puas T-S', '8,78E+11', '', 'T-S', '', '11.02', '13.00', '0.00', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(291, 6, 58, 1, 'Collar con puas T-M', '8,78E+11', '', 'T-M', '', '11.86', '14.00', '0.00', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(292, 6, 58, 1, 'Collar con puas T-L', '8,78E+11', '', 'T-L', '', '13.56', '16.00', '0.00', '16.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(293, 6, 58, 1, 'Collar con puas T-XL ', '8,78E+11', '', 'T-XL ', '', '14.41', '17.00', '0.00', '17.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(294, 6, 58, 1, 'Pechera de cuero T-1', '8,78E+11', '', 'T-1', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(295, 6, 58, 1, 'Pechera de cuero T-2', '8,78E+11', '', 'T-2', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(296, 6, 58, 1, 'Pechera de cuero T-3', '8,78E+11', '', 'T-3', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(297, 6, 58, 1, 'Pechera de cuero T-4', '8,78E+11', '', 'T-4', '', '9.32', '11.00', '0.00', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(298, 6, 58, 1, 'Pechera de cuero T-5', '8,78E+11', '', 'T-5', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(299, 6, 58, 1, 'Pechera de cuero T-6', '8,78E+11', '', 'T-6', '', '11.86', '14.00', '0.00', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(300, 6, 58, 1, 'Pechera de cuero T-7', '8,79E+11', '', 'T-7', '', '13.56', '16.00', '0.00', '16.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(301, 6, 58, 1, 'Tiro de cadena importado 2 mm ', '8,79E+11', '', '2 mm ', '', '2.54', '3.00', '0.00', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(302, 6, 58, 1, 'Tiro de cadena importado 3 mm', '8,79E+11', '', '3 mm', '', '3.39', '4.00', '0.00', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(303, 6, 58, 1, 'Tiro de cadena importado 4 mm', '8,79E+11', '', '4 mm', '', '5.08', '6.00', '0.00', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(304, 6, 58, 1, 'Soga de nylon 1.20 mt Mini ', '8,79E+11', '', 'Mini ', '', '2.54', '3.00', '0.00', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(305, 6, 58, 1, 'Soga de nylon 1.20 mt Delgado', '8,79E+11', '', 'Delgado', '', '4.24', '5.00', '0.00', '5.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(306, 6, 58, 1, 'Soga de nylon 1.20 mt Grueso ', '8,79E+11', '', 'Grueso ', '', '5.93', '7.00', '0.00', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(307, 6, 58, 1, 'Soga de nylon 2.00 mt Delgado', '8,79E+11', '', 'Delgado', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(308, 6, 58, 1, 'Soga de nylon 2.00 mt Grueso ', '8,79E+11', '', 'Grueso ', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(309, 6, 58, 1, 'Tiro de nylon + collar ahorque Grueso ', '8,79E+11', '', 'Grueso ', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(310, 6, 58, 1, 'Tiro de nylon + collar ahorque Delgado', '8,80E+11', '', 'Delgado', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(311, 6, 58, 1, 'Collar ahorque sin tiro ', '8,80E+11', '', '', '', '5.93', '7.00', '0.00', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(312, 6, 58, 1, 'Tiro de soga + cadena ahorque ', '8,80E+11', '', '', '', '9.32', '11.00', '0.00', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(313, 6, 58, 1, 'Tiro de cadena soldada Grueso ', '8,80E+11', '', 'Grueso ', '', '11.02', '13.00', '0.00', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(314, 6, 58, 1, 'Tiro de cadena soldada Delgado ', '8,80E+11', '', 'Delgado ', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(315, 6, 58, 1, 'Plancha de collar nylon x 12 unid Perrito ', '8,80E+11', '', 'Perrito ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(316, 6, 58, 1, 'Plancha de collar nylon x 12 unid Michi ', '8,80E+11', '', 'Michi ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(317, 6, 58, 1, 'Plancha de collar nylon x 12 unid Huella-Hueso ', '8,80E+11', '', 'Huella-Hueso ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(318, 6, 58, 1, 'Plancha de collar nylon x 12 unid Pescadito ', '8,80E+11', '', 'Pescadito ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(319, 6, 58, 1, 'Plancha de collar nylon x 12 unid Puntos ', '8,80E+11', '', 'Puntos ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(320, 6, 58, 1, 'Plancha de collar nylon x 12 unid Camuflado ', '8,81E+11', '', 'Camuflado ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(321, 6, 58, 1, 'Plancha de collar nylon x 12 unid Huella', '8,81E+11', '', 'Huella', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(322, 6, 58, 1, 'Plancha de collar nylon x 12 unid Osito ', '8,81E+11', '', 'Osito ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(323, 6, 58, 1, 'Plancha de collar nylon x 12 unid Reflectivo ', '8,81E+11', '', 'Reflectivo ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(324, 6, 58, 1, 'Collar luminoso x 4 unid Gatito', '8,81E+11', '', 'Gatito', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(325, 6, 58, 1, 'Collar luminoso x 4 unid Perrito ', '8,81E+11', '', 'Perrito ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(326, 6, 58, 1, 'Arnes gatito', '8,81E+11', '', '', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(327, 6, 58, 1, 'Arnes con alitas T-XS ', '8,81E+11', '', 'T-XS ', '', '4.24', '5.00', '0.00', '5.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(328, 6, 58, 1, 'Arnes con alitas T-M ', '8,81E+11', '', 'T-M ', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(329, 6, 58, 1, 'Vestido con pechera + tiro T-S', '8,81E+11', '', 'T-S', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(330, 6, 58, 1, 'Vestido con pechera + tiro T-M ', '8,82E+11', '', 'T-M ', '', '11.86', '14.00', '0.00', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(331, 6, 58, 1, 'Pechera + tiro T-S ', '8,82E+11', '', 'T-S ', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(332, 6, 58, 1, 'Pechera + tiro T-M', '8,82E+11', '', 'T-M', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(333, 6, 58, 1, 'Pechera + tiro T-L', '8,82E+11', '', 'T-L', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(334, 6, 58, 1, 'Collar de cadena + placa ', '8,82E+11', '', '', '', '5.08', '6.00', '0.00', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(335, 6, 58, 1, 'Plancha de arnes escoces X 12 Unid T-S ', '8,82E+11', '', 'T-S ', '', '35.59', '42.00', '0.00', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(336, 6, 58, 1, 'Arnes con peluche T-S ', '8,82E+11', '', 'T-S ', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(337, 6, 58, 1, 'Tiro trensado + ahorque T-L ', '8,82E+11', '', 'T-L ', '', '11.86', '14.00', '0.00', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(338, 6, 58, 1, 'Arnes Rayas negras con tiro 1 T-L ', '8,82E+11', '', 'T-L ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(339, 6, 58, 1, 'Arnes Rayas negras con tiro 2 T-L ', '8,82E+11', '', 'T-L ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(340, 6, 58, 1, 'Arnes color entero c/reflectivo T-M ', '8,83E+11', '', 'T-M ', '', '11.02', '13.00', '0.00', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(341, 6, 58, 1, 'Arnes de lona T-L ', '8,83E+11', '', 'T-L ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(342, 6, 58, 1, 'Arnes de lona T-XL ', '8,83E+11', '', 'T-XL ', '', '15.25', '18.00', '0.00', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(343, 6, 58, 1, 'Arnes jaspeado KM 2235 T-L ', '8,83E+11', '', 'T-L ', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(344, 6, 58, 1, 'Arnes jaspeado T-M ', '8,83E+11', '', 'T-M ', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(345, 6, 58, 1, 'Arnes brillo T-M ', '8,83E+11', '', 'T-M ', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(346, 6, 58, 1, 'Arnes brillo T-L', '8,83E+11', '', 'T-L', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(347, 6, 58, 1, 'Arnes brillo gancho bombero T-S', '8,83E+11', '', 'T-S', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(348, 6, 58, 1, 'Arnes brillo gancho bombero T-M', '8,83E+11', '', 'T-M', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(349, 6, 58, 1, 'Arnes brillo gancho bombero T-L', '8,83E+11', '', 'T-L', '', '15.25', '18.00', '0.00', '18.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(350, 6, 58, 1, 'Police K9 T-S ', '8,84E+11', '', 'T-S ', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(351, 6, 58, 1, 'Police K9 T-M ', '8,84E+11', '', 'T-M ', '', '11.86', '14.00', '0.00', '14.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(352, 6, 58, 1, 'Police K9 T-L', '8,84E+11', '', 'T-L', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(353, 6, 58, 1, 'Police K9 T-XL ', '8,84E+11', '', 'T-XL ', '', '14.41', '17.00', '0.00', '17.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(354, 6, 58, 1, 'Medias paquete (S,M,L) X 12 Unid tallas surtido  T-XL ', '8,84E+11', '', 'T-XL', '', '2.54', '3.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(355, 6, 58, 1, 'Medias TXL', '8,84E+11', '', 'TXL', '', '3.39', '4.00', '2.54', '3.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(356, 6, 58, 1, 'Set de bozal de plastico x 7 unid ', '8,84E+11', '', '', '', '23.73', '28.00', '0.00', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(357, 6, 58, 1, 'Bozal de cuero T-1', '8,84E+11', '', 'T-1', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(358, 6, 58, 1, 'Bozal de cuero T-2', '8,84E+11', '', 'T-2', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(359, 6, 58, 1, 'Bozal de cuero T-3', '8,84E+11', '', 'T-3', '', '9.32', '11.00', '0.00', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(360, 6, 58, 1, 'Bozal de cuero regulable T-1', '8,85E+11', '', 'T-1', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(361, 6, 58, 1, 'Bozal de cuero regulable T-2', '8,85E+11', '', 'T-2', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(362, 6, 58, 1, 'Bozal de cuero regulable T-3', '8,85E+11', '', 'T-3', '', '9.32', '11.00', '0.00', '11.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(363, 6, 58, 1, 'Bozal de cuero regulable Pitbull', '8,85E+11', '', 'Pitbull', '', '17.80', '21.00', '0.00', '21.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(364, 6, 58, 1, 'Bozal de metal Rottweiler', '8,85E+11', '', 'Rottweiler', '', '17.80', '21.00', '0.00', '21.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(365, 6, 58, 1, 'Bozal de metal Pastor', '8,85E+11', '', 'Pastor', '', '17.80', '21.00', '0.00', '21.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(366, 6, 58, 1, 'Bozal de metal Kocker', '8,85E+11', '', 'Kocker', '', '16.10', '19.00', '0.00', '19.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(367, 6, 58, 1, 'Hociquera de cuero T-1', '8,85E+11', '', 'T-1', '', '6.78', '8.00', '0.00', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(368, 6, 58, 1, 'Hociquera de cuero T-2', '8,85E+11', '', 'T-2', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(369, 6, 58, 1, 'Hociquera de cuero T-3', '8,85E+11', '', 'T-3', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(370, 6, 58, 1, 'Hociquera de nylon  T-0', '8,86E+11', '', 'T-0', '', '3.39', '4.00', '0.00', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(371, 6, 58, 1, 'Hociquera de nylon T-1', '8,86E+11', '', 'T-1', '', '3.39', '4.00', '0.00', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(372, 6, 58, 1, 'Hociquera de nylon T-2', '8,86E+11', '', 'T-2', '', '4.24', '5.00', '0.00', '5.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(373, 6, 58, 1, 'Hociquera de nylon T-3', '8,86E+11', '', 'T-3', '', '5.08', '6.00', '0.00', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(374, 6, 58, 1, 'Hociquera de nylon T-4', '8,86E+11', '', 'T-4', '', '5.93', '7.00', '0.00', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(375, 6, 58, 1, 'Hociquera de nylon T-5', '8,86E+11', '', 'T-5', '', '7.63', '9.00', '0.00', '9.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(376, 6, 58, 1, 'Hociquera de nylon T-6', '8,86E+11', '', 'T-6', '', '8.47', '10.00', '0.00', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(377, 6, 58, 1, 'Collar isabelino T-S ', '8,86E+11', '', 'T-S ', '', '11.02', '13.00', '0.00', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(378, 6, 58, 1, 'Collar isabelino T-M', '8,86E+11', '', 'T-M', '', '12.71', '15.00', '0.00', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(379, 6, 58, 1, 'Collar isabelino T-L', '8,86E+11', '', 'T-L', '', '13.56', '16.00', '0.00', '16.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(380, 6, 58, 1, 'Collar isabelino T-XL ', '8,87E+11', '', 'T-XL ', '', '16.95', '20.00', '0.00', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(381, 6, 58, 1, 'Collar isabelino T-XXL ', '8,87E+11', '', 'T-XXL ', '', '20.34', '24.00', '0.00', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(382, 6, 58, 1, 'Retractil dog Leash -5 mt ', '8,87E+11', '', 'R7004', '', '10.17', '12.00', '0.00', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(383, 7, 58, 1, 'Cama en tela T-0', '8,88E+11', '', 'T-0', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(384, 7, 58, 1, 'Cama en tela T-1', '8,89E+11', '', 'T-1', '', '14.41', '17.00', '14.41', '17.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(385, 7, 58, 1, 'Cama en tela T-2', '8,90E+11', '', 'T-2', '', '19.49', '23.00', '19.49', '23.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(386, 7, 58, 1, 'Cama en tela T-3', '8,91E+11', '', 'T-3', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(387, 7, 58, 1, 'Cama en tela T-4', '8,92E+11', '', 'T-4', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(388, 7, 58, 1, 'Cama en tela T-5', '8,93E+11', '', 'T-5', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(389, 7, 58, 1, 'Cama polar T-0', '8,94E+11', '', 'T-0', '', '11.02', '13.00', '11.02', '13.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(390, 7, 58, 1, 'Cama polar T-1', '8,95E+11', '', 'T-1', '', '14.41', '17.00', '14.41', '17.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(391, 7, 58, 1, 'Cama polar T-2', '8,96E+11', '', 'T-2', '', '19.49', '23.00', '19.49', '23.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(392, 7, 58, 1, 'Cama polar T-3', '8,97E+11', '', 'T-3', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(393, 7, 58, 1, 'Cama polar T-4', '8,98E+11', '', 'T-4', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(394, 7, 58, 1, 'Cama polar T-5', '8,99E+11', '', 'T-5', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(395, 7, 58, 1, 'Cama iglu T-S ', '9,00E+11', '', 'T-S ', '', '25.42', '30.00', '25.42', '30.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(396, 7, 58, 1, 'Cama iglu T-M', '9,01E+11', '', 'T-M', '', '36.44', '43.00', '36.44', '43.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(397, 7, 58, 1, 'Cama iglu T-L', '9,02E+11', '', 'T-L', '', '50.85', '60.00', '50.85', '60.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(398, 7, 58, 1, 'Cama cueva T-XS', '9,03E+11', '', 'T-XS', '', '12.71', '15.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(399, 7, 58, 1, 'Cama cueva T-S ', '9,04E+11', '', 'T-S ', '', '18.64', '22.00', '18.64', '22.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(400, 7, 58, 1, 'Cama cueva T-M', '9,05E+11', '', 'T-M', '', '27.12', '32.00', '27.12', '32.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(401, 7, 58, 1, 'Cama cueva T-L ', '9,06E+11', '', 'T-L ', '', '39.83', '47.00', '39.83', '47.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(402, 7, 58, 1, 'Piramide con orejita T-S ', '9,07E+11', '', 'T-S ', '', '33.90', '40.00', '33.90', '40.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(403, 7, 58, 1, 'Piramide con orejita T-M', '9,08E+11', '', 'T-M', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(404, 7, 58, 1, 'Piramide con orejita T-L', '9,09E+11', '', 'T-L', '', '45.76', '54.00', '45.76', '54.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(405, 7, 58, 1, 'Cama huella T-S ', '9,10E+11', '', 'T-S ', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(406, 7, 58, 1, 'Cama huella T-M', '9,11E+11', '', 'T-M', '', '33.90', '40.00', '33.90', '40.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(407, 7, 58, 1, 'Cama huella T-L', '9,12E+11', '', 'T-L', '', '37.29', '44.00', '37.29', '44.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(408, 7, 58, 1, 'Cama huella T-XL ', '9,13E+11', '', 'T-XL ', '', '50.85', '60.00', '50.85', '60.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(409, 7, 58, 1, 'cama dona peluche T-S ', '9,14E+11', '', 'T-S ', '', '38.98', '46.00', '38.98', '46.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(410, 7, 58, 1, 'cama dona peluche T-M ', '9,15E+11', '', 'T-M ', '', '42.37', '50.00', '42.37', '50.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(411, 7, 58, 1, 'cama dona peluche T-L ', '9,16E+11', '', 'T-L ', '', '45.76', '54.00', '45.76', '54.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(412, 7, 58, 1, 'Cama dona corona T-S ', '9,17E+11', '', 'T-S ', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(413, 7, 58, 1, 'Cama dona corona T-M ', '9,18E+11', '', 'T-M ', '', '33.90', '40.00', '33.90', '40.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(414, 7, 58, 1, 'Cama dona corona T-L ', '9,19E+11', '', 'T-L ', '', '37.29', '44.00', '37.29', '44.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(415, 7, 58, 1, 'Cama dona terciopelo T-S ', '9,20E+11', '', 'T-S ', '', '27.12', '32.00', '27.12', '32.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(416, 7, 58, 1, 'Cama dona terciopelo T-M ', '9,21E+11', '', 'T-M ', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(417, 7, 58, 1, 'Cama dona terciopelo T-L ', '9,22E+11', '', 'T-L ', '', '34.75', '41.00', '34.75', '41.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(418, 7, 58, 1, 'Cama dona stitch T-S ', '9,23E+11', '', 'T-S ', '', '33.90', '40.00', '33.90', '40.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(419, 7, 58, 1, 'Cama dona stitch T-M ', '9,24E+11', '', 'T-M ', '', '37.29', '44.00', '37.29', '44.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(420, 7, 58, 1, 'Cama dona stitch T-L ', '9,25E+11', '', 'T-L ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(421, 7, 58, 1, 'Cama dona angela T-S ', '9,26E+11', '', 'T-S ', '', '33.90', '40.00', '33.90', '40.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(422, 7, 58, 1, 'Cama dona angela T-M ', '9,27E+11', '', 'T-M ', '', '37.29', '44.00', '37.29', '44.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(423, 7, 58, 1, 'Cama dona angela T-L ', '9,28E+11', '', 'T-L ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(424, 7, 58, 1, 'Cama cuadrada terciopelo T-S ', '9,29E+11', '', 'T-S ', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(425, 7, 58, 1, 'Cama cuadrada terciopelo T-M ', '9,30E+11', '', 'T-M ', '', '34.75', '41.00', '34.75', '41.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(426, 7, 58, 1, 'Cama cuadrada terciopelo T-L ', '9,31E+11', '', 'T-L ', '', '40.68', '48.00', '40.68', '48.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(427, 7, 58, 1, 'cama cuadrada especial T-M', '9,32E+11', '', 'T-M', '', '41.53', '49.00', '41.53', '49.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(428, 7, 58, 1, 'cama cuadrada especial T-L', '9,33E+11', '', 'T-L', '', '50.85', '60.00', '50.85', '60.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(429, 7, 58, 1, 'cama cuadrada especial T-XL ', '9,34E+11', '', 'T-XL ', '', '64.41', '76.00', '64.41', '76.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(430, 7, 58, 1, 'cama cuadrada especial T-XXL', '9,35E+11', '', 'T-XXL', '', '76.27', '90.00', '76.27', '90.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(431, 7, 58, 1, 'Colchoneta acolchada terciopelo T-S ', '9,36E+11', '', 'T-S ', '', '16.95', '20.00', '16.95', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(432, 7, 58, 1, 'Colchoneta acolchada terciopelo T-M ', '9,37E+11', '', 'T-M ', '', '22.88', '27.00', '22.88', '27.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(433, 7, 58, 1, 'Colchoneta acolchada terciopelo T-L ', '9,38E+11', '', 'T-L ', '', '27.97', '33.00', '27.97', '33.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(434, 7, 58, 1, 'Colchoneta acolchada terciopelo T-XL ', '9,39E+11', '', 'T-XL ', '', '39.83', '47.00', '39.83', '47.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(435, 7, 58, 1, 'Colchoneta acolchada felpa T-S ', '9,40E+11', '', 'T-S ', '', '18.64', '22.00', '18.64', '22.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(436, 7, 58, 1, 'Colchoneta acolchada felpa T-M', '9,41E+11', '', 'T-M', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(437, 7, 58, 1, 'Colchoneta acolchada felpa T-L', '9,42E+11', '', 'T-L', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(438, 7, 58, 1, 'Colchoneta acolchada felpa T-XL ', '9,43E+11', '', 'T-XL ', '', '42.37', '50.00', '42.37', '50.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(439, 7, 58, 1, 'Colchoneta acolchada tela T-S ', '9,44E+11', '', 'T-S ', '', '18.64', '22.00', '18.64', '22.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(440, 7, 58, 1, 'Colchoneta acolchada tela T-M', '9,45E+11', '', 'T-M', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(441, 7, 58, 1, 'Colchoneta acolchada tela T-L', '9,46E+11', '', 'T-L', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(442, 7, 58, 1, 'Colchoneta acolchada tela T-XL ', '9,47E+11', '', 'T-XL ', '', '42.37', '50.00', '42.37', '50.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(443, 7, 58, 1, 'Colchoneta con cierre T-0', '9,48E+11', '', 'T-0', '', '10.17', '12.00', '10.17', '12.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(444, 7, 58, 1, 'Colchoneta con cierre T-1', '9,49E+11', '', 'T-1', '', '12.71', '15.00', '12.71', '15.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(445, 7, 58, 1, 'Colchoneta con cierre T-2', '9,50E+11', '', 'T-2', '', '16.95', '20.00', '16.95', '20.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(446, 7, 58, 1, 'Colchoneta con cierre T-3', '9,51E+11', '', 'T-3', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(447, 7, 58, 1, 'Colchoneta con cierre T-4', '9,52E+11', '', 'T-4', '', '22.03', '26.00', '22.03', '26.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(448, 7, 58, 1, 'Casa con cierre Chico ', '9,53E+11', '', 'Chico ', '', '23.73', '28.00', '23.73', '28.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(449, 7, 58, 1, 'Casa con cierre Mediano ', '9,54E+11', '', 'Mediano ', '', '28.81', '34.00', '28.81', '34.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(450, 7, 58, 1, 'Casa con cierre Grande ', '9,55E+11', '', 'Grande ', '', '46.61', '55.00', '46.61', '55.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(451, 7, 58, 1, 'Sofa especial Chico ', '9,56E+11', '', 'Chico ', '', '57.63', '68.00', '57.63', '68.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(452, 7, 58, 1, 'Sofa especial Grande ', '9,57E+11', '', 'Grande ', '', '61.02', '72.00', '61.02', '72.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(483, 8, 58, 1, 'Paños húmedo amigo ', '9,88E+11', '', '', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(484, 8, 58, 1, 'Paños húmedo k-nino ', '9,89E+11', '', '', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(485, 8, 58, 1, 'Toallitas huemdas (50 unid)', '9,90E+11', '', '', '', '4.24', '5.00', '4.24', '5.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(486, 8, 58, 1, 'Toallitas huemdas (80 unid)', '9,91E+11', '', '', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(487, 8, 58, 1, 'Toallitas huemdas (100 unid)', '9,92E+11', '', '', '', '6.78', '8.00', '6.78', '8.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(488, 8, 58, 1, 'Baño con gras sintetico con bandeja Grande ', '9,93E+11', '', 'Grande ', '', '59.32', '70.00', '59.32', '70.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(489, 8, 58, 1, 'Baño con gras sintetico Chico ', '9,94E+11', '', 'Chico ', '', '21.19', '25.00', '21.19', '25.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(490, 8, 58, 1, 'Pañal de piso absorbente T-S', '9,95E+11', '', 'T-S', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(491, 8, 58, 1, 'Pañal de piso absorbente T-M', '9,96E+11', '', 'T-M', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(492, 8, 58, 1, 'Pañal de piso absorbente T-L', '9,97E+11', '', 'T-L', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(493, 8, 58, 1, 'Pañal de piso absorbente T-XL ', '9,98E+11', '', 'T-XL ', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(494, 9, 58, 1, 'Apoquel 20 tabletas 3.6 mg ', '9,99E+11', '', '3.6 mg ', '', '72.03', '85.00', '72.03', '85.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(495, 9, 58, 1, 'Apoquel 20 tabletas 5.4 mg', '1,00E+12', '', '5.4 mg', '', '88.14', '104.00', '88.14', '104.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(496, 9, 58, 1, 'Apoquel 20 tabletas 16 mg ', '1,00E+12', '', '16 mg ', '', '132.20', '156.00', '132.20', '156.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(497, 9, 58, 1, 'Aprurix 20 tabletas 3.6 mg ', '1,00E+12', '', '3.6 mg ', '', '54.24', '64.00', '54.24', '64.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(498, 9, 58, 1, 'Aprurix 20 tabletas 5.4 mg ', '1,00E+12', '', '5.4 mg ', '', '64.41', '76.00', '64.41', '76.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(499, 9, 58, 1, 'Aprurix 20 tabletas (27 kg a 29 .9 kg) 16 mg ', '1,00E+12', '', '16 mg ', '', '103.39', '122.00', '103.39', '122.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(500, 9, 58, 1, 'Paravetol clasico x 32 comprimidos Clasico ', '1,01E+12', '', 'Clasico ', '', '20.34', '24.00', '20.34', '24.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(501, 9, 58, 1, 'Paravetol plus  x 32 comprimidos ', '1,01E+12', '', 'Plus ', '', '36.44', '43.00', '36.44', '43.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(502, 9, 58, 1, 'Endal caja x 4 pastillas ', '1,01E+12', '', '', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(503, 9, 58, 1, 'Nanormen plus para gato caja x 1 pastilla ', '1,01E+12', '', '', '', '3.39', '4.00', '3.39', '4.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(504, 9, 58, 1, 'Trivermex Suspensión x 15 ml (Laboratorio zoovet)', '1,01E+12', '', '', '', '19.49', '23.00', '19.49', '23.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(505, 9, 58, 1, 'Gel desparasitante -IVERNI PLUS 3 ml ', '1,01E+12', '', '3 ml ', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(506, 9, 58, 1, 'Gel desparasitante -IVERNI PLUS 5 ml ', '1,01E+12', '', '5 ml ', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(507, 9, 58, 1, 'Gel desparasitante -IVERNI PLUS 10 ml ', '1,01E+12', '', '10 ml ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(508, 9, 58, 1, 'Oxantel gel desparasitante 2 ml', '1,01E+12', '', '2 ml', '', '5.08', '6.00', '5.08', '6.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(509, 9, 58, 1, 'Oxantel gel desparasitante 5 ml ', '1,01E+12', '', '5 ml ', '', '5.93', '7.00', '5.93', '7.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(510, 9, 58, 1, 'Oxantel gel desparasitante 10 ml ', '1,02E+12', '', '10 ml ', '', '8.47', '10.00', '8.47', '10.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(511, 9, 58, 1, 'Oxantel gel desparasitante 50 ml ', '1,02E+12', '', '50 ml ', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(512, 9, 58, 1, 'Oxantel gel desparasitante 100 tabletas ', '1,02E+12', '', '100 tabletas ', '', '44.92', '53.00', '44.92', '53.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(513, 9, 58, 1, 'Prazican -F (50 TABLETAS )', '1,02E+12', '', '', '', '29.66', '35.00', '29.66', '35.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(514, 9, 58, 1, 'Advantix pipeta perro menor 4 kg ', '1,02E+12', '', '4 kg ', '', '31.36', '37.00', '31.36', '37.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(515, 9, 58, 1, 'Advantix perro de 4 a 10 kg ', '1,02E+12', '', '4 a 10 kg ', '', '33.05', '39.00', '33.05', '39.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(516, 9, 58, 1, 'Advantix perro de 10 a 2 kg ', '1,02E+12', '', '10 a 2 kg ', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(517, 9, 58, 1, 'Advantix de 25 a mas kg ', '1,02E+12', '', '25 a mas kg ', '', '38.98', '46.00', '38.98', '46.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(518, 9, 58, 1, 'Advantix gato menores 4 kg ', '1,02E+12', '', 'menores 4 kg ', '', '27.12', '32.00', '27.12', '32.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(519, 9, 58, 1, 'Advantix gato mayores 4 kg ', '1,02E+12', '', 'mayores 4 kg ', '', '35.59', '42.00', '35.59', '42.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(520, 9, 58, 1, 'Atrevia XR Mini Para perros de 2 a 4.5 kg', '1,03E+12', '', 'Para perros de 2 a 4.5 kg', '', '62.71', '74.00', '62.71', '74.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(521, 9, 58, 1, 'Atrevia XR Small Para perros de 4.5 a 10  kg', '1,03E+12', '', 'Para perros de 4.5 a 10  kg', '', '68.64', '81.00', '68.64', '81.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(522, 9, 58, 1, 'Atrevia XR Mediun   Para perros de 10 a 20 kg', '1,03E+12', '', 'Para perros de 10 a 20 kg', '', '73.73', '87.00', '73.73', '87.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(523, 9, 58, 1, 'Atrevia XR Large Para perros de 20 a 40 kg', '1,03E+12', '', 'Para perros de 20 a 40 kg', '', '101.69', '120.00', '101.69', '120.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(524, 9, 58, 1, 'Atrevia One Mini Para perros de 2 a 4.5 kg', '1,03E+12', '', 'Para perros de 2 a 4.5 kg', '', '30.51', '36.00', '30.51', '36.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(525, 9, 58, 1, 'Atrevia One Small Para perros de 4.5 a 10  kg', '1,03E+12', '', 'Para perros de 4.5 a 10  kg', '', '32.20', '38.00', '32.20', '38.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(526, 9, 58, 1, 'Atrevia One Mediun   Para perros de 10 a 20 kg', '1,03E+12', '', 'Para perros de 10 a 20 kg', '', '38.14', '45.00', '38.14', '45.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(527, 9, 58, 1, 'Atrevia One Large Para perros de 20 a 40 kg', '1,03E+12', '', 'Para perros de 20 a 40 kg', '', '47.46', '56.00', '47.46', '56.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(528, 9, 58, 1, 'Bravecto plus gato  1.2 a 2.8 kg ', '1,03E+12', '', '1.2 a 2.8 kg ', '', '81.36', '96.00', '81.36', '96.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(529, 9, 58, 1, 'Bravecto plus gato 2.8 a 6.25 kg ', '1,03E+12', '', '2.8 a 6.25 kg ', '', '91.53', '108.00', '91.53', '108.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(530, 9, 58, 1, 'Bravecto plus gato 6.25 a 12 kg ', '1,04E+12', '', '6.25 a 12 kg ', '', '94.92', '112.00', '94.92', '112.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(531, 9, 58, 1, 'Bravecto 2 a 4.5 kg ', '1,04E+12', '', '2 a 4.5 kg ', '', '73.73', '87.00', '73.73', '87.00', '1.18', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(532, 9, 58, 1, 'Bravecto 4.5 a 10 kg ', '1,04E+12', '', '4.5 a 10 kg ', '', '0.00', '95.00', '0.00', '95.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(533, 9, 58, 1, 'Bravecto 10 a 20 kg ', '1,04E+12', '', '10 a 20 kg ', '', '0.00', '101.00', '0.00', '101.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(534, 9, 58, 1, 'Bravecto 20 a 40 kg ', '1,04E+12', '', '20 a 40 kg ', '', '0.00', '126.00', '0.00', '126.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(535, 9, 58, 1, 'Bravecto 40 a 56 kg ', '1,04E+12', '', '40 a 56 kg ', '', '0.00', '160.00', '0.00', '160.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(536, 9, 58, 1, 'Simparica trio x 3 tabletas 2.5 a 5 kg ', '1,04E+12', '', '2.5 a 5 kg ', '', '0.00', '119.00', '0.00', '119.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(537, 9, 58, 1, 'Simparica trio x 3 tabletas 5 a 10 kg ', '1,04E+12', '', '5 a 10 kg ', '', '0.00', '132.00', '0.00', '132.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(538, 9, 58, 1, 'Simparica trio x 3 tabletas 10 a 20 kg ', '1,04E+12', '', '10 a 20 kg ', '', '0.00', '154.00', '0.00', '154.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(539, 9, 58, 1, 'Simparica trio x 3 tabletas 20 a 40 kg ', '1,04E+12', '', '20 a 40 kg ', '', '0.00', '186.00', '0.00', '186.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(540, 9, 58, 1, 'Simparica clasico x 3 tabletas  2.5 a 5 kg ', '1,05E+12', '', '2.5 a 5 kg ', '', '0.00', '117.00', '0.00', '117.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(541, 9, 58, 1, 'Simparica clasico x 3 tabletas  5 a 10 kg ', '1,05E+12', '', '5 a 10 kg ', '', '0.00', '128.00', '0.00', '128.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(542, 9, 58, 1, 'Simparica clasico x 3 tabletas  10 a 20 kg ', '1,05E+12', '', '10 a 20 kg ', '', '0.00', '150.00', '0.00', '150.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(543, 9, 58, 1, 'Simparica clasico x 3 tabletas 20 a 40 kg ', '1,05E+12', '', '20 a 40 kg ', '', '0.00', '182.00', '0.00', '182.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(544, 9, 58, 1, 'Nexgard x 3 tabletas 2 a 4 kg ', '1,05E+12', '', '2 a 4 kg ', '', '0.00', '105.00', '0.00', '105.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(545, 9, 58, 1, 'Nexgard x 3 tabletas 4.1 a 10 kg ', '1,05E+12', '', '4.1 a 10 kg ', '', '0.00', '110.00', '0.00', '110.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(546, 9, 58, 1, 'Nexgard x 3 tabletas 10.1 a 25  kg ', '1,05E+12', '', '10.1 a 25  kg ', '', '0.00', '125.00', '0.00', '125.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(547, 9, 58, 1, 'Nexgard x 3 tabletas 25.1 a 50 kg ', '1,05E+12', '', '25.1 a 50 kg ', '', '0.00', '148.00', '0.00', '148.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(548, 9, 58, 1, 'Nexgard spectra x 3 tabletas 3.6 a 7.5 kg ', '1,05E+12', '', '3.6 a 7.5 kg ', '', '0.00', '115.00', '0.00', '115.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(549, 9, 58, 1, 'Nexgard spectra x 3 tabletas 7.6 a 15 kg ', '1,05E+12', '', '7.6 a 15 kg ', '', '0.00', '123.00', '0.00', '123.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(550, 9, 58, 1, 'Nexgard spectra x 3 tabletas 15.1 a 30 kg ', '1,06E+12', '', '15.1 a 30 kg ', '', '0.00', '148.00', '0.00', '148.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(551, 9, 58, 1, 'Nexgard spectra x 3 tabletas 30.1 a 60 kg ', '1,06E+12', '', '30.1 a 60 kg ', '', '0.00', '178.00', '0.00', '178.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(552, 9, 58, 1, 'Proteggo x 3 meses 2 a 4.5 kg ', '1,06E+12', '', '2 a 4.5 kg ', '', '0.00', '62.00', '0.00', '62.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(553, 9, 58, 1, 'Proteggo x 3 meses 4.5 a 10 kg ', '1,06E+12', '', '4.5 a 10 kg ', '', '0.00', '70.00', '0.00', '70.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(554, 9, 58, 1, 'Proteggo x 3 meses 10 a 20 kg ', '1,06E+12', '', '10 a 20 kg ', '', '0.00', '80.00', '0.00', '80.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(555, 9, 58, 1, 'Proteggo x 3 meses 20 a 40 kg ', '1,06E+12', '', '20 a 40 kg ', '', '0.00', '96.00', '0.00', '96.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(556, 9, 58, 1, 'Proteggo x 1 mes 2 a 4.5 kg ', '1,06E+12', '', '2 a 4.5 kg ', '', '0.00', '28.00', '0.00', '28.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(557, 9, 58, 1, 'Proteggo x 1 mes 4.5 a 10 kg ', '1,06E+12', '', '4.5 a 10 kg ', '', '0.00', '32.00', '0.00', '32.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(558, 9, 58, 1, 'Proteggo x 1 mes 10 a 20 kg ', '1,06E+12', '', '10 a 20 kg ', '', '0.00', '37.00', '0.00', '37.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(559, 9, 58, 1, 'Proteggo x 1 mes 20 a 40 kg ', '1,06E+12', '', '20 a 40 kg ', '', '0.00', '47.00', '0.00', '47.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(560, 9, 58, 1, 'Feline full spot -gato 1 a 2 kg para gatos ', '1,07E+12', '', '1 a 2 kg para gatos ', '', '0.00', '24.00', '0.00', '24.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(561, 9, 58, 1, 'Feline full spot -gato 2 a 5 kg para gatos ', '1,07E+12', '', '2 a 5 kg para gatos ', '', '0.00', '29.00', '0.00', '29.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(562, 9, 58, 1, 'Feline full spot -gato 5 a mas kg  para gatos ', '1,07E+12', '', '5 a mas kg  para gatos ', '', '0.00', '32.00', '0.00', '32.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(563, 9, 58, 1, '6% x 3 Pipetas para menos de 2.5 kg Rosado ', '1,07E+12', '', 'Rosado ', '', '0.00', '110.00', '0.00', '110.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(564, 9, 58, 1, '6% x 3 Pipetas para menos de 2.6 a 7.5 kg Azul', '1,07E+12', '', 'Azul', '', '0.00', '115.00', '0.00', '115.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(565, 9, 58, 1, '12 % x 3 Pipetas para menos de 2.6 a 5 kg Morado ', '1,07E+12', '', 'Morado ', '', '0.00', '125.00', '0.00', '125.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(566, 9, 58, 1, '12 % x 3 Pipetas para menos de 5.1 a 10  kg Café ', '1,07E+12', '', 'Café ', '', '0.00', '132.00', '0.00', '132.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(567, 9, 58, 1, '12 % x 3 Pipetas para menos de 10.1 a 20 kg Rojo', '1,07E+12', '', 'Rojo', '', '0.00', '140.00', '0.00', '140.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(568, 9, 58, 1, '12 % x 3 Pipetas para menos de 20.1 a 40  kg Verde ', '1,07E+12', '', 'Verde ', '', '0.00', '185.00', '0.00', '185.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(569, 9, 58, 1, 'Revolution plus gatos hasta 2.5 kg x 3 Pipetas  Amarillo ', '1,07E+12', '', 'Amarillo ', '', '0.00', '115.00', '0.00', '115.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(570, 9, 58, 1, 'Revolution plus gatos hasta 2.5 a 5 kg x 3 Pipetas Naranja ', '1,08E+12', '', 'Naranja ', '', '0.00', '135.00', '0.00', '135.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(571, 9, 58, 1, 'Revolution plus gatos de 5 a mas kg x 1 Pipetas Verde ', '1,08E+12', '', 'Verde ', '', '0.00', '60.00', '0.00', '60.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(572, 9, 58, 1, 'Rivolta 12 % pipeta 0.25 ml Perros de 2.6 a 5 kg', '1,08E+12', '', 'Perros de 2.6 a 5 kg', '', '0.00', '26.00', '0.00', '26.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(573, 9, 58, 1, 'Rivolta 12 % pipeta 0.50 ml Perros de 5 a 10 kg', '1,08E+12', '', 'Perros de 5 a 10 kg', '', '0.00', '30.00', '0.00', '30.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(574, 9, 58, 1, 'Rivolta 12 % pipeta 1 ml Perros de 10 a 20  kg', '1,08E+12', '', 'Perros de 10 a 20  kg', '', '0.00', '35.00', '0.00', '35.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(575, 9, 58, 1, 'Rivolta 12 % pipeta 2 ml Perros de 20 a 40  kg', '1,08E+12', '', 'Perros de 20 a 40  kg', '', '0.00', '50.00', '0.00', '50.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(576, 9, 58, 1, 'Collar antipulga seresto para mascota menos de 8 kg ', '1,08E+12', '', 'menos de 8 kg ', '', '0.00', '176.00', '0.00', '176.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(577, 9, 58, 1, 'Collar antipulga seresto para mascota mas de 8 kg ', '1,08E+12', '', 'mas de 8 kg ', '', '0.00', '192.00', '0.00', '192.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `productos` (`id_pro`, `id_ca`, `id_medida`, `id_tipo_afectacion`, `pro_nombre`, `pro_codigo`, `pro_descripcion`, `pro_presentacion`, `pro_medida`, `pro_precio_valor`, `pro_precio_uni`, `pro_precio_valor_ma`, `pro_precio_uni_ma`, `pro_porcen_igv`, `pro_foto`, `pro_stock`, `pro_estado`, `impuesto_bolsa`, `created_at`, `updated_at`) VALUES
(578, 9, 58, 1, 'Brocopet 100 ml ', '1,08E+12', '', '100 ml ', '', '0.00', '13.00', '0.00', '13.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(579, 9, 58, 1, 'Alerflan x 40 comprimidos ', '1,08E+12', '', '', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(580, 9, 58, 1, 'Bactrina x 32 comprimidos ', '1,09E+12', '', '', '', '0.00', '24.00', '0.00', '24.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(581, 9, 58, 1, 'Carprovet x 40 tabletas x 25 mg ', '1,09E+12', '', '', '', '0.00', '33.00', '0.00', '33.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(582, 9, 58, 1, 'Carprovet x 20 tabletas x 100 mg ', '1,09E+12', '', '', '', '0.00', '54.00', '0.00', '54.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(583, 9, 58, 1, 'Cefavet x 32 tabletas 300 mg ', '1,09E+12', '', '300 mg ', '', '0.00', '21.00', '0.00', '21.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(584, 9, 58, 1, 'Cefavet x 32 tabletas 600 mg ', '1,09E+12', '', '600 mg ', '', '0.00', '34.00', '0.00', '34.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(585, 9, 58, 1, 'Clamovet 250 mg x 40 pastilla ', '1,09E+12', '', '', '', '0.00', '47.00', '0.00', '47.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(586, 9, 58, 1, 'Clindavet 75 mg x 32 tabletas ', '1,09E+12', '', '', '', '0.00', '24.00', '0.00', '24.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(587, 9, 58, 1, 'Clindavet 150 mg x 32 tabletas ', '1,09E+12', '', '', '', '0.00', '39.00', '0.00', '39.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(588, 9, 58, 1, 'Cortavance x 76 ml', '1,09E+12', '', '', '', '0.00', '138.00', '0.00', '138.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(589, 9, 58, 1, 'Crema 6 A 15 gr ', '1,09E+12', '', '15 gr ', '', '0.00', '25.00', '0.00', '25.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(590, 9, 58, 1, 'Crema 6 A 30 gr ', '1,10E+12', '', '30 gr ', '', '0.00', '36.00', '0.00', '36.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(591, 9, 58, 1, 'Crema Livre 15 gr ', '1,10E+12', '', '', '', '0.00', '22.00', '0.00', '22.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(592, 9, 58, 1, 'Crema dermatologico creampet x 25 gr ', '1,10E+12', '', '', '', '0.00', '15.00', '0.00', '15.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(593, 9, 58, 1, 'Dermasep spray x 265 ml ', '1,10E+12', '', 'x 265 ml ', '', '0.00', '14.00', '0.00', '14.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(594, 9, 58, 1, 'Dermasep pack de 6 botellas x 120 ml ', '1,10E+12', '', '120 ml ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(595, 9, 58, 1, 'Crema protectora 120 gr ', '1,10E+12', '', '120 gr ', '', '0.00', '9.00', '0.00', '9.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(596, 9, 58, 1, 'Crema dermatologica acarin 30 gr ', '1,10E+12', '', '30 gr ', '', '0.00', '10.00', '0.00', '10.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(597, 9, 58, 1, 'Petco crema curativa 28 gr ', '1,10E+12', '', '28 gr ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(598, 9, 58, 1, 'Petco bálsamo hidratante 28 gr ', '1,10E+12', '', '28 gr ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(599, 9, 58, 1, 'Cicatrizante gmasu  20 ml ', '1,10E+12', '', '', '', '0.00', '4.00', '0.00', '4.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(600, 9, 58, 1, 'Venda adhesiva ', '1,11E+12', '', '', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(601, 9, 58, 1, 'Doxitel x 32 tabletas 100 mg ', '1,11E+12', '', '100 mg ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(602, 9, 58, 1, 'Doxitel x 32 tabletas 200 mg ', '1,11E+12', '', '200 mg ', '', '0.00', '27.00', '0.00', '27.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(603, 9, 58, 1, 'Doxitel Flow 10 ml ', '1,11E+12', '', '10 ml ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(604, 9, 58, 1, 'Ecader Spray x 120 ml ', '1,11E+12', '', 'Spray x 120 ml ', '', '0.00', '30.00', '0.00', '30.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(605, 9, 58, 1, 'Ecader Spray 500 ml', '1,11E+12', '', 'Spray 500 ml', '', '0.00', '52.00', '0.00', '52.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(606, 9, 58, 1, 'Ecader Crema x 60 gr ', '1,11E+12', '', 'Crema x 60 gr ', '', '0.00', '22.00', '0.00', '22.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(607, 9, 58, 1, 'Ecader Gel x 120 gr ', '1,11E+12', '', 'Gel x 120 gr ', '', '0.00', '35.00', '0.00', '35.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(608, 9, 58, 1, 'Ecader Pañitos humedos x 80 unid ', '1,11E+12', '', 'Pañitos humedos x 80 unid ', '', '0.00', '22.00', '0.00', '22.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(609, 9, 58, 1, 'Floxatel 50 mg x 40 pastillas ', '1,11E+12', '', '', '', '0.00', '16.00', '0.00', '16.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(610, 9, 58, 1, 'Floxatel 100 mg x 40 pastillas ', '1,12E+12', '', '', '', '0.00', '23.00', '0.00', '23.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(611, 9, 58, 1, 'Gastropet x 40 tabletas ', '1,12E+12', '', '', '', '0.00', '28.00', '0.00', '28.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(612, 9, 58, 1, 'Hepatiopet x 40 tabletas ', '1,12E+12', '', '', '', '0.00', '27.00', '0.00', '27.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(613, 9, 58, 1, 'Histapet x 40 tabletas ', '1,12E+12', '', '', '', '0.00', '16.00', '0.00', '16.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(614, 9, 58, 1, 'Ketovet 10 mg 40 tabletas ', '1,12E+12', '', '', '', '0.00', '26.00', '0.00', '26.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(615, 9, 58, 1, 'Ketovet 20 mg 40 tabletas ', '1,12E+12', '', '', '', '0.00', '45.00', '0.00', '45.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(616, 9, 58, 1, 'Lax natur 22 gr', '1,12E+12', '', '', '', '0.00', '14.00', '0.00', '14.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(617, 9, 58, 1, 'Meloxivet 1 mg x 40 tabletas ', '1,12E+12', '', '', '', '0.00', '15.00', '0.00', '15.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(618, 9, 58, 1, 'Meloxivet 4 mg x 40 tabletas ', '1,12E+12', '', '', '', '0.00', '35.00', '0.00', '35.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(619, 9, 58, 1, 'Micopet  x 32  tabletas ', '1,12E+12', '', '', '', '0.00', '24.00', '0.00', '24.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(620, 9, 58, 1, 'Mixantip plus forte x 15 gr ', '1,13E+12', '', '', '', '0.00', '25.00', '0.00', '25.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(621, 9, 58, 1, 'Nefrotec x 60 tabletas ', '1,13E+12', '', '', '', '0.00', '40.00', '0.00', '40.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(622, 9, 58, 1, 'Prednovet caja x 120 tabletas ', '1,13E+12', '', '', '', '0.00', '164.00', '0.00', '164.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(623, 9, 58, 1, 'Prednovet caja x 10 pastillas ', '1,13E+12', '', '', '', '0.00', '14.00', '0.00', '14.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(624, 9, 58, 1, 'Proteliv en gotas 15 ml ', '1,13E+12', '', '', '', '0.00', '46.00', '0.00', '46.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(625, 9, 58, 1, 'Rostrum x 50 mg x 10 pastillas ', '1,13E+12', '', '', '', '0.00', '8.00', '0.00', '8.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(626, 9, 58, 1, 'Rostrum x 150 mg x 10 pastillas ', '1,13E+12', '', '', '', '0.00', '14.00', '0.00', '14.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(627, 9, 58, 1, 'Trihepat x 100 ml ', '1,13E+12', '', '', '', '0.00', '56.00', '0.00', '56.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(628, 9, 58, 1, 'Ultra 7 x 11 gr ', '1,13E+12', '', '', '', '0.00', '16.00', '0.00', '16.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(629, 9, 58, 1, 'Ursovet  60 ml -Acido Ursodesoxicolico', '1,13E+12', '', '', '', '0.00', '68.00', '0.00', '68.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(630, 9, 58, 1, 'Ketofer 20 X 40 Comprimidos ', '1,14E+12', '', '', '', '0.00', '20.00', '0.00', '20.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(631, 9, 58, 1, 'Doxivet -Plus x 32 comprimidos 100 mg ', '1,14E+12', '', '100 mg ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(632, 9, 58, 1, 'Doxivet -Plus x 32 comprimidos 200 mg ', '1,14E+12', '', '200 mg ', '', '0.00', '25.00', '0.00', '25.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(633, 9, 58, 1, 'Silimavet x 32 comprimidos', '1,14E+12', '', '', '', '0.00', '25.00', '0.00', '25.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(634, 9, 58, 1, 'Prazican -F x 50 tabletas  300 mg ', '1,14E+12', '', '300 mg ', '', '0.00', '35.00', '0.00', '35.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(635, 9, 58, 1, 'Jarabe Prazican  60 ML ', '1,14E+12', '', '60 ML ', '', '0.00', '21.00', '0.00', '21.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(636, 9, 58, 1, 'Broncomox x 20 tabletas ', '1,14E+12', '', '', '', '0.00', '21.00', '0.00', '21.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(637, 9, 58, 1, 'Ivermectina 1 % 30 ml ', '1,14E+12', '', '30 ml ', '', '0.00', '12.00', '0.00', '12.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(638, 9, 58, 1, 'Jarabe Welvet  120 ml ', '1,14E+12', '', '120 ml ', '', '0.00', '26.00', '0.00', '26.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(639, 9, 58, 1, 'Jarabe diarrefin 60 ml ', '1,14E+12', '', '60 ml ', '', '0.00', '13.00', '0.00', '13.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(640, 9, 58, 1, 'Optomax - gotas oftalmica 10 ml ', '1,15E+12', '', '10 ml ', '', '0.00', '12.00', '0.00', '12.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(641, 9, 58, 1, 'Otocor -gotas oftalmica ', '1,15E+12', '', '', '', '0.00', '11.00', '0.00', '11.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(642, 9, 58, 1, 'Aurizon x 20 ml ', '1,15E+12', '', '', '', '0.00', '40.00', '0.00', '40.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(643, 9, 58, 1, 'Ciproplus gel otico x 10 ml ', '1,15E+12', '', '', '', '0.00', '30.00', '0.00', '30.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(644, 9, 58, 1, 'Ecaótic limpiador otico xb 60 ml', '1,15E+12', '', '', '', '0.00', '17.00', '0.00', '17.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(645, 9, 58, 1, 'Epiotic limpiador de oidos x 100 ml ', '1,15E+12', '', '', '', '0.00', '52.00', '0.00', '52.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(646, 9, 58, 1, 'Fripets otico jeringa x 10 g ', '1,15E+12', '', '', '', '0.00', '36.00', '0.00', '36.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(647, 9, 58, 1, 'Fripets otico limpiador x 100 ml ', '1,15E+12', '', '', '', '0.00', '36.00', '0.00', '36.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(648, 9, 58, 1, 'Usornia x 1 unid 1 ml ', '1,15E+12', '', '', '', '0.00', '58.00', '0.00', '58.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(649, 9, 58, 1, 'Otiflex C  25 ML ', '1,15E+12', '', '25 ML ', '', '0.00', '42.00', '0.00', '42.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(650, 9, 58, 1, 'Otiflex limpiador 25 ML ', '1,16E+12', '', '25 ML ', '', '0.00', '30.00', '0.00', '30.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(651, 9, 58, 1, 'Otibact gel 5 gr ', '1,16E+12', '', '5 gr ', '', '0.00', '23.00', '0.00', '23.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(652, 9, 58, 1, 'Otolog 25 ML ', '1,16E+12', '', '25 ML ', '', '0.00', '45.00', '0.00', '45.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(653, 9, 58, 1, 'Pet otic x 100 ml ', '1,16E+12', '', '100 ml ', '', '0.00', '18.00', '0.00', '18.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(654, 9, 58, 1, 'Ciprovet 5 ml ', '1,16E+12', '', '5 ml ', '', '0.00', '58.00', '0.00', '58.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(655, 9, 58, 1, 'Ocubiotic 5 ml ', '1,16E+12', '', '5 ml ', '', '0.00', '40.00', '0.00', '40.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(656, 9, 58, 1, 'Tobromax 5 ml ', '1,16E+12', '', '5 ml ', '', '0.00', '45.00', '0.00', '45.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(657, 9, 58, 1, 'Apeticat 100 ml ', '1,16E+12', '', '100 ml ', '', '0.00', '34.00', '0.00', '34.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(658, 9, 58, 1, 'Colageno hidrolizado 90 tabletas ', '1,16E+12', '', '90 tabletas ', '', '0.00', '28.00', '0.00', '28.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(659, 9, 58, 1, 'Felovite II', '1,16E+12', '', '', '', '0.00', '41.00', '0.00', '41.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(660, 9, 58, 1, 'Methigel 4.25 onzas 120 gr ', '1,17E+12', '', '120 gr ', '', '0.00', '40.00', '0.00', '40.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(661, 9, 58, 1, 'Nutrical ', '1,17E+12', '', '', '', '0.00', '38.00', '0.00', '38.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(662, 9, 58, 1, 'Flexadin ', '1,17E+12', '', '', '', '0.00', '178.00', '0.00', '178.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(663, 9, 58, 1, 'Hemolitan x 60 ml ', '1,17E+12', '', '', '', '0.00', '60.00', '0.00', '60.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(664, 9, 58, 1, 'Omega perro adulto  125 ml ', '1,17E+12', '', '125 ml ', '', '0.00', '36.00', '0.00', '36.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(665, 9, 58, 1, 'Omega perro senior 125 ml ', '1,17E+12', '', '125 ml ', '', '0.00', '43.00', '0.00', '43.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(666, 9, 58, 1, 'Mirrapel control de  caida de pelo  600 gr ', '1,17E+12', '', '600 gr ', '', '0.00', '53.00', '0.00', '53.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(667, 9, 58, 1, 'Mirrapel control de  caida de pelo 236 ml ', '1,17E+12', '', '236 ml ', '', '0.00', '48.00', '0.00', '48.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(668, 9, 58, 1, 'Pet tabs 60 tabletas ', '1,17E+12', '', '60 tabletas ', '', '0.00', '63.00', '0.00', '63.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(669, 9, 58, 1, 'Pet tabs 180 tabletas ', '1,17E+12', '', '180 tabletas ', '', '0.00', '169.00', '0.00', '169.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(670, 9, 58, 1, 'Pet cal 60 tabletas ', '1,18E+12', '', '60 tabletas ', '', '0.00', '60.00', '0.00', '60.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(671, 9, 58, 1, 'Potenza 120.5 gr ', '1,18E+12', '', '120.5 gr ', '', '0.00', '60.00', '0.00', '60.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(672, 9, 58, 1, 'Probiotics pack x 6 frascos 30 tabletas cada frasco ', '1,18E+12', '', '30 tabletas cada frasco ', '', '0.00', '30.00', '0.00', '30.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(673, 9, 58, 1, 'Visorbits 50 tabletas ', '1,18E+12', '', '50 tabletas ', '', '0.00', '48.00', '0.00', '48.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(674, 8, 58, 1, 'Dispensador de shampoo ', '9,58E+11', '', '', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(675, 8, 58, 1, 'venda adhesiva ', '9,59E+11', '', '', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(676, 8, 58, 1, 'Rasqueta doble cuadrado ', '9,60E+11', '', '', '', '0.00', '6.00', '0.00', '6.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(677, 8, 58, 1, 'Peine doble de metal ', '9,61E+11', '', '', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(678, 8, 58, 1, 'Cepillo expulsador chico ', '9,62E+11', '', 'chico ', '', '0.00', '4.00', '0.00', '4.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(679, 8, 58, 1, 'Cepillo expulsador ', '9,63E+11', '', '', '', '0.00', '7.00', '0.00', '7.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(680, 8, 58, 1, 'Cepillo expulsador  gatito ', '9,64E+11', '', '', '', '0.00', '6.00', '0.00', '6.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(681, 8, 58, 1, 'Cepillo expulsador azul chico ', '9,65E+11', '', 'chico ', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(682, 8, 58, 1, 'Cepillo expulsador azul Grande ', '9,66E+11', '', 'Grande ', '', '0.00', '7.00', '0.00', '7.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(683, 8, 58, 1, 'Rasqueta de colores chico ', '9,67E+11', '', 'chico ', '', '0.00', '4.00', '0.00', '3.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(684, 8, 58, 1, 'Rasqueta de colores Grande ', '9,68E+11', '', 'Grande ', '', '0.00', '4.00', '0.00', '4.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(685, 8, 58, 1, 'Kit corta pelo ', '9,69E+11', '', '', '', '0.00', '42.00', '0.00', '42.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(686, 8, 58, 1, 'Cepillo ovalado Chico ', '9,70E+11', '', 'Chico ', '', '0.00', '4.00', '0.00', '4.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(687, 8, 58, 1, 'Cepillo ovalado Grande ', '9,71E+11', '', 'Grande ', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(688, 8, 58, 1, 'Rasqueta plomo Chico ', '9,72E+11', '', 'Chico ', '', '0.00', '3.00', '0.00', '3.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(689, 8, 58, 1, 'Rasqueta plomo Mediano ', '9,73E+11', '', 'Mediano ', '', '0.00', '4.00', '0.00', '4.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(690, 8, 58, 1, 'Rasqueta plomo Grande ', '9,74E+11', '', 'Grande ', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(691, 8, 58, 1, 'Corta uña grande con Lima ', '9,75E+11', '', '', '', '0.00', '7.00', '0.00', '7.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(692, 8, 58, 1, 'Corta uña nunbell Mediano ', '9,76E+11', '', 'Mediano ', '', '0.00', '7.00', '0.00', '7.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(693, 8, 58, 1, 'Corta uña tijera C/Lima ', '9,77E+11', '', '', '', '0.00', '4.00', '0.00', '4.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(694, 8, 58, 1, 'Lava patas Chico ', '9,78E+11', '', 'Chico ', '', '0.00', '8.00', '0.00', '8.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(695, 8, 58, 1, 'Lava patas Grande ', '9,79E+11', '', 'Grande ', '', '0.00', '10.00', '0.00', '10.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(696, 8, 58, 1, 'Kit pasta dental nunbel 95 gr ', '9,80E+11', '', '', '', '0.00', '9.00', '0.00', '9.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(697, 8, 58, 1, 'Pasta dental dental care con cepillo 95 gr ', '9,81E+11', '', '', '', '0.00', '8.00', '0.00', '8.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(698, 8, 58, 1, 'Pasta dental dental care sin cepillo 95 gr ', '9,82E+11', '', '', '', '0.00', '5.00', '0.00', '5.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(699, 8, 58, 1, 'Pasta dental DENTO PET X 42 gr ', '9,83E+11', '', '', '', '0.00', '9.00', '0.00', '9.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(700, 8, 58, 1, 'Bolsita con huellitas x 8 unid ', '9,84E+11', '', '', '', '0.00', '6.00', '0.00', '6.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(701, 8, 58, 1, 'Bolsitas x 5 + dispensador ', '9,85E+11', '', '', '', '0.00', '6.00', '0.00', '6.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(702, 8, 58, 1, 'Dispensador de bolsitas ', '9,86E+11', '', '', '', '0.00', '3.00', '0.00', '3.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(703, 8, 58, 1, 'Bolsa de repuesto nunbel (8 rollos)', '9,87E+11', '', '', '', '0.00', '7.00', '0.00', '7.00', '0.00', '', 10, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(704, 3, 58, 1, 'Kit de biberón Pett Bottle', 'D-91', NULL, '120 ml', NULL, '4.66', '5.50', '4.66', '5.50', '1.18', 'productos/1712166857-dae0efdec58f6b121a0d1dd12a608ca9.webp', 10, 1, 0, NULL, NULL),
(705, 6, 58, 1, 'Bozal de metal', 'Pitbull', NULL, '00', '00', '17.80', '21.00', '17.80', '21.00', '1.18', 'productos/1712337783-47ed4fa8-31ce-499f-a0dc-204d26aa10f7.webp', 10, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedores` bigint UNSIGNED NOT NULL,
  `id_sede` bigint NOT NULL DEFAULT '1',
  `id_tipo_documento` bigint UNSIGNED NOT NULL,
  `proveedores_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedores_numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedores_direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedores_nombre_contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedores_cargo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedores_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedores_correo` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedores_estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedoes_categoria` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id_proveedores`, `id_sede`, `id_tipo_documento`, `proveedores_nombre`, `proveedores_numero_documento`, `proveedores_direccion`, `proveedores_nombre_contacto`, `proveedores_cargo`, `proveedores_telefono`, `proveedores_correo`, `proveedores_estado`, `proveedoes_categoria`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'HOU E.I.R.L', '001638', 'Jr. Andahuylas N° 1053-Lima', NULL, NULL, '954 130 531', NULL, '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol_descripcion` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_estado` int DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(270, 1),
(271, 1),
(272, 1),
(273, 1),
(274, 1),
(275, 1),
(276, 1),
(277, 1),
(278, 1),
(279, 1),
(280, 1),
(281, 1),
(282, 1),
(283, 1),
(284, 1),
(285, 1),
(286, 1),
(287, 1),
(288, 1),
(289, 1),
(290, 1),
(291, 1),
(292, 1),
(293, 1),
(294, 1),
(295, 1),
(296, 1),
(297, 1),
(298, 1),
(299, 1),
(300, 1),
(301, 1),
(302, 1),
(303, 1),
(304, 1),
(305, 1),
(306, 1),
(307, 1),
(308, 1),
(309, 1),
(310, 1),
(311, 1),
(312, 1),
(313, 1),
(314, 1),
(315, 1),
(316, 1),
(317, 1),
(318, 1),
(319, 1),
(320, 1),
(321, 1),
(322, 1),
(323, 1),
(324, 1),
(325, 1),
(326, 1),
(327, 1),
(328, 1),
(329, 1),
(330, 1),
(331, 1),
(332, 1),
(333, 1),
(334, 1),
(335, 1),
(336, 1),
(337, 1),
(338, 1),
(339, 1),
(342, 1),
(343, 1),
(344, 1),
(270, 2),
(271, 2),
(272, 2),
(273, 2),
(274, 2),
(275, 2),
(276, 2),
(277, 2),
(278, 2),
(279, 2),
(280, 2),
(281, 2),
(282, 2),
(283, 2),
(284, 2),
(285, 2),
(286, 2),
(287, 2),
(288, 2),
(289, 2),
(290, 2),
(291, 2),
(292, 2),
(293, 2),
(294, 2),
(295, 2),
(296, 2),
(297, 2),
(298, 2),
(299, 2),
(300, 2),
(301, 2),
(302, 2),
(303, 2),
(304, 2),
(305, 2),
(306, 2),
(307, 2),
(308, 2),
(309, 2),
(310, 2),
(311, 2),
(312, 2),
(313, 2),
(314, 2),
(315, 2),
(316, 2),
(317, 2),
(318, 2),
(319, 2),
(320, 2),
(321, 2),
(322, 2),
(323, 2),
(324, 2),
(325, 2),
(326, 2),
(327, 2),
(328, 2),
(329, 2),
(330, 2),
(331, 2),
(332, 2),
(333, 2),
(334, 2),
(335, 2),
(336, 2),
(337, 2),
(338, 2),
(339, 2),
(342, 2),
(343, 2),
(344, 2);

-- --------------------------------------------------------

--
-- Table structure for table `serie`
--

CREATE TABLE `serie` (
  `id_serie` bigint UNSIGNED NOT NULL,
  `id_caja_numero` bigint UNSIGNED NOT NULL,
  `tipocomp` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` int NOT NULL,
  `estado` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `serie`
--

INSERT INTO `serie` (`id_serie`, `id_caja_numero`, `tipocomp`, `serie`, `correlativo`, `estado`, `created_at`, `updated_at`) VALUES
(3, 1, '01', 'F001', 1, 1, NULL, NULL),
(5, 1, '03', 'B001', 7, 1, NULL, NULL),
(6, 1, '07', 'FN01', 0, 1, NULL, NULL),
(7, 1, '07', 'BN01', 0, 1, NULL, NULL),
(8, 1, '08', 'FD01', 0, 1, NULL, NULL),
(9, 1, '08', 'BD01', 0, 1, NULL, NULL),
(10, 1, 'RC', '20240301', 0, 1, NULL, NULL),
(11, 1, 'RA', '20210520', 0, 1, NULL, NULL),
(13, 1, '20', 'NV01', 0, 1, NULL, NULL),
(23, 1, '99', 'T01', 0, 1, NULL, NULL),
(24, 1, '09', 'TTT1', 0, 1, NULL, NULL),
(25, 1, '31', 'VVV1', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submenu`
--

CREATE TABLE `submenu` (
  `id_submenu` bigint UNSIGNED NOT NULL,
  `id_menu` bigint UNSIGNED NOT NULL,
  `submenu_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_funcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(48, 1, 'Iconos', 'iconos', 1, 5, 1, '2023-12-30 15:04:21', '2023-12-30 15:04:21'),
(49, 13, 'Proveedores', 'proveedores', 1, 1, 1, '2024-01-14 16:30:37', '2024-01-14 16:30:37'),
(50, 13, 'Familias', 'familias', 1, 2, 1, '2024-01-14 16:34:43', '2024-01-14 18:30:15'),
(51, 13, 'Categoria', 'categoria', 0, 3, 1, '2024-01-15 00:50:16', '2024-01-15 00:51:58'),
(52, 14, 'Gestionar Productos', 'gestionar_productos', 1, 1, 1, '2024-01-15 01:45:46', '2024-01-15 02:10:03'),
(53, 14, 'Compras', 'compras', 1, 1, 1, '2024-01-15 01:46:03', '2024-01-15 01:46:03'),
(54, 14, 'Orden Compra Detalle', 'ordenCompraDetalle', 0, 3, 1, '2024-01-28 16:51:40', '2024-01-28 16:51:40'),
(55, 15, 'Movimientos', 'movimientos', 1, 1, 1, '2024-02-02 03:18:12', '2024-02-02 03:18:12'),
(56, 15, 'Realizar ventas', 'realizar_ventas', 1, 2, 1, '2024-02-02 03:20:55', '2024-02-02 03:20:55'),
(57, 15, 'Venta Detalle', 'venta_detalle', 0, 3, 1, '2024-02-14 13:38:04', '2024-02-14 13:38:04'),
(58, 16, 'Pendientes de Declarar', 'pendiente_declarar', 1, 1, 1, '2024-02-16 01:23:12', '2024-02-16 01:23:12'),
(59, 16, 'Historial de Envíos', 'historial_envios', 1, 2, 1, '2024-02-16 01:23:40', '2024-02-16 01:23:40'),
(60, 16, 'Detalle Resumen', 'detalle_resumen', 0, 3, 1, '2024-02-16 01:24:46', '2024-02-16 01:24:46'),
(61, 16, 'Generar Nota', 'generar_nota', 0, 4, 1, '2024-02-16 01:24:57', '2024-02-16 01:24:57'),
(62, 17, 'Ventas por caja', 'ventas_por_caja', 1, 1, 1, '2024-02-18 11:03:55', '2024-02-18 11:03:55'),
(63, 17, 'Reporte de productos', 'reporte_de_productos', 1, 2, 1, '2024-02-18 11:04:32', '2024-02-18 11:04:32'),
(64, 17, 'Reporte de ventas', 'reporte_de_ventas', 1, 3, 1, '2024-02-18 11:05:57', '2024-02-18 11:05:57'),
(65, 17, 'Reporte Proveedores', 'proveedores_reporte', 1, 4, 1, '2024-02-21 03:23:26', '2024-02-21 03:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `id_tipo_afectacion` bigint UNSIGNED NOT NULL,
  `codigo` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_afectacion` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_afectacion` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_afectacion` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `tipodocumento_codigo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_identidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_identidad_abr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_nota_descripcion` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `codigo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_nota_descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `tipo_pago_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `tipo_venta_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `transaccion_codigo` char(6) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `transaccion_tipo_pago` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `transaccion_total_pago` float(10,2) NOT NULL,
  `vads_capture_delay` int DEFAULT NULL,
  `vads_trans_status` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_card_brand` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_card_number` varchar(16) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_payment_certificate` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_ctx_mode` varchar(12) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_currency` char(3) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_effective_amount` varchar(8) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_effective_currency` varchar(4) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_trans_date` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_trans_uuid` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_hash` varchar(500) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vads_url_check_src` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `transaccion_creacion` datetime NOT NULL,
  `transaccion_cierre` datetime DEFAULT NULL,
  `transaccion_mt` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL
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
-- Table structure for table `ubigeo`
--

CREATE TABLE `ubigeo` (
  `id_ubigeo` bigint NOT NULL,
  `ubigeo_cod` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ubigeo_departamento` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ubigeo_provincia` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ubigeo_distrito` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ubigeo_capital` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ubigeo`
--

INSERT INTO `ubigeo` (`id_ubigeo`, `ubigeo_cod`, `ubigeo_departamento`, `ubigeo_provincia`, `ubigeo_distrito`, `ubigeo_capital`) VALUES
(1, '10102', 'AMAZONAS', 'CHACHAPOYAS', 'ASUNCION', 'ASUNCION'),
(2, '10103', 'AMAZONAS', 'CHACHAPOYAS', 'BALSAS', 'BALSAS'),
(3, '10104', 'AMAZONAS', 'CHACHAPOYAS', 'CHETO', 'CHETO'),
(4, '10105', 'AMAZONAS', 'CHACHAPOYAS', 'CHILIQUIN', 'CHILIQUIN'),
(5, '10106', 'AMAZONAS', 'CHACHAPOYAS', 'CHUQUIBAMBA', 'CHUQUIBAMBA'),
(6, '10107', 'AMAZONAS', 'CHACHAPOYAS', 'GRANADA', 'GRANADA'),
(7, '10108', 'AMAZONAS', 'CHACHAPOYAS', 'HUANCAS', 'HUANCAS'),
(8, '10109', 'AMAZONAS', 'CHACHAPOYAS', 'LA JALCA', 'LA JALCA'),
(9, '10110', 'AMAZONAS', 'CHACHAPOYAS', 'LEIMEBAMBA', 'LEIMEBAMBA'),
(10, '10111', 'AMAZONAS', 'CHACHAPOYAS', 'LEVANTO', 'LEVANTO'),
(11, '10112', 'AMAZONAS', 'CHACHAPOYAS', 'MAGDALENA', 'MAGDALENA'),
(12, '10113', 'AMAZONAS', 'CHACHAPOYAS', 'MARISCAL CASTILLA', 'DURAZNOPAMPA'),
(13, '10114', 'AMAZONAS', 'CHACHAPOYAS', 'MOLINOPAMPA', 'MOLINOPAMPA'),
(14, '10115', 'AMAZONAS', 'CHACHAPOYAS', 'MONTEVIDEO', 'MONTEVIDEO'),
(15, '10116', 'AMAZONAS', 'CHACHAPOYAS', 'OLLEROS', 'OLLEROS'),
(16, '10117', 'AMAZONAS', 'CHACHAPOYAS', 'QUINJALCA', 'QUINJALCA'),
(17, '10118', 'AMAZONAS', 'CHACHAPOYAS', 'SAN FRANCISCO DE DAGUAS', 'DAGUAS'),
(18, '10119', 'AMAZONAS', 'CHACHAPOYAS', 'SAN ISIDRO DE MAINO', 'MAINO'),
(19, '10120', 'AMAZONAS', 'CHACHAPOYAS', 'SOLOCO', 'SOLOCO'),
(20, '10121', 'AMAZONAS', 'CHACHAPOYAS', 'SONCHE', 'SAN JUAN DE SONCHE'),
(21, '10201', 'AMAZONAS', 'BAGUA', 'BAGUA', 'BAGUA'),
(22, '10202', 'AMAZONAS', 'BAGUA', 'ARAMANGO', 'ARAMANGO'),
(23, '10203', 'AMAZONAS', 'BAGUA', 'COPALLIN', 'COPALLIN'),
(24, '10204', 'AMAZONAS', 'BAGUA', 'EL PARCO', 'EL PARCO'),
(25, '10205', 'AMAZONAS', 'BAGUA', 'IMAZA', 'CHIRIACO'),
(26, '10206', 'AMAZONAS', 'BAGUA', 'LA PECA', 'LA PECA'),
(27, '10301', 'AMAZONAS', 'BONGARA', 'JUMBILLA', 'JUMBILLA'),
(28, '10302', 'AMAZONAS', 'BONGARA', 'CHISQUILLA', 'CHISQUILLA'),
(29, '10303', 'AMAZONAS', 'BONGARA', 'CHURUJA', 'CHURUJA'),
(30, '10304', 'AMAZONAS', 'BONGARA', 'COROSHA', 'COROSHA'),
(31, '10305', 'AMAZONAS', 'BONGARA', 'CUISPES', 'CUISPES'),
(32, '10306', 'AMAZONAS', 'BONGARA', 'FLORIDA', 'FLORIDA (POMACOCHAS)'),
(33, '10307', 'AMAZONAS', 'BONGARA', 'JAZAN', 'PEDRO RUIZ GALLO'),
(34, '10308', 'AMAZONAS', 'BONGARA', 'RECTA', 'RECTA'),
(35, '10309', 'AMAZONAS', 'BONGARA', 'SAN CARLOS', 'SAN CARLOS'),
(36, '10310', 'AMAZONAS', 'BONGARA', 'SHIPASBAMBA', 'SHIPASBAMBA'),
(37, '10311', 'AMAZONAS', 'BONGARA', 'VALERA', 'VALERA (SAN PABLO)'),
(38, '10312', 'AMAZONAS', 'BONGARA', 'YAMBRASBAMBA', 'YAMBRASBAMBA'),
(39, '10401', 'AMAZONAS', 'CONDORCANQUI', 'NIEVA', 'SANTA MARIA DE NIEVA'),
(40, '10402', 'AMAZONAS', 'CONDORCANQUI', 'EL CENEPA', 'HUAMPAMI'),
(41, '10403', 'AMAZONAS', 'CONDORCANQUI', 'RIO SANTIAGO', 'PUERTO GALILEA'),
(42, '10501', 'AMAZONAS', 'LUYA', 'LAMUD', 'LAMUD'),
(43, '10502', 'AMAZONAS', 'LUYA', 'CAMPORREDONDO', 'CAMPORREDONDO'),
(44, '10503', 'AMAZONAS', 'LUYA', 'COCABAMBA', 'COCABAMBA'),
(45, '10504', 'AMAZONAS', 'LUYA', 'COLCAMAR', 'COLCAMAR'),
(46, '10505', 'AMAZONAS', 'LUYA', 'CONILA', 'COHECHAN'),
(47, '10506', 'AMAZONAS', 'LUYA', 'INGUILPATA', 'INGUILPATA'),
(48, '10507', 'AMAZONAS', 'LUYA', 'LONGUITA', 'LONGUITA'),
(49, '10508', 'AMAZONAS', 'LUYA', 'LONYA CHICO', 'LONYA CHICO'),
(50, '10509', 'AMAZONAS', 'LUYA', 'LUYA', 'LUYA'),
(51, '10510', 'AMAZONAS', 'LUYA', 'LUYA VIEJO', 'LUYA VIEJO'),
(52, '10511', 'AMAZONAS', 'LUYA', 'MARIA', 'MARIA'),
(53, '10512', 'AMAZONAS', 'LUYA', 'OCALLI', 'OCALLI'),
(54, '10513', 'AMAZONAS', 'LUYA', 'OCUMAL', 'COLLONCE'),
(55, '10514', 'AMAZONAS', 'LUYA', 'PISUQUIA', 'YOMBLON'),
(56, '10515', 'AMAZONAS', 'LUYA', 'PROVIDENCIA', 'PROVIDENCIA'),
(57, '10516', 'AMAZONAS', 'LUYA', 'SAN CRISTOBAL', 'OLTO'),
(58, '10517', 'AMAZONAS', 'LUYA', 'SAN FRANCISCO DEL YESO', 'SAN FRANCISCO DEL YESO'),
(59, '10518', 'AMAZONAS', 'LUYA', 'SAN JERONIMO', 'PACLAS'),
(60, '10519', 'AMAZONAS', 'LUYA', 'SAN JUAN DE LOPECANCHA', 'SAN JUAN DE LOPECANCHA'),
(61, '10520', 'AMAZONAS', 'LUYA', 'SANTA CATALINA', 'SANTA CATALINA'),
(62, '10521', 'AMAZONAS', 'LUYA', 'SANTO TOMAS', 'SANTO TOMAS'),
(63, '10522', 'AMAZONAS', 'LUYA', 'TINGO', 'TINGO'),
(64, '10523', 'AMAZONAS', 'LUYA', 'TRITA', 'TRITA'),
(65, '10601', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'SAN NICOLAS', 'MENDOZA'),
(66, '10602', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'CHIRIMOTO', 'CHIRIMOTO'),
(67, '10603', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'COCHAMAL', 'COCHAMAL'),
(68, '10604', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'HUAMBO', 'HUAMBO'),
(69, '10605', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'LIMABAMBA', 'LIMABAMBA'),
(70, '10606', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'LONGAR', 'LONGAR'),
(71, '10607', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'MARISCAL BENAVIDES', 'MARISCAL BENAVIDES'),
(72, '10608', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'MILPUC', 'MILPUC'),
(73, '10609', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'OMIA', 'OMIA'),
(74, '10610', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'SANTA ROSA', 'SANTA ROSA DE HUAYABAMBA'),
(75, '10611', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'TOTORA', 'TOTORA'),
(76, '10612', 'AMAZONAS', 'RODRIGUEZ DE MENDOZA', 'VISTA ALEGRE', 'VISTA ALEGRE'),
(77, '10701', 'AMAZONAS', 'UTCUBAMBA', 'BAGUA GRANDE', 'BAGUA GRANDE'),
(78, '10702', 'AMAZONAS', 'UTCUBAMBA', 'CAJARURO', 'CAJARURO'),
(79, '10703', 'AMAZONAS', 'UTCUBAMBA', 'CUMBA', 'CUMBA'),
(80, '10704', 'AMAZONAS', 'UTCUBAMBA', 'EL MILAGRO', 'EL MILAGRO'),
(81, '10705', 'AMAZONAS', 'UTCUBAMBA', 'JAMALCA', 'JAMALCA'),
(82, '10706', 'AMAZONAS', 'UTCUBAMBA', 'LONYA GRANDE', 'LONYA GRANDE'),
(83, '10707', 'AMAZONAS', 'UTCUBAMBA', 'YAMON', 'YAMON'),
(84, '20101', 'ANCASH', 'HUARAZ', 'HUARAZ', 'HUARAZ'),
(85, '20102', 'ANCASH', 'HUARAZ', 'COCHABAMBA', 'COCHABAMBA'),
(86, '20103', 'ANCASH', 'HUARAZ', 'COLCABAMBA', 'COLCABAMBA'),
(87, '20104', 'ANCASH', 'HUARAZ', 'HUANCHAY', 'HUANCHAY'),
(88, '20105', 'ANCASH', 'HUARAZ', 'INDEPENDENCIA', 'CENTENARIO'),
(89, '20106', 'ANCASH', 'HUARAZ', 'JANGAS', 'JANGAS'),
(90, '20107', 'ANCASH', 'HUARAZ', 'LA LIBERTAD', 'CAJAMARQUILLA'),
(91, '20108', 'ANCASH', 'HUARAZ', 'OLLEROS', 'OLLEROS'),
(92, '20109', 'ANCASH', 'HUARAZ', 'PAMPAS GRANDE', 'PAMPAS GRANDE'),
(93, '20110', 'ANCASH', 'HUARAZ', 'PARIACOTO', 'PARIACOTO'),
(94, '20111', 'ANCASH', 'HUARAZ', 'PIRA', 'PIRA'),
(95, '20112', 'ANCASH', 'HUARAZ', 'TARICA', 'TARICA'),
(96, '20201', 'ANCASH', 'AIJA', 'AIJA', 'AIJA'),
(97, '20202', 'ANCASH', 'AIJA', 'CORIS', 'CORIS'),
(98, '20203', 'ANCASH', 'AIJA', 'HUACLLAN', 'HUACLLAN'),
(99, '20204', 'ANCASH', 'AIJA', 'LA MERCED', 'LA MERCED'),
(100, '20205', 'ANCASH', 'AIJA', 'SUCCHA', 'SUCCHA'),
(101, '20301', 'ANCASH', 'ANTONIO RAYMONDI', 'LLAMELLIN', 'LLAMELLIN'),
(102, '20302', 'ANCASH', 'ANTONIO RAYMONDI', 'ACZO', 'ACZO'),
(103, '20303', 'ANCASH', 'ANTONIO RAYMONDI', 'CHACCHO', 'CHACCHO'),
(104, '20304', 'ANCASH', 'ANTONIO RAYMONDI', 'CHINGAS', 'CHINGAS'),
(105, '20305', 'ANCASH', 'ANTONIO RAYMONDI', 'MIRGAS', 'MIRGAS'),
(106, '20306', 'ANCASH', 'ANTONIO RAYMONDI', 'SAN JUAN DE RONTOY', 'SAN JUAN DE RONTOY'),
(107, '20401', 'ANCASH', 'ASUNCION', 'CHACAS', 'CHACAS'),
(108, '20402', 'ANCASH', 'ASUNCION', 'ACOCHACA', 'ACOCHACA'),
(109, '20501', 'ANCASH', 'BOLOGNESI', 'CHIQUIAN', 'CHIQUIAN'),
(110, '20502', 'ANCASH', 'BOLOGNESI', 'ABELARDO PARDO LEZAMETA', 'LLACLLA'),
(111, '20503', 'ANCASH', 'BOLOGNESI', 'ANTONIO RAYMONDI', 'RAQUIA'),
(112, '20504', 'ANCASH', 'BOLOGNESI', 'AQUIA', 'AQUIA'),
(113, '20505', 'ANCASH', 'BOLOGNESI', 'CAJACAY', 'CAJACAY'),
(114, '20506', 'ANCASH', 'BOLOGNESI', 'CANIS', 'CANIS'),
(115, '20507', 'ANCASH', 'BOLOGNESI', 'COLQUIOC', 'CHASQUITAMBO'),
(116, '20508', 'ANCASH', 'BOLOGNESI', 'HUALLANCA', 'HUALLANCA'),
(117, '20509', 'ANCASH', 'BOLOGNESI', 'HUASTA', 'HUASTA'),
(118, '20510', 'ANCASH', 'BOLOGNESI', 'HUAYLLACAYAN', 'HUAYLLACAYAN'),
(119, '20511', 'ANCASH', 'BOLOGNESI', 'LA PRIMAVERA', 'GORGORILLO'),
(120, '20512', 'ANCASH', 'BOLOGNESI', 'MANGAS', 'MANGAS'),
(121, '20513', 'ANCASH', 'BOLOGNESI', 'PACLLON', 'PACLLON'),
(122, '20514', 'ANCASH', 'BOLOGNESI', 'SAN MIGUEL DE CORPANQUI', 'CORPANQUI'),
(123, '20515', 'ANCASH', 'BOLOGNESI', 'TICLLOS', 'TICLLOS'),
(124, '20601', 'ANCASH', 'CARHUAZ', 'CARHUAZ', 'CARHUAZ'),
(125, '20602', 'ANCASH', 'CARHUAZ', 'ACOPAMPA', 'ACOPAMPA'),
(126, '20603', 'ANCASH', 'CARHUAZ', 'AMASHCA', 'AMASHCA'),
(127, '20604', 'ANCASH', 'CARHUAZ', 'ANTA', 'ANTA'),
(128, '20605', 'ANCASH', 'CARHUAZ', 'ATAQUERO', 'CARHUAC'),
(129, '20606', 'ANCASH', 'CARHUAZ', 'MARCARA', 'MARCARA'),
(130, '20607', 'ANCASH', 'CARHUAZ', 'PARIAHUANCA', 'PARIAHUANCA'),
(131, '20608', 'ANCASH', 'CARHUAZ', 'SAN MIGUEL DE ACO', 'ACO'),
(132, '20609', 'ANCASH', 'CARHUAZ', 'SHILLA', 'SHILLA'),
(133, '20610', 'ANCASH', 'CARHUAZ', 'TINCO', 'TINCO'),
(134, '20611', 'ANCASH', 'CARHUAZ', 'YUNGAR', 'YUNGAR'),
(135, '20701', 'ANCASH', 'CARLOS FERMIN FITZCARRALD', 'SAN LUIS', 'SAN LUIS'),
(136, '20702', 'ANCASH', 'CARLOS FERMIN FITZCARRALD', 'SAN NICOLAS', 'SAN NICOLAS'),
(137, '20703', 'ANCASH', 'CARLOS FERMIN FITZCARRALD', 'YAUYA', 'YAUYA'),
(138, '20801', 'ANCASH', 'CASMA', 'CASMA', 'CASMA'),
(139, '20802', 'ANCASH', 'CASMA', 'BUENA VISTA ALTA', 'BUENA VISTA ALTA'),
(140, '20803', 'ANCASH', 'CASMA', 'COMANDANTE NOEL', 'PUERTO CASMA'),
(141, '20804', 'ANCASH', 'CASMA', 'YAUTAN', 'YAUTAN'),
(142, '20901', 'ANCASH', 'CORONGO', 'CORONGO', 'CORONGO'),
(143, '20902', 'ANCASH', 'CORONGO', 'ACO', 'ACO'),
(144, '20903', 'ANCASH', 'CORONGO', 'BAMBAS', 'BAMBAS'),
(145, '20904', 'ANCASH', 'CORONGO', 'CUSCA', 'CUSCA'),
(146, '20905', 'ANCASH', 'CORONGO', 'LA PAMPA', 'LA PAMPA'),
(147, '20906', 'ANCASH', 'CORONGO', 'YANAC', 'YANAC'),
(148, '20907', 'ANCASH', 'CORONGO', 'YUPAN', 'YUPAN'),
(149, '21001', 'ANCASH', 'HUARI', 'HUARI', 'HUARI'),
(150, '21002', 'ANCASH', 'HUARI', 'ANRA', 'ANRA'),
(151, '21003', 'ANCASH', 'HUARI', 'CAJAY', 'CAJAY'),
(152, '21004', 'ANCASH', 'HUARI', 'CHAVIN DE HUANTAR', 'CHAVIN DE HUANTAR'),
(153, '21005', 'ANCASH', 'HUARI', 'HUACACHI', 'HUACACHI'),
(154, '21006', 'ANCASH', 'HUARI', 'HUACCHIS', 'HUACCHIS'),
(155, '21007', 'ANCASH', 'HUARI', 'HUACHIS', 'HUACHIS'),
(156, '21008', 'ANCASH', 'HUARI', 'HUANTAR', 'HUANTAR'),
(157, '21009', 'ANCASH', 'HUARI', 'MASIN', 'MASIN'),
(158, '21010', 'ANCASH', 'HUARI', 'PAUCAS', 'PAUCAS'),
(159, '21011', 'ANCASH', 'HUARI', 'PONTO', 'PONTO'),
(160, '21012', 'ANCASH', 'HUARI', 'RAHUAPAMPA', 'RAHUAPAMPA'),
(161, '21013', 'ANCASH', 'HUARI', 'RAPAYAN', 'RAPAYAN'),
(162, '21014', 'ANCASH', 'HUARI', 'SAN MARCOS', 'SAN MARCOS'),
(163, '21015', 'ANCASH', 'HUARI', 'SAN PEDRO DE CHANA', 'CHANA'),
(164, '21016', 'ANCASH', 'HUARI', 'UCO', 'UCO'),
(165, '21101', 'ANCASH', 'HUARMEY', 'HUARMEY', 'HUARMEY'),
(166, '21102', 'ANCASH', 'HUARMEY', 'COCHAPETI', 'COCHAPETI'),
(167, '21103', 'ANCASH', 'HUARMEY', 'CULEBRAS', 'LA CALETA CULEBRAS'),
(168, '21104', 'ANCASH', 'HUARMEY', 'HUAYAN', 'HUAYAN'),
(169, '21105', 'ANCASH', 'HUARMEY', 'MALVAS', 'MALVAS'),
(170, '21201', 'ANCASH', 'HUAYLAS', 'CARAZ', 'CARAZ'),
(171, '21202', 'ANCASH', 'HUAYLAS', 'HUALLANCA', 'HUALLANCA'),
(172, '21203', 'ANCASH', 'HUAYLAS', 'HUATA', 'HUATA'),
(173, '21204', 'ANCASH', 'HUAYLAS', 'HUAYLAS', 'HUAYLAS'),
(174, '21205', 'ANCASH', 'HUAYLAS', 'MATO', 'SUCRE'),
(175, '21206', 'ANCASH', 'HUAYLAS', 'PAMPAROMAS', 'PAMPAROMAS'),
(176, '21207', 'ANCASH', 'HUAYLAS', 'PUEBLO LIBRE', 'PUEBLO LIBRE /1'),
(177, '21208', 'ANCASH', 'HUAYLAS', 'SANTA CRUZ', 'HUARIPAMPA'),
(178, '21209', 'ANCASH', 'HUAYLAS', 'SANTO TORIBIO', 'SANTO TORIBIO'),
(179, '21210', 'ANCASH', 'HUAYLAS', 'YURACMARCA', 'YURACMARCA'),
(180, '21301', 'ANCASH', 'MARISCAL LUZURIAGA', 'PISCOBAMBA', 'PISCOBAMBA'),
(181, '21302', 'ANCASH', 'MARISCAL LUZURIAGA', 'CASCA', 'CASCA'),
(182, '21303', 'ANCASH', 'MARISCAL LUZURIAGA', 'ELEAZAR GUZMAN BARRON', 'PAMPACHACRA'),
(183, '21304', 'ANCASH', 'MARISCAL LUZURIAGA', 'FIDEL OLIVAS ESCUDERO', 'SANACHGAN'),
(184, '21305', 'ANCASH', 'MARISCAL LUZURIAGA', 'LLAMA', 'LLAMA'),
(185, '21306', 'ANCASH', 'MARISCAL LUZURIAGA', 'LLUMPA', 'LLUMPA'),
(186, '21307', 'ANCASH', 'MARISCAL LUZURIAGA', 'LUCMA', 'LUCMA'),
(187, '21308', 'ANCASH', 'MARISCAL LUZURIAGA', 'MUSGA', 'MUSGA'),
(188, '21401', 'ANCASH', 'OCROS', 'OCROS', 'OCROS'),
(189, '21402', 'ANCASH', 'OCROS', 'ACAS', 'ACAS'),
(190, '21403', 'ANCASH', 'OCROS', 'CAJAMARQUILLA', 'CAJAMARQUILLA'),
(191, '21404', 'ANCASH', 'OCROS', 'CARHUAPAMPA', 'ACO'),
(192, '21405', 'ANCASH', 'OCROS', 'COCHAS', 'HUANCHAY'),
(193, '21406', 'ANCASH', 'OCROS', 'CONGAS', 'CONGAS'),
(194, '21407', 'ANCASH', 'OCROS', 'LLIPA', 'LLIPA'),
(195, '21408', 'ANCASH', 'OCROS', 'SAN CRISTOBAL DE RAJAN', 'RAJAN'),
(196, '21409', 'ANCASH', 'OCROS', 'SAN PEDRO', 'COPA'),
(197, '21410', 'ANCASH', 'OCROS', 'SANTIAGO DE CHILCAS', 'SANTIAGO DE CHILCAS'),
(198, '21501', 'ANCASH', 'PALLASCA', 'CABANA', 'CABANA'),
(199, '21502', 'ANCASH', 'PALLASCA', 'BOLOGNESI', 'BOLOGNESI'),
(200, '21503', 'ANCASH', 'PALLASCA', 'CONCHUCOS', 'CONCHUCOS'),
(201, '21504', 'ANCASH', 'PALLASCA', 'HUACASCHUQUE', 'HUACASCHUQUE'),
(202, '21505', 'ANCASH', 'PALLASCA', 'HUANDOVAL', 'HUANDOVAL'),
(203, '21506', 'ANCASH', 'PALLASCA', 'LACABAMBA', 'LACABAMBA'),
(204, '21507', 'ANCASH', 'PALLASCA', 'LLAPO', 'LLAPO'),
(205, '21508', 'ANCASH', 'PALLASCA', 'PALLASCA', 'PALLASCA'),
(206, '21509', 'ANCASH', 'PALLASCA', 'PAMPAS', 'PAMPAS'),
(207, '21510', 'ANCASH', 'PALLASCA', 'SANTA ROSA', 'SANTA ROSA'),
(208, '21511', 'ANCASH', 'PALLASCA', 'TAUCA', 'TAUCA'),
(209, '21601', 'ANCASH', 'POMABAMBA', 'POMABAMBA', 'POMABAMBA'),
(210, '21602', 'ANCASH', 'POMABAMBA', 'HUAYLLAN', 'HUAYLLAN'),
(211, '21603', 'ANCASH', 'POMABAMBA', 'PAROBAMBA', 'PAROBAMBA'),
(212, '21604', 'ANCASH', 'POMABAMBA', 'QUINUABAMBA', 'QUINUABAMBA'),
(213, '21701', 'ANCASH', 'RECUAY', 'RECUAY', 'RECUAY'),
(214, '21702', 'ANCASH', 'RECUAY', 'CATAC', 'CATAC'),
(215, '21703', 'ANCASH', 'RECUAY', 'COTAPARACO', 'COTAPARACO'),
(216, '21704', 'ANCASH', 'RECUAY', 'HUAYLLAPAMPA', 'HUAYLLAPAMPA'),
(217, '21705', 'ANCASH', 'RECUAY', 'LLACLLIN', 'LLACLLIN'),
(218, '21706', 'ANCASH', 'RECUAY', 'MARCA', 'MARCA'),
(219, '21707', 'ANCASH', 'RECUAY', 'PAMPAS CHICO', 'PAMPAS CHICO'),
(220, '21708', 'ANCASH', 'RECUAY', 'PARARIN', 'PARARIN'),
(221, '21709', 'ANCASH', 'RECUAY', 'TAPACOCHA', 'TAPACOCHA'),
(222, '21710', 'ANCASH', 'RECUAY', 'TICAPAMPA', 'TICAPAMPA'),
(223, '21801', 'ANCASH', 'SANTA', 'CHIMBOTE', 'CHIMBOTE'),
(224, '21802', 'ANCASH', 'SANTA', 'CACERES DEL PERU', 'JIMBE'),
(225, '21803', 'ANCASH', 'SANTA', 'COISHCO', 'COISHCO'),
(226, '21804', 'ANCASH', 'SANTA', 'MACATE', 'MACATE'),
(227, '21805', 'ANCASH', 'SANTA', 'MORO', 'MORO'),
(228, '21806', 'ANCASH', 'SANTA', 'NEPEÑA', 'NEPEÑA'),
(229, '21807', 'ANCASH', 'SANTA', 'SAMANCO', 'SAMANCO'),
(230, '21808', 'ANCASH', 'SANTA', 'SANTA', 'SANTA'),
(231, '21809', 'ANCASH', 'SANTA', 'NUEVO CHIMBOTE', 'BUENOS AIRES'),
(232, '21901', 'ANCASH', 'SIHUAS', 'SIHUAS', 'SIHUAS'),
(233, '21902', 'ANCASH', 'SIHUAS', 'ACOBAMBA', 'ACOBAMBA'),
(234, '21903', 'ANCASH', 'SIHUAS', 'ALFONSO UGARTE', 'ULLULLUCO'),
(235, '21904', 'ANCASH', 'SIHUAS', 'CASHAPAMPA', 'CASHAPAMPA'),
(236, '21905', 'ANCASH', 'SIHUAS', 'CHINGALPO', 'CHINGALPO'),
(237, '21906', 'ANCASH', 'SIHUAS', 'HUAYLLABAMBA', 'HUAYLLABAMBA'),
(238, '21907', 'ANCASH', 'SIHUAS', 'QUICHES', 'QUICHES'),
(239, '21908', 'ANCASH', 'SIHUAS', 'RAGASH', 'RAGASH'),
(240, '21909', 'ANCASH', 'SIHUAS', 'SAN JUAN', 'CHULLIN'),
(241, '21910', 'ANCASH', 'SIHUAS', 'SICSIBAMBA', 'UMBE'),
(242, '22001', 'ANCASH', 'YUNGAY', 'YUNGAY', 'YUNGAY'),
(243, '22002', 'ANCASH', 'YUNGAY', 'CASCAPARA', 'CASCAPARA'),
(244, '22003', 'ANCASH', 'YUNGAY', 'MANCOS', 'MANCOS'),
(245, '22004', 'ANCASH', 'YUNGAY', 'MATACOTO', 'MATACOTO'),
(246, '22005', 'ANCASH', 'YUNGAY', 'QUILLO', 'QUILLO'),
(247, '22006', 'ANCASH', 'YUNGAY', 'RANRAHIRCA', 'RANRAHIRCA'),
(248, '22007', 'ANCASH', 'YUNGAY', 'SHUPLUY', 'SHUPLUY'),
(249, '22008', 'ANCASH', 'YUNGAY', 'YANAMA', 'YANAMA'),
(250, '30101', 'APURIMAC', 'ABANCAY', 'ABANCAY', 'ABANCAY'),
(251, '30102', 'APURIMAC', 'ABANCAY', 'CHACOCHE', 'CHACOCHE'),
(252, '30103', 'APURIMAC', 'ABANCAY', 'CIRCA', 'CIRCA'),
(253, '30104', 'APURIMAC', 'ABANCAY', 'CURAHUASI', 'CURAHUASI'),
(254, '30105', 'APURIMAC', 'ABANCAY', 'HUANIPACA', 'HUANIPACA'),
(255, '30106', 'APURIMAC', 'ABANCAY', 'LAMBRAMA', 'LAMBRAMA'),
(256, '30107', 'APURIMAC', 'ABANCAY', 'PICHIRHUA', 'PICHIRHUA'),
(257, '30108', 'APURIMAC', 'ABANCAY', 'SAN PEDRO DE CACHORA', 'CACHORA'),
(258, '30109', 'APURIMAC', 'ABANCAY', 'TAMBURCO', 'TAMBURCO'),
(259, '30201', 'APURIMAC', 'ANDAHUAYLAS', 'ANDAHUAYLAS', 'ANDAHUAYLAS'),
(260, '30202', 'APURIMAC', 'ANDAHUAYLAS', 'ANDARAPA', 'ANDARAPA'),
(261, '30203', 'APURIMAC', 'ANDAHUAYLAS', 'CHIARA', 'CHIARA'),
(262, '30204', 'APURIMAC', 'ANDAHUAYLAS', 'HUANCARAMA', 'HUANCARAMA'),
(263, '30205', 'APURIMAC', 'ANDAHUAYLAS', 'HUANCARAY', 'HUANCARAY'),
(264, '30206', 'APURIMAC', 'ANDAHUAYLAS', 'HUAYANA', 'HUAYANA'),
(265, '30207', 'APURIMAC', 'ANDAHUAYLAS', 'KISHUARA', 'KISHUARA'),
(266, '30208', 'APURIMAC', 'ANDAHUAYLAS', 'PACOBAMBA', 'PACOBAMBA'),
(267, '30209', 'APURIMAC', 'ANDAHUAYLAS', 'PACUCHA', 'PACUCHA'),
(268, '30210', 'APURIMAC', 'ANDAHUAYLAS', 'PAMPACHIRI', 'PAMPACHIRI'),
(269, '30211', 'APURIMAC', 'ANDAHUAYLAS', 'POMACOCHA', 'POMACOCHA'),
(270, '30212', 'APURIMAC', 'ANDAHUAYLAS', 'SAN ANTONIO DE CACHI', 'SAN ANTONIO DE CACHI'),
(271, '30213', 'APURIMAC', 'ANDAHUAYLAS', 'SAN JERONIMO', 'SAN JERONIMO'),
(272, '30214', 'APURIMAC', 'ANDAHUAYLAS', 'SAN MIGUEL DE CHACCRAMPA', 'CHACCRAMPA'),
(273, '30215', 'APURIMAC', 'ANDAHUAYLAS', 'SANTA MARIA DE CHICMO', 'SANTA MARIA DE CHICMO'),
(274, '30216', 'APURIMAC', 'ANDAHUAYLAS', 'TALAVERA', 'TALAVERA'),
(275, '30217', 'APURIMAC', 'ANDAHUAYLAS', 'TUMAY HUARACA', 'UMAMARCA'),
(276, '30218', 'APURIMAC', 'ANDAHUAYLAS', 'TURPO', 'TURPO'),
(277, '30219', 'APURIMAC', 'ANDAHUAYLAS', 'KAQUIABAMBA', 'KAQUIABAMBA'),
(278, '30220', 'APURIMAC', 'ANDAHUAYLAS', 'JOSE MARIA ARGUEDAS', 'HUANCABAMBA'),
(279, '30301', 'APURIMAC', 'ANTABAMBA', 'ANTABAMBA', 'ANTABAMBA'),
(280, '30302', 'APURIMAC', 'ANTABAMBA', 'EL ORO', 'AYAHUAY'),
(281, '30303', 'APURIMAC', 'ANTABAMBA', 'HUAQUIRCA', 'HUAQUIRCA'),
(282, '30304', 'APURIMAC', 'ANTABAMBA', 'JUAN ESPINOZA MEDRANO', 'MOLLEBAMBA'),
(283, '30305', 'APURIMAC', 'ANTABAMBA', 'OROPESA', 'OROPESA'),
(284, '30306', 'APURIMAC', 'ANTABAMBA', 'PACHACONAS', 'PACHACONAS'),
(285, '30307', 'APURIMAC', 'ANTABAMBA', 'SABAINO', 'SABAINO'),
(286, '30401', 'APURIMAC', 'AYMARAES', 'CHALHUANCA', 'CHALHUANCA'),
(287, '30402', 'APURIMAC', 'AYMARAES', 'CAPAYA', 'CAPAYA'),
(288, '30403', 'APURIMAC', 'AYMARAES', 'CARAYBAMBA', 'CARAYBAMBA'),
(289, '30404', 'APURIMAC', 'AYMARAES', 'CHAPIMARCA', 'CHAPIMARCA'),
(290, '30405', 'APURIMAC', 'AYMARAES', 'COLCABAMBA', 'COLCABAMBA'),
(291, '30406', 'APURIMAC', 'AYMARAES', 'COTARUSE', 'COTARUSE'),
(292, '30407', 'APURIMAC', 'AYMARAES', 'IHUAYLLO', 'IHUAYLLO'),
(293, '30408', 'APURIMAC', 'AYMARAES', 'JUSTO APU SAHUARAURA', 'PICHIHUA'),
(294, '30409', 'APURIMAC', 'AYMARAES', 'LUCRE', 'LUCRE'),
(295, '30410', 'APURIMAC', 'AYMARAES', 'POCOHUANCA', 'POCOHUANCA'),
(296, '30411', 'APURIMAC', 'AYMARAES', 'SAN JUAN DE CHACÑA', 'SAN JUAN DE CHACÑA'),
(297, '30412', 'APURIMAC', 'AYMARAES', 'SAÑAYCA', 'SAÑAYCA'),
(298, '30413', 'APURIMAC', 'AYMARAES', 'SORAYA', 'SORAYA'),
(299, '30414', 'APURIMAC', 'AYMARAES', 'TAPAIRIHUA', 'TAPAIRIHUA'),
(300, '30415', 'APURIMAC', 'AYMARAES', 'TINTAY', 'TINTAY'),
(301, '30416', 'APURIMAC', 'AYMARAES', 'TORAYA', 'TORAYA'),
(302, '30417', 'APURIMAC', 'AYMARAES', 'YANACA', 'YANACA'),
(303, '30501', 'APURIMAC', 'COTABAMBAS', 'TAMBOBAMBA', 'TAMBOBAMBA'),
(304, '30502', 'APURIMAC', 'COTABAMBAS', 'COTABAMBAS', 'COTABAMBAS'),
(305, '30503', 'APURIMAC', 'COTABAMBAS', 'COYLLURQUI', 'COYLLURQUI'),
(306, '30504', 'APURIMAC', 'COTABAMBAS', 'HAQUIRA', 'HAQUIRA'),
(307, '30505', 'APURIMAC', 'COTABAMBAS', 'MARA', 'MARA'),
(308, '30506', 'APURIMAC', 'COTABAMBAS', 'CHALLHUAHUACHO', 'CHALLHUAHUACHO'),
(309, '30601', 'APURIMAC', 'CHINCHEROS', 'CHINCHEROS', 'CHINCHEROS'),
(310, '30602', 'APURIMAC', 'CHINCHEROS', 'ANCO_HUALLO', 'URIPA'),
(311, '30603', 'APURIMAC', 'CHINCHEROS', 'COCHARCAS', 'COCHARCAS'),
(312, '30604', 'APURIMAC', 'CHINCHEROS', 'HUACCANA', 'HUACCANA'),
(313, '30605', 'APURIMAC', 'CHINCHEROS', 'OCOBAMBA', 'OCOBAMBA'),
(314, '30606', 'APURIMAC', 'CHINCHEROS', 'ONGOY', 'ONGOY'),
(315, '30607', 'APURIMAC', 'CHINCHEROS', 'URANMARCA', 'URANMARCA'),
(316, '30608', 'APURIMAC', 'CHINCHEROS', 'RANRACANCHA', 'RANRACANCHA'),
(317, '30609', 'APURIMAC', 'CHINCHEROS', 'ROCCHACC', 'ROCCHACC'),
(318, '30610', 'APURIMAC', 'CHINCHEROS', 'EL PORVENIR', 'SAN PEDRO HUAMBURQUE'),
(319, '30611', 'APURIMAC', 'CHINCHEROS', 'LOS CHANKAS', 'RIO BLANCO'),
(320, '30701', 'APURIMAC', 'GRAU', 'CHUQUIBAMBILLA', 'CHUQUIBAMBILLA'),
(321, '30702', 'APURIMAC', 'GRAU', 'CURPAHUASI', 'CURPAHUASI'),
(322, '30703', 'APURIMAC', 'GRAU', 'GAMARRA', 'PALPACACHI'),
(323, '30704', 'APURIMAC', 'GRAU', 'HUAYLLATI', 'HUAYLLATI'),
(324, '30705', 'APURIMAC', 'GRAU', 'MAMARA', 'MAMARA'),
(325, '30706', 'APURIMAC', 'GRAU', 'MICAELA BASTIDAS', 'AYRIHUANCA'),
(326, '30707', 'APURIMAC', 'GRAU', 'PATAYPAMPA', 'PATAYPAMPA'),
(327, '30708', 'APURIMAC', 'GRAU', 'PROGRESO', 'PROGRESO'),
(328, '30709', 'APURIMAC', 'GRAU', 'SAN ANTONIO', 'SAN ANTONIO'),
(329, '30710', 'APURIMAC', 'GRAU', 'SANTA ROSA', 'SANTA ROSA'),
(330, '30711', 'APURIMAC', 'GRAU', 'TURPAY', 'TURPAY'),
(331, '30712', 'APURIMAC', 'GRAU', 'VILCABAMBA', 'VILCABAMBA'),
(332, '30713', 'APURIMAC', 'GRAU', 'VIRUNDO', 'SAN JUAN DE VIRUNDO'),
(333, '30714', 'APURIMAC', 'GRAU', 'CURASCO', 'CURASCO'),
(334, '40101', 'AREQUIPA', 'AREQUIPA', 'AREQUIPA', 'AREQUIPA'),
(335, '40102', 'AREQUIPA', 'AREQUIPA', 'ALTO SELVA ALEGRE', 'SELVA ALEGRE'),
(336, '40103', 'AREQUIPA', 'AREQUIPA', 'CAYMA', 'CAYMA'),
(337, '40104', 'AREQUIPA', 'AREQUIPA', 'CERRO COLORADO', 'LA LIBERTAD'),
(338, '40105', 'AREQUIPA', 'AREQUIPA', 'CHARACATO', 'CHARACATO'),
(339, '40106', 'AREQUIPA', 'AREQUIPA', 'CHIGUATA', 'CHIGUATA'),
(340, '40107', 'AREQUIPA', 'AREQUIPA', 'JACOBO HUNTER', 'JACOBO HUNTER'),
(341, '40108', 'AREQUIPA', 'AREQUIPA', 'LA JOYA', 'LA JOYA'),
(342, '40109', 'AREQUIPA', 'AREQUIPA', 'MARIANO MELGAR', 'MARIANO MELGAR'),
(343, '40110', 'AREQUIPA', 'AREQUIPA', 'MIRAFLORES', 'MIRAFLORES'),
(344, '40111', 'AREQUIPA', 'AREQUIPA', 'MOLLEBAYA', 'MOLLEBAYA'),
(345, '40112', 'AREQUIPA', 'AREQUIPA', 'PAUCARPATA', 'PAUCARPATA'),
(346, '40113', 'AREQUIPA', 'AREQUIPA', 'POCSI', 'POCSI'),
(347, '40114', 'AREQUIPA', 'AREQUIPA', 'POLOBAYA', 'POLOBAYA GRANDE'),
(348, '40115', 'AREQUIPA', 'AREQUIPA', 'QUEQUEÑA', 'QUEQUEÑA'),
(349, '40116', 'AREQUIPA', 'AREQUIPA', 'SABANDIA', 'SABANDIA'),
(350, '40117', 'AREQUIPA', 'AREQUIPA', 'SACHACA', 'SACHACA'),
(351, '40118', 'AREQUIPA', 'AREQUIPA', 'SAN JUAN DE SIGUAS', 'SAN JUAN DE SIGUAS /2'),
(352, '40119', 'AREQUIPA', 'AREQUIPA', 'SAN JUAN DE TARUCANI', 'TARUCANI'),
(353, '40120', 'AREQUIPA', 'AREQUIPA', 'SANTA ISABEL DE SIGUAS', 'SANTA ISABEL DE SIGUAS'),
(354, '40121', 'AREQUIPA', 'AREQUIPA', 'SANTA RITA DE SIGUAS', 'SANTA RITA DE SIGUAS'),
(355, '40122', 'AREQUIPA', 'AREQUIPA', 'SOCABAYA', 'SOCABAYA'),
(356, '40123', 'AREQUIPA', 'AREQUIPA', 'TIABAYA', 'TIABAYA'),
(357, '40124', 'AREQUIPA', 'AREQUIPA', 'UCHUMAYO', 'UCHUMAYO'),
(358, '40125', 'AREQUIPA', 'AREQUIPA', 'VITOR', 'VITOR'),
(359, '40126', 'AREQUIPA', 'AREQUIPA', 'YANAHUARA', 'YANAHUARA'),
(360, '40127', 'AREQUIPA', 'AREQUIPA', 'YARABAMBA', 'YARABAMBA'),
(361, '40128', 'AREQUIPA', 'AREQUIPA', 'YURA', 'YURA'),
(362, '40129', 'AREQUIPA', 'AREQUIPA', 'JOSE LUIS BUSTAMANTE Y RIVERO', 'CIUDAD SATELITE'),
(363, '40201', 'AREQUIPA', 'CAMANA', 'CAMANA', 'CAMANA'),
(364, '40202', 'AREQUIPA', 'CAMANA', 'JOSE MARIA QUIMPER', 'EL CARDO'),
(365, '40203', 'AREQUIPA', 'CAMANA', 'MARIANO NICOLAS VALCARCEL', 'URASQUI'),
(366, '40204', 'AREQUIPA', 'CAMANA', 'MARISCAL CACERES', 'SAN JOSE'),
(367, '40205', 'AREQUIPA', 'CAMANA', 'NICOLAS DE PIEROLA', 'SAN GREGORIO'),
(368, '40206', 'AREQUIPA', 'CAMANA', 'OCOÑA', 'OCOÑA'),
(369, '40207', 'AREQUIPA', 'CAMANA', 'QUILCA', 'QUILCA'),
(370, '40208', 'AREQUIPA', 'CAMANA', 'SAMUEL PASTOR', 'LA PAMPA'),
(371, '40301', 'AREQUIPA', 'CARAVELI', 'CARAVELI', 'CARAVELI'),
(372, '40302', 'AREQUIPA', 'CARAVELI', 'ACARI', 'ACARI'),
(373, '40303', 'AREQUIPA', 'CARAVELI', 'ATICO', 'ATICO'),
(374, '40304', 'AREQUIPA', 'CARAVELI', 'ATIQUIPA', 'ATIQUIPA'),
(375, '40305', 'AREQUIPA', 'CARAVELI', 'BELLA UNION', 'BELLA UNION'),
(376, '40306', 'AREQUIPA', 'CARAVELI', 'CAHUACHO', 'CAHUACHO'),
(377, '40307', 'AREQUIPA', 'CARAVELI', 'CHALA', 'CHALA'),
(378, '40308', 'AREQUIPA', 'CARAVELI', 'CHAPARRA', 'ACHANIZO'),
(379, '40309', 'AREQUIPA', 'CARAVELI', 'HUANUHUANU', 'TOCOTA'),
(380, '40310', 'AREQUIPA', 'CARAVELI', 'JAQUI', 'JAQUI'),
(381, '40311', 'AREQUIPA', 'CARAVELI', 'LOMAS', 'LOMAS'),
(382, '40312', 'AREQUIPA', 'CARAVELI', 'QUICACHA', 'QUICACHA'),
(383, '40313', 'AREQUIPA', 'CARAVELI', 'YAUCA', 'YAUCA'),
(384, '40401', 'AREQUIPA', 'CASTILLA', 'APLAO', 'APLAO'),
(385, '40402', 'AREQUIPA', 'CASTILLA', 'ANDAGUA', 'ANDAGUA'),
(386, '40403', 'AREQUIPA', 'CASTILLA', 'AYO', 'AYO'),
(387, '40404', 'AREQUIPA', 'CASTILLA', 'CHACHAS', 'CHACHAS'),
(388, '40405', 'AREQUIPA', 'CASTILLA', 'CHILCAYMARCA', 'CHILCAYMARCA'),
(389, '40406', 'AREQUIPA', 'CASTILLA', 'CHOCO', 'CHOCO'),
(390, '40407', 'AREQUIPA', 'CASTILLA', 'HUANCARQUI', 'HUANCARQUI'),
(391, '40408', 'AREQUIPA', 'CASTILLA', 'MACHAGUAY', 'MACHAGUAY'),
(392, '40409', 'AREQUIPA', 'CASTILLA', 'ORCOPAMPA', 'ORCOPAMPA'),
(393, '40410', 'AREQUIPA', 'CASTILLA', 'PAMPACOLCA', 'PAMPACOLCA'),
(394, '40411', 'AREQUIPA', 'CASTILLA', 'TIPAN', 'TIPAN'),
(395, '40412', 'AREQUIPA', 'CASTILLA', 'UÑON', 'UÑON'),
(396, '40413', 'AREQUIPA', 'CASTILLA', 'URACA', 'CORIRI'),
(397, '40414', 'AREQUIPA', 'CASTILLA', 'VIRACO', 'VIRACO'),
(398, '40501', 'AREQUIPA', 'CAYLLOMA', 'CHIVAY', 'CHIVAY'),
(399, '40502', 'AREQUIPA', 'CAYLLOMA', 'ACHOMA', 'ACHOMA'),
(400, '40503', 'AREQUIPA', 'CAYLLOMA', 'CABANACONDE', 'CABANACONDE'),
(401, '40504', 'AREQUIPA', 'CAYLLOMA', 'CALLALLI', 'CALLALLI'),
(402, '40505', 'AREQUIPA', 'CAYLLOMA', 'CAYLLOMA', 'CAYLLOMA'),
(403, '40506', 'AREQUIPA', 'CAYLLOMA', 'COPORAQUE', 'COPORAQUE'),
(404, '40507', 'AREQUIPA', 'CAYLLOMA', 'HUAMBO', 'HUAMBO'),
(405, '40508', 'AREQUIPA', 'CAYLLOMA', 'HUANCA', 'HUANCA'),
(406, '40509', 'AREQUIPA', 'CAYLLOMA', 'ICHUPAMPA', 'ICHUPAMPA'),
(407, '40510', 'AREQUIPA', 'CAYLLOMA', 'LARI', 'LARI'),
(408, '40511', 'AREQUIPA', 'CAYLLOMA', 'LLUTA', 'LLUTA'),
(409, '40512', 'AREQUIPA', 'CAYLLOMA', 'MACA', 'MACA'),
(410, '40513', 'AREQUIPA', 'CAYLLOMA', 'MADRIGAL', 'MADRIGAL'),
(411, '40514', 'AREQUIPA', 'CAYLLOMA', 'SAN ANTONIO DE CHUCA', 'SAN ANTONIO DE CHUCA /3'),
(412, '40515', 'AREQUIPA', 'CAYLLOMA', 'SIBAYO', 'SIBAYO'),
(413, '40516', 'AREQUIPA', 'CAYLLOMA', 'TAPAY', 'TAPAY'),
(414, '40517', 'AREQUIPA', 'CAYLLOMA', 'TISCO', 'TISCO'),
(415, '40518', 'AREQUIPA', 'CAYLLOMA', 'TUTI', 'TUTI'),
(416, '40519', 'AREQUIPA', 'CAYLLOMA', 'YANQUE', 'YANQUE'),
(417, '40520', 'AREQUIPA', 'CAYLLOMA', 'MAJES', 'EL PEDREGAL'),
(418, '40601', 'AREQUIPA', 'CONDESUYOS', 'CHUQUIBAMBA', 'CHUQUIBAMBA'),
(419, '40602', 'AREQUIPA', 'CONDESUYOS', 'ANDARAY', 'ANDARAY'),
(420, '40603', 'AREQUIPA', 'CONDESUYOS', 'CAYARANI', 'CAYARANI'),
(421, '40604', 'AREQUIPA', 'CONDESUYOS', 'CHICHAS', 'CHICHAS'),
(422, '40605', 'AREQUIPA', 'CONDESUYOS', 'IRAY', 'IRAY'),
(423, '40606', 'AREQUIPA', 'CONDESUYOS', 'RIO GRANDE', 'IQUIPI'),
(424, '40607', 'AREQUIPA', 'CONDESUYOS', 'SALAMANCA', 'SALAMANCA'),
(425, '40608', 'AREQUIPA', 'CONDESUYOS', 'YANAQUIHUA', 'YANAQUIHUA'),
(426, '40701', 'AREQUIPA', 'ISLAY', 'MOLLENDO', 'MOLLENDO'),
(427, '40702', 'AREQUIPA', 'ISLAY', 'COCACHACRA', 'COCACHACRA'),
(428, '40703', 'AREQUIPA', 'ISLAY', 'DEAN VALDIVIA', 'LA CURVA'),
(429, '40704', 'AREQUIPA', 'ISLAY', 'ISLAY', 'ISLAY (MATARANI)'),
(430, '40705', 'AREQUIPA', 'ISLAY', 'MEJIA', 'MEJIA'),
(431, '40706', 'AREQUIPA', 'ISLAY', 'PUNTA DE BOMBON', 'PUNTA DE BOMBON'),
(432, '40801', 'AREQUIPA', 'LA UNION', 'COTAHUASI', 'COTAHUASI'),
(433, '40802', 'AREQUIPA', 'LA UNION', 'ALCA', 'ALCA'),
(434, '40803', 'AREQUIPA', 'LA UNION', 'CHARCANA', 'CHARCANA'),
(435, '40804', 'AREQUIPA', 'LA UNION', 'HUAYNACOTAS', 'TAURISMA'),
(436, '40805', 'AREQUIPA', 'LA UNION', 'PAMPAMARCA', 'MUNGUI'),
(437, '40806', 'AREQUIPA', 'LA UNION', 'PUYCA', 'PUYCA'),
(438, '40807', 'AREQUIPA', 'LA UNION', 'QUECHUALLA', 'VELINGA'),
(439, '40808', 'AREQUIPA', 'LA UNION', 'SAYLA', 'SAYLA'),
(440, '40809', 'AREQUIPA', 'LA UNION', 'TAURIA', 'TAURIA'),
(441, '40810', 'AREQUIPA', 'LA UNION', 'TOMEPAMPA', 'TOMEPAMPA'),
(442, '40811', 'AREQUIPA', 'LA UNION', 'TORO', 'TORO'),
(443, '50101', 'AYACUCHO', 'HUAMANGA', 'AYACUCHO', 'AYACUCHO'),
(444, '50102', 'AYACUCHO', 'HUAMANGA', 'ACOCRO', 'ACOCRO'),
(445, '50103', 'AYACUCHO', 'HUAMANGA', 'ACOS VINCHOS', 'ACOS VINCHOS'),
(446, '50104', 'AYACUCHO', 'HUAMANGA', 'CARMEN ALTO', 'CARMEN ALTO'),
(447, '50105', 'AYACUCHO', 'HUAMANGA', 'CHIARA', 'CHIARA'),
(448, '50106', 'AYACUCHO', 'HUAMANGA', 'OCROS', 'OCROS'),
(449, '50107', 'AYACUCHO', 'HUAMANGA', 'PACAYCASA', 'PACAYCASA'),
(450, '50108', 'AYACUCHO', 'HUAMANGA', 'QUINUA', 'QUINUA'),
(451, '50109', 'AYACUCHO', 'HUAMANGA', 'SAN JOSE DE TICLLAS', 'TICLLAS'),
(452, '50110', 'AYACUCHO', 'HUAMANGA', 'SAN JUAN BAUTISTA', 'SAN JUAN BAUTISTA'),
(453, '50111', 'AYACUCHO', 'HUAMANGA', 'SANTIAGO DE PISCHA', 'SAN PEDRO DE CACHI'),
(454, '50112', 'AYACUCHO', 'HUAMANGA', 'SOCOS', 'SOCOS'),
(455, '50113', 'AYACUCHO', 'HUAMANGA', 'TAMBILLO', 'TAMBILLO'),
(456, '50114', 'AYACUCHO', 'HUAMANGA', 'VINCHOS', 'VINCHOS'),
(457, '50115', 'AYACUCHO', 'HUAMANGA', 'JESUS NAZARENO', 'LAS NAZARENAS'),
(458, '50116', 'AYACUCHO', 'HUAMANGA', 'ANDRES AVELINO CACERES DORREGARAY', 'JARDIN'),
(459, '50201', 'AYACUCHO', 'CANGALLO', 'CANGALLO', 'CANGALLO'),
(460, '50202', 'AYACUCHO', 'CANGALLO', 'CHUSCHI', 'CHUSCHI'),
(461, '50203', 'AYACUCHO', 'CANGALLO', 'LOS MOROCHUCOS', 'PAMPA-CANGALLO'),
(462, '50204', 'AYACUCHO', 'CANGALLO', 'MARIA PARADO DE BELLIDO', 'POMABAMBA'),
(463, '50205', 'AYACUCHO', 'CANGALLO', 'PARAS', 'PARAS'),
(464, '50206', 'AYACUCHO', 'CANGALLO', 'TOTOS', 'TOTOS'),
(465, '50301', 'AYACUCHO', 'HUANCA SANCOS', 'SANCOS', 'HUANCA SANCOS'),
(466, '50302', 'AYACUCHO', 'HUANCA SANCOS', 'CARAPO', 'CARAPO'),
(467, '50303', 'AYACUCHO', 'HUANCA SANCOS', 'SACSAMARCA', 'SACSAMARCA'),
(468, '50304', 'AYACUCHO', 'HUANCA SANCOS', 'SANTIAGO DE LUCANAMARCA', 'SANTIAGO DE LUCANAMARCA'),
(469, '50401', 'AYACUCHO', 'HUANTA', 'HUANTA', 'HUANTA'),
(470, '50402', 'AYACUCHO', 'HUANTA', 'AYAHUANCO', 'VIRACOCHAN'),
(471, '50403', 'AYACUCHO', 'HUANTA', 'HUAMANGUILLA', 'HUAMANGUILLA'),
(472, '50404', 'AYACUCHO', 'HUANTA', 'IGUAIN', 'MACACHACRA'),
(473, '50405', 'AYACUCHO', 'HUANTA', 'LURICOCHA', 'LURICOCHA'),
(474, '50406', 'AYACUCHO', 'HUANTA', 'SANTILLANA', 'SAN JOSE DE SECCE'),
(475, '50407', 'AYACUCHO', 'HUANTA', 'SIVIA', 'SIVIA'),
(476, '50408', 'AYACUCHO', 'HUANTA', 'LLOCHEGUA', 'LLOCHEGUA'),
(477, '50409', 'AYACUCHO', 'HUANTA', 'CANAYRE', 'CANAYRE'),
(478, '50410', 'AYACUCHO', 'HUANTA', 'UCHURACCAY', 'HUAYNACANCHA'),
(479, '50411', 'AYACUCHO', 'HUANTA', 'PUCACOLPA', 'HUALLHUA'),
(480, '50412', 'AYACUCHO', 'HUANTA', 'CHACA', 'CHACA'),
(481, '50501', 'AYACUCHO', 'LA MAR', 'SAN MIGUEL', 'SAN MIGUEL'),
(482, '50502', 'AYACUCHO', 'LA MAR', 'ANCO', 'CHIQUINTIRCA'),
(483, '50503', 'AYACUCHO', 'LA MAR', 'AYNA', 'SAN FRANCISCO'),
(484, '50504', 'AYACUCHO', 'LA MAR', 'CHILCAS', 'CHILCAS'),
(485, '50505', 'AYACUCHO', 'LA MAR', 'CHUNGUI', 'CHUNGUI'),
(486, '50506', 'AYACUCHO', 'LA MAR', 'LUIS CARRANZA', 'PAMPAS'),
(487, '50507', 'AYACUCHO', 'LA MAR', 'SANTA ROSA', 'SANTA ROSA'),
(488, '50508', 'AYACUCHO', 'LA MAR', 'TAMBO', 'TAMBO'),
(489, '50509', 'AYACUCHO', 'LA MAR', 'SAMUGARI', 'PALMAPAMPA'),
(490, '50510', 'AYACUCHO', 'LA MAR', 'ANCHIHUAY', 'ANCHIHUAY'),
(491, '50511', 'AYACUCHO', 'LA MAR', 'ORONCCOY', 'ORONCCOY'),
(492, '50601', 'AYACUCHO', 'LUCANAS', 'PUQUIO', 'PUQUIO'),
(493, '50602', 'AYACUCHO', 'LUCANAS', 'AUCARA', 'AUCARA'),
(494, '50603', 'AYACUCHO', 'LUCANAS', 'CABANA', 'CABANA'),
(495, '50604', 'AYACUCHO', 'LUCANAS', 'CARMEN SALCEDO', 'ANDAMARCA'),
(496, '50605', 'AYACUCHO', 'LUCANAS', 'CHAVIÑA', 'CHAVIÑA'),
(497, '50606', 'AYACUCHO', 'LUCANAS', 'CHIPAO', 'CHIPAO'),
(498, '50607', 'AYACUCHO', 'LUCANAS', 'HUAC-HUAS', 'HUAC-HUAS'),
(499, '50608', 'AYACUCHO', 'LUCANAS', 'LARAMATE', 'LARAMATE'),
(500, '50609', 'AYACUCHO', 'LUCANAS', 'LEONCIO PRADO', 'TAMBO QUEMADO'),
(501, '50610', 'AYACUCHO', 'LUCANAS', 'LLAUTA', 'LLAUTA'),
(502, '50611', 'AYACUCHO', 'LUCANAS', 'LUCANAS', 'LUCANAS'),
(503, '50612', 'AYACUCHO', 'LUCANAS', 'OCAÑA', 'OCAÑA'),
(504, '50613', 'AYACUCHO', 'LUCANAS', 'OTOCA', 'OTOCA'),
(505, '50614', 'AYACUCHO', 'LUCANAS', 'SAISA', 'SAISA'),
(506, '50615', 'AYACUCHO', 'LUCANAS', 'SAN CRISTOBAL', 'SAN CRISTOBAL'),
(507, '50616', 'AYACUCHO', 'LUCANAS', 'SAN JUAN', 'SAN JUAN'),
(508, '50617', 'AYACUCHO', 'LUCANAS', 'SAN PEDRO', 'SAN PEDRO'),
(509, '50618', 'AYACUCHO', 'LUCANAS', 'SAN PEDRO DE PALCO', 'SAN PEDRO DE PALCO'),
(510, '50619', 'AYACUCHO', 'LUCANAS', 'SANCOS', 'SANCOS'),
(511, '50620', 'AYACUCHO', 'LUCANAS', 'SANTA ANA DE HUAYCAHUACHO', 'SANTA ANA DE HUAYCAHUACHO'),
(512, '50621', 'AYACUCHO', 'LUCANAS', 'SANTA LUCIA', 'SANTA LUCIA'),
(513, '50701', 'AYACUCHO', 'PARINACOCHAS', 'CORACORA', 'CORACORA'),
(514, '50702', 'AYACUCHO', 'PARINACOCHAS', 'CHUMPI', 'CHUMPI'),
(515, '50703', 'AYACUCHO', 'PARINACOCHAS', 'CORONEL CASTAÑEDA', 'ANISO'),
(516, '50704', 'AYACUCHO', 'PARINACOCHAS', 'PACAPAUSA', 'PACAPAUSA'),
(517, '50705', 'AYACUCHO', 'PARINACOCHAS', 'PULLO', 'PULLO'),
(518, '50706', 'AYACUCHO', 'PARINACOCHAS', 'PUYUSCA', 'INCUYO'),
(519, '50707', 'AYACUCHO', 'PARINACOCHAS', 'SAN FRANCISCO DE RAVACAYCO', 'SAN FRANCISCO DE RAVACAYCO'),
(520, '50708', 'AYACUCHO', 'PARINACOCHAS', 'UPAHUACHO', 'UPAHUACHO'),
(521, '50801', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'PAUSA', 'PAUSA'),
(522, '50802', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'COLTA', 'COLTA'),
(523, '50803', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'CORCULLA', 'CORCULLA'),
(524, '50804', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'LAMPA', 'LAMPA'),
(525, '50805', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'MARCABAMBA', 'MARCABAMBA'),
(526, '50806', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'OYOLO', 'OYOLO'),
(527, '50807', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'PARARCA', 'PARARCA'),
(528, '50808', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'SAN JAVIER DE ALPABAMBA', 'SAN JAVIER DE ALPABAMBA'),
(529, '50809', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'SAN JOSE DE USHUA', 'SAN JOSE DE USHUA'),
(530, '50810', 'AYACUCHO', 'PAUCAR DEL SARA SARA', 'SARA SARA', 'QUILCATA'),
(531, '50901', 'AYACUCHO', 'SUCRE', 'QUEROBAMBA', 'QUEROBAMBA'),
(532, '50902', 'AYACUCHO', 'SUCRE', 'BELEN', 'BELEN'),
(533, '50903', 'AYACUCHO', 'SUCRE', 'CHALCOS', 'CHALCOS'),
(534, '50904', 'AYACUCHO', 'SUCRE', 'CHILCAYOC', 'CHILCAYOC'),
(535, '50905', 'AYACUCHO', 'SUCRE', 'HUACAÑA', 'HUACAÑA'),
(536, '50906', 'AYACUCHO', 'SUCRE', 'MORCOLLA', 'MORCOLLA'),
(537, '50907', 'AYACUCHO', 'SUCRE', 'PAICO', 'PAICO'),
(538, '50908', 'AYACUCHO', 'SUCRE', 'SAN PEDRO DE LARCAY', 'SAN PEDRO DE LARCAY'),
(539, '50909', 'AYACUCHO', 'SUCRE', 'SAN SALVADOR DE QUIJE', 'SAN SALVADOR DE QUIJE'),
(540, '50910', 'AYACUCHO', 'SUCRE', 'SANTIAGO DE PAUCARAY', 'SANTIAGO DE PAUCARAY'),
(541, '50911', 'AYACUCHO', 'SUCRE', 'SORAS', 'SORAS'),
(542, '51001', 'AYACUCHO', 'VICTOR FAJARDO', 'HUANCAPI', 'HUANCAPI'),
(543, '51002', 'AYACUCHO', 'VICTOR FAJARDO', 'ALCAMENCA', 'ALCAMENCA'),
(544, '51003', 'AYACUCHO', 'VICTOR FAJARDO', 'APONGO', 'APONGO'),
(545, '51004', 'AYACUCHO', 'VICTOR FAJARDO', 'ASQUIPATA', 'ASQUIPATA'),
(546, '51005', 'AYACUCHO', 'VICTOR FAJARDO', 'CANARIA', 'CANARIA'),
(547, '51006', 'AYACUCHO', 'VICTOR FAJARDO', 'CAYARA', 'CAYARA'),
(548, '51007', 'AYACUCHO', 'VICTOR FAJARDO', 'COLCA', 'COLCA'),
(549, '51008', 'AYACUCHO', 'VICTOR FAJARDO', 'HUAMANQUIQUIA', 'HUAMANQUIQUIA'),
(550, '51009', 'AYACUCHO', 'VICTOR FAJARDO', 'HUANCARAYLLA', 'HUANCARAYLLA'),
(551, '51010', 'AYACUCHO', 'VICTOR FAJARDO', 'HUALLA', 'SAN PEDRO DE HUALLA'),
(552, '51011', 'AYACUCHO', 'VICTOR FAJARDO', 'SARHUA', 'SARHUA'),
(553, '51012', 'AYACUCHO', 'VICTOR FAJARDO', 'VILCANCHOS', 'VILCANCHOS'),
(554, '51101', 'AYACUCHO', 'VILCAS HUAMAN', 'VILCAS HUAMAN', 'VILCAS HUAMAN'),
(555, '51102', 'AYACUCHO', 'VILCAS HUAMAN', 'ACCOMARCA', 'ACCOMARCA'),
(556, '51103', 'AYACUCHO', 'VILCAS HUAMAN', 'CARHUANCA', 'CARHUANCA'),
(557, '51104', 'AYACUCHO', 'VILCAS HUAMAN', 'CONCEPCION', 'CONCEPCION'),
(558, '51105', 'AYACUCHO', 'VILCAS HUAMAN', 'HUAMBALPA', 'HUAMBALPA'),
(559, '51106', 'AYACUCHO', 'VILCAS HUAMAN', 'INDEPENDENCIA', 'PACCHA HUALLHUA /4'),
(560, '51107', 'AYACUCHO', 'VILCAS HUAMAN', 'SAURAMA', 'SAURAMA'),
(561, '51108', 'AYACUCHO', 'VILCAS HUAMAN', 'VISCHONGO', 'VISCHONGO'),
(562, '60101', 'CAJAMARCA', 'CAJAMARCA', 'CAJAMARCA', 'CAJAMARCA'),
(563, '60102', 'CAJAMARCA', 'CAJAMARCA', 'ASUNCION', 'ASUNCION'),
(564, '60103', 'CAJAMARCA', 'CAJAMARCA', 'CHETILLA', 'CHETILLA'),
(565, '60104', 'CAJAMARCA', 'CAJAMARCA', 'COSPAN', 'COSPAN'),
(566, '60105', 'CAJAMARCA', 'CAJAMARCA', 'ENCAÑADA', 'ENCAÑADA'),
(567, '60106', 'CAJAMARCA', 'CAJAMARCA', 'JESUS', 'JESUS'),
(568, '60107', 'CAJAMARCA', 'CAJAMARCA', 'LLACANORA', 'LLACANORA'),
(569, '60108', 'CAJAMARCA', 'CAJAMARCA', 'LOS BAÑOS DEL INCA', 'LOS BAÑOS DEL INCA'),
(570, '60109', 'CAJAMARCA', 'CAJAMARCA', 'MAGDALENA', 'MAGDALENA'),
(571, '60110', 'CAJAMARCA', 'CAJAMARCA', 'MATARA', 'MATARA'),
(572, '60111', 'CAJAMARCA', 'CAJAMARCA', 'NAMORA', 'NAMORA'),
(573, '60112', 'CAJAMARCA', 'CAJAMARCA', 'SAN JUAN', 'SAN JUAN'),
(574, '60201', 'CAJAMARCA', 'CAJABAMBA', 'CAJABAMBA', 'CAJABAMBA'),
(575, '60202', 'CAJAMARCA', 'CAJABAMBA', 'CACHACHI', 'CACHACHI'),
(576, '60203', 'CAJAMARCA', 'CAJABAMBA', 'CONDEBAMBA', 'CAUDAY'),
(577, '60204', 'CAJAMARCA', 'CAJABAMBA', 'SITACOCHA', 'LLUCHUBAMBA'),
(578, '60301', 'CAJAMARCA', 'CELENDIN', 'CELENDIN', 'CELENDIN'),
(579, '60302', 'CAJAMARCA', 'CELENDIN', 'CHUMUCH', 'CHUMUCH'),
(580, '60303', 'CAJAMARCA', 'CELENDIN', 'CORTEGANA', 'CHIMUCH (CORTEGANA)'),
(581, '60304', 'CAJAMARCA', 'CELENDIN', 'HUASMIN', 'HUASMIN'),
(582, '60305', 'CAJAMARCA', 'CELENDIN', 'JORGE CHAVEZ', 'LUCMAPAMPA'),
(583, '60306', 'CAJAMARCA', 'CELENDIN', 'JOSE GALVEZ', 'HUACAPAMPA'),
(584, '60307', 'CAJAMARCA', 'CELENDIN', 'MIGUEL IGLESIAS', 'CHALAN'),
(585, '60308', 'CAJAMARCA', 'CELENDIN', 'OXAMARCA', 'OXAMARCA'),
(586, '60309', 'CAJAMARCA', 'CELENDIN', 'SOROCHUCO', 'SOROCHUCO'),
(587, '60310', 'CAJAMARCA', 'CELENDIN', 'SUCRE', 'SUCRE'),
(588, '60311', 'CAJAMARCA', 'CELENDIN', 'UTCO', 'UTCO'),
(589, '60312', 'CAJAMARCA', 'CELENDIN', 'LA LIBERTAD DE PALLAN', 'LA LIBERTAD DE PALLAN'),
(590, '60401', 'CAJAMARCA', 'CHOTA', 'CHOTA', 'CHOTA'),
(591, '60402', 'CAJAMARCA', 'CHOTA', 'ANGUIA', 'ANGUIA'),
(592, '60403', 'CAJAMARCA', 'CHOTA', 'CHADIN', 'CHADIN'),
(593, '60404', 'CAJAMARCA', 'CHOTA', 'CHIGUIRIP', 'CHIGUIRIP'),
(594, '60405', 'CAJAMARCA', 'CHOTA', 'CHIMBAN', 'CHIMBAN'),
(595, '60406', 'CAJAMARCA', 'CHOTA', 'CHOROPAMPA', 'CHOROPAMPA'),
(596, '60407', 'CAJAMARCA', 'CHOTA', 'COCHABAMBA', 'COCHABAMBA'),
(597, '60408', 'CAJAMARCA', 'CHOTA', 'CONCHAN', 'CONCHAN'),
(598, '60409', 'CAJAMARCA', 'CHOTA', 'HUAMBOS', 'HUAMBOS'),
(599, '60410', 'CAJAMARCA', 'CHOTA', 'LAJAS', 'LAJAS'),
(600, '60411', 'CAJAMARCA', 'CHOTA', 'LLAMA', 'LLAMA'),
(601, '60412', 'CAJAMARCA', 'CHOTA', 'MIRACOSTA', 'MIRACOSTA'),
(602, '60413', 'CAJAMARCA', 'CHOTA', 'PACCHA', 'PACCHA'),
(603, '60414', 'CAJAMARCA', 'CHOTA', 'PION', 'PION'),
(604, '60415', 'CAJAMARCA', 'CHOTA', 'QUEROCOTO', 'QUEROCOTO'),
(605, '60416', 'CAJAMARCA', 'CHOTA', 'SAN JUAN DE LICUPIS', 'LICUPIS'),
(606, '60417', 'CAJAMARCA', 'CHOTA', 'TACABAMBA', 'TACABAMBA'),
(607, '60418', 'CAJAMARCA', 'CHOTA', 'TOCMOCHE', 'TOCMOCHE'),
(608, '60419', 'CAJAMARCA', 'CHOTA', 'CHALAMARCA', 'CHALAMARCA'),
(609, '60501', 'CAJAMARCA', 'CONTUMAZA', 'CONTUMAZA', 'CONTUMAZA'),
(610, '60502', 'CAJAMARCA', 'CONTUMAZA', 'CHILETE', 'CHILETE'),
(611, '60503', 'CAJAMARCA', 'CONTUMAZA', 'CUPISNIQUE', 'TRINIDAD'),
(612, '60504', 'CAJAMARCA', 'CONTUMAZA', 'GUZMANGO', 'GUZMANGO'),
(613, '60505', 'CAJAMARCA', 'CONTUMAZA', 'SAN BENITO', 'SAN BENITO'),
(614, '60506', 'CAJAMARCA', 'CONTUMAZA', 'SANTA CRUZ DE TOLED', 'SANTA CRUZ DE TOLED'),
(615, '60507', 'CAJAMARCA', 'CONTUMAZA', 'TANTARICA', 'CATAN'),
(616, '60508', 'CAJAMARCA', 'CONTUMAZA', 'YONAN', 'TEMBLADERA'),
(617, '60601', 'CAJAMARCA', 'CUTERVO', 'CUTERVO', 'CUTERVO'),
(618, '60602', 'CAJAMARCA', 'CUTERVO', 'CALLAYUC', 'CALLAYUC'),
(619, '60603', 'CAJAMARCA', 'CUTERVO', 'CHOROS', 'CHOROS'),
(620, '60604', 'CAJAMARCA', 'CUTERVO', 'CUJILLO', 'CUJILLO'),
(621, '60605', 'CAJAMARCA', 'CUTERVO', 'LA RAMADA', 'LA RAMADA'),
(622, '60606', 'CAJAMARCA', 'CUTERVO', 'PIMPINGOS', 'PIMPINGOS'),
(623, '60607', 'CAJAMARCA', 'CUTERVO', 'QUEROCOTILLO', 'QUEROCOTILLO'),
(624, '60608', 'CAJAMARCA', 'CUTERVO', 'SAN ANDRES DE CUTERVO', 'SAN ANDRES DE CUTERVO'),
(625, '60609', 'CAJAMARCA', 'CUTERVO', 'SAN JUAN DE CUTERVO', 'SAN JUAN DE CUTERVO'),
(626, '60610', 'CAJAMARCA', 'CUTERVO', 'SAN LUIS DE LUCMA', 'SAN LUIS DE LUCMA'),
(627, '60611', 'CAJAMARCA', 'CUTERVO', 'SANTA CRUZ', 'SANTA CRUZ'),
(628, '60612', 'CAJAMARCA', 'CUTERVO', 'SANTO DOMINGO DE LA CAPILLA', 'SANTO DOMINGO DE LA CAPILLA'),
(629, '60613', 'CAJAMARCA', 'CUTERVO', 'SANTO TOMAS', 'SANTO TOMAS'),
(630, '60614', 'CAJAMARCA', 'CUTERVO', 'SOCOTA', 'SOCOTA'),
(631, '60615', 'CAJAMARCA', 'CUTERVO', 'TORIBIO CASANOVA', 'LA SACILIA'),
(632, '60701', 'CAJAMARCA', 'HUALGAYOC', 'BAMBAMARCA', 'BAMBAMARCA'),
(633, '60702', 'CAJAMARCA', 'HUALGAYOC', 'CHUGUR', 'CHUGUR'),
(634, '60703', 'CAJAMARCA', 'HUALGAYOC', 'HUALGAYOC', 'HUALGAYOC'),
(635, '60801', 'CAJAMARCA', 'JAEN', 'JAEN', 'JAEN'),
(636, '60802', 'CAJAMARCA', 'JAEN', 'BELLAVISTA', 'BELLAVISTA'),
(637, '60803', 'CAJAMARCA', 'JAEN', 'CHONTALI', 'CHONTALI'),
(638, '60804', 'CAJAMARCA', 'JAEN', 'COLASAY', 'COLASAY'),
(639, '60805', 'CAJAMARCA', 'JAEN', 'HUABAL', 'HUABAL'),
(640, '60806', 'CAJAMARCA', 'JAEN', 'LAS PIRIAS', 'LAS PIRIAS'),
(641, '60807', 'CAJAMARCA', 'JAEN', 'POMAHUACA', 'POMAHUACA'),
(642, '60808', 'CAJAMARCA', 'JAEN', 'PUCARA', 'PUCARA'),
(643, '60809', 'CAJAMARCA', 'JAEN', 'SALLIQUE', 'SALLIQUE'),
(644, '60810', 'CAJAMARCA', 'JAEN', 'SAN FELIPE', 'SAN FELIPE'),
(645, '60811', 'CAJAMARCA', 'JAEN', 'SAN JOSE DEL ALTO', 'SAN JOSE DEL ALTO'),
(646, '60812', 'CAJAMARCA', 'JAEN', 'SANTA ROSA', 'SANTA ROSA'),
(647, '60901', 'CAJAMARCA', 'SAN IGNACIO', 'SAN IGNACIO', 'SAN IGNACIO'),
(648, '60902', 'CAJAMARCA', 'SAN IGNACIO', 'CHIRINOS', 'CHIRINOS'),
(649, '60903', 'CAJAMARCA', 'SAN IGNACIO', 'HUARANGO', 'HUARANGO'),
(650, '60904', 'CAJAMARCA', 'SAN IGNACIO', 'LA COIPA', 'LA COIPA'),
(651, '60905', 'CAJAMARCA', 'SAN IGNACIO', 'NAMBALLE', 'NAMBALLE'),
(652, '60906', 'CAJAMARCA', 'SAN IGNACIO', 'SAN JOSE DE LOURDES', 'SAN JOSE DE LOURDES'),
(653, '60907', 'CAJAMARCA', 'SAN IGNACIO', 'TABACONAS', 'TABACONAS'),
(654, '61001', 'CAJAMARCA', 'SAN MARCOS', 'PEDRO GALVEZ', 'SAN MARCOS'),
(655, '61002', 'CAJAMARCA', 'SAN MARCOS', 'CHANCAY', 'CHANCAY'),
(656, '61003', 'CAJAMARCA', 'SAN MARCOS', 'EDUARDO VILLANUEVA', 'LA GRAMA'),
(657, '61004', 'CAJAMARCA', 'SAN MARCOS', 'GREGORIO PITA', 'PAUCAMARCA'),
(658, '61005', 'CAJAMARCA', 'SAN MARCOS', 'ICHOCAN', 'ICHOCAN'),
(659, '61006', 'CAJAMARCA', 'SAN MARCOS', 'JOSE MANUEL QUIROZ', 'SHIRAC'),
(660, '61007', 'CAJAMARCA', 'SAN MARCOS', 'JOSE SABOGAL', 'VENECIA'),
(661, '61101', 'CAJAMARCA', 'SAN MIGUEL', 'SAN MIGUEL', 'SAN MIGUEL DE PALLAQUES'),
(662, '61102', 'CAJAMARCA', 'SAN MIGUEL', 'BOLIVAR', 'BOLIVAR'),
(663, '61103', 'CAJAMARCA', 'SAN MIGUEL', 'CALQUIS', 'CALQUIS'),
(664, '61104', 'CAJAMARCA', 'SAN MIGUEL', 'CATILLUC', 'CATILLUC'),
(665, '61105', 'CAJAMARCA', 'SAN MIGUEL', 'EL PRADO', 'EL PRADO'),
(666, '61106', 'CAJAMARCA', 'SAN MIGUEL', 'LA FLORIDA', 'LA FLORIDA'),
(667, '61107', 'CAJAMARCA', 'SAN MIGUEL', 'LLAPA', 'LLAPA'),
(668, '61108', 'CAJAMARCA', 'SAN MIGUEL', 'NANCHOC', 'NANCHOC'),
(669, '61109', 'CAJAMARCA', 'SAN MIGUEL', 'NIEPOS', 'NIEPOS'),
(670, '61110', 'CAJAMARCA', 'SAN MIGUEL', 'SAN GREGORIO', 'SAN GREGORIO'),
(671, '61111', 'CAJAMARCA', 'SAN MIGUEL', 'SAN SILVESTRE DE COCHAN', 'SAN SILVESTRE DE COCHAN'),
(672, '61112', 'CAJAMARCA', 'SAN MIGUEL', 'TONGOD', 'TONGOD'),
(673, '61113', 'CAJAMARCA', 'SAN MIGUEL', 'UNION AGUA BLANCA', 'AGUA BLANCA'),
(674, '61201', 'CAJAMARCA', 'SAN PABLO', 'SAN PABLO', 'SAN PABLO'),
(675, '61202', 'CAJAMARCA', 'SAN PABLO', 'SAN BERNARDINO', 'SAN BERNARDINO'),
(676, '61203', 'CAJAMARCA', 'SAN PABLO', 'SAN LUIS', 'SAN LUIS GRANDE'),
(677, '61204', 'CAJAMARCA', 'SAN PABLO', 'TUMBADEN', 'TUMBADEN'),
(678, '61301', 'CAJAMARCA', 'SANTA CRUZ', 'SANTA CRUZ', 'SANTA CRUZ DE SUCCHABAMBA'),
(679, '61302', 'CAJAMARCA', 'SANTA CRUZ', 'ANDABAMBA', 'ANDABAMBA'),
(680, '61303', 'CAJAMARCA', 'SANTA CRUZ', 'CATACHE', 'CATACHE'),
(681, '61304', 'CAJAMARCA', 'SANTA CRUZ', 'CHANCAYBAÑOS', 'CHANCAYBAÑOS'),
(682, '61305', 'CAJAMARCA', 'SANTA CRUZ', 'LA ESPERANZA', 'LA ESPERANZA'),
(683, '61306', 'CAJAMARCA', 'SANTA CRUZ', 'NINABAMBA', 'NINABAMBA'),
(684, '61307', 'CAJAMARCA', 'SANTA CRUZ', 'PULAN', 'PULAN'),
(685, '61308', 'CAJAMARCA', 'SANTA CRUZ', 'SAUCEPAMPA', 'SAUCEPAMPA'),
(686, '61309', 'CAJAMARCA', 'SANTA CRUZ', 'SEXI', 'SEXI'),
(687, '61310', 'CAJAMARCA', 'SANTA CRUZ', 'UTICYACU', 'UTICYACU'),
(688, '61311', 'CAJAMARCA', 'SANTA CRUZ', 'YAUYUCAN', 'YAUYUCAN'),
(689, '70101', 'CALLAO', 'CALLAO', 'CALLAO', 'CALLAO'),
(690, '70102', 'CALLAO', 'CALLAO', 'BELLAVISTA', 'BELLAVISTA'),
(691, '70103', 'CALLAO', 'CALLAO', 'CARMEN DE LA LEGUA REYNOSO', 'CARMEN DE LA LEGUA REYNOSO'),
(692, '70104', 'CALLAO', 'CALLAO', 'LA PERLA', 'LA PERLA'),
(693, '70105', 'CALLAO', 'CALLAO', 'LA PUNTA', 'LA PUNTA'),
(694, '70106', 'CALLAO', 'CALLAO', 'VENTANILLA', 'VENTANILLA'),
(695, '70107', 'CALLAO', 'CALLAO', 'MI PERU', 'MI PERU'),
(696, '80101', 'CUSCO', 'CUSCO', 'CUSCO', 'CUSCO'),
(697, '80102', 'CUSCO', 'CUSCO', 'CCORCA', 'CCORCA'),
(698, '80103', 'CUSCO', 'CUSCO', 'POROY', 'POROY'),
(699, '80104', 'CUSCO', 'CUSCO', 'SAN JERONIMO', 'SAN JERONIMO'),
(700, '80105', 'CUSCO', 'CUSCO', 'SAN SEBASTIAN', 'SAN SEBASTIAN'),
(701, '80106', 'CUSCO', 'CUSCO', 'SANTIAGO', 'SANTIAGO'),
(702, '80107', 'CUSCO', 'CUSCO', 'SAYLLA', 'SAYLLA'),
(703, '80108', 'CUSCO', 'CUSCO', 'WANCHAQ', 'WANCHAQ'),
(704, '80201', 'CUSCO', 'ACOMAYO', 'ACOMAYO', 'ACOMAYO'),
(705, '80202', 'CUSCO', 'ACOMAYO', 'ACOPIA', 'ACOPIA'),
(706, '80203', 'CUSCO', 'ACOMAYO', 'ACOS', 'ACOS'),
(707, '80204', 'CUSCO', 'ACOMAYO', 'MOSOC LLACTA', 'MOSOC LLACTA'),
(708, '80205', 'CUSCO', 'ACOMAYO', 'POMACANCHI', 'POMACANCHI'),
(709, '80206', 'CUSCO', 'ACOMAYO', 'RONDOCAN', 'RONDOCAN'),
(710, '80207', 'CUSCO', 'ACOMAYO', 'SANGARARA', 'SANGARARA'),
(711, '80301', 'CUSCO', 'ANTA', 'ANTA', 'ANTA'),
(712, '80302', 'CUSCO', 'ANTA', 'ANCAHUASI', 'ANCAHUASI'),
(713, '80303', 'CUSCO', 'ANTA', 'CACHIMAYO', 'CACHIMAYO'),
(714, '80304', 'CUSCO', 'ANTA', 'CHINCHAYPUJIO', 'CHINCHAYPUJIO'),
(715, '80305', 'CUSCO', 'ANTA', 'HUAROCONDO', 'HUAROCONDO'),
(716, '80306', 'CUSCO', 'ANTA', 'LIMATAMBO', 'LIMATAMBO'),
(717, '80307', 'CUSCO', 'ANTA', 'MOLLEPATA', 'MOLLEPATA'),
(718, '80308', 'CUSCO', 'ANTA', 'PUCYURA', 'PUCYURA'),
(719, '80309', 'CUSCO', 'ANTA', 'ZURITE', 'ZURITE'),
(720, '80401', 'CUSCO', 'CALCA', 'CALCA', 'CALCA'),
(721, '80402', 'CUSCO', 'CALCA', 'COYA', 'COYA'),
(722, '80403', 'CUSCO', 'CALCA', 'LAMAY', 'LAMAY'),
(723, '80404', 'CUSCO', 'CALCA', 'LARES', 'LARES'),
(724, '80405', 'CUSCO', 'CALCA', 'PISAC', 'PISAC'),
(725, '80406', 'CUSCO', 'CALCA', 'SAN SALVADOR', 'SAN SALVADOR'),
(726, '80407', 'CUSCO', 'CALCA', 'TARAY', 'TARAY'),
(727, '80408', 'CUSCO', 'CALCA', 'YANATILE', 'QUEBRADA HONDA'),
(728, '80501', 'CUSCO', 'CANAS', 'YANAOCA', 'YANAOCA'),
(729, '80502', 'CUSCO', 'CANAS', 'CHECCA', 'CHECCA'),
(730, '80503', 'CUSCO', 'CANAS', 'KUNTURKANKI', 'EL DESCANSO'),
(731, '80504', 'CUSCO', 'CANAS', 'LANGUI', 'LANGUI'),
(732, '80505', 'CUSCO', 'CANAS', 'LAYO', 'LAYO'),
(733, '80506', 'CUSCO', 'CANAS', 'PAMPAMARCA', 'PAMPAMARCA'),
(734, '80507', 'CUSCO', 'CANAS', 'QUEHUE', 'QUEHUE'),
(735, '80508', 'CUSCO', 'CANAS', 'TUPAC AMARU', 'TUNGASUCA'),
(736, '80601', 'CUSCO', 'CANCHIS', 'SICUANI', 'SICUANI'),
(737, '80602', 'CUSCO', 'CANCHIS', 'CHECACUPE', 'CHECACUPE'),
(738, '80603', 'CUSCO', 'CANCHIS', 'COMBAPATA', 'COMBAPATA'),
(739, '80604', 'CUSCO', 'CANCHIS', 'MARANGANI', 'MARANGANI'),
(740, '80605', 'CUSCO', 'CANCHIS', 'PITUMARCA', 'PITUMARCA'),
(741, '80606', 'CUSCO', 'CANCHIS', 'SAN PABLO', 'SAN PABLO'),
(742, '80607', 'CUSCO', 'CANCHIS', 'SAN PEDRO', 'SAN PEDRO'),
(743, '80608', 'CUSCO', 'CANCHIS', 'TINTA', 'TINTA'),
(744, '80701', 'CUSCO', 'CHUMBIVILCAS', 'SANTO TOMAS', 'SANTO TOMAS'),
(745, '80702', 'CUSCO', 'CHUMBIVILCAS', 'CAPACMARCA', 'CAPACMARCA'),
(746, '80703', 'CUSCO', 'CHUMBIVILCAS', 'CHAMACA', 'CHAMACA'),
(747, '80704', 'CUSCO', 'CHUMBIVILCAS', 'COLQUEMARCA', 'COLQUEMARCA'),
(748, '80705', 'CUSCO', 'CHUMBIVILCAS', 'LIVITACA', 'LIVITACA'),
(749, '80706', 'CUSCO', 'CHUMBIVILCAS', 'LLUSCO', 'LLUSCO'),
(750, '80707', 'CUSCO', 'CHUMBIVILCAS', 'QUIÑOTA', 'QUIÑOTA'),
(751, '80708', 'CUSCO', 'CHUMBIVILCAS', 'VELILLE', 'VELILLE'),
(752, '80801', 'CUSCO', 'ESPINAR', 'ESPINAR', 'YAURI'),
(753, '80802', 'CUSCO', 'ESPINAR', 'CONDOROMA', 'CONDOROMA'),
(754, '80803', 'CUSCO', 'ESPINAR', 'COPORAQUE', 'COPORAQUE'),
(755, '80804', 'CUSCO', 'ESPINAR', 'OCORURO', 'OCORURO'),
(756, '80805', 'CUSCO', 'ESPINAR', 'PALLPATA', 'HECTOR TEJADA'),
(757, '80806', 'CUSCO', 'ESPINAR', 'PICHIGUA', 'PICHIGUA'),
(758, '80807', 'CUSCO', 'ESPINAR', 'SUYCKUTAMBO', 'SUYCKUTAMBO /5'),
(759, '80808', 'CUSCO', 'ESPINAR', 'ALTO PICHIGUA', 'ACCOCUNCA'),
(760, '80901', 'CUSCO', 'LA CONVENCION', 'SANTA ANA', 'QUILLABAMBA'),
(761, '80902', 'CUSCO', 'LA CONVENCION', 'ECHARATE', 'ECHARATE'),
(762, '80903', 'CUSCO', 'LA CONVENCION', 'HUAYOPATA', 'IPAL /6'),
(763, '80904', 'CUSCO', 'LA CONVENCION', 'MARANURA', 'MARANURA'),
(764, '80905', 'CUSCO', 'LA CONVENCION', 'OCOBAMBA', 'OCOBAMBA /7'),
(765, '80906', 'CUSCO', 'LA CONVENCION', 'QUELLOUNO', 'QUELLOUNO'),
(766, '80907', 'CUSCO', 'LA CONVENCION', 'KIMBIRI', 'KIMBIRI'),
(767, '80908', 'CUSCO', 'LA CONVENCION', 'SANTA TERESA', 'SANTA TERESA'),
(768, '80909', 'CUSCO', 'LA CONVENCION', 'VILCABAMBA', 'LUCMA'),
(769, '80910', 'CUSCO', 'LA CONVENCION', 'PICHARI', 'PICHARI'),
(770, '80911', 'CUSCO', 'LA CONVENCION', 'INKAWASI', 'AMAYBAMBA'),
(771, '80912', 'CUSCO', 'LA CONVENCION', 'VILLA VIRGEN', 'VILLA VIRGEN'),
(772, '80913', 'CUSCO', 'LA CONVENCION', 'VILLA KINTIARINA', 'VILLA KINTIARINA'),
(773, '80914', 'CUSCO', 'LA CONVENCION', 'MEGANTONI', 'CAMISEA'),
(774, '81001', 'CUSCO', 'PARURO', 'PARURO', 'PARURO'),
(775, '81002', 'CUSCO', 'PARURO', 'ACCHA', 'ACCHA'),
(776, '81003', 'CUSCO', 'PARURO', 'CCAPI', 'CCAPI'),
(777, '81004', 'CUSCO', 'PARURO', 'COLCHA', 'COLCHA'),
(778, '81005', 'CUSCO', 'PARURO', 'HUANOQUITE', 'HUANOQUITE'),
(779, '81006', 'CUSCO', 'PARURO', 'OMACHA', 'OMACHA'),
(780, '81007', 'CUSCO', 'PARURO', 'PACCARITAMBO', 'PACCARITAMBO'),
(781, '81008', 'CUSCO', 'PARURO', 'PILLPINTO', 'PILLPINTO'),
(782, '81009', 'CUSCO', 'PARURO', 'YAURISQUE', 'YAURISQUE'),
(783, '81101', 'CUSCO', 'PAUCARTAMBO', 'PAUCARTAMBO', 'PAUCARTAMBO'),
(784, '81102', 'CUSCO', 'PAUCARTAMBO', 'CAICAY', 'CAICAY'),
(785, '81103', 'CUSCO', 'PAUCARTAMBO', 'CHALLABAMBA', 'CHALLABAMBA'),
(786, '81104', 'CUSCO', 'PAUCARTAMBO', 'COLQUEPATA', 'COLQUEPATA'),
(787, '81105', 'CUSCO', 'PAUCARTAMBO', 'HUANCARANI', 'HUANCARANI'),
(788, '81106', 'CUSCO', 'PAUCARTAMBO', 'KOSÑIPATA', 'PILLCOPATA'),
(789, '81201', 'CUSCO', 'QUISPICANCHI', 'URCOS', 'URCOS');
INSERT INTO `ubigeo` (`id_ubigeo`, `ubigeo_cod`, `ubigeo_departamento`, `ubigeo_provincia`, `ubigeo_distrito`, `ubigeo_capital`) VALUES
(790, '81202', 'CUSCO', 'QUISPICANCHI', 'ANDAHUAYLILLAS', 'ANDAHUAYLILLAS'),
(791, '81203', 'CUSCO', 'QUISPICANCHI', 'CAMANTI', 'QUINCE MIL'),
(792, '81204', 'CUSCO', 'QUISPICANCHI', 'CCARHUAYO', 'CCARHUAYO'),
(793, '81205', 'CUSCO', 'QUISPICANCHI', 'CCATCA', 'CCATCA'),
(794, '81206', 'CUSCO', 'QUISPICANCHI', 'CUSIPATA', 'CUSIPATA'),
(795, '81207', 'CUSCO', 'QUISPICANCHI', 'HUARO', 'HUARO'),
(796, '81208', 'CUSCO', 'QUISPICANCHI', 'LUCRE', 'LUCRE'),
(797, '81209', 'CUSCO', 'QUISPICANCHI', 'MARCAPATA', 'MARCAPATA'),
(798, '81210', 'CUSCO', 'QUISPICANCHI', 'OCONGATE', 'OCONGATE'),
(799, '81211', 'CUSCO', 'QUISPICANCHI', 'OROPESA', 'OROPESA'),
(800, '81212', 'CUSCO', 'QUISPICANCHI', 'QUIQUIJANA', 'QUIQUIJANA'),
(801, '81301', 'CUSCO', 'URUBAMBA', 'URUBAMBA', 'URUBAMBA'),
(802, '81302', 'CUSCO', 'URUBAMBA', 'CHINCHERO', 'CHINCHERO'),
(803, '81303', 'CUSCO', 'URUBAMBA', 'HUAYLLABAMBA', 'HUAYLLABAMBA'),
(804, '81304', 'CUSCO', 'URUBAMBA', 'MACHUPICCHU', 'MACHUPICCHU'),
(805, '81305', 'CUSCO', 'URUBAMBA', 'MARAS', 'MARAS'),
(806, '81306', 'CUSCO', 'URUBAMBA', 'OLLANTAYTAMBO', 'OLLANTAYTAMBO'),
(807, '81307', 'CUSCO', 'URUBAMBA', 'YUCAY', 'YUCAY'),
(808, '90101', 'HUANCAVELICA', 'HUANCAVELICA', 'HUANCAVELICA', 'HUANCAVELICA'),
(809, '90102', 'HUANCAVELICA', 'HUANCAVELICA', 'ACOBAMBILLA', 'ACOBAMBILLA'),
(810, '90103', 'HUANCAVELICA', 'HUANCAVELICA', 'ACORIA', 'ACORIA'),
(811, '90104', 'HUANCAVELICA', 'HUANCAVELICA', 'CONAYCA', 'CONAYCA'),
(812, '90105', 'HUANCAVELICA', 'HUANCAVELICA', 'CUENCA', 'CUENCA'),
(813, '90106', 'HUANCAVELICA', 'HUANCAVELICA', 'HUACHOCOLPA', 'HUACHOCOLPA'),
(814, '90107', 'HUANCAVELICA', 'HUANCAVELICA', 'HUAYLLAHUARA', 'HUAYLLAHUARA'),
(815, '90108', 'HUANCAVELICA', 'HUANCAVELICA', 'IZCUCHACA', 'IZCUCHACA'),
(816, '90109', 'HUANCAVELICA', 'HUANCAVELICA', 'LARIA', 'LARIA'),
(817, '90110', 'HUANCAVELICA', 'HUANCAVELICA', 'MANTA', 'MANTA'),
(818, '90111', 'HUANCAVELICA', 'HUANCAVELICA', 'MARISCAL CACERES', 'MARISCAL CACERES'),
(819, '90112', 'HUANCAVELICA', 'HUANCAVELICA', 'MOYA', 'MOYA'),
(820, '90113', 'HUANCAVELICA', 'HUANCAVELICA', 'NUEVO OCCORO', 'OCCORO'),
(821, '90114', 'HUANCAVELICA', 'HUANCAVELICA', 'PALCA', 'PALCA'),
(822, '90115', 'HUANCAVELICA', 'HUANCAVELICA', 'PILCHACA', 'PILCHACA'),
(823, '90116', 'HUANCAVELICA', 'HUANCAVELICA', 'VILCA', 'VILCA'),
(824, '90117', 'HUANCAVELICA', 'HUANCAVELICA', 'YAULI', 'YAULI'),
(825, '90118', 'HUANCAVELICA', 'HUANCAVELICA', 'ASCENSION', 'ASCENSION'),
(826, '90119', 'HUANCAVELICA', 'HUANCAVELICA', 'HUANDO', 'HUANDO'),
(827, '90201', 'HUANCAVELICA', 'ACOBAMBA', 'ACOBAMBA', 'ACOBAMBA'),
(828, '90202', 'HUANCAVELICA', 'ACOBAMBA', 'ANDABAMBA', 'ANDABAMBA'),
(829, '90203', 'HUANCAVELICA', 'ACOBAMBA', 'ANTA', 'ANTA'),
(830, '90204', 'HUANCAVELICA', 'ACOBAMBA', 'CAJA', 'CAJA'),
(831, '90205', 'HUANCAVELICA', 'ACOBAMBA', 'MARCAS', 'MARCAS'),
(832, '90206', 'HUANCAVELICA', 'ACOBAMBA', 'PAUCARA', 'PAUCARA'),
(833, '90207', 'HUANCAVELICA', 'ACOBAMBA', 'POMACOCHA', 'POMACOCHA'),
(834, '90208', 'HUANCAVELICA', 'ACOBAMBA', 'ROSARIO', 'ROSARIO'),
(835, '90301', 'HUANCAVELICA', 'ANGARAES', 'LIRCAY', 'LIRCAY'),
(836, '90302', 'HUANCAVELICA', 'ANGARAES', 'ANCHONGA', 'ANCHONGA'),
(837, '90303', 'HUANCAVELICA', 'ANGARAES', 'CALLANMARCA', 'CALLANMARCA'),
(838, '90304', 'HUANCAVELICA', 'ANGARAES', 'CCOCHACCASA', 'CCOCHACCASA'),
(839, '90305', 'HUANCAVELICA', 'ANGARAES', 'CHINCHO', 'CHINCHO'),
(840, '90306', 'HUANCAVELICA', 'ANGARAES', 'CONGALLA', 'CONGALLA'),
(841, '90307', 'HUANCAVELICA', 'ANGARAES', 'HUANCA-HUANCA', 'HUANCA-HUANCA'),
(842, '90308', 'HUANCAVELICA', 'ANGARAES', 'HUAYLLAY GRANDE', 'HUAYLLAY GRANDE'),
(843, '90309', 'HUANCAVELICA', 'ANGARAES', 'JULCAMARCA', 'JULCAMARCA'),
(844, '90310', 'HUANCAVELICA', 'ANGARAES', 'SAN ANTONIO DE ANTAPARCO', 'ANTAPARCO'),
(845, '90311', 'HUANCAVELICA', 'ANGARAES', 'SANTO TOMAS DE PATA', 'SANTO TOMAS DE PATA'),
(846, '90312', 'HUANCAVELICA', 'ANGARAES', 'SECCLLA', 'SECCLLA'),
(847, '90401', 'HUANCAVELICA', 'CASTROVIRREYNA', 'CASTROVIRREYNA', 'CASTROVIRREYNA'),
(848, '90402', 'HUANCAVELICA', 'CASTROVIRREYNA', 'ARMA', 'ARMA'),
(849, '90403', 'HUANCAVELICA', 'CASTROVIRREYNA', 'AURAHUA', 'AURAHUA'),
(850, '90404', 'HUANCAVELICA', 'CASTROVIRREYNA', 'CAPILLAS', 'CAPILLAS'),
(851, '90405', 'HUANCAVELICA', 'CASTROVIRREYNA', 'CHUPAMARCA', 'CHUPAMARCA'),
(852, '90406', 'HUANCAVELICA', 'CASTROVIRREYNA', 'COCAS', 'COCAS'),
(853, '90407', 'HUANCAVELICA', 'CASTROVIRREYNA', 'HUACHOS', 'HUACHOS'),
(854, '90408', 'HUANCAVELICA', 'CASTROVIRREYNA', 'HUAMATAMBO', 'HUAMATAMBO'),
(855, '90409', 'HUANCAVELICA', 'CASTROVIRREYNA', 'MOLLEPAMPA', 'MOLLEPAMPA'),
(856, '90410', 'HUANCAVELICA', 'CASTROVIRREYNA', 'SAN JUAN', 'SAN JUAN'),
(857, '90411', 'HUANCAVELICA', 'CASTROVIRREYNA', 'SANTA ANA', 'SANTA ANA'),
(858, '90412', 'HUANCAVELICA', 'CASTROVIRREYNA', 'TANTARA', 'TANTARA'),
(859, '90413', 'HUANCAVELICA', 'CASTROVIRREYNA', 'TICRAPO', 'TICRAPO'),
(860, '90501', 'HUANCAVELICA', 'CHURCAMPA', 'CHURCAMPA', 'CHURCAMPA'),
(861, '90502', 'HUANCAVELICA', 'CHURCAMPA', 'ANCO', 'LA ESMERALDA'),
(862, '90503', 'HUANCAVELICA', 'CHURCAMPA', 'CHINCHIHUASI', 'CHINCHIHUASI'),
(863, '90504', 'HUANCAVELICA', 'CHURCAMPA', 'EL CARMEN', 'PAUCARBAMBILLA'),
(864, '90505', 'HUANCAVELICA', 'CHURCAMPA', 'LA MERCED', 'LA MERCED'),
(865, '90506', 'HUANCAVELICA', 'CHURCAMPA', 'LOCROJA', 'LOCROJA'),
(866, '90507', 'HUANCAVELICA', 'CHURCAMPA', 'PAUCARBAMBA', 'PAUCARBAMBA'),
(867, '90508', 'HUANCAVELICA', 'CHURCAMPA', 'SAN MIGUEL DE MAYOCC', 'MAYOCC'),
(868, '90509', 'HUANCAVELICA', 'CHURCAMPA', 'SAN PEDRO DE CORIS', 'SAN PEDRO DE CORIS'),
(869, '90510', 'HUANCAVELICA', 'CHURCAMPA', 'PACHAMARCA', 'PACHAMARCA'),
(870, '90511', 'HUANCAVELICA', 'CHURCAMPA', 'COSME', 'SANTA CLARA DE COSME'),
(871, '90601', 'HUANCAVELICA', 'HUAYTARA', 'HUAYTARA', 'HUAYTARA'),
(872, '90602', 'HUANCAVELICA', 'HUAYTARA', 'AYAVI', 'AYAVI'),
(873, '90603', 'HUANCAVELICA', 'HUAYTARA', 'CORDOVA', 'CORDOVA'),
(874, '90604', 'HUANCAVELICA', 'HUAYTARA', 'HUAYACUNDO ARMA', 'HUAYACUNDO ARMA'),
(875, '90605', 'HUANCAVELICA', 'HUAYTARA', 'LARAMARCA', 'LARAMARCA'),
(876, '90606', 'HUANCAVELICA', 'HUAYTARA', 'OCOYO', 'OCOYO'),
(877, '90607', 'HUANCAVELICA', 'HUAYTARA', 'PILPICHACA', 'PILPICHACA'),
(878, '90608', 'HUANCAVELICA', 'HUAYTARA', 'QUERCO', 'QUERCO'),
(879, '90609', 'HUANCAVELICA', 'HUAYTARA', 'QUITO-ARMA', 'QUITO-ARMA'),
(880, '90610', 'HUANCAVELICA', 'HUAYTARA', 'SAN ANTONIO DE CUSICANCHA', 'CUSICANCHA'),
(881, '90611', 'HUANCAVELICA', 'HUAYTARA', 'SAN FRANCISCO DE SANGAYAICO', 'SAN FRANCISCO DE SANGAYAICO'),
(882, '90612', 'HUANCAVELICA', 'HUAYTARA', 'SAN ISIDRO', 'SAN JUAN DE HUIRPACANCHA'),
(883, '90613', 'HUANCAVELICA', 'HUAYTARA', 'SANTIAGO DE CHOCORVOS', 'SANTIAGO DE CHOCORVOS'),
(884, '90614', 'HUANCAVELICA', 'HUAYTARA', 'SANTIAGO DE QUIRAHUARA', 'SANTIAGO DE QUIRAHUARA'),
(885, '90615', 'HUANCAVELICA', 'HUAYTARA', 'SANTO DOMINGO DE CAPILLAS', 'SANTO DOMINGO DE CAPILLAS'),
(886, '90616', 'HUANCAVELICA', 'HUAYTARA', 'TAMBO', 'TAMBO'),
(887, '90701', 'HUANCAVELICA', 'TAYACAJA', 'PAMPAS', 'PAMPAS'),
(888, '90702', 'HUANCAVELICA', 'TAYACAJA', 'ACOSTAMBO', 'ACOSTAMBO'),
(889, '90703', 'HUANCAVELICA', 'TAYACAJA', 'ACRAQUIA', 'ACRAQUIA'),
(890, '90704', 'HUANCAVELICA', 'TAYACAJA', 'AHUAYCHA', 'AHUAYCHA'),
(891, '90705', 'HUANCAVELICA', 'TAYACAJA', 'COLCABAMBA', 'COLCABAMBA'),
(892, '90706', 'HUANCAVELICA', 'TAYACAJA', 'DANIEL HERNANDEZ', 'MARISCAL CACERES'),
(893, '90707', 'HUANCAVELICA', 'TAYACAJA', 'HUACHOCOLPA', 'HUACHOCOLPA'),
(894, '90709', 'HUANCAVELICA', 'TAYACAJA', 'HUARIBAMBA', 'HUARIBAMBA'),
(895, '90710', 'HUANCAVELICA', 'TAYACAJA', 'ÑAHUIMPUQUIO', 'ÑAHUIMPUQUIO'),
(896, '90711', 'HUANCAVELICA', 'TAYACAJA', 'PAZOS', 'PAZOS'),
(897, '90713', 'HUANCAVELICA', 'TAYACAJA', 'QUISHUAR', 'QUISHUAR'),
(898, '90714', 'HUANCAVELICA', 'TAYACAJA', 'SALCABAMBA', 'SALCABAMBA'),
(899, '90715', 'HUANCAVELICA', 'TAYACAJA', 'SALCAHUASI', 'SALCAHUASI'),
(900, '90716', 'HUANCAVELICA', 'TAYACAJA', 'SAN MARCOS DE ROCCHAC', 'SAN MARCOS DE ROCCHAC'),
(901, '90717', 'HUANCAVELICA', 'TAYACAJA', 'SURCUBAMBA', 'SURCUBAMBA'),
(902, '90718', 'HUANCAVELICA', 'TAYACAJA', 'TINTAY PUNCU', 'TINTAY'),
(903, '90719', 'HUANCAVELICA', 'TAYACAJA', 'QUICHUAS', 'QUICHUAS'),
(904, '90720', 'HUANCAVELICA', 'TAYACAJA', 'ANDAYMARCA', 'ANDAYMARCA'),
(905, '90721', 'HUANCAVELICA', 'TAYACAJA', 'ROBLE', 'PUERTO SAN ANTONIO'),
(906, '90722', 'HUANCAVELICA', 'TAYACAJA', 'PICHOS', 'PICHOS'),
(907, '90723', 'HUANCAVELICA', 'TAYACAJA', 'SANTIAGO DE TUCUMA', 'SANTIAGO DE TUCUMA'),
(908, '100101', 'HUANUCO', 'HUANUCO', 'HUANUCO', 'HUANUCO'),
(909, '100102', 'HUANUCO', 'HUANUCO', 'AMARILIS', 'PAUCARBAMBA'),
(910, '100103', 'HUANUCO', 'HUANUCO', 'CHINCHAO', 'ACOMAYO'),
(911, '100104', 'HUANUCO', 'HUANUCO', 'CHURUBAMBA', 'CHURUBAMBA'),
(912, '100105', 'HUANUCO', 'HUANUCO', 'MARGOS', 'MARGOS'),
(913, '100106', 'HUANUCO', 'HUANUCO', 'QUISQUI (KICHKI)', 'HUANCAPALLAC'),
(914, '100107', 'HUANUCO', 'HUANUCO', 'SAN FRANCISCO DE CAYRAN', 'CAYRAN'),
(915, '100108', 'HUANUCO', 'HUANUCO', 'SAN PEDRO DE CHAULAN', 'CHAULAN'),
(916, '100109', 'HUANUCO', 'HUANUCO', 'SANTA MARIA DEL VALLE', 'SANTA MARIA DEL VALLE'),
(917, '100110', 'HUANUCO', 'HUANUCO', 'YARUMAYO', 'YARUMAYO'),
(918, '100111', 'HUANUCO', 'HUANUCO', 'PILLCO MARCA', 'CAYHUAYNA'),
(919, '100112', 'HUANUCO', 'HUANUCO', 'YACUS', 'YACUS'),
(920, '100113', 'HUANUCO', 'HUANUCO', 'SAN PABLO DE PILLAO', 'SAN PABLO DE PILLAO'),
(921, '100201', 'HUANUCO', 'AMBO', 'AMBO', 'AMBO'),
(922, '100202', 'HUANUCO', 'AMBO', 'CAYNA', 'CAYNA'),
(923, '100203', 'HUANUCO', 'AMBO', 'COLPAS', 'COLPAS'),
(924, '100204', 'HUANUCO', 'AMBO', 'CONCHAMARCA', 'CONCHAMARCA'),
(925, '100205', 'HUANUCO', 'AMBO', 'HUACAR', 'HUACAR'),
(926, '100206', 'HUANUCO', 'AMBO', 'SAN FRANCISCO', 'MOSCA'),
(927, '100207', 'HUANUCO', 'AMBO', 'SAN RAFAEL', 'SAN RAFAEL'),
(928, '100208', 'HUANUCO', 'AMBO', 'TOMAY KICHWA', 'TOMAY KICHWA'),
(929, '100301', 'HUANUCO', 'DOS DE MAYO', 'LA UNION', 'LA UNION'),
(930, '100307', 'HUANUCO', 'DOS DE MAYO', 'CHUQUIS', 'CHUQUIS'),
(931, '100311', 'HUANUCO', 'DOS DE MAYO', 'MARIAS', 'MARIAS'),
(932, '100313', 'HUANUCO', 'DOS DE MAYO', 'PACHAS', 'PACHAS'),
(933, '100316', 'HUANUCO', 'DOS DE MAYO', 'QUIVILLA', 'QUIVILLA'),
(934, '100317', 'HUANUCO', 'DOS DE MAYO', 'RIPAN', 'RIPAN'),
(935, '100321', 'HUANUCO', 'DOS DE MAYO', 'SHUNQUI', 'SHUNQUI'),
(936, '100322', 'HUANUCO', 'DOS DE MAYO', 'SILLAPATA', 'SILLAPATA'),
(937, '100323', 'HUANUCO', 'DOS DE MAYO', 'YANAS', 'YANAS'),
(938, '100401', 'HUANUCO', 'HUACAYBAMBA', 'HUACAYBAMBA', 'HUACAYBAMBA'),
(939, '100402', 'HUANUCO', 'HUACAYBAMBA', 'CANCHABAMBA', 'CANCHABAMBA'),
(940, '100403', 'HUANUCO', 'HUACAYBAMBA', 'COCHABAMBA', 'COCHABAMBA'),
(941, '100404', 'HUANUCO', 'HUACAYBAMBA', 'PINRA', 'PINRA'),
(942, '100501', 'HUANUCO', 'HUAMALIES', 'LLATA', 'LLATA'),
(943, '100502', 'HUANUCO', 'HUAMALIES', 'ARANCAY', 'ARANCAY'),
(944, '100503', 'HUANUCO', 'HUAMALIES', 'CHAVIN DE PARIARCA', 'CHAVIN DE PARIARCA'),
(945, '100504', 'HUANUCO', 'HUAMALIES', 'JACAS GRANDE', 'JACAS GRANDE'),
(946, '100505', 'HUANUCO', 'HUAMALIES', 'JIRCAN', 'JIRCAN'),
(947, '100506', 'HUANUCO', 'HUAMALIES', 'MIRAFLORES', 'MIRAFLORES'),
(948, '100507', 'HUANUCO', 'HUAMALIES', 'MONZON', 'MONZON'),
(949, '100508', 'HUANUCO', 'HUAMALIES', 'PUNCHAO', 'PUNCHAO'),
(950, '100509', 'HUANUCO', 'HUAMALIES', 'PUÑOS', 'PUÑOS'),
(951, '100510', 'HUANUCO', 'HUAMALIES', 'SINGA', 'SINGA'),
(952, '100511', 'HUANUCO', 'HUAMALIES', 'TANTAMAYO', 'TANTAMAYO'),
(953, '100601', 'HUANUCO', 'LEONCIO PRADO', 'RUPA-RUPA', 'TINGO MARIA'),
(954, '100602', 'HUANUCO', 'LEONCIO PRADO', 'DANIEL ALOMIA ROBLES', 'DANIEL ALOMIA ROBLES'),
(955, '100603', 'HUANUCO', 'LEONCIO PRADO', 'HERMILIO VALDIZAN', 'HERMILIO VALDIZAN'),
(956, '100604', 'HUANUCO', 'LEONCIO PRADO', 'JOSE CRESPO Y CASTILLO', 'AUCAYACU'),
(957, '100605', 'HUANUCO', 'LEONCIO PRADO', 'LUYANDO', 'LUYANDO /8'),
(958, '100606', 'HUANUCO', 'LEONCIO PRADO', 'MARIANO DAMASO BERAUN', 'LAS PALMAS'),
(959, '100607', 'HUANUCO', 'LEONCIO PRADO', 'PUCAYACU', 'PUCAYACU'),
(960, '100608', 'HUANUCO', 'LEONCIO PRADO', 'CASTILLO GRANDE', 'CASTILLO GRANDE'),
(961, '100609', 'HUANUCO', 'LEONCIO PRADO', 'PUEBLO NUEVO', 'PUEBLO NUEVO'),
(962, '100610', 'HUANUCO', 'LEONCIO PRADO', 'SANTO DOMINGO DE ANDIA', 'PACAE'),
(963, '100701', 'HUANUCO', 'MARAÑON', 'HUACRACHUCO', 'HUACRACHUCO'),
(964, '100702', 'HUANUCO', 'MARAÑON', 'CHOLON', 'SAN PEDRO DE CHONTA'),
(965, '100703', 'HUANUCO', 'MARAÑON', 'SAN BUENAVENTURA', 'SAN BUENAVENTURA'),
(966, '100704', 'HUANUCO', 'MARAÑON', 'LA MORADA', 'LA MORADA'),
(967, '100705', 'HUANUCO', 'MARAÑON', 'SANTA ROSA DE ALTO YANAJANCA', 'SANTA ROSA DE ALTO YANAJANCA'),
(968, '100801', 'HUANUCO', 'PACHITEA', 'PANAO', 'PANAO'),
(969, '100802', 'HUANUCO', 'PACHITEA', 'CHAGLLA', 'CHAGLLA'),
(970, '100803', 'HUANUCO', 'PACHITEA', 'MOLINO', 'MOLINO'),
(971, '100804', 'HUANUCO', 'PACHITEA', 'UMARI', 'UMARI (TAMBILLO)'),
(972, '100901', 'HUANUCO', 'PUERTO INCA', 'PUERTO INCA', 'PUERTO INCA'),
(973, '100902', 'HUANUCO', 'PUERTO INCA', 'CODO DEL POZUZO', 'CODO DEL POZUZO'),
(974, '100903', 'HUANUCO', 'PUERTO INCA', 'HONORIA', 'HONORIA'),
(975, '100904', 'HUANUCO', 'PUERTO INCA', 'TOURNAVISTA', 'TOURNAVISTA'),
(976, '100905', 'HUANUCO', 'PUERTO INCA', 'YUYAPICHIS', 'YUYAPICHIS'),
(977, '101001', 'HUANUCO', 'LAURICOCHA', 'JESUS', 'JESUS'),
(978, '101002', 'HUANUCO', 'LAURICOCHA', 'BAÑOS', 'BAÑOS'),
(979, '101003', 'HUANUCO', 'LAURICOCHA', 'JIVIA', 'JIVIA'),
(980, '101004', 'HUANUCO', 'LAURICOCHA', 'QUEROPALCA', 'QUEROPALCA'),
(981, '101005', 'HUANUCO', 'LAURICOCHA', 'RONDOS', 'RONDOS'),
(982, '101006', 'HUANUCO', 'LAURICOCHA', 'SAN FRANCISCO DE ASIS', 'HUARIN'),
(983, '101007', 'HUANUCO', 'LAURICOCHA', 'SAN MIGUEL DE CAURI', 'CAURI'),
(984, '101101', 'HUANUCO', 'YAROWILCA', 'CHAVINILLO', 'CHAVINILLO'),
(985, '101102', 'HUANUCO', 'YAROWILCA', 'CAHUAC', 'CAHUAC'),
(986, '101103', 'HUANUCO', 'YAROWILCA', 'CHACABAMBA', 'CHACABAMBA'),
(987, '101104', 'HUANUCO', 'YAROWILCA', 'APARICIO POMARES', 'CHUPAN'),
(988, '101105', 'HUANUCO', 'YAROWILCA', 'JACAS CHICO', 'SAN CRISTOBAL DE JACAS CHICO'),
(989, '101106', 'HUANUCO', 'YAROWILCA', 'OBAS', 'OBAS'),
(990, '101107', 'HUANUCO', 'YAROWILCA', 'PAMPAMARCA', 'PAMPAMARCA'),
(991, '101108', 'HUANUCO', 'YAROWILCA', 'CHORAS', 'CHORAS'),
(992, '110101', 'ICA', 'ICA', 'ICA', 'ICA'),
(993, '110102', 'ICA', 'ICA', 'LA TINGUIÑA', 'LA TINGUIÑA'),
(994, '110103', 'ICA', 'ICA', 'LOS AQUIJES', 'LOS AQUIJES'),
(995, '110104', 'ICA', 'ICA', 'OCUCAJE', 'OCUCAJE'),
(996, '110105', 'ICA', 'ICA', 'PACHACUTEC', 'PAMPA DE TATE'),
(997, '110106', 'ICA', 'ICA', 'PARCONA', 'PARCONA'),
(998, '110107', 'ICA', 'ICA', 'PUEBLO NUEVO', 'PUEBLO NUEVO'),
(999, '110108', 'ICA', 'ICA', 'SALAS', 'GUADALUPE'),
(1000, '110109', 'ICA', 'ICA', 'SAN JOSE DE LOS MOLINOS', 'SAN JOSE DE LOS MOLINOS'),
(1001, '110110', 'ICA', 'ICA', 'SAN JUAN BAUTISTA', 'SAN JUAN BAUTISTA'),
(1002, '110111', 'ICA', 'ICA', 'SANTIAGO', 'SANTIAGO'),
(1003, '110112', 'ICA', 'ICA', 'SUBTANJALLA', 'SUBTANJALLA'),
(1004, '110113', 'ICA', 'ICA', 'TATE', 'TATE DE LA CAPILLA'),
(1005, '110114', 'ICA', 'ICA', 'YAUCA DEL ROSARIO', 'CURIS /9'),
(1006, '110201', 'ICA', 'CHINCHA', 'CHINCHA ALTA', 'CHINCHA ALTA'),
(1007, '110202', 'ICA', 'CHINCHA', 'ALTO LARAN', 'ALTO LARAN'),
(1008, '110203', 'ICA', 'CHINCHA', 'CHAVIN', 'CHAVIN'),
(1009, '110204', 'ICA', 'CHINCHA', 'CHINCHA BAJA', 'CHINCHA BAJA'),
(1010, '110205', 'ICA', 'CHINCHA', 'EL CARMEN', 'EL CARMEN'),
(1011, '110206', 'ICA', 'CHINCHA', 'GROCIO PRADO', 'SAN PEDRO'),
(1012, '110207', 'ICA', 'CHINCHA', 'PUEBLO NUEVO', 'PUEBLO NUEVO'),
(1013, '110208', 'ICA', 'CHINCHA', 'SAN JUAN DE YANAC', 'SAN JUAN DE YANAC'),
(1014, '110209', 'ICA', 'CHINCHA', 'SAN PEDRO DE HUACARPANA', 'SAN PEDRO DE HUACARPANA'),
(1015, '110210', 'ICA', 'CHINCHA', 'SUNAMPE', 'SUNAMPE'),
(1016, '110211', 'ICA', 'CHINCHA', 'TAMBO DE MORA', 'TAMBO DE MORA'),
(1017, '110301', 'ICA', 'NASCA', 'NASCA', 'NASCA'),
(1018, '110302', 'ICA', 'NASCA', 'CHANGUILLO', 'CHANGUILLO'),
(1019, '110303', 'ICA', 'NASCA', 'EL INGENIO', 'EL INGENIO'),
(1020, '110304', 'ICA', 'NASCA', 'MARCONA', 'SAN JUAN'),
(1021, '110305', 'ICA', 'NASCA', 'VISTA ALEGRE', 'VISTA ALEGRE'),
(1022, '110401', 'ICA', 'PALPA', 'PALPA', 'PALPA'),
(1023, '110402', 'ICA', 'PALPA', 'LLIPATA', 'LLIPATA'),
(1024, '110403', 'ICA', 'PALPA', 'RIO GRANDE', 'RIO GRANDE'),
(1025, '110404', 'ICA', 'PALPA', 'SANTA CRUZ', 'SANTA CRUZ'),
(1026, '110405', 'ICA', 'PALPA', 'TIBILLO', 'TIBILLO'),
(1027, '110501', 'ICA', 'PISCO', 'PISCO', 'PISCO'),
(1028, '110502', 'ICA', 'PISCO', 'HUANCANO', 'HUANCANO'),
(1029, '110503', 'ICA', 'PISCO', 'HUMAY', 'HUMAY'),
(1030, '110504', 'ICA', 'PISCO', 'INDEPENDENCIA', 'INDEPENDENCIA'),
(1031, '110505', 'ICA', 'PISCO', 'PARACAS', 'PARACAS'),
(1032, '110506', 'ICA', 'PISCO', 'SAN ANDRES', 'SAN ANDRES'),
(1033, '110507', 'ICA', 'PISCO', 'SAN CLEMENTE', 'SAN CLEMENTE'),
(1034, '110508', 'ICA', 'PISCO', 'TUPAC AMARU INCA', 'TUPAC AMARU'),
(1035, '120101', 'JUNIN', 'HUANCAYO', 'HUANCAYO', 'HUANCAYO'),
(1036, '120104', 'JUNIN', 'HUANCAYO', 'CARHUACALLANGA', 'CARHUACALLANGA'),
(1037, '120105', 'JUNIN', 'HUANCAYO', 'CHACAPAMPA', 'CHACAPAMPA'),
(1038, '120106', 'JUNIN', 'HUANCAYO', 'CHICCHE', 'CHICCHE'),
(1039, '120107', 'JUNIN', 'HUANCAYO', 'CHILCA', 'CHILCA'),
(1040, '120108', 'JUNIN', 'HUANCAYO', 'CHONGOS ALTO', 'CHONGOS ALTO'),
(1041, '120111', 'JUNIN', 'HUANCAYO', 'CHUPURO', 'CHUPURO'),
(1042, '120112', 'JUNIN', 'HUANCAYO', 'COLCA', 'COLCA'),
(1043, '120113', 'JUNIN', 'HUANCAYO', 'CULLHUAS', 'CULLHUAS'),
(1044, '120114', 'JUNIN', 'HUANCAYO', 'EL TAMBO', 'EL TAMBO'),
(1045, '120116', 'JUNIN', 'HUANCAYO', 'HUACRAPUQUIO', 'HUACRAPUQUIO'),
(1046, '120117', 'JUNIN', 'HUANCAYO', 'HUALHUAS', 'HUALHUAS'),
(1047, '120119', 'JUNIN', 'HUANCAYO', 'HUANCAN', 'HUANCAN'),
(1048, '120120', 'JUNIN', 'HUANCAYO', 'HUASICANCHA', 'HUASICANCHA'),
(1049, '120121', 'JUNIN', 'HUANCAYO', 'HUAYUCACHI', 'HUAYUCACHI'),
(1050, '120122', 'JUNIN', 'HUANCAYO', 'INGENIO', 'INGENIO'),
(1051, '120124', 'JUNIN', 'HUANCAYO', 'PARIAHUANCA', 'PARIAHUANCA /10'),
(1052, '120125', 'JUNIN', 'HUANCAYO', 'PILCOMAYO', 'PILCOMAYO'),
(1053, '120126', 'JUNIN', 'HUANCAYO', 'PUCARA', 'PUCARA'),
(1054, '120127', 'JUNIN', 'HUANCAYO', 'QUICHUAY', 'QUICHUAY'),
(1055, '120128', 'JUNIN', 'HUANCAYO', 'QUILCAS', 'QUILCAS'),
(1056, '120129', 'JUNIN', 'HUANCAYO', 'SAN AGUSTIN', 'SAN AGUSTIN'),
(1057, '120130', 'JUNIN', 'HUANCAYO', 'SAN JERONIMO DE TUNAN', 'SAN JERONIMO DE TUNAN'),
(1058, '120132', 'JUNIN', 'HUANCAYO', 'SAÑO', 'SAÑO'),
(1059, '120133', 'JUNIN', 'HUANCAYO', 'SAPALLANGA', 'SAPALLANGA'),
(1060, '120134', 'JUNIN', 'HUANCAYO', 'SICAYA', 'SICAYA'),
(1061, '120135', 'JUNIN', 'HUANCAYO', 'SANTO DOMINGO DE ACOBAMBA', 'SANTO DOMINGO DE ACOBAMBA'),
(1062, '120136', 'JUNIN', 'HUANCAYO', 'VIQUES', 'VIQUES'),
(1063, '120201', 'JUNIN', 'CONCEPCION', 'CONCEPCION', 'CONCEPCION'),
(1064, '120202', 'JUNIN', 'CONCEPCION', 'ACO', 'ACO'),
(1065, '120203', 'JUNIN', 'CONCEPCION', 'ANDAMARCA', 'ANDAMARCA'),
(1066, '120204', 'JUNIN', 'CONCEPCION', 'CHAMBARA', 'CHAMBARA'),
(1067, '120205', 'JUNIN', 'CONCEPCION', 'COCHAS', 'COCHAS'),
(1068, '120206', 'JUNIN', 'CONCEPCION', 'COMAS', 'COMAS'),
(1069, '120207', 'JUNIN', 'CONCEPCION', 'HEROINAS TOLEDO', 'SAN ANTONIO DE OCOPA'),
(1070, '120208', 'JUNIN', 'CONCEPCION', 'MANZANARES', 'SAN MIGUEL'),
(1071, '120209', 'JUNIN', 'CONCEPCION', 'MARISCAL CASTILLA', 'MUCLLO'),
(1072, '120210', 'JUNIN', 'CONCEPCION', 'MATAHUASI', 'MATAHUASI'),
(1073, '120211', 'JUNIN', 'CONCEPCION', 'MITO', 'MITO'),
(1074, '120212', 'JUNIN', 'CONCEPCION', 'NUEVE DE JULIO', 'SANTO DOMINGO DEL PRADO'),
(1075, '120213', 'JUNIN', 'CONCEPCION', 'ORCOTUNA', 'ORCOTUNA'),
(1076, '120214', 'JUNIN', 'CONCEPCION', 'SAN JOSE DE QUERO', 'SAN JOSE DE QUERO'),
(1077, '120215', 'JUNIN', 'CONCEPCION', 'SANTA ROSA DE OCOPA', 'SANTA ROSA'),
(1078, '120301', 'JUNIN', 'CHANCHAMAYO', 'CHANCHAMAYO', 'LA MERCED'),
(1079, '120302', 'JUNIN', 'CHANCHAMAYO', 'PERENE', 'PERENE'),
(1080, '120303', 'JUNIN', 'CHANCHAMAYO', 'PICHANAQUI', 'BAJO PICHANAQUI'),
(1081, '120304', 'JUNIN', 'CHANCHAMAYO', 'SAN LUIS DE SHUARO', 'SAN LUIS DE SHUARO'),
(1082, '120305', 'JUNIN', 'CHANCHAMAYO', 'SAN RAMON', 'SAN RAMON'),
(1083, '120306', 'JUNIN', 'CHANCHAMAYO', 'VITOC', 'PUCARA'),
(1084, '120401', 'JUNIN', 'JAUJA', 'JAUJA', 'JAUJA'),
(1085, '120402', 'JUNIN', 'JAUJA', 'ACOLLA', 'ACOLLA'),
(1086, '120403', 'JUNIN', 'JAUJA', 'APATA', 'APATA'),
(1087, '120404', 'JUNIN', 'JAUJA', 'ATAURA', 'ATAURA'),
(1088, '120405', 'JUNIN', 'JAUJA', 'CANCHAYLLO', 'CANCHAYLLO'),
(1089, '120406', 'JUNIN', 'JAUJA', 'CURICACA', 'EL ROSARIO'),
(1090, '120407', 'JUNIN', 'JAUJA', 'EL MANTARO', 'PUCUCHO'),
(1091, '120408', 'JUNIN', 'JAUJA', 'HUAMALI', 'HUAMALI'),
(1092, '120409', 'JUNIN', 'JAUJA', 'HUARIPAMPA', 'HUARIPAMPA'),
(1093, '120410', 'JUNIN', 'JAUJA', 'HUERTAS', 'HUERTAS'),
(1094, '120411', 'JUNIN', 'JAUJA', 'JANJAILLO', 'JANJAILLO /11'),
(1095, '120412', 'JUNIN', 'JAUJA', 'JULCAN', 'JULCAN'),
(1096, '120413', 'JUNIN', 'JAUJA', 'LEONOR ORDOÑEZ', 'HUANCANI'),
(1097, '120414', 'JUNIN', 'JAUJA', 'LLOCLLAPAMPA', 'LLOCLLAPAMPA'),
(1098, '120415', 'JUNIN', 'JAUJA', 'MARCO', 'MARCO'),
(1099, '120416', 'JUNIN', 'JAUJA', 'MASMA', 'MASMA'),
(1100, '120417', 'JUNIN', 'JAUJA', 'MASMA CHICCHE', 'MASMA CHICCHE'),
(1101, '120418', 'JUNIN', 'JAUJA', 'MOLINOS', 'MOLINOS'),
(1102, '120419', 'JUNIN', 'JAUJA', 'MONOBAMBA', 'MONOBAMBA'),
(1103, '120420', 'JUNIN', 'JAUJA', 'MUQUI', 'MUQUI'),
(1104, '120421', 'JUNIN', 'JAUJA', 'MUQUIYAUYO', 'MUQUIYAUYO'),
(1105, '120422', 'JUNIN', 'JAUJA', 'PACA', 'PACA'),
(1106, '120423', 'JUNIN', 'JAUJA', 'PACCHA', 'PACCHA'),
(1107, '120424', 'JUNIN', 'JAUJA', 'PANCAN', 'PANCAN'),
(1108, '120425', 'JUNIN', 'JAUJA', 'PARCO', 'PARCO'),
(1109, '120426', 'JUNIN', 'JAUJA', 'POMACANCHA', 'POMACANCHA'),
(1110, '120427', 'JUNIN', 'JAUJA', 'RICRAN', 'RICRAN'),
(1111, '120428', 'JUNIN', 'JAUJA', 'SAN LORENZO', 'SAN LORENZO'),
(1112, '120429', 'JUNIN', 'JAUJA', 'SAN PEDRO DE CHUNAN', 'SAN PEDRO DE CHUNAN'),
(1113, '120430', 'JUNIN', 'JAUJA', 'SAUSA', 'SAUSA'),
(1114, '120431', 'JUNIN', 'JAUJA', 'SINCOS', 'SINCOS'),
(1115, '120432', 'JUNIN', 'JAUJA', 'TUNAN MARCA', 'CONCHO'),
(1116, '120433', 'JUNIN', 'JAUJA', 'YAULI', 'YAULI'),
(1117, '120434', 'JUNIN', 'JAUJA', 'YAUYOS', 'YAUYOS'),
(1118, '120501', 'JUNIN', 'JUNIN', 'JUNIN', 'JUNIN'),
(1119, '120502', 'JUNIN', 'JUNIN', 'CARHUAMAYO', 'CARHUAMAYO'),
(1120, '120503', 'JUNIN', 'JUNIN', 'ONDORES', 'ONDORES'),
(1121, '120504', 'JUNIN', 'JUNIN', 'ULCUMAYO', 'ULCUMAYO'),
(1122, '120601', 'JUNIN', 'SATIPO', 'SATIPO', 'SATIPO'),
(1123, '120602', 'JUNIN', 'SATIPO', 'COVIRIALI', 'COVIRIALI'),
(1124, '120603', 'JUNIN', 'SATIPO', 'LLAYLLA', 'LLAYLLA'),
(1125, '120604', 'JUNIN', 'SATIPO', 'MAZAMARI', 'MAZAMARI'),
(1126, '120605', 'JUNIN', 'SATIPO', 'PAMPA HERMOSA', 'MARIPOSA'),
(1127, '120606', 'JUNIN', 'SATIPO', 'PANGOA', 'SAN MARTIN DE PANGOA'),
(1128, '120607', 'JUNIN', 'SATIPO', 'RIO NEGRO', 'RIO NEGRO'),
(1129, '120608', 'JUNIN', 'SATIPO', 'RIO TAMBO', 'PUERTO OCOPA'),
(1130, '120609', 'JUNIN', 'SATIPO', 'VIZCATAN DEL ENE', 'SAN MIGUEL DEL ENE'),
(1131, '120701', 'JUNIN', 'TARMA', 'TARMA', 'TARMA'),
(1132, '120702', 'JUNIN', 'TARMA', 'ACOBAMBA', 'ACOBAMBA'),
(1133, '120703', 'JUNIN', 'TARMA', 'HUARICOLCA', 'HUARICOLCA'),
(1134, '120704', 'JUNIN', 'TARMA', 'HUASAHUASI', 'HUASAHUASI'),
(1135, '120705', 'JUNIN', 'TARMA', 'LA UNION', 'LETICIA'),
(1136, '120706', 'JUNIN', 'TARMA', 'PALCA', 'PALCA'),
(1137, '120707', 'JUNIN', 'TARMA', 'PALCAMAYO', 'PALCAMAYO'),
(1138, '120708', 'JUNIN', 'TARMA', 'SAN PEDRO DE CAJAS', 'SAN PEDRO DE CAJAS'),
(1139, '120709', 'JUNIN', 'TARMA', 'TAPO', 'TAPO'),
(1140, '120801', 'JUNIN', 'YAULI', 'LA OROYA', 'LA OROYA'),
(1141, '120802', 'JUNIN', 'YAULI', 'CHACAPALPA', 'CHACAPALPA'),
(1142, '120803', 'JUNIN', 'YAULI', 'HUAY-HUAY', 'HUAY-HUAY'),
(1143, '120804', 'JUNIN', 'YAULI', 'MARCAPOMACOCHA', 'MARCAPOMACOCHA'),
(1144, '120805', 'JUNIN', 'YAULI', 'MOROCOCHA', 'NUEVA MOROCOCHA'),
(1145, '120806', 'JUNIN', 'YAULI', 'PACCHA', 'PACCHA'),
(1146, '120807', 'JUNIN', 'YAULI', 'SANTA BARBARA DE CARHUACAYAN', 'SANTA BARBARA DE CARHUACAYAN'),
(1147, '120808', 'JUNIN', 'YAULI', 'SANTA ROSA DE SACCO', 'SANTA ROSA DE SACCO'),
(1148, '120809', 'JUNIN', 'YAULI', 'SUITUCANCHA', 'SUITUCANCHA'),
(1149, '120810', 'JUNIN', 'YAULI', 'YAULI', 'YAULI'),
(1150, '120901', 'JUNIN', 'CHUPACA', 'CHUPACA', 'CHUPACA'),
(1151, '120902', 'JUNIN', 'CHUPACA', 'AHUAC', 'AHUAC'),
(1152, '120903', 'JUNIN', 'CHUPACA', 'CHONGOS BAJO', 'CHONGOS BAJO'),
(1153, '120904', 'JUNIN', 'CHUPACA', 'HUACHAC', 'HUACHAC'),
(1154, '120905', 'JUNIN', 'CHUPACA', 'HUAMANCACA CHICO', 'HUAMANCACA CHICO'),
(1155, '120906', 'JUNIN', 'CHUPACA', 'SAN JUAN DE ISCOS', 'ISCOS'),
(1156, '120907', 'JUNIN', 'CHUPACA', 'SAN JUAN DE JARPA', 'JARPA'),
(1157, '120908', 'JUNIN', 'CHUPACA', 'TRES DE DICIEMBRE', 'TRES DE DICIEMBRE'),
(1158, '120909', 'JUNIN', 'CHUPACA', 'YANACANCHA', 'YANACANCHA'),
(1159, '130101', 'LA LIBERTAD', 'TRUJILLO', 'TRUJILLO', 'TRUJILLO'),
(1160, '130102', 'LA LIBERTAD', 'TRUJILLO', 'EL PORVENIR', 'EL PORVENIR'),
(1161, '130103', 'LA LIBERTAD', 'TRUJILLO', 'FLORENCIA DE MORA', 'FLORENCIA DE MORA'),
(1162, '130104', 'LA LIBERTAD', 'TRUJILLO', 'HUANCHACO', 'HUANCHACO'),
(1163, '130105', 'LA LIBERTAD', 'TRUJILLO', 'LA ESPERANZA', 'LA ESPERANZA'),
(1164, '130106', 'LA LIBERTAD', 'TRUJILLO', 'LAREDO', 'LAREDO'),
(1165, '130107', 'LA LIBERTAD', 'TRUJILLO', 'MOCHE', 'MOCHE'),
(1166, '130108', 'LA LIBERTAD', 'TRUJILLO', 'POROTO', 'POROTO'),
(1167, '130109', 'LA LIBERTAD', 'TRUJILLO', 'SALAVERRY', 'SALAVERRY'),
(1168, '130110', 'LA LIBERTAD', 'TRUJILLO', 'SIMBAL', 'SIMBAL'),
(1169, '130111', 'LA LIBERTAD', 'TRUJILLO', 'VICTOR LARCO HERRERA', 'BUENOS AIRES'),
(1170, '130201', 'LA LIBERTAD', 'ASCOPE', 'ASCOPE', 'ASCOPE'),
(1171, '130202', 'LA LIBERTAD', 'ASCOPE', 'CHICAMA', 'CHICAMA'),
(1172, '130203', 'LA LIBERTAD', 'ASCOPE', 'CHOCOPE', 'CHOCOPE'),
(1173, '130204', 'LA LIBERTAD', 'ASCOPE', 'MAGDALENA DE CAO', 'MAGDALENA DE CAO'),
(1174, '130205', 'LA LIBERTAD', 'ASCOPE', 'PAIJAN', 'PAIJAN'),
(1175, '130206', 'LA LIBERTAD', 'ASCOPE', 'RAZURI', 'PUERTO DE MALABRIGO'),
(1176, '130207', 'LA LIBERTAD', 'ASCOPE', 'SANTIAGO DE CAO', 'SANTIAGO DE CAO'),
(1177, '130208', 'LA LIBERTAD', 'ASCOPE', 'CASA GRANDE', 'CASA GRANDE'),
(1178, '130301', 'LA LIBERTAD', 'BOLIVAR', 'BOLIVAR', 'BOLIVAR'),
(1179, '130302', 'LA LIBERTAD', 'BOLIVAR', 'BAMBAMARCA', 'BAMBAMARCA'),
(1180, '130303', 'LA LIBERTAD', 'BOLIVAR', 'CONDORMARCA', 'CONDORMARCA /12'),
(1181, '130304', 'LA LIBERTAD', 'BOLIVAR', 'LONGOTEA', 'LONGOTEA'),
(1182, '130305', 'LA LIBERTAD', 'BOLIVAR', 'UCHUMARCA', 'UCHUMARCA'),
(1183, '130306', 'LA LIBERTAD', 'BOLIVAR', 'UCUNCHA', 'UCUNCHA'),
(1184, '130401', 'LA LIBERTAD', 'CHEPEN', 'CHEPEN', 'CHEPEN'),
(1185, '130402', 'LA LIBERTAD', 'CHEPEN', 'PACANGA', 'PACANGA'),
(1186, '130403', 'LA LIBERTAD', 'CHEPEN', 'PUEBLO NUEVO', 'PUEBLO NUEVO'),
(1187, '130501', 'LA LIBERTAD', 'JULCAN', 'JULCAN', 'JULCAN'),
(1188, '130502', 'LA LIBERTAD', 'JULCAN', 'CALAMARCA', 'CALAMARCA'),
(1189, '130503', 'LA LIBERTAD', 'JULCAN', 'CARABAMBA', 'CARABAMBA'),
(1190, '130504', 'LA LIBERTAD', 'JULCAN', 'HUASO', 'HUASO'),
(1191, '130601', 'LA LIBERTAD', 'OTUZCO', 'OTUZCO', 'OTUZCO'),
(1192, '130602', 'LA LIBERTAD', 'OTUZCO', 'AGALLPAMPA', 'AGALLPAMPA'),
(1193, '130604', 'LA LIBERTAD', 'OTUZCO', 'CHARAT', 'CHARAT'),
(1194, '130605', 'LA LIBERTAD', 'OTUZCO', 'HUARANCHAL', 'HUARANCHAL'),
(1195, '130606', 'LA LIBERTAD', 'OTUZCO', 'LA CUESTA', 'LA CUESTA'),
(1196, '130608', 'LA LIBERTAD', 'OTUZCO', 'MACHE', 'MACHE'),
(1197, '130610', 'LA LIBERTAD', 'OTUZCO', 'PARANDAY', 'PARANDAY'),
(1198, '130611', 'LA LIBERTAD', 'OTUZCO', 'SALPO', 'SALPO'),
(1199, '130613', 'LA LIBERTAD', 'OTUZCO', 'SINSICAP', 'SINSICAP'),
(1200, '130614', 'LA LIBERTAD', 'OTUZCO', 'USQUIL', 'USQUIL'),
(1201, '130701', 'LA LIBERTAD', 'PACASMAYO', 'SAN PEDRO DE LLOC', 'SAN PEDRO DE LLOC'),
(1202, '130702', 'LA LIBERTAD', 'PACASMAYO', 'GUADALUPE', 'GUADALUPE'),
(1203, '130703', 'LA LIBERTAD', 'PACASMAYO', 'JEQUETEPEQUE', 'JEQUETEPEQUE'),
(1204, '130704', 'LA LIBERTAD', 'PACASMAYO', 'PACASMAYO', 'PACASMAYO'),
(1205, '130705', 'LA LIBERTAD', 'PACASMAYO', 'SAN JOSE', 'SAN JOSE'),
(1206, '130801', 'LA LIBERTAD', 'PATAZ', 'TAYABAMBA', 'TAYABAMBA'),
(1207, '130802', 'LA LIBERTAD', 'PATAZ', 'BULDIBUYO', 'BULDIBUYO'),
(1208, '130803', 'LA LIBERTAD', 'PATAZ', 'CHILLIA', 'CHILLIA'),
(1209, '130804', 'LA LIBERTAD', 'PATAZ', 'HUANCASPATA', 'HUANCASPATA'),
(1210, '130805', 'LA LIBERTAD', 'PATAZ', 'HUAYLILLAS', 'HUAYLILLAS'),
(1211, '130806', 'LA LIBERTAD', 'PATAZ', 'HUAYO', 'HUAYO'),
(1212, '130807', 'LA LIBERTAD', 'PATAZ', 'ONGON', 'ONGON'),
(1213, '130808', 'LA LIBERTAD', 'PATAZ', 'PARCOY', 'PARCOY'),
(1214, '130809', 'LA LIBERTAD', 'PATAZ', 'PATAZ', 'PATAZ'),
(1215, '130810', 'LA LIBERTAD', 'PATAZ', 'PIAS', 'PIAS'),
(1216, '130811', 'LA LIBERTAD', 'PATAZ', 'SANTIAGO DE CHALLAS', 'CHALLAS'),
(1217, '130812', 'LA LIBERTAD', 'PATAZ', 'TAURIJA', 'TAURIJA'),
(1218, '130813', 'LA LIBERTAD', 'PATAZ', 'URPAY', 'URPAY'),
(1219, '130901', 'LA LIBERTAD', 'SANCHEZ CARRION', 'HUAMACHUCO', 'HUAMACHUCO'),
(1220, '130902', 'LA LIBERTAD', 'SANCHEZ CARRION', 'CHUGAY', 'CHUGAY'),
(1221, '130903', 'LA LIBERTAD', 'SANCHEZ CARRION', 'COCHORCO', 'ARICAPAMPA'),
(1222, '130904', 'LA LIBERTAD', 'SANCHEZ CARRION', 'CURGOS', 'CURGOS'),
(1223, '130905', 'LA LIBERTAD', 'SANCHEZ CARRION', 'MARCABAL', 'MARCABAL'),
(1224, '130906', 'LA LIBERTAD', 'SANCHEZ CARRION', 'SANAGORAN', 'SANAGORAN'),
(1225, '130907', 'LA LIBERTAD', 'SANCHEZ CARRION', 'SARIN', 'SARIN'),
(1226, '130908', 'LA LIBERTAD', 'SANCHEZ CARRION', 'SARTIMBAMBA', 'SARTIMBAMBA'),
(1227, '131001', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'SANTIAGO DE CHUCO', 'SANTIAGO DE CHUCO'),
(1228, '131002', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'ANGASMARCA', 'ANGASMARCA'),
(1229, '131003', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'CACHICADAN', 'CACHICADAN'),
(1230, '131004', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'MOLLEBAMBA', 'MOLLEBAMBA'),
(1231, '131005', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'MOLLEPATA', 'MOLLEPATA'),
(1232, '131006', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'QUIRUVILCA', 'QUIRUVILCA'),
(1233, '131007', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'SANTA CRUZ DE CHUCA', 'SANTA CRUZ DE CHUCA'),
(1234, '131008', 'LA LIBERTAD', 'SANTIAGO DE CHUCO', 'SITABAMBA', 'SITABAMBA'),
(1235, '131101', 'LA LIBERTAD', 'GRAN CHIMU', 'CASCAS', 'CASCAS'),
(1236, '131102', 'LA LIBERTAD', 'GRAN CHIMU', 'LUCMA', 'LUCMA'),
(1237, '131103', 'LA LIBERTAD', 'GRAN CHIMU', 'MARMOT', 'MARMOT /13'),
(1238, '131104', 'LA LIBERTAD', 'GRAN CHIMU', 'SAYAPULLO', 'SAYAPULLO'),
(1239, '131201', 'LA LIBERTAD', 'VIRU', 'VIRU', 'VIRU'),
(1240, '131202', 'LA LIBERTAD', 'VIRU', 'CHAO', 'CHAO'),
(1241, '131203', 'LA LIBERTAD', 'VIRU', 'GUADALUPITO', 'GUADALUPITO'),
(1242, '140101', 'LAMBAYEQUE', 'CHICLAYO', 'CHICLAYO', 'CHICLAYO'),
(1243, '140102', 'LAMBAYEQUE', 'CHICLAYO', 'CHONGOYAPE', 'CHONGOYAPE'),
(1244, '140103', 'LAMBAYEQUE', 'CHICLAYO', 'ETEN', 'ETEN'),
(1245, '140104', 'LAMBAYEQUE', 'CHICLAYO', 'ETEN PUERTO', 'ETEN PUERTO'),
(1246, '140105', 'LAMBAYEQUE', 'CHICLAYO', 'JOSE LEONARDO ORTIZ', 'JOSE LEONARDO ORTIZ'),
(1247, '140106', 'LAMBAYEQUE', 'CHICLAYO', 'LA VICTORIA', 'LA VICTORIA'),
(1248, '140107', 'LAMBAYEQUE', 'CHICLAYO', 'LAGUNAS', 'MOCUPE'),
(1249, '140108', 'LAMBAYEQUE', 'CHICLAYO', 'MONSEFU', 'MONSEFU'),
(1250, '140109', 'LAMBAYEQUE', 'CHICLAYO', 'NUEVA ARICA', 'NUEVA ARICA'),
(1251, '140110', 'LAMBAYEQUE', 'CHICLAYO', 'OYOTUN', 'OYOTUN'),
(1252, '140111', 'LAMBAYEQUE', 'CHICLAYO', 'PICSI', 'PICSI'),
(1253, '140112', 'LAMBAYEQUE', 'CHICLAYO', 'PIMENTEL', 'PIMENTEL'),
(1254, '140113', 'LAMBAYEQUE', 'CHICLAYO', 'REQUE', 'REQUE'),
(1255, '140114', 'LAMBAYEQUE', 'CHICLAYO', 'SANTA ROSA', 'SANTA ROSA'),
(1256, '140115', 'LAMBAYEQUE', 'CHICLAYO', 'SAÑA', 'SAÑA'),
(1257, '140116', 'LAMBAYEQUE', 'CHICLAYO', 'CAYALTI', 'CAYALTI'),
(1258, '140117', 'LAMBAYEQUE', 'CHICLAYO', 'PATAPO', 'PATAPO'),
(1259, '140118', 'LAMBAYEQUE', 'CHICLAYO', 'POMALCA', 'POMALCA'),
(1260, '140119', 'LAMBAYEQUE', 'CHICLAYO', 'PUCALA', 'PUCALA'),
(1261, '140120', 'LAMBAYEQUE', 'CHICLAYO', 'TUMAN', 'TUMAN'),
(1262, '140201', 'LAMBAYEQUE', 'FERREÑAFE', 'FERREÑAFE', 'FERREÑAFE'),
(1263, '140202', 'LAMBAYEQUE', 'FERREÑAFE', 'CAÑARIS', 'CAÑARIS'),
(1264, '140203', 'LAMBAYEQUE', 'FERREÑAFE', 'INCAHUASI', 'INCAHUASI'),
(1265, '140204', 'LAMBAYEQUE', 'FERREÑAFE', 'MANUEL ANTONIO MESONES MURO', 'MANUEL ANTONIO MESONES MURO'),
(1266, '140205', 'LAMBAYEQUE', 'FERREÑAFE', 'PITIPO', 'PITIPO'),
(1267, '140206', 'LAMBAYEQUE', 'FERREÑAFE', 'PUEBLO NUEVO', 'PUEBLO NUEVO'),
(1268, '140301', 'LAMBAYEQUE', 'LAMBAYEQUE', 'LAMBAYEQUE', 'LAMBAYEQUE'),
(1269, '140302', 'LAMBAYEQUE', 'LAMBAYEQUE', 'CHOCHOPE', 'CHOCHOPE'),
(1270, '140303', 'LAMBAYEQUE', 'LAMBAYEQUE', 'ILLIMO', 'ILLIMO'),
(1271, '140304', 'LAMBAYEQUE', 'LAMBAYEQUE', 'JAYANCA', 'JAYANCA'),
(1272, '140305', 'LAMBAYEQUE', 'LAMBAYEQUE', 'MOCHUMI', 'MOCHUMI'),
(1273, '140306', 'LAMBAYEQUE', 'LAMBAYEQUE', 'MORROPE', 'MORROPE'),
(1274, '140307', 'LAMBAYEQUE', 'LAMBAYEQUE', 'MOTUPE', 'MOTUPE'),
(1275, '140308', 'LAMBAYEQUE', 'LAMBAYEQUE', 'OLMOS', 'OLMOS'),
(1276, '140309', 'LAMBAYEQUE', 'LAMBAYEQUE', 'PACORA', 'PACORA'),
(1277, '140310', 'LAMBAYEQUE', 'LAMBAYEQUE', 'SALAS', 'SALAS'),
(1278, '140311', 'LAMBAYEQUE', 'LAMBAYEQUE', 'SAN JOSE', 'SAN JOSE'),
(1279, '140312', 'LAMBAYEQUE', 'LAMBAYEQUE', 'TUCUME', 'TUCUME'),
(1280, '150101', 'LIMA', 'LIMA', 'LIMA', 'LIMA'),
(1281, '150102', 'LIMA', 'LIMA', 'ANCON', 'ANCON'),
(1282, '150103', 'LIMA', 'LIMA', 'ATE', 'VITARTE'),
(1283, '150104', 'LIMA', 'LIMA', 'BARRANCO', 'BARRANCO'),
(1284, '150105', 'LIMA', 'LIMA', 'BREÑA', 'BREÑA'),
(1285, '150106', 'LIMA', 'LIMA', 'CARABAYLLO', 'CARABAYLLO'),
(1286, '150107', 'LIMA', 'LIMA', 'CHACLACAYO', 'CHACLACAYO'),
(1287, '150108', 'LIMA', 'LIMA', 'CHORRILLOS', 'CHORRILLOS'),
(1288, '150109', 'LIMA', 'LIMA', 'CIENEGUILLA', 'CIENEGUILLA'),
(1289, '150110', 'LIMA', 'LIMA', 'COMAS', 'LA LIBERTAD'),
(1290, '150111', 'LIMA', 'LIMA', 'EL AGUSTINO', 'EL AGUSTINO'),
(1291, '150112', 'LIMA', 'LIMA', 'INDEPENDENCIA', 'INDEPENDENCIA'),
(1292, '150113', 'LIMA', 'LIMA', 'JESUS MARIA', 'JESUS MARIA'),
(1293, '150114', 'LIMA', 'LIMA', 'LA MOLINA', 'LA MOLINA'),
(1294, '150115', 'LIMA', 'LIMA', 'LA VICTORIA', 'LA VICTORIA'),
(1295, '150116', 'LIMA', 'LIMA', 'LINCE', 'LINCE'),
(1296, '150117', 'LIMA', 'LIMA', 'LOS OLIVOS', 'LAS PALMERAS'),
(1297, '150118', 'LIMA', 'LIMA', 'LURIGANCHO', 'CHOSICA'),
(1298, '150119', 'LIMA', 'LIMA', 'LURIN', 'LURIN'),
(1299, '150120', 'LIMA', 'LIMA', 'MAGDALENA DEL MAR', 'MAGDALENA DEL MAR'),
(1300, '150121', 'LIMA', 'LIMA', 'PUEBLO LIBRE', 'PUEBLO LIBRE'),
(1301, '150122', 'LIMA', 'LIMA', 'MIRAFLORES', 'MIRAFLORES'),
(1302, '150123', 'LIMA', 'LIMA', 'PACHACAMAC', 'PACHACAMAC'),
(1303, '150124', 'LIMA', 'LIMA', 'PUCUSANA', 'PUCUSANA'),
(1304, '150125', 'LIMA', 'LIMA', 'PUENTE PIEDRA', 'PUENTE PIEDRA'),
(1305, '150126', 'LIMA', 'LIMA', 'PUNTA HERMOSA', 'PUNTA HERMOSA'),
(1306, '150127', 'LIMA', 'LIMA', 'PUNTA NEGRA', 'PUNTA NEGRA'),
(1307, '150128', 'LIMA', 'LIMA', 'RIMAC', 'RIMAC'),
(1308, '150129', 'LIMA', 'LIMA', 'SAN BARTOLO', 'SAN BARTOLO'),
(1309, '150130', 'LIMA', 'LIMA', 'SAN BORJA', 'SAN FRANCISCO DE BORJA'),
(1310, '150131', 'LIMA', 'LIMA', 'SAN ISIDRO', 'SAN ISIDRO'),
(1311, '150132', 'LIMA', 'LIMA', 'SAN JUAN DE LURIGANCHO', 'SAN JUAN DE LURIGANCHO'),
(1312, '150133', 'LIMA', 'LIMA', 'SAN JUAN DE MIRAFLORES', 'CIUDAD DE DIOS'),
(1313, '150134', 'LIMA', 'LIMA', 'SAN LUIS', 'SAN LUIS'),
(1314, '150135', 'LIMA', 'LIMA', 'SAN MARTIN DE PORRES', 'BARRIO OBRERO INDUSTRIAL'),
(1315, '150136', 'LIMA', 'LIMA', 'SAN MIGUEL', 'SAN MIGUEL'),
(1316, '150137', 'LIMA', 'LIMA', 'SANTA ANITA', 'SANTA ANITA - LOS FICUS'),
(1317, '150138', 'LIMA', 'LIMA', 'SANTA MARIA DEL MAR', 'SANTA MARIA DEL MAR'),
(1318, '150139', 'LIMA', 'LIMA', 'SANTA ROSA', 'SANTA ROSA'),
(1319, '150140', 'LIMA', 'LIMA', 'SANTIAGO DE SURCO', 'SANTIAGO DE SURCO'),
(1320, '150141', 'LIMA', 'LIMA', 'SURQUILLO', 'SURQUILLO'),
(1321, '150142', 'LIMA', 'LIMA', 'VILLA EL SALVADOR', 'VILLA EL SALVADOR'),
(1322, '150143', 'LIMA', 'LIMA', 'VILLA MARIA DEL TRIUNFO', 'VILLA MARIA DEL TRIUNFO'),
(1323, '150201', 'LIMA', 'BARRANCA', 'BARRANCA', 'BARRANCA'),
(1324, '150202', 'LIMA', 'BARRANCA', 'PARAMONGA', 'PARAMONGA'),
(1325, '150203', 'LIMA', 'BARRANCA', 'PATIVILCA', 'PATIVILCA'),
(1326, '150204', 'LIMA', 'BARRANCA', 'SUPE', 'SUPE'),
(1327, '150205', 'LIMA', 'BARRANCA', 'SUPE PUERTO', 'SUPE PUERTO'),
(1328, '150301', 'LIMA', 'CAJATAMBO', 'CAJATAMBO', 'CAJATAMBO'),
(1329, '150302', 'LIMA', 'CAJATAMBO', 'COPA', 'COPA'),
(1330, '150303', 'LIMA', 'CAJATAMBO', 'GORGOR', 'GORGOR'),
(1331, '150304', 'LIMA', 'CAJATAMBO', 'HUANCAPON', 'HUANCAPON'),
(1332, '150305', 'LIMA', 'CAJATAMBO', 'MANAS', 'MANAS'),
(1333, '150401', 'LIMA', 'CANTA', 'CANTA', 'CANTA'),
(1334, '150402', 'LIMA', 'CANTA', 'ARAHUAY', 'ARAHUAY'),
(1335, '150403', 'LIMA', 'CANTA', 'HUAMANTANGA', 'HUAMANTANGA'),
(1336, '150404', 'LIMA', 'CANTA', 'HUAROS', 'HUAROS'),
(1337, '150405', 'LIMA', 'CANTA', 'LACHAQUI', 'LACHAQUI'),
(1338, '150406', 'LIMA', 'CANTA', 'SAN BUENAVENTURA', 'SAN BUENAVENTURA'),
(1339, '150407', 'LIMA', 'CANTA', 'SANTA ROSA DE QUIVES', 'YANGAS'),
(1340, '150501', 'LIMA', 'CAÑETE', 'SAN VICENTE DE CAÑETE', 'SAN VICENTE DE CAÑETE'),
(1341, '150502', 'LIMA', 'CAÑETE', 'ASIA', 'ASIA'),
(1342, '150503', 'LIMA', 'CAÑETE', 'CALANGO', 'CALANGO'),
(1343, '150504', 'LIMA', 'CAÑETE', 'CERRO AZUL', 'CERRO AZUL'),
(1344, '150505', 'LIMA', 'CAÑETE', 'CHILCA', 'CHILCA'),
(1345, '150506', 'LIMA', 'CAÑETE', 'COAYLLO', 'COAYLLO'),
(1346, '150507', 'LIMA', 'CAÑETE', 'IMPERIAL', 'IMPERIAL'),
(1347, '150508', 'LIMA', 'CAÑETE', 'LUNAHUANA', 'LUNAHUANA'),
(1348, '150509', 'LIMA', 'CAÑETE', 'MALA', 'MALA'),
(1349, '150510', 'LIMA', 'CAÑETE', 'NUEVO IMPERIAL', 'NUEVO IMPERIAL'),
(1350, '150511', 'LIMA', 'CAÑETE', 'PACARAN', 'PACARAN'),
(1351, '150512', 'LIMA', 'CAÑETE', 'QUILMANA', 'QUILMANA'),
(1352, '150513', 'LIMA', 'CAÑETE', 'SAN ANTONIO', 'SAN ANTONIO'),
(1353, '150514', 'LIMA', 'CAÑETE', 'SAN LUIS', 'SAN LUIS'),
(1354, '150515', 'LIMA', 'CAÑETE', 'SANTA CRUZ DE FLORES', 'SANTA CRUZ DE FLORES'),
(1355, '150516', 'LIMA', 'CAÑETE', 'ZUÑIGA', 'ZUÑIGA'),
(1356, '150601', 'LIMA', 'HUARAL', 'HUARAL', 'HUARAL'),
(1357, '150602', 'LIMA', 'HUARAL', 'ATAVILLOS ALTO', 'PIRCA'),
(1358, '150603', 'LIMA', 'HUARAL', 'ATAVILLOS BAJO', 'SAN AGUSTIN DE HUAYOPAMPA'),
(1359, '150604', 'LIMA', 'HUARAL', 'AUCALLAMA', 'AUCALLAMA'),
(1360, '150605', 'LIMA', 'HUARAL', 'CHANCAY', 'CHANCAY'),
(1361, '150606', 'LIMA', 'HUARAL', 'IHUARI', 'IHUARI'),
(1362, '150607', 'LIMA', 'HUARAL', 'LAMPIAN', 'LAMPIAN'),
(1363, '150608', 'LIMA', 'HUARAL', 'PACARAOS', 'PACARAOS'),
(1364, '150609', 'LIMA', 'HUARAL', 'SAN MIGUEL DE ACOS', 'ACOS'),
(1365, '150610', 'LIMA', 'HUARAL', 'SANTA CRUZ DE ANDAMARCA', 'SANTA CRUZ DE ANDAMARCA'),
(1366, '150611', 'LIMA', 'HUARAL', 'SUMBILCA', 'SUMBILCA'),
(1367, '150612', 'LIMA', 'HUARAL', 'VEINTISIETE DE NOVIEMBRE', 'CARAC'),
(1368, '150701', 'LIMA', 'HUAROCHIRI', 'MATUCANA', 'MATUCANA'),
(1369, '150702', 'LIMA', 'HUAROCHIRI', 'ANTIOQUIA', 'ANTIOQUIA'),
(1370, '150703', 'LIMA', 'HUAROCHIRI', 'CALLAHUANCA', 'CALLAHUANCA'),
(1371, '150704', 'LIMA', 'HUAROCHIRI', 'CARAMPOMA', 'CARAMPOMA'),
(1372, '150705', 'LIMA', 'HUAROCHIRI', 'CHICLA', 'CHICLA'),
(1373, '150706', 'LIMA', 'HUAROCHIRI', 'CUENCA', 'SAN JOSE DE LOS CHORRILLOS'),
(1374, '150707', 'LIMA', 'HUAROCHIRI', 'HUACHUPAMPA', 'SAN LORENZO DE HUACHUPAMPA'),
(1375, '150708', 'LIMA', 'HUAROCHIRI', 'HUANZA', 'HUANZA'),
(1376, '150709', 'LIMA', 'HUAROCHIRI', 'HUAROCHIRI', 'HUAROCHIRI'),
(1377, '150710', 'LIMA', 'HUAROCHIRI', 'LAHUAYTAMBO', 'LAHUAYTAMBO'),
(1378, '150711', 'LIMA', 'HUAROCHIRI', 'LANGA', 'LANGA'),
(1379, '150712', 'LIMA', 'HUAROCHIRI', 'SAN PEDRO DE LARAOS', 'LARAOS'),
(1380, '150713', 'LIMA', 'HUAROCHIRI', 'MARIATANA', 'MARIATANA'),
(1381, '150714', 'LIMA', 'HUAROCHIRI', 'RICARDO PALMA', 'RICARDO PALMA'),
(1382, '150715', 'LIMA', 'HUAROCHIRI', 'SAN ANDRES DE TUPICOCHA', 'SAN ANDRES DE TUPICOCHA'),
(1383, '150716', 'LIMA', 'HUAROCHIRI', 'SAN ANTONIO', 'CHACLLA'),
(1384, '150717', 'LIMA', 'HUAROCHIRI', 'SAN BARTOLOME', 'SAN BARTOLOME'),
(1385, '150718', 'LIMA', 'HUAROCHIRI', 'SAN DAMIAN', 'SAN DAMIAN'),
(1386, '150719', 'LIMA', 'HUAROCHIRI', 'SAN JUAN DE IRIS', 'SAN JUAN DE IRIS'),
(1387, '150720', 'LIMA', 'HUAROCHIRI', 'SAN JUAN DE TANTARANCHE', 'SAN JUAN DE TANTARANCHE'),
(1388, '150721', 'LIMA', 'HUAROCHIRI', 'SAN LORENZO DE QUINTI', 'SAN LORENZO DE QUINTI'),
(1389, '150722', 'LIMA', 'HUAROCHIRI', 'SAN MATEO', 'SAN MATEO'),
(1390, '150723', 'LIMA', 'HUAROCHIRI', 'SAN MATEO DE OTAO', 'SAN JUAN DE LANCA'),
(1391, '150724', 'LIMA', 'HUAROCHIRI', 'SAN PEDRO DE CASTA', 'SAN PEDRO DE CASTA'),
(1392, '150725', 'LIMA', 'HUAROCHIRI', 'SAN PEDRO DE HUANCAYRE', 'SAN PEDRO'),
(1393, '150726', 'LIMA', 'HUAROCHIRI', 'SANGALLAYA', 'SANGALLAYA'),
(1394, '150727', 'LIMA', 'HUAROCHIRI', 'SANTA CRUZ DE COCACHACRA', 'COCACHACRA'),
(1395, '150728', 'LIMA', 'HUAROCHIRI', 'SANTA EULALIA', 'SANTA EULALIA'),
(1396, '150729', 'LIMA', 'HUAROCHIRI', 'SANTIAGO DE ANCHUCAYA', 'SANTIAGO DE ANCHUCAYA'),
(1397, '150730', 'LIMA', 'HUAROCHIRI', 'SANTIAGO DE TUNA', 'SANTIAGO DE TUNA'),
(1398, '150731', 'LIMA', 'HUAROCHIRI', 'SANTO DOMINGO DE LOS OLLEROS', 'SANTO DOMINGO DE LOS OLLEROS'),
(1399, '150732', 'LIMA', 'HUAROCHIRI', 'SURCO', 'SURCO'),
(1400, '150801', 'LIMA', 'HUAURA', 'HUACHO', 'HUACHO'),
(1401, '150802', 'LIMA', 'HUAURA', 'AMBAR', 'AMBAR'),
(1402, '150803', 'LIMA', 'HUAURA', 'CALETA DE CARQUIN', 'CALETA DE CARQUIN'),
(1403, '150804', 'LIMA', 'HUAURA', 'CHECRAS', 'MARAY'),
(1404, '150805', 'LIMA', 'HUAURA', 'HUALMAY', 'HUALMAY'),
(1405, '150806', 'LIMA', 'HUAURA', 'HUAURA', 'HUAURA'),
(1406, '150807', 'LIMA', 'HUAURA', 'LEONCIO PRADO', 'SANTA CRUZ'),
(1407, '150808', 'LIMA', 'HUAURA', 'PACCHO', 'PACCHO'),
(1408, '150809', 'LIMA', 'HUAURA', 'SANTA LEONOR', 'JUCUL'),
(1409, '150810', 'LIMA', 'HUAURA', 'SANTA MARIA', 'CRUZ BLANCA'),
(1410, '150811', 'LIMA', 'HUAURA', 'SAYAN', 'SAYAN'),
(1411, '150812', 'LIMA', 'HUAURA', 'VEGUETA', 'VEGUETA'),
(1412, '150901', 'LIMA', 'OYON', 'OYON', 'OYON'),
(1413, '150902', 'LIMA', 'OYON', 'ANDAJES', 'ANDAJES'),
(1414, '150903', 'LIMA', 'OYON', 'CAUJUL', 'CAUJUL'),
(1415, '150904', 'LIMA', 'OYON', 'COCHAMARCA', 'COCHAMARCA'),
(1416, '150905', 'LIMA', 'OYON', 'NAVAN', 'NAVAN'),
(1417, '150906', 'LIMA', 'OYON', 'PACHANGARA', 'CHURIN'),
(1418, '151001', 'LIMA', 'YAUYOS', 'YAUYOS', 'YAUYOS'),
(1419, '151002', 'LIMA', 'YAUYOS', 'ALIS', 'ALIS'),
(1420, '151003', 'LIMA', 'YAUYOS', 'ALLAUCA', 'ALLAUCA'),
(1421, '151004', 'LIMA', 'YAUYOS', 'AYAVIRI', 'AYAVIRI'),
(1422, '151005', 'LIMA', 'YAUYOS', 'AZANGARO', 'AZANGARO'),
(1423, '151006', 'LIMA', 'YAUYOS', 'CACRA', 'CACRA'),
(1424, '151007', 'LIMA', 'YAUYOS', 'CARANIA', 'CARANIA'),
(1425, '151008', 'LIMA', 'YAUYOS', 'CATAHUASI', 'CATAHUASI'),
(1426, '151009', 'LIMA', 'YAUYOS', 'CHOCOS', 'CHOCOS'),
(1427, '151010', 'LIMA', 'YAUYOS', 'COCHAS', 'COCHAS'),
(1428, '151011', 'LIMA', 'YAUYOS', 'COLONIA', 'COLONIA'),
(1429, '151012', 'LIMA', 'YAUYOS', 'HONGOS', 'HONGOS'),
(1430, '151013', 'LIMA', 'YAUYOS', 'HUAMPARA', 'HUAMPARA'),
(1431, '151014', 'LIMA', 'YAUYOS', 'HUANCAYA', 'HUANCAYA'),
(1432, '151015', 'LIMA', 'YAUYOS', 'HUANGASCAR', 'HUANGASCAR'),
(1433, '151016', 'LIMA', 'YAUYOS', 'HUANTAN', 'HUANTAN'),
(1434, '151017', 'LIMA', 'YAUYOS', 'HUAÑEC', 'HUAÑEC'),
(1435, '151018', 'LIMA', 'YAUYOS', 'LARAOS', 'LARAOS'),
(1436, '151019', 'LIMA', 'YAUYOS', 'LINCHA', 'LINCHA'),
(1437, '151020', 'LIMA', 'YAUYOS', 'MADEAN', 'MADEAN'),
(1438, '151021', 'LIMA', 'YAUYOS', 'MIRAFLORES', 'MIRAFLORES'),
(1439, '151022', 'LIMA', 'YAUYOS', 'OMAS', 'OMAS'),
(1440, '151023', 'LIMA', 'YAUYOS', 'PUTINZA', 'SAN LORENZO DE PUTINZA'),
(1441, '151024', 'LIMA', 'YAUYOS', 'QUINCHES', 'QUINCHES'),
(1442, '151025', 'LIMA', 'YAUYOS', 'QUINOCAY', 'QUINOCAY'),
(1443, '151026', 'LIMA', 'YAUYOS', 'SAN JOAQUIN', 'SAN JOAQUIN'),
(1444, '151027', 'LIMA', 'YAUYOS', 'SAN PEDRO DE PILAS', 'SAN PEDRO DE PILAS'),
(1445, '151028', 'LIMA', 'YAUYOS', 'TANTA', 'TANTA'),
(1446, '151029', 'LIMA', 'YAUYOS', 'TAURIPAMPA', 'TAURIPAMPA'),
(1447, '151030', 'LIMA', 'YAUYOS', 'TOMAS', 'TOMAS'),
(1448, '151031', 'LIMA', 'YAUYOS', 'TUPE', 'TUPE'),
(1449, '151032', 'LIMA', 'YAUYOS', 'VIÑAC', 'VIÑAC'),
(1450, '151033', 'LIMA', 'YAUYOS', 'VITIS', 'VITIS'),
(1451, '160101', 'LORETO', 'MAYNAS', 'IQUITOS', 'IQUITOS'),
(1452, '160102', 'LORETO', 'MAYNAS', 'ALTO NANAY', 'SANTA MARIA DE NANAY'),
(1453, '160103', 'LORETO', 'MAYNAS', 'FERNANDO LORES', 'TAMSHIYACU'),
(1454, '160104', 'LORETO', 'MAYNAS', 'INDIANA', 'INDIANA'),
(1455, '160105', 'LORETO', 'MAYNAS', 'LAS AMAZONAS', 'FRANCISCO DE ORELLANA'),
(1456, '160106', 'LORETO', 'MAYNAS', 'MAZAN', 'MAZAN'),
(1457, '160107', 'LORETO', 'MAYNAS', 'NAPO', 'SANTA CLOTILDE'),
(1458, '160108', 'LORETO', 'MAYNAS', 'PUNCHANA', 'PUNCHANA'),
(1459, '160110', 'LORETO', 'MAYNAS', 'TORRES CAUSANA', 'PANTOJA'),
(1460, '160112', 'LORETO', 'MAYNAS', 'BELEN', 'BELEN'),
(1461, '160113', 'LORETO', 'MAYNAS', 'SAN JUAN BAUTISTA', 'SAN JUAN'),
(1462, '160201', 'LORETO', 'ALTO AMAZONAS', 'YURIMAGUAS', 'YURIMAGUAS'),
(1463, '160202', 'LORETO', 'ALTO AMAZONAS', 'BALSAPUERTO', 'BALSAPUERTO'),
(1464, '160205', 'LORETO', 'ALTO AMAZONAS', 'JEBEROS', 'JEBEROS'),
(1465, '160206', 'LORETO', 'ALTO AMAZONAS', 'LAGUNAS', 'LAGUNAS'),
(1466, '160210', 'LORETO', 'ALTO AMAZONAS', 'SANTA CRUZ', 'SANTA CRUZ'),
(1467, '160211', 'LORETO', 'ALTO AMAZONAS', 'TENIENTE CESAR LOPEZ ROJAS', 'SHUCUSHUYACU'),
(1468, '160301', 'LORETO', 'LORETO', 'NAUTA', 'NAUTA'),
(1469, '160302', 'LORETO', 'LORETO', 'PARINARI', 'PARINARI'),
(1470, '160303', 'LORETO', 'LORETO', 'TIGRE', 'INTUTU'),
(1471, '160304', 'LORETO', 'LORETO', 'TROMPETEROS', 'VILLA TROMPETEROS'),
(1472, '160305', 'LORETO', 'LORETO', 'URARINAS', 'CONCORDIA'),
(1473, '160401', 'LORETO', 'MARISCAL RAMON CASTILLA', 'RAMON CASTILLA', 'CABALLOCOCHA'),
(1474, '160402', 'LORETO', 'MARISCAL RAMON CASTILLA', 'PEBAS', 'PEBAS'),
(1475, '160403', 'LORETO', 'MARISCAL RAMON CASTILLA', 'YAVARI', 'AMELIA /14'),
(1476, '160404', 'LORETO', 'MARISCAL RAMON CASTILLA', 'SAN PABLO', 'SAN PABLO DE LORETO'),
(1477, '160501', 'LORETO', 'REQUENA', 'REQUENA', 'REQUENA'),
(1478, '160502', 'LORETO', 'REQUENA', 'ALTO TAPICHE', 'SANTA ELENA'),
(1479, '160503', 'LORETO', 'REQUENA', 'CAPELO', 'FLOR DE PUNGA'),
(1480, '160504', 'LORETO', 'REQUENA', 'EMILIO SAN MARTIN', 'TAMANCO'),
(1481, '160505', 'LORETO', 'REQUENA', 'MAQUIA', 'SANTA ISABEL'),
(1482, '160506', 'LORETO', 'REQUENA', 'PUINAHUA', 'BRETAÑA'),
(1483, '160507', 'LORETO', 'REQUENA', 'SAQUENA', 'BAGAZAN'),
(1484, '160508', 'LORETO', 'REQUENA', 'SOPLIN', 'NUEVA ALEJANDRIA (CURINGA)'),
(1485, '160509', 'LORETO', 'REQUENA', 'TAPICHE', 'IBERIA'),
(1486, '160510', 'LORETO', 'REQUENA', 'JENARO HERRERA', 'JENARO HERRERA'),
(1487, '160511', 'LORETO', 'REQUENA', 'YAQUERANA', 'ANGAMOS'),
(1488, '160601', 'LORETO', 'UCAYALI', 'CONTAMANA', 'CONTAMANA'),
(1489, '160602', 'LORETO', 'UCAYALI', 'INAHUAYA', 'INAHUAYA'),
(1490, '160603', 'LORETO', 'UCAYALI', 'PADRE MARQUEZ', 'TIRUNTAN'),
(1491, '160604', 'LORETO', 'UCAYALI', 'PAMPA HERMOSA', 'PAMPA HERMOSA'),
(1492, '160605', 'LORETO', 'UCAYALI', 'SARAYACU', 'DOS DE MAYO'),
(1493, '160606', 'LORETO', 'UCAYALI', 'VARGAS GUERRA', 'ORELLANA'),
(1494, '160701', 'LORETO', 'DATEM DEL MARAÑON', 'BARRANCA', 'SAN LORENZO'),
(1495, '160702', 'LORETO', 'DATEM DEL MARAÑON', 'CAHUAPANAS', 'SANTA MARIA DE CAHUAPANAS'),
(1496, '160703', 'LORETO', 'DATEM DEL MARAÑON', 'MANSERICHE', 'SARAMIRIZA'),
(1497, '160704', 'LORETO', 'DATEM DEL MARAÑON', 'MORONA', 'PUERTO ALEGRIA'),
(1498, '160705', 'LORETO', 'DATEM DEL MARAÑON', 'PASTAZA', 'ULLPAYACU'),
(1499, '160706', 'LORETO', 'DATEM DEL MARAÑON', 'ANDOAS', 'ALIANZA CRISTIANA'),
(1500, '160801', 'LORETO', 'PUTUMAYO', 'PUTUMAYO', 'SAN ANTONIO DEL ESTRECHO'),
(1501, '160802', 'LORETO', 'PUTUMAYO', 'ROSA PANDURO', 'SANTA MERCEDES'),
(1502, '160803', 'LORETO', 'PUTUMAYO', 'TENIENTE MANUEL CLAVERO', 'SOPLIN VARGAS'),
(1503, '160804', 'LORETO', 'PUTUMAYO', 'YAGUAS', 'REMANSO'),
(1504, '170101', 'MADRE DE DIOS', 'TAMBOPATA', 'TAMBOPATA', 'PUERTO MALDONADO'),
(1505, '170102', 'MADRE DE DIOS', 'TAMBOPATA', 'INAMBARI', 'MAZUKO'),
(1506, '170103', 'MADRE DE DIOS', 'TAMBOPATA', 'LAS PIEDRAS', 'LAS PIEDRAS (PLANCHON)'),
(1507, '170104', 'MADRE DE DIOS', 'TAMBOPATA', 'LABERINTO', 'PUERTO ROSARIO DE LABERINTO'),
(1508, '170201', 'MADRE DE DIOS', 'MANU', 'MANU', 'SALVACION'),
(1509, '170202', 'MADRE DE DIOS', 'MANU', 'FITZCARRALD', 'BOCA MANU'),
(1510, '170203', 'MADRE DE DIOS', 'MANU', 'MADRE DE DIOS', 'BOCA COLORADO'),
(1511, '170204', 'MADRE DE DIOS', 'MANU', 'HUEPETUHE', 'HUEPETUHE'),
(1512, '170301', 'MADRE DE DIOS', 'TAHUAMANU', 'IÑAPARI', 'IÑAPARI'),
(1513, '170302', 'MADRE DE DIOS', 'TAHUAMANU', 'IBERIA', 'IBERIA'),
(1514, '170303', 'MADRE DE DIOS', 'TAHUAMANU', 'TAHUAMANU', 'SAN LORENZO'),
(1515, '180101', 'MOQUEGUA', 'MARISCAL NIETO', 'MOQUEGUA', 'MOQUEGUA'),
(1516, '180102', 'MOQUEGUA', 'MARISCAL NIETO', 'CARUMAS', 'CARUMAS'),
(1517, '180103', 'MOQUEGUA', 'MARISCAL NIETO', 'CUCHUMBAYA', 'CUCHUMBAYA'),
(1518, '180104', 'MOQUEGUA', 'MARISCAL NIETO', 'SAMEGUA', 'SAMEGUA'),
(1519, '180105', 'MOQUEGUA', 'MARISCAL NIETO', 'SAN CRISTOBAL', 'CALACOA'),
(1520, '180106', 'MOQUEGUA', 'MARISCAL NIETO', 'TORATA', 'TORATA'),
(1521, '180201', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'OMATE', 'OMATE'),
(1522, '180202', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'CHOJATA', 'CHOJATA'),
(1523, '180203', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'COALAQUE', 'COALAQUE'),
(1524, '180204', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'ICHUÑA', 'ICHUÑA'),
(1525, '180205', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'LA CAPILLA', 'LA CAPILLA'),
(1526, '180206', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'LLOQUE', 'LLOQUE'),
(1527, '180207', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'MATALAQUE', 'MATALAQUE'),
(1528, '180208', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'PUQUINA', 'PUQUINA'),
(1529, '180209', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'QUINISTAQUILLAS', 'QUINISTAQUILLAS'),
(1530, '180210', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'UBINAS', 'UBINAS'),
(1531, '180211', 'MOQUEGUA', 'GENERAL SANCHEZ CERRO', 'YUNGA', 'YUNGA'),
(1532, '180301', 'MOQUEGUA', 'ILO', 'ILO', 'ILO'),
(1533, '180302', 'MOQUEGUA', 'ILO', 'EL ALGARROBAL', 'EL ALGARROBAL'),
(1534, '180303', 'MOQUEGUA', 'ILO', 'PACOCHA', 'PUEBLO NUEVO'),
(1535, '190101', 'PASCO', 'PASCO', 'CHAUPIMARCA', 'CERRO DE PASCO'),
(1536, '190102', 'PASCO', 'PASCO', 'HUACHON', 'HUACHON'),
(1537, '190103', 'PASCO', 'PASCO', 'HUARIACA', 'HUARIACA'),
(1538, '190104', 'PASCO', 'PASCO', 'HUAYLLAY', 'HUAYLLAY'),
(1539, '190105', 'PASCO', 'PASCO', 'NINACACA', 'NINACACA'),
(1540, '190106', 'PASCO', 'PASCO', 'PALLANCHACRA', 'PALLANCHACRA'),
(1541, '190107', 'PASCO', 'PASCO', 'PAUCARTAMBO', 'PAUCARTAMBO'),
(1542, '190108', 'PASCO', 'PASCO', 'SAN FRANCISCO DE ASIS DE YARUSYACAN', 'YARUSYACAN'),
(1543, '190109', 'PASCO', 'PASCO', 'SIMON BOLIVAR', 'SAN ANTONIO DE RANCAS'),
(1544, '190110', 'PASCO', 'PASCO', 'TICLACAYAN', 'TICLACAYAN'),
(1545, '190111', 'PASCO', 'PASCO', 'TINYAHUARCO', 'TINYAHUARCO (SMELTER)'),
(1546, '190112', 'PASCO', 'PASCO', 'VICCO', 'VICCO'),
(1547, '190113', 'PASCO', 'PASCO', 'YANACANCHA', 'YANACANCHA');
INSERT INTO `ubigeo` (`id_ubigeo`, `ubigeo_cod`, `ubigeo_departamento`, `ubigeo_provincia`, `ubigeo_distrito`, `ubigeo_capital`) VALUES
(1548, '190201', 'PASCO', 'DANIEL ALCIDES CARRION', 'YANAHUANCA', 'YANAHUANCA'),
(1549, '190202', 'PASCO', 'DANIEL ALCIDES CARRION', 'CHACAYAN', 'CHACAYAN'),
(1550, '190203', 'PASCO', 'DANIEL ALCIDES CARRION', 'GOYLLARISQUIZGA', 'GOYLLARISQUIZGA'),
(1551, '190204', 'PASCO', 'DANIEL ALCIDES CARRION', 'PAUCAR', 'PAUCAR'),
(1552, '190205', 'PASCO', 'DANIEL ALCIDES CARRION', 'SAN PEDRO DE PILLAO', 'SAN PEDRO DE PILLAO'),
(1553, '190206', 'PASCO', 'DANIEL ALCIDES CARRION', 'SANTA ANA DE TUSI', 'SANTA ANA DE TUSI'),
(1554, '190207', 'PASCO', 'DANIEL ALCIDES CARRION', 'TAPUC', 'TAPUC'),
(1555, '190208', 'PASCO', 'DANIEL ALCIDES CARRION', 'VILCABAMBA', 'VILCABAMBA'),
(1556, '190301', 'PASCO', 'OXAPAMPA', 'OXAPAMPA', 'OXAPAMPA'),
(1557, '190302', 'PASCO', 'OXAPAMPA', 'CHONTABAMBA', 'CHONTABAMBA'),
(1558, '190303', 'PASCO', 'OXAPAMPA', 'HUANCABAMBA', 'HUANCABAMBA'),
(1559, '190304', 'PASCO', 'OXAPAMPA', 'PALCAZU', 'ISCOZACIN'),
(1560, '190305', 'PASCO', 'OXAPAMPA', 'POZUZO', 'POZUZO'),
(1561, '190306', 'PASCO', 'OXAPAMPA', 'PUERTO BERMUDEZ', 'PUERTO BERMUDEZ'),
(1562, '190307', 'PASCO', 'OXAPAMPA', 'VILLA RICA', 'VILLA RICA'),
(1563, '190308', 'PASCO', 'OXAPAMPA', 'CONSTITUCION', 'CONSTITUCION'),
(1564, '200101', 'PIURA', 'PIURA', 'PIURA', 'PIURA'),
(1565, '200104', 'PIURA', 'PIURA', 'CASTILLA', 'CASTILLA'),
(1566, '200105', 'PIURA', 'PIURA', 'CATACAOS', 'CATACAOS'),
(1567, '200107', 'PIURA', 'PIURA', 'CURA MORI', 'CUCUNGARA'),
(1568, '200108', 'PIURA', 'PIURA', 'EL TALLAN', 'SINCHAO'),
(1569, '200109', 'PIURA', 'PIURA', 'LA ARENA', 'LA ARENA'),
(1570, '200110', 'PIURA', 'PIURA', 'LA UNION', 'LA UNION'),
(1571, '200111', 'PIURA', 'PIURA', 'LAS LOMAS', 'LAS LOMAS'),
(1572, '200114', 'PIURA', 'PIURA', 'TAMBO GRANDE', 'TAMBO GRANDE'),
(1573, '200115', 'PIURA', 'PIURA', 'VEINTISEIS DE OCTUBRE', 'SAN MARTIN'),
(1574, '200201', 'PIURA', 'AYABACA', 'AYABACA', 'AYABACA'),
(1575, '200202', 'PIURA', 'AYABACA', 'FRIAS', 'FRIAS'),
(1576, '200203', 'PIURA', 'AYABACA', 'JILILI', 'JILILI'),
(1577, '200204', 'PIURA', 'AYABACA', 'LAGUNAS', 'LAGUNAS'),
(1578, '200205', 'PIURA', 'AYABACA', 'MONTERO', 'MONTERO'),
(1579, '200206', 'PIURA', 'AYABACA', 'PACAIPAMPA', 'PACAIPAMPA'),
(1580, '200207', 'PIURA', 'AYABACA', 'PAIMAS', 'PAIMAS'),
(1581, '200208', 'PIURA', 'AYABACA', 'SAPILLICA', 'SAPILLICA'),
(1582, '200209', 'PIURA', 'AYABACA', 'SICCHEZ', 'SICCHEZ'),
(1583, '200210', 'PIURA', 'AYABACA', 'SUYO', 'SUYO'),
(1584, '200301', 'PIURA', 'HUANCABAMBA', 'HUANCABAMBA', 'HUANCABAMBA'),
(1585, '200302', 'PIURA', 'HUANCABAMBA', 'CANCHAQUE', 'CANCHAQUE'),
(1586, '200303', 'PIURA', 'HUANCABAMBA', 'EL CARMEN DE LA FRONTERA', 'SAPALACHE'),
(1587, '200304', 'PIURA', 'HUANCABAMBA', 'HUARMACA', 'HUARMACA'),
(1588, '200305', 'PIURA', 'HUANCABAMBA', 'LALAQUIZ', 'TUNAL'),
(1589, '200306', 'PIURA', 'HUANCABAMBA', 'SAN MIGUEL DE EL FAIQUE', 'SAN MIGUEL DE EL FAIQUE'),
(1590, '200307', 'PIURA', 'HUANCABAMBA', 'SONDOR', 'SONDOR'),
(1591, '200308', 'PIURA', 'HUANCABAMBA', 'SONDORILLO', 'SONDORILLO'),
(1592, '200401', 'PIURA', 'MORROPON', 'CHULUCANAS', 'CHULUCANAS'),
(1593, '200402', 'PIURA', 'MORROPON', 'BUENOS AIRES', 'BUENOS AIRES'),
(1594, '200403', 'PIURA', 'MORROPON', 'CHALACO', 'CHALACO'),
(1595, '200404', 'PIURA', 'MORROPON', 'LA MATANZA', 'LA MATANZA'),
(1596, '200405', 'PIURA', 'MORROPON', 'MORROPON', 'MORROPON'),
(1597, '200406', 'PIURA', 'MORROPON', 'SALITRAL', 'SALITRAL'),
(1598, '200407', 'PIURA', 'MORROPON', 'SAN JUAN DE BIGOTE', 'BIGOTE'),
(1599, '200408', 'PIURA', 'MORROPON', 'SANTA CATALINA DE MOSSA', 'PALTASHACO'),
(1600, '200409', 'PIURA', 'MORROPON', 'SANTO DOMINGO', 'SANTO DOMINGO'),
(1601, '200410', 'PIURA', 'MORROPON', 'YAMANGO', 'YAMANGO'),
(1602, '200501', 'PIURA', 'PAITA', 'PAITA', 'PAITA'),
(1603, '200502', 'PIURA', 'PAITA', 'AMOTAPE', 'AMOTAPE'),
(1604, '200503', 'PIURA', 'PAITA', 'ARENAL', 'ARENAL'),
(1605, '200504', 'PIURA', 'PAITA', 'COLAN', 'SAN LUCAS (PUEBLO NUEVO DE COLAN)'),
(1606, '200505', 'PIURA', 'PAITA', 'LA HUACA', 'LA HUACA'),
(1607, '200506', 'PIURA', 'PAITA', 'TAMARINDO', 'TAMARINDO'),
(1608, '200507', 'PIURA', 'PAITA', 'VICHAYAL', 'SAN FELIPE DE VICHAYAL'),
(1609, '200601', 'PIURA', 'SULLANA', 'SULLANA', 'SULLANA'),
(1610, '200602', 'PIURA', 'SULLANA', 'BELLAVISTA', 'BELLAVISTA'),
(1611, '200603', 'PIURA', 'SULLANA', 'IGNACIO ESCUDERO', 'SAN JACINTO'),
(1612, '200604', 'PIURA', 'SULLANA', 'LANCONES', 'LANCONES'),
(1613, '200605', 'PIURA', 'SULLANA', 'MARCAVELICA', 'MARCAVELICA'),
(1614, '200606', 'PIURA', 'SULLANA', 'MIGUEL CHECA', 'SOJO'),
(1615, '200607', 'PIURA', 'SULLANA', 'QUERECOTILLO', 'QUERECOTILLO'),
(1616, '200608', 'PIURA', 'SULLANA', 'SALITRAL', 'SALITRAL'),
(1617, '200701', 'PIURA', 'TALARA', 'PARIÑAS', 'TALARA'),
(1618, '200702', 'PIURA', 'TALARA', 'EL ALTO', 'EL ALTO'),
(1619, '200703', 'PIURA', 'TALARA', 'LA BREA', 'NEGRITOS'),
(1620, '200704', 'PIURA', 'TALARA', 'LOBITOS', 'LOBITOS'),
(1621, '200705', 'PIURA', 'TALARA', 'LOS ORGANOS', 'LOS ORGANOS'),
(1622, '200706', 'PIURA', 'TALARA', 'MANCORA', 'MANCORA'),
(1623, '200801', 'PIURA', 'SECHURA', 'SECHURA', 'SECHURA'),
(1624, '200802', 'PIURA', 'SECHURA', 'BELLAVISTA DE LA UNION', 'BELLAVISTA'),
(1625, '200803', 'PIURA', 'SECHURA', 'BERNAL', 'BERNAL'),
(1626, '200804', 'PIURA', 'SECHURA', 'CRISTO NOS VALGA', 'SAN CRISTO'),
(1627, '200805', 'PIURA', 'SECHURA', 'VICE', 'VICE'),
(1628, '200806', 'PIURA', 'SECHURA', 'RINCONADA LLICUAR', 'DOS PUEBLOS'),
(1629, '210101', 'PUNO', 'PUNO', 'PUNO', 'PUNO'),
(1630, '210102', 'PUNO', 'PUNO', 'ACORA', 'ACORA'),
(1631, '210103', 'PUNO', 'PUNO', 'AMANTANI', 'AMANTANI'),
(1632, '210104', 'PUNO', 'PUNO', 'ATUNCOLLA', 'ATUNCOLLA'),
(1633, '210105', 'PUNO', 'PUNO', 'CAPACHICA', 'CAPACHICA'),
(1634, '210106', 'PUNO', 'PUNO', 'CHUCUITO', 'CHUCUITO'),
(1635, '210107', 'PUNO', 'PUNO', 'COATA', 'COATA'),
(1636, '210108', 'PUNO', 'PUNO', 'HUATA', 'HUATA'),
(1637, '210109', 'PUNO', 'PUNO', 'MAÑAZO', 'MAÑAZO'),
(1638, '210110', 'PUNO', 'PUNO', 'PAUCARCOLLA', 'PAUCARCOLLA'),
(1639, '210111', 'PUNO', 'PUNO', 'PICHACANI', 'LARAQUERI'),
(1640, '210112', 'PUNO', 'PUNO', 'PLATERIA', 'PLATERIA'),
(1641, '210113', 'PUNO', 'PUNO', 'SAN ANTONIO', 'SAN ANTONIO DE ESQUILACHE /15'),
(1642, '210114', 'PUNO', 'PUNO', 'TIQUILLACA', 'TIQUILLACA'),
(1643, '210115', 'PUNO', 'PUNO', 'VILQUE', 'VILQUE'),
(1644, '210201', 'PUNO', 'AZANGARO', 'AZANGARO', 'AZANGARO'),
(1645, '210202', 'PUNO', 'AZANGARO', 'ACHAYA', 'ACHAYA'),
(1646, '210203', 'PUNO', 'AZANGARO', 'ARAPA', 'ARAPA'),
(1647, '210204', 'PUNO', 'AZANGARO', 'ASILLO', 'ASILLO'),
(1648, '210205', 'PUNO', 'AZANGARO', 'CAMINACA', 'CAMINACA'),
(1649, '210206', 'PUNO', 'AZANGARO', 'CHUPA', 'CHUPA'),
(1650, '210207', 'PUNO', 'AZANGARO', 'JOSE DOMINGO CHOQUEHUANCA', 'ESTACION DE PUCARA'),
(1651, '210208', 'PUNO', 'AZANGARO', 'MUÑANI', 'MUÑANI'),
(1652, '210209', 'PUNO', 'AZANGARO', 'POTONI', 'POTONI'),
(1653, '210210', 'PUNO', 'AZANGARO', 'SAMAN', 'SAMAN'),
(1654, '210211', 'PUNO', 'AZANGARO', 'SAN ANTON', 'SAN ANTON'),
(1655, '210212', 'PUNO', 'AZANGARO', 'SAN JOSE', 'SAN JOSE'),
(1656, '210213', 'PUNO', 'AZANGARO', 'SAN JUAN DE SALINAS', 'SAN JUAN DE SALINAS'),
(1657, '210214', 'PUNO', 'AZANGARO', 'SANTIAGO DE PUPUJA', 'SANTIAGO DE PUPUJA'),
(1658, '210215', 'PUNO', 'AZANGARO', 'TIRAPATA', 'TIRAPATA'),
(1659, '210301', 'PUNO', 'CARABAYA', 'MACUSANI', 'MACUSANI'),
(1660, '210302', 'PUNO', 'CARABAYA', 'AJOYANI', 'AJOYANI'),
(1661, '210303', 'PUNO', 'CARABAYA', 'AYAPATA', 'AYAPATA'),
(1662, '210304', 'PUNO', 'CARABAYA', 'COASA', 'COASA'),
(1663, '210305', 'PUNO', 'CARABAYA', 'CORANI', 'CORANI'),
(1664, '210306', 'PUNO', 'CARABAYA', 'CRUCERO', 'CRUCERO'),
(1665, '210307', 'PUNO', 'CARABAYA', 'ITUATA', 'ITUATA /16'),
(1666, '210308', 'PUNO', 'CARABAYA', 'OLLACHEA', 'OLLACHEA'),
(1667, '210309', 'PUNO', 'CARABAYA', 'SAN GABAN', 'LANLACUNI BAJO'),
(1668, '210310', 'PUNO', 'CARABAYA', 'USICAYOS', 'USICAYOS'),
(1669, '210401', 'PUNO', 'CHUCUITO', 'JULI', 'JULI'),
(1670, '210402', 'PUNO', 'CHUCUITO', 'DESAGUADERO', 'DESAGUADERO'),
(1671, '210403', 'PUNO', 'CHUCUITO', 'HUACULLANI', 'HUACULLANI'),
(1672, '210404', 'PUNO', 'CHUCUITO', 'KELLUYO', 'KELLUYO'),
(1673, '210405', 'PUNO', 'CHUCUITO', 'PISACOMA', 'PISACOMA'),
(1674, '210406', 'PUNO', 'CHUCUITO', 'POMATA', 'POMATA'),
(1675, '210407', 'PUNO', 'CHUCUITO', 'ZEPITA', 'ZEPITA'),
(1676, '210501', 'PUNO', 'EL COLLAO', 'ILAVE', 'ILAVE'),
(1677, '210502', 'PUNO', 'EL COLLAO', 'CAPAZO', 'CAPAZO'),
(1678, '210503', 'PUNO', 'EL COLLAO', 'PILCUYO', 'PILCUYO'),
(1679, '210504', 'PUNO', 'EL COLLAO', 'SANTA ROSA', 'MAZO CRUZ'),
(1680, '210505', 'PUNO', 'EL COLLAO', 'CONDURIRI', 'CONDURIRI'),
(1681, '210601', 'PUNO', 'HUANCANE', 'HUANCANE', 'HUANCANE'),
(1682, '210602', 'PUNO', 'HUANCANE', 'COJATA', 'COJATA'),
(1683, '210603', 'PUNO', 'HUANCANE', 'HUATASANI', 'HUATASANI'),
(1684, '210604', 'PUNO', 'HUANCANE', 'INCHUPALLA', 'INCHUPALLA'),
(1685, '210605', 'PUNO', 'HUANCANE', 'PUSI', 'PUSI'),
(1686, '210606', 'PUNO', 'HUANCANE', 'ROSASPATA', 'ROSASPATA'),
(1687, '210607', 'PUNO', 'HUANCANE', 'TARACO', 'TARACO'),
(1688, '210608', 'PUNO', 'HUANCANE', 'VILQUE CHICO', 'VILQUE CHICO'),
(1689, '210701', 'PUNO', 'LAMPA', 'LAMPA', 'LAMPA'),
(1690, '210702', 'PUNO', 'LAMPA', 'CABANILLA', 'CABANILLA'),
(1691, '210703', 'PUNO', 'LAMPA', 'CALAPUJA', 'CALAPUJA'),
(1692, '210704', 'PUNO', 'LAMPA', 'NICASIO', 'NICASIO'),
(1693, '210705', 'PUNO', 'LAMPA', 'OCUVIRI', 'OCUVIRI'),
(1694, '210706', 'PUNO', 'LAMPA', 'PALCA', 'PALCA'),
(1695, '210707', 'PUNO', 'LAMPA', 'PARATIA', 'PARATIA'),
(1696, '210708', 'PUNO', 'LAMPA', 'PUCARA', 'PUCARA'),
(1697, '210709', 'PUNO', 'LAMPA', 'SANTA LUCIA', 'SANTA LUCIA'),
(1698, '210710', 'PUNO', 'LAMPA', 'VILAVILA', 'VILAVILA'),
(1699, '210801', 'PUNO', 'MELGAR', 'AYAVIRI', 'AYAVIRI'),
(1700, '210802', 'PUNO', 'MELGAR', 'ANTAUTA', 'ANTAUTA'),
(1701, '210803', 'PUNO', 'MELGAR', 'CUPI', 'CUPI'),
(1702, '210804', 'PUNO', 'MELGAR', 'LLALLI', 'LLALLI'),
(1703, '210805', 'PUNO', 'MELGAR', 'MACARI', 'MACARI'),
(1704, '210806', 'PUNO', 'MELGAR', 'NUÑOA', 'NUÑOA'),
(1705, '210807', 'PUNO', 'MELGAR', 'ORURILLO', 'ORURILLO'),
(1706, '210808', 'PUNO', 'MELGAR', 'SANTA ROSA', 'SANTA ROSA'),
(1707, '210809', 'PUNO', 'MELGAR', 'UMACHIRI', 'UMACHIRI'),
(1708, '210901', 'PUNO', 'MOHO', 'MOHO', 'MOHO'),
(1709, '210902', 'PUNO', 'MOHO', 'CONIMA', 'CONIMA'),
(1710, '210903', 'PUNO', 'MOHO', 'HUAYRAPATA', 'HUAYRAPATA'),
(1711, '210904', 'PUNO', 'MOHO', 'TILALI', 'TILALI'),
(1712, '211001', 'PUNO', 'SAN ANTONIO DE PUTINA', 'PUTINA', 'PUTINA'),
(1713, '211002', 'PUNO', 'SAN ANTONIO DE PUTINA', 'ANANEA', 'ANANEA'),
(1714, '211003', 'PUNO', 'SAN ANTONIO DE PUTINA', 'PEDRO VILCA APAZA', 'AYRAMPUNI'),
(1715, '211004', 'PUNO', 'SAN ANTONIO DE PUTINA', 'QUILCAPUNCU', 'QUILCAPUNCU'),
(1716, '211005', 'PUNO', 'SAN ANTONIO DE PUTINA', 'SINA', 'SINA'),
(1717, '211101', 'PUNO', 'SAN ROMAN', 'JULIACA', 'JULIACA'),
(1718, '211102', 'PUNO', 'SAN ROMAN', 'CABANA', 'CABANA'),
(1719, '211103', 'PUNO', 'SAN ROMAN', 'CABANILLAS', 'DEUSTUA'),
(1720, '211104', 'PUNO', 'SAN ROMAN', 'CARACOTO', 'CARACOTO'),
(1721, '211105', 'PUNO', 'SAN ROMAN', 'SAN MIGUEL', 'SAN MIGUEL'),
(1722, '211201', 'PUNO', 'SANDIA', 'SANDIA', 'SANDIA'),
(1723, '211202', 'PUNO', 'SANDIA', 'CUYOCUYO', 'CUYOCUYO'),
(1724, '211203', 'PUNO', 'SANDIA', 'LIMBANI', 'LIMBANI'),
(1725, '211204', 'PUNO', 'SANDIA', 'PATAMBUCO', 'PATAMBUCO'),
(1726, '211205', 'PUNO', 'SANDIA', 'PHARA', 'PHARA'),
(1727, '211206', 'PUNO', 'SANDIA', 'QUIACA', 'QUIACA'),
(1728, '211207', 'PUNO', 'SANDIA', 'SAN JUAN DEL ORO', 'SAN JUAN DEL ORO'),
(1729, '211208', 'PUNO', 'SANDIA', 'YANAHUAYA', 'YANAHUAYA'),
(1730, '211209', 'PUNO', 'SANDIA', 'ALTO INAMBARI', 'MASSIAPO'),
(1731, '211210', 'PUNO', 'SANDIA', 'SAN PEDRO DE PUTINA PUNCO', 'PUTINA PUNCO'),
(1732, '211301', 'PUNO', 'YUNGUYO', 'YUNGUYO', 'YUNGUYO'),
(1733, '211302', 'PUNO', 'YUNGUYO', 'ANAPIA', 'ANAPIA'),
(1734, '211303', 'PUNO', 'YUNGUYO', 'COPANI', 'COPANI'),
(1735, '211304', 'PUNO', 'YUNGUYO', 'CUTURAPI', 'SAN JUAN DE CUTURAPI'),
(1736, '211305', 'PUNO', 'YUNGUYO', 'OLLARAYA', 'SAN MIGUEL DE OLLARAYA'),
(1737, '211306', 'PUNO', 'YUNGUYO', 'TINICACHI', 'TINICACHI'),
(1738, '211307', 'PUNO', 'YUNGUYO', 'UNICACHI', 'MARCAJA'),
(1739, '220101', 'SAN MARTIN', 'MOYOBAMBA', 'MOYOBAMBA', 'MOYOBAMBA'),
(1740, '220102', 'SAN MARTIN', 'MOYOBAMBA', 'CALZADA', 'CALZADA'),
(1741, '220103', 'SAN MARTIN', 'MOYOBAMBA', 'HABANA', 'HABANA'),
(1742, '220104', 'SAN MARTIN', 'MOYOBAMBA', 'JEPELACIO', 'JEPELACIO'),
(1743, '220105', 'SAN MARTIN', 'MOYOBAMBA', 'SORITOR', 'SORITOR'),
(1744, '220106', 'SAN MARTIN', 'MOYOBAMBA', 'YANTALO', 'YANTALO'),
(1745, '220201', 'SAN MARTIN', 'BELLAVISTA', 'BELLAVISTA', 'BELLAVISTA'),
(1746, '220202', 'SAN MARTIN', 'BELLAVISTA', 'ALTO BIAVO', 'CUZCO'),
(1747, '220203', 'SAN MARTIN', 'BELLAVISTA', 'BAJO BIAVO', 'NUEVO LIMA'),
(1748, '220204', 'SAN MARTIN', 'BELLAVISTA', 'HUALLAGA', 'LEDOY'),
(1749, '220205', 'SAN MARTIN', 'BELLAVISTA', 'SAN PABLO', 'SAN PABLO'),
(1750, '220206', 'SAN MARTIN', 'BELLAVISTA', 'SAN RAFAEL', 'SAN RAFAEL'),
(1751, '220301', 'SAN MARTIN', 'EL DORADO', 'SAN JOSE DE SISA', 'SAN JOSE DE SISA'),
(1752, '220302', 'SAN MARTIN', 'EL DORADO', 'AGUA BLANCA', 'AGUA BLANCA'),
(1753, '220303', 'SAN MARTIN', 'EL DORADO', 'SAN MARTIN', 'SAN MARTIN'),
(1754, '220304', 'SAN MARTIN', 'EL DORADO', 'SANTA ROSA', 'SANTA ROSA'),
(1755, '220305', 'SAN MARTIN', 'EL DORADO', 'SHATOJA', 'SHATOJA'),
(1756, '220401', 'SAN MARTIN', 'HUALLAGA', 'SAPOSOA', 'SAPOSOA'),
(1757, '220402', 'SAN MARTIN', 'HUALLAGA', 'ALTO SAPOSOA', 'PASARRAYA'),
(1758, '220403', 'SAN MARTIN', 'HUALLAGA', 'EL ESLABON', 'EL ESLABON'),
(1759, '220404', 'SAN MARTIN', 'HUALLAGA', 'PISCOYACU', 'PISCOYACU'),
(1760, '220405', 'SAN MARTIN', 'HUALLAGA', 'SACANCHE', 'SACANCHE'),
(1761, '220406', 'SAN MARTIN', 'HUALLAGA', 'TINGO DE SAPOSOA', 'TINGO DE SAPOSOA'),
(1762, '220501', 'SAN MARTIN', 'LAMAS', 'LAMAS', 'LAMAS'),
(1763, '220502', 'SAN MARTIN', 'LAMAS', 'ALONSO DE ALVARADO', 'ROQUE'),
(1764, '220503', 'SAN MARTIN', 'LAMAS', 'BARRANQUITA', 'BARRANQUITA'),
(1765, '220504', 'SAN MARTIN', 'LAMAS', 'CAYNARACHI', 'PONGO DE CAYNARACHI'),
(1766, '220505', 'SAN MARTIN', 'LAMAS', 'CUÑUMBUQUI', 'CUÑUMBUQUI'),
(1767, '220506', 'SAN MARTIN', 'LAMAS', 'PINTO RECODO', 'PINTO RECODO'),
(1768, '220507', 'SAN MARTIN', 'LAMAS', 'RUMISAPA', 'RUMISAPA'),
(1769, '220508', 'SAN MARTIN', 'LAMAS', 'SAN ROQUE DE CUMBAZA', 'SAN ROQUE DE CUMBAZA'),
(1770, '220509', 'SAN MARTIN', 'LAMAS', 'SHANAO', 'SHANAO'),
(1771, '220510', 'SAN MARTIN', 'LAMAS', 'TABALOSOS', 'TABALOSOS'),
(1772, '220511', 'SAN MARTIN', 'LAMAS', 'ZAPATERO', 'ZAPATERO'),
(1773, '220601', 'SAN MARTIN', 'MARISCAL CACERES', 'JUANJUI', 'JUANJUI'),
(1774, '220602', 'SAN MARTIN', 'MARISCAL CACERES', 'CAMPANILLA', 'CAMPANILLA'),
(1775, '220603', 'SAN MARTIN', 'MARISCAL CACERES', 'HUICUNGO', 'HUICUNGO'),
(1776, '220604', 'SAN MARTIN', 'MARISCAL CACERES', 'PACHIZA', 'PACHIZA'),
(1777, '220605', 'SAN MARTIN', 'MARISCAL CACERES', 'PAJARILLO', 'PAJARILLO'),
(1778, '220701', 'SAN MARTIN', 'PICOTA', 'PICOTA', 'PICOTA'),
(1779, '220702', 'SAN MARTIN', 'PICOTA', 'BUENOS AIRES', 'BUENOS AIRES'),
(1780, '220703', 'SAN MARTIN', 'PICOTA', 'CASPISAPA', 'CASPISAPA'),
(1781, '220704', 'SAN MARTIN', 'PICOTA', 'PILLUANA', 'PILLUANA'),
(1782, '220705', 'SAN MARTIN', 'PICOTA', 'PUCACACA', 'PUCACACA'),
(1783, '220706', 'SAN MARTIN', 'PICOTA', 'SAN CRISTOBAL', 'PUERTO RICO'),
(1784, '220707', 'SAN MARTIN', 'PICOTA', 'SAN HILARION', 'SAN CRISTOBAL DE SISA'),
(1785, '220708', 'SAN MARTIN', 'PICOTA', 'SHAMBOYACU', 'SHAMBOYACU'),
(1786, '220709', 'SAN MARTIN', 'PICOTA', 'TINGO DE PONASA', 'TINGO DE PONASA'),
(1787, '220710', 'SAN MARTIN', 'PICOTA', 'TRES UNIDOS', 'TRES UNIDOS'),
(1788, '220801', 'SAN MARTIN', 'RIOJA', 'RIOJA', 'RIOJA'),
(1789, '220802', 'SAN MARTIN', 'RIOJA', 'AWAJUN', 'BAJO NARANJILLO'),
(1790, '220803', 'SAN MARTIN', 'RIOJA', 'ELIAS SOPLIN VARGAS', 'SEGUNDA JERUSALEN-AZUNGUILLO'),
(1791, '220804', 'SAN MARTIN', 'RIOJA', 'NUEVA CAJAMARCA', 'NUEVA CAJAMARCA'),
(1792, '220805', 'SAN MARTIN', 'RIOJA', 'PARDO MIGUEL', 'NARANJOS'),
(1793, '220806', 'SAN MARTIN', 'RIOJA', 'POSIC', 'POSIC'),
(1794, '220807', 'SAN MARTIN', 'RIOJA', 'SAN FERNANDO', 'SAN FERNANDO'),
(1795, '220808', 'SAN MARTIN', 'RIOJA', 'YORONGOS', 'YORONGOS'),
(1796, '220809', 'SAN MARTIN', 'RIOJA', 'YURACYACU', 'YURACYACU'),
(1797, '220901', 'SAN MARTIN', 'SAN MARTIN', 'TARAPOTO', 'TARAPOTO'),
(1798, '220902', 'SAN MARTIN', 'SAN MARTIN', 'ALBERTO LEVEAU', 'UTCURARCA'),
(1799, '220903', 'SAN MARTIN', 'SAN MARTIN', 'CACATACHI', 'CACATACHI'),
(1800, '220904', 'SAN MARTIN', 'SAN MARTIN', 'CHAZUTA', 'CHAZUTA'),
(1801, '220905', 'SAN MARTIN', 'SAN MARTIN', 'CHIPURANA', 'NAVARRO'),
(1802, '220906', 'SAN MARTIN', 'SAN MARTIN', 'EL PORVENIR', 'PELEJO'),
(1803, '220907', 'SAN MARTIN', 'SAN MARTIN', 'HUIMBAYOC', 'HUIMBAYOC'),
(1804, '220908', 'SAN MARTIN', 'SAN MARTIN', 'JUAN GUERRA', 'JUAN GUERRA'),
(1805, '220909', 'SAN MARTIN', 'SAN MARTIN', 'LA BANDA DE SHILCAYO', 'LA BANDA'),
(1806, '220910', 'SAN MARTIN', 'SAN MARTIN', 'MORALES', 'MORALES'),
(1807, '220911', 'SAN MARTIN', 'SAN MARTIN', 'PAPAPLAYA', 'PAPAPLAYA'),
(1808, '220912', 'SAN MARTIN', 'SAN MARTIN', 'SAN ANTONIO', 'SAN ANTONIO'),
(1809, '220913', 'SAN MARTIN', 'SAN MARTIN', 'SAUCE', 'SAUCE'),
(1810, '220914', 'SAN MARTIN', 'SAN MARTIN', 'SHAPAJA', 'SHAPAJA'),
(1811, '221001', 'SAN MARTIN', 'TOCACHE', 'TOCACHE', 'TOCACHE'),
(1812, '221002', 'SAN MARTIN', 'TOCACHE', 'NUEVO PROGRESO', 'NUEVO PROGRESO'),
(1813, '221003', 'SAN MARTIN', 'TOCACHE', 'POLVORA', 'POLVORA'),
(1814, '221004', 'SAN MARTIN', 'TOCACHE', 'SHUNTE', 'TAMBO DE PAJA /18'),
(1815, '221005', 'SAN MARTIN', 'TOCACHE', 'UCHIZA', 'UCHIZA'),
(1816, '230101', 'TACNA', 'TACNA', 'TACNA', 'TACNA'),
(1817, '230102', 'TACNA', 'TACNA', 'ALTO DE LA ALIANZA', 'LA ESPERANZA'),
(1818, '230103', 'TACNA', 'TACNA', 'CALANA', 'CALANA'),
(1819, '230104', 'TACNA', 'TACNA', 'CIUDAD NUEVA', 'CIUDAD NUEVA'),
(1820, '230105', 'TACNA', 'TACNA', 'INCLAN', 'SAMA GRANDE'),
(1821, '230106', 'TACNA', 'TACNA', 'PACHIA', 'PACHIA'),
(1822, '230107', 'TACNA', 'TACNA', 'PALCA', 'PALCA'),
(1823, '230108', 'TACNA', 'TACNA', 'POCOLLAY', 'POCOLLAY'),
(1824, '230109', 'TACNA', 'TACNA', 'SAMA', 'LAS YARAS'),
(1825, '230110', 'TACNA', 'TACNA', 'CORONEL GREGORIO ALBARRACIN LANCHIPA', 'ALFONSO UGARTE'),
(1826, '230111', 'TACNA', 'TACNA', 'LA YARADA LOS PALOS', 'LOS PALOS'),
(1827, '230201', 'TACNA', 'CANDARAVE', 'CANDARAVE', 'CANDARAVE'),
(1828, '230202', 'TACNA', 'CANDARAVE', 'CAIRANI', 'CAIRANI'),
(1829, '230203', 'TACNA', 'CANDARAVE', 'CAMILACA', 'ALTO CAMILACA'),
(1830, '230204', 'TACNA', 'CANDARAVE', 'CURIBAYA', 'CURIBAYA'),
(1831, '230205', 'TACNA', 'CANDARAVE', 'HUANUARA', 'HUANUARA'),
(1832, '230206', 'TACNA', 'CANDARAVE', 'QUILAHUANI', 'QUILAHUANI'),
(1833, '230301', 'TACNA', 'JORGE BASADRE', 'LOCUMBA', 'LOCUMBA'),
(1834, '230302', 'TACNA', 'JORGE BASADRE', 'ILABAYA', 'ILABAYA'),
(1835, '230303', 'TACNA', 'JORGE BASADRE', 'ITE', 'ITE'),
(1836, '230401', 'TACNA', 'TARATA', 'TARATA', 'TARATA'),
(1837, '230402', 'TACNA', 'TARATA', 'HEROES ALBARRACIN', 'CHUCATAMANI'),
(1838, '230403', 'TACNA', 'TARATA', 'ESTIQUE', 'ESTIQUE'),
(1839, '230404', 'TACNA', 'TARATA', 'ESTIQUE-PAMPA', 'ESTIQUE-PAMPA'),
(1840, '230405', 'TACNA', 'TARATA', 'SITAJARA', 'SITAJARA'),
(1841, '230406', 'TACNA', 'TARATA', 'SUSAPAYA', 'SUSAPAYA'),
(1842, '230407', 'TACNA', 'TARATA', 'TARUCACHI', 'TARUCACHI'),
(1843, '230408', 'TACNA', 'TARATA', 'TICACO', 'TICACO'),
(1844, '240101', 'TUMBES', 'TUMBES', 'TUMBES', 'TUMBES'),
(1845, '240102', 'TUMBES', 'TUMBES', 'CORRALES', 'SAN PEDRO DE LOS INCAS'),
(1846, '240103', 'TUMBES', 'TUMBES', 'LA CRUZ', 'CALETA CRUZ'),
(1847, '240104', 'TUMBES', 'TUMBES', 'PAMPAS DE HOSPITAL', 'PAMPAS DE HOSPITAL'),
(1848, '240105', 'TUMBES', 'TUMBES', 'SAN JACINTO', 'SAN JACINTO'),
(1849, '240106', 'TUMBES', 'TUMBES', 'SAN JUAN DE LA VIRGEN', 'SAN JUAN DE LA VIRGEN'),
(1850, '240201', 'TUMBES', 'CONTRALMIRANTE VILLAR', 'ZORRITOS', 'ZORRITOS'),
(1851, '240202', 'TUMBES', 'CONTRALMIRANTE VILLAR', 'CASITAS', 'CAÑAVERAL'),
(1852, '240203', 'TUMBES', 'CONTRALMIRANTE VILLAR', 'CANOAS DE PUNTA SAL', 'CANCAS'),
(1853, '240301', 'TUMBES', 'ZARUMILLA', 'ZARUMILLA', 'ZARUMILLA'),
(1854, '240302', 'TUMBES', 'ZARUMILLA', 'AGUAS VERDES', 'AGUAS VERDES'),
(1855, '240303', 'TUMBES', 'ZARUMILLA', 'MATAPALO', 'MATAPALO'),
(1856, '240304', 'TUMBES', 'ZARUMILLA', 'PAPAYAL', 'PAPAYAL'),
(1857, '250101', 'UCAYALI', 'CORONEL PORTILLO', 'CALLERIA', 'PUCALLPA'),
(1858, '250102', 'UCAYALI', 'CORONEL PORTILLO', 'CAMPOVERDE', 'CAMPO VERDE'),
(1859, '250103', 'UCAYALI', 'CORONEL PORTILLO', 'IPARIA', 'IPARIA'),
(1860, '250104', 'UCAYALI', 'CORONEL PORTILLO', 'MASISEA', 'MASISEA'),
(1861, '250105', 'UCAYALI', 'CORONEL PORTILLO', 'YARINACOCHA', 'PUERTO CALLAO'),
(1862, '250106', 'UCAYALI', 'CORONEL PORTILLO', 'NUEVA REQUENA', 'NUEVA REQUENA'),
(1863, '250107', 'UCAYALI', 'CORONEL PORTILLO', 'MANANTAY', 'SAN FERNANDO'),
(1864, '250201', 'UCAYALI', 'ATALAYA', 'RAYMONDI', 'ATALAYA'),
(1865, '250202', 'UCAYALI', 'ATALAYA', 'SEPAHUA', 'SEPAHUA'),
(1866, '250203', 'UCAYALI', 'ATALAYA', 'TAHUANIA', 'BOLOGNESI'),
(1867, '250204', 'UCAYALI', 'ATALAYA', 'YURUA', 'BREU'),
(1868, '250301', 'UCAYALI', 'PADRE ABAD', 'PADRE ABAD', 'AGUAYTIA'),
(1869, '250302', 'UCAYALI', 'PADRE ABAD', 'IRAZOLA', 'SAN ALEJANDRO'),
(1870, '250303', 'UCAYALI', 'PADRE ABAD', 'CURIMANA', 'CURIMANA'),
(1871, '250304', 'UCAYALI', 'PADRE ABAD', 'NESHUYA', 'MONTE ALEGRE'),
(1872, '250305', 'UCAYALI', 'PADRE ABAD', 'ALEXANDER VON HUMBOLDT', 'ALEXANDER VON HUMBOLDT'),
(1873, '250401', 'UCAYALI', 'PURUS', 'PURUS', 'ESPERANZA');

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
  `nombre_users` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_fotografia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_persona` bigint DEFAULT NULL,
  `users_estado` tinyint DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nombre_users`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `username`, `user_fotografia`, `id_persona`, `users_estado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'reynaalfredo421@gmail.com', NULL, '$2y$10$PguwZg.k8bCjqmvyH8Z9BuaLgKJv4QcVhtkO6QFwUbcnMR08VlNq2', NULL, NULL, NULL, 'superadmin', 'usuarios/1703949274-a9b2674e-c733-4d91-9edd-bbb29c8c7362.webp', 1, 1, '2FoH5zKGYVLGbX6pwFFVmQPJJVeS2vg8eFTD4arCFO1Qs9t2xahsEpslH6jN', '2023-06-13 22:56:32', '2023-12-30 15:14:34'),
(4, 'KAREN PAMELA', 'karenpamela@emyspets.com', NULL, '$2y$10$SG3BqngOVwSiwkzyab75m.jkLQDHlGA/.tlZRlvGTQHv9n3Mir47C', NULL, NULL, NULL, 'karen_emy2024', 'usuarios/1709129267-default_photo.webp', 4, 1, '835h4moKf5YObwCoHf6St5IX2NAywtHOCRuJ8ERSUvM8pZydedZsWKkwkHO2', '2024-02-25 02:46:15', '2024-03-01 03:23:00');

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
  `id_tipo_pago` bigint DEFAULT '3',
  `id_moneda` bigint DEFAULT '1',
  `venta_tipo_campo` decimal(10,2) DEFAULT NULL COMMENT 'aca se guardara el tipo de cambio',
  `venta_condicion_resumen` tinyint NOT NULL DEFAULT '1' COMMENT '1-Registro, 2-Actualizar, 3-baja',
  `venta_tipo_envio` tinyint NOT NULL DEFAULT '0' COMMENT '1-directo, 2-resumen diario',
  `venta_direccion` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_tipo` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `venta_serie` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_correlativo` varchar(60) COLLATE utf8mb3_unicode_ci NOT NULL,
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
  `venta_observacion` varchar(500) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tipo_documento_modificar` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `serie_modificar` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `correlativo_modificar` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_codigo_motivo_nota` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_estado_sunat` tinyint NOT NULL DEFAULT '0',
  `venta_fecha_envio` datetime DEFAULT NULL,
  `venta_rutaXML` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_rutaCDR` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_respuesta_sunat` varchar(2000) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `venta_fecha_de_baja` date DEFAULT NULL,
  `anulado_sunat` tinyint NOT NULL DEFAULT '0',
  `venta_cancelar` tinyint(1) NOT NULL DEFAULT '1',
  `venta_seriecorrelativo_notaventa` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '	Aqui se llena cuando se edita una nota de venta',
  `venta_codigo` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `cambiar_concepto` tinyint NOT NULL DEFAULT '1' COMMENT '1 es NO, 2 es SI',
  `concepto_nuevo` varchar(300) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
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
(1, 1, 1, 4, 3, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '1', '0.00', '0.00', '0.00', '0.00', '127.10', '22.90', 1, '0.00', '0.00', '150.00', '150.00', '0.00', '2024-04-05 14:37:19', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1712345839.0604', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(2, 1, 1, 1, 4, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '2', '0.00', '0.00', '0.00', '0.00', '33.83', '6.17', 1, '0.00', '0.00', '40.00', '40.00', '0.00', '2024-04-14 19:00:22', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713139222.4354', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(3, 1, 1, 1, 4, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '3', '0.00', '0.00', '0.00', '0.00', '116.94', '21.06', 1, '0.00', '0.00', '138.00', '140.00', '2.00', '2024-04-14 19:06:33', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713139593.8204', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(4, 1, 1, 1, 3, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '4', '0.00', '0.00', '0.00', '0.00', '8.48', '1.52', 1, '0.00', '0.00', '10.00', '10.00', '0.00', '2024-04-14 19:09:33', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713139773.0702', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(5, 1, 1, 1, 3, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '5', '0.00', '0.00', '0.00', '0.00', '3.38', '0.62', 1, '0.00', '0.00', '4.00', '5.00', '1.00', '2024-04-14 19:10:24', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713139824.8106', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(6, 1, 1, 1, 5, NULL, 1, '0.00', 1, 0, NULL, '01', 'F001', '1', '0.00', '0.00', '0.00', '0.00', '8.45', '1.55', 1, '0.00', '0.00', '10.00', '10.00', '0.00', '2024-04-14 19:11:27', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713139887.995', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(7, 1, 1, 1, 3, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '6', '0.00', '0.00', '0.00', '0.00', '35.60', '6.40', 1, '0.00', '0.00', '42.00', '50.00', '8.00', '2024-04-14 19:22:56', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713140576.0053', 1, NULL, 0, 1, 1, 2, NULL, NULL),
(8, 1, 1, 1, 3, NULL, 1, '0.00', 1, 0, NULL, '03', 'B001', '7', '0.00', '0.00', '0.00', '0.00', '14.41', '2.59', 1, '0.00', '0.00', '17.00', '17.00', '0.00', '2024-04-17 16:47:48', NULL, '', NULL, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '1713390468.3863', 1, NULL, 0, 1, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ventas_anulados`
--

CREATE TABLE `ventas_anulados` (
  `id_venta_anulado` bigint UNSIGNED NOT NULL,
  `venta_anulado_fecha` date NOT NULL,
  `venta_anulado_serie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_anulado_correlativo` int NOT NULL,
  `venta_anulacion_ticket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_anulado_rutaXML` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_anulado_rutaCDR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_anulado_estado_sunat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `id_users` bigint UNSIGNED NOT NULL,
  `venta_anulado_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `venta_anulado_estado` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ventas_cuotas`
--

CREATE TABLE `ventas_cuotas` (
  `id_ventas_cuotas` bigint UNSIGNED NOT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `id_tipo_pago` bigint UNSIGNED DEFAULT NULL,
  `id_formas_pago` bigint UNSIGNED DEFAULT NULL,
  `venta_cuota_numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_cuota_importe` decimal(10,2) NOT NULL,
  `venta_cuota_fecha` date NOT NULL,
  `venta_cuota_estado` tinyint NOT NULL,
  `venta_cuota_pago` tinyint NOT NULL COMMENT 'este campo sera para saber si se pago la cuota o no 1 pago 0 no pago',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id_venta_detalle` bigint NOT NULL,
  `id_venta` bigint NOT NULL,
  `id_pro` bigint NOT NULL,
  `venta_detalle_valor_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_precio_unitario` decimal(10,2) NOT NULL,
  `venta_detalle_nombre_producto` varchar(200) COLLATE utf8mb3_unicode_ci NOT NULL,
  `venta_detalle_cantidad` double NOT NULL,
  `venta_detalle_total_igv` decimal(10,2) NOT NULL,
  `venta_detalle_porcentaje_igv` int NOT NULL DEFAULT '0',
  `venta_detalle_total_icbper` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_valor_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_importe_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ventas_detalle`
--

INSERT INTO `ventas_detalle` (`id_venta_detalle`, `id_venta`, `id_pro`, `venta_detalle_valor_unitario`, `venta_detalle_precio_unitario`, `venta_detalle_nombre_producto`, `venta_detalle_cantidad`, `venta_detalle_total_igv`, `venta_detalle_porcentaje_igv`, `venta_detalle_total_icbper`, `venta_detalle_valor_total`, `venta_detalle_importe_total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '8.47', '10.00', 'Lentes con elastico-Perro ', 10, '15.30', 18, '0.00', '84.70', '100.00', NULL, NULL),
(2, 1, 2, '4.24', '5.00', 'Lentes para gato 8 cm', 10, '7.60', 18, '0.00', '42.40', '50.00', NULL, NULL),
(3, 2, 3, '5.08', '6.00', 'Lentes para gato 11 cm', 3, '2.76', 18, '0.00', '15.24', '18.00', NULL, NULL),
(4, 2, 8, '1.69', '2.00', 'Muslo de pollo toy', 10, '3.10', 18, '0.00', '16.90', '20.00', NULL, NULL),
(5, 2, 9, '1.69', '2.00', 'Hueso Mancuerna Chico', 1, '0.31', 18, '0.00', '1.69', '2.00', NULL, NULL),
(6, 3, 3, '5.08', '6.00', 'Lentes para gato 11 cm', 1, '0.92', 18, '0.00', '5.08', '6.00', NULL, NULL),
(7, 3, 9, '55.93', '66.00', 'Hueso Mancuerna Chico', 2, '20.14', 18, '0.00', '111.86', '132.00', NULL, NULL),
(8, 4, 10, '4.24', '5.00', 'Hueso Mancuerna  Mediano', 2, '1.52', 18, '0.00', '8.48', '10.00', NULL, NULL),
(9, 5, 9, '1.69', '2.00', 'Hueso Mancuerna Chico', 2, '0.62', 18, '0.00', '3.38', '4.00', NULL, NULL),
(10, 6, 9, '1.69', '2.00', 'Hueso Mancuerna Chico', 5, '1.55', 18, '0.00', '8.45', '10.00', NULL, NULL),
(11, 7, 13, '3.39', '4.00', 'Juguete soga c/pelota tenis JF1004 ', 2, '1.22', 18, '0.00', '6.78', '8.00', NULL, NULL),
(12, 7, 14, '3.39', '4.00', 'Juguete soga c/pelota tenis F1005', 2, '1.22', 18, '0.00', '6.78', '8.00', NULL, NULL),
(13, 7, 15, '3.39', '4.00', 'Juguete soga c/pelota tenis JF1011', 2, '1.22', 18, '0.00', '6.78', '8.00', NULL, NULL),
(14, 7, 16, '4.24', '5.00', 'Juguete soga c/pelota tenis JF1012', 2, '1.52', 18, '0.00', '8.48', '10.00', NULL, NULL),
(15, 7, 17, '3.39', '4.00', 'Pelota dura c/soga solo rojo ', 2, '1.22', 18, '0.00', '6.78', '8.00', NULL, NULL),
(16, 8, 13, '3.39', '4.00', 'Juguete soga c/pelota tenis JF1004 ', 1, '0.61', 18, '0.00', '3.39', '4.00', NULL, NULL),
(17, 8, 14, '3.39', '4.00', 'Juguete soga c/pelota tenis F1005', 1, '0.61', 18, '0.00', '3.39', '4.00', NULL, NULL),
(18, 8, 15, '3.39', '4.00', 'Juguete soga c/pelota tenis JF1011', 1, '0.61', 18, '0.00', '3.39', '4.00', NULL, NULL),
(19, 8, 16, '4.24', '5.00', 'Juguete soga c/pelota tenis JF1012', 1, '0.76', 18, '0.00', '4.24', '5.00', NULL, NULL);

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
(1, 1, 1, '150.00', 1, NULL, NULL),
(2, 2, 1, '40.00', 1, NULL, NULL),
(3, 3, 1, '138.00', 1, NULL, NULL),
(4, 4, 1, '10.00', 1, NULL, NULL),
(5, 5, 1, '4.00', 1, NULL, NULL),
(6, 6, 1, '10.00', 1, NULL, NULL),
(7, 7, 1, '42.00', 1, NULL, NULL),
(8, 8, 1, '17.00', 1, NULL, NULL);

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
  `venta_web_direccion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_otros_datos` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tipo_documento` bigint DEFAULT NULL,
  `venta_web_numdoc_receptor` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_nombre_receptor` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_correo_receptor` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_telefono_receptor` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_estado` tinyint NOT NULL,
  `venta_web_estado_pedido` tinyint DEFAULT NULL COMMENT '0 pendiente de confirmacion 1 confirmacion y pendiente de entrega o envio ,2 enviado , 3 entregado',
  `venta_web_codigotranslado` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_documentotransferencia` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_web_fecha_enviado` datetime DEFAULT NULL,
  `id_agencias` bigint DEFAULT NULL,
  `id_usuarios_misky` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indexes for table `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`),
  ADD KEY `caja_id_caja_numero_foreign` (`id_caja_numero`);

--
-- Indexes for table `caja_numero`
--
ALTER TABLE `caja_numero`
  ADD PRIMARY KEY (`id_caja_numero`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_ca`),
  ADD KEY `categorias_id_fa_foreign` (`id_fa`);

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
-- Indexes for table `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`id_fa`);

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
-- Indexes for table `movimientos_productos`
--
ALTER TABLE `movimientos_productos`
  ADD PRIMARY KEY (`id_movimientos_productos`),
  ADD KEY `movimientos_productos_id_users_foreign` (`id_users`);

--
-- Indexes for table `movimientos_productos_detalle`
--
ALTER TABLE `movimientos_productos_detalle`
  ADD PRIMARY KEY (`id_movimientos_productos_detalle`),
  ADD KEY `movimientos_productos_detalle_id_movimientos_productos_foreign` (`id_movimientos_productos`),
  ADD KEY `movimientos_productos_detalle_id_producto_foreign` (`id_pro`);

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
-- Indexes for table `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`id_orden_compra`),
  ADD KEY `orden_compra_id_solicitante_foreign` (`id_solicitante`),
  ADD KEY `orden_compra_id_aprobacion_foreign` (`id_aprobacion`),
  ADD KEY `orden_compra_id_proveedores_foreign` (`id_proveedores`),
  ADD KEY `orden_compra_id_sucursal_foreign` (`id_sede`),
  ADD KEY `orden_compra_id_tipo_de_pago_foreign` (`id_tipo_pago`);

--
-- Indexes for table `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `detalle_compra_id_orden_compra_foreign` (`id_orden_compra`),
  ADD KEY `detalle_compra_id_insumos_sucursal_foreign` (`id_pro`);

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
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_pro`),
  ADD KEY `productos_id_ca_foreign` (`id_ca`),
  ADD KEY `productos_id_medida_foreign` (`id_medida`),
  ADD KEY `productos_id_tipo_afectacion_foreign` (`id_tipo_afectacion`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedores`),
  ADD KEY `proveedores_id_tipo_documento_foreign` (`id_tipo_documento`);

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
-- Indexes for table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`id_serie`),
  ADD KEY `serie_id_caja_numero_foreign` (`id_caja_numero`);

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
-- Indexes for table `ubigeo`
--
ALTER TABLE `ubigeo`
  ADD PRIMARY KEY (`id_ubigeo`);

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
  ADD KEY `id_comanda_detalle` (`id_pro`);

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
-- AUTO_INCREMENT for table `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id_almacen` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `caja_numero`
--
ALTER TABLE `caja_numero`
  MODIFY `id_caja_numero` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_ca` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_clientes` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id_envio_resumen` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  MODIFY `id_envio_resumen_detalle` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `familias`
--
ALTER TABLE `familias`
  MODIFY `id_fa` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `medida`
--
ALTER TABLE `medida`
  MODIFY `id_medida` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id_moneda` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movimientos_productos`
--
ALTER TABLE `movimientos_productos`
  MODIFY `id_movimientos_productos` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movimientos_productos_detalle`
--
ALTER TABLE `movimientos_productos_detalle`
  MODIFY `id_movimientos_productos_detalle` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oferta_detalle`
--
ALTER TABLE `oferta_detalle`
  MODIFY `id_oferta_detalle` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_opciones` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden_compra` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  MODIFY `id_detalle_compra` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_pro` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=706;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedores` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `serie`
--
ALTER TABLE `serie`
  MODIFY `id_serie` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id_submenu` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

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
-- AUTO_INCREMENT for table `ubigeo`
--
ALTER TABLE `ubigeo`
  MODIFY `id_ubigeo` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1874;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ventas_anulados`
--
ALTER TABLE `ventas_anulados`
  MODIFY `id_venta_anulado` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ventas_cuotas`
--
ALTER TABLE `ventas_cuotas`
  MODIFY `id_ventas_cuotas` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id_venta_detalle` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ventas_detalle_pagos`
--
ALTER TABLE `ventas_detalle_pagos`
  MODIFY `id_venta_detalle_pago` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `venta_web`
--
ALTER TABLE `venta_web`
  MODIFY `id_venta_web` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visualizacion`
--
ALTER TABLE `visualizacion`
  MODIFY `id_visualizacion` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_id_fa_foreign` FOREIGN KEY (`id_fa`) REFERENCES `familias` (`id_fa`);

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
-- Constraints for table `movimientos_productos`
--
ALTER TABLE `movimientos_productos`
  ADD CONSTRAINT `movimientos_productos_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `movimientos_productos_detalle`
--
ALTER TABLE `movimientos_productos_detalle`
  ADD CONSTRAINT `movimientos_productos_detalle_id_movimientos_productos_foreign` FOREIGN KEY (`id_movimientos_productos`) REFERENCES `movimientos_productos` (`id_movimientos_productos`);

--
-- Constraints for table `opciones`
--
ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_id_submenu_foreign` FOREIGN KEY (`id_submenu`) REFERENCES `submenu` (`id_submenu`);

--
-- Constraints for table `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `orden_compra_id_proveedores_foreign` FOREIGN KEY (`id_proveedores`) REFERENCES `proveedores` (`id_proveedores`),
  ADD CONSTRAINT `orden_compra_id_solicitante_foreign` FOREIGN KEY (`id_solicitante`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `orden_compra_id_tipo_pago_foreign` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tipo_pago` (`id_tipo_pago`);

--
-- Constraints for table `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  ADD CONSTRAINT `detalle_compra_id_orden_compra_foreign` FOREIGN KEY (`id_orden_compra`) REFERENCES `orden_compra` (`id_orden_compra`);

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_id_ca_foreign` FOREIGN KEY (`id_ca`) REFERENCES `categorias` (`id_ca`),
  ADD CONSTRAINT `productos_id_medida_foreign` FOREIGN KEY (`id_medida`) REFERENCES `medida` (`id_medida`),
  ADD CONSTRAINT `productos_id_tipo_afectacion_foreign` FOREIGN KEY (`id_tipo_afectacion`) REFERENCES `tipo_afectacion` (`id_tipo_afectacion`);

--
-- Constraints for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_id_tipo_documento_foreign` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`);

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
