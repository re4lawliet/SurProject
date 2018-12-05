-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2018 a las 05:35:44
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sur`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `apellido` varchar(250) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `nit` varchar(250) DEFAULT NULL,
  `telefono` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `direccion`, `nit`, `telefono`, `created_at`, `updated_at`) VALUES
(1, '123', 'Monterroso', '12 Ave 27-66', '123', '54822108', '2018-11-30 04:55:02', '2018-11-30 04:55:02'),
(2, '123', '123', '123', '123', '123', '2018-11-30 04:55:11', '2018-11-30 04:55:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre_empresa` varchar(250) DEFAULT NULL,
  `nit_empresa` varchar(250) DEFAULT NULL,
  `direccion_empresa` varchar(250) DEFAULT NULL,
  `telefono_oficina` varchar(250) DEFAULT NULL,
  `telefono_empresa` varchar(250) DEFAULT NULL,
  `correo_empresa` varchar(250) DEFAULT NULL,
  `telefono_encargado` varchar(250) DEFAULT NULL,
  `correo_encargado` varchar(250) DEFAULT NULL,
  `nombre_encargado` varchar(250) DEFAULT NULL,
  `puesto_encargado` varchar(250) DEFAULT NULL,
  `nombre_banco` varchar(250) DEFAULT NULL,
  `forma_pago` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre_empresa`, `nit_empresa`, `direccion_empresa`, `telefono_oficina`, `telefono_empresa`, `correo_empresa`, `telefono_encargado`, `correo_encargado`, `nombre_encargado`, `puesto_encargado`, `nombre_banco`, `forma_pago`, `created_at`, `updated_at`) VALUES
(2, 'Distribuidora Alvarez Wong / Daw', NULL, NULL, 'Oficina (502) 2473-3652', NULL, 'daw@alvarezwong.com', 'Celular (502) 3077-2399', NULL, 'Ing. Gustavo Alvarez W.', 'Gerente Comercial', 'Bi', 'cheque', '2018-11-12 17:14:42', '2018-11-14 13:03:36'),
(3, 'Samboro, S.A.', NULL, NULL, 'Oficinas: (502) 2202-6900', NULL, NULL, 'Móvil: (502) 5697-2548', 'apadilla@samboro.com', 'Alfonso Padilla', 'Proyectos - Samboro', NULL, NULL, '2018-11-12 17:16:43', '2018-11-12 17:16:43'),
(4, 'Materiales de construccion importados de Taiwan,S.A. / ezet', NULL, NULL, NULL, 'Tel.23370167', 'ventas.ezet@gmail.com', 'Cel. 59365954', 'ventas.ezeset@gmail.com', 'Vanessa Argueta Cerraduras Ezset', NULL, NULL, NULL, '2018-11-12 17:18:10', '2018-11-12 17:18:10'),
(5, 'Hidroconfort / Jose Americo Estrada', NULL, NULL, '4721 1507- 4693 7214', '4721 1507- 4693 7214', 'jaestrada@hidroconfort.com.gt', '4721 1507- 4693 7214', 'jaestrada@hidroconfort.com.gt', 'Jose Américo Estrada', 'Gerente de Ventas', NULL, NULL, '2018-11-12 17:19:43', '2018-11-12 17:19:43'),
(6, 'Viglass, S.A.', NULL, NULL, 'Móvil: 30025092', 'Móvil: 30025092', 'lissie@viglass.com', 'Móvil: 30025092', 'lissie@viglass.com', 'Elvis Lanuza', 'Encargado', NULL, NULL, '2018-11-12 17:21:52', '2018-11-12 17:21:52'),
(7, 'Suministro Instalacion y Construccion, S.A. / Sicsa', NULL, NULL, '22021010- 24347019', '22021010- 24347019', 'c.quevedo@sicsa.com.gt', '22021010- 24347019', 'c.quevedo@sicsa.com.gt', 'Julie Castillo de Guzman', 'Gerente', NULL, NULL, '2018-11-12 17:30:21', '2018-11-12 17:30:21'),
(8, 'Grupo Adhere / Jose Luis Rodriguez Lucas', NULL, NULL, NULL, NULL, 'servipin.jl@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:31:15', '2018-11-12 17:31:15'),
(9, 'Modus / Tio, S.A.', NULL, NULL, '56961415 - 2494-6400', '56961415 - 2494-6400', 'ventas@modus.com.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:32:05', '2018-11-12 17:32:05'),
(10, 'Cotyssa, S.A.', NULL, NULL, NULL, NULL, 'karoche@cotyssa.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:32:36', '2018-11-12 17:32:36'),
(11, 'Rotulos Molina', NULL, NULL, '66341801', '66341801', 'rotulos@intelnet.net.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:33:21', '2018-11-12 17:33:21'),
(12, 'Proyectos de ahorro energetico / Proa', NULL, NULL, '55958923', '55958923', 'gervin@proa.com.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:34:15', '2018-11-12 17:34:15'),
(13, 'Servicios de mano de obra, S.A. / Sermasa', NULL, NULL, NULL, NULL, 'be2767@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:34:45', '2018-11-12 17:34:45'),
(14, 'Gruas y formaletas, S.A.', NULL, NULL, NULL, NULL, 'grufosa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:35:13', '2018-11-12 17:35:13'),
(15, 'Durman Esquivel Guatemala, S.A.', NULL, NULL, 'Tel: +502.6636-1111', 'Tel: +502.6636-1111', 'acaal@aliaxis-la.com', 'Movil: 55101111', NULL, 'Anabela Caal', NULL, NULL, NULL, '2018-11-12 17:37:02', '2018-11-12 17:37:02'),
(16, 'Equipos y fijaciones de Guatemala / Efisa', NULL, NULL, '2388 0606 - 59909922', '2388 0606 - 59909922', 'servicioconstruccion@efisaguate.com', '2388 0606 - 59909922', NULL, 'Mario Cuque', NULL, NULL, NULL, '2018-11-12 17:38:03', '2018-11-12 17:38:03'),
(17, 'Cisa / Cerraduras Internacionales, S.A.', NULL, NULL, 'T +502 2323-8723', 'T +502 2323-8723', 'ecadenas@corpcisa.com', 'M +502 5201-0021', 'grb@corpcisa.com', 'Ing. Guillermo Ramos Bianchi', NULL, NULL, NULL, '2018-11-12 17:39:29', '2018-11-12 17:39:29'),
(18, 'Solpro', NULL, NULL, NULL, NULL, 'ventas@solpro.com', 'Cel. 4049-1265', NULL, 'Nancy Tobar González', NULL, NULL, NULL, '2018-11-12 17:40:16', '2018-11-12 17:40:16'),
(19, 'Recsa', NULL, NULL, '23669180', '23669180', 'ventas@recsacorp.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:40:48', '2018-11-12 17:40:48'),
(20, 'Euro Morteros, S.A.', NULL, NULL, '23858642', '23858642', 'recepcion@euromorteros.com.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:41:35', '2018-11-12 17:41:35'),
(21, 'Grupo Moed, S.A.', NULL, NULL, 'Tel: 2363-5335', 'Tel: 2363-5335', 'ovillatoro@grupomoed.com', 'Tel: 2363-5335', NULL, 'Omar Orellana', NULL, NULL, NULL, '2018-11-12 17:42:13', '2018-11-12 17:42:13'),
(22, 'Distribuidora electronica, S.A. / Distelsa', NULL, NULL, '24230100/56908490', '24230100/56908490', 'max.zona10@distelsa.com.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:43:26', '2018-11-12 17:43:26'),
(23, 'Inmobiliaria la Roca, S.A.', NULL, NULL, '2209-4141', '2209-4141', 'hmendoza@laroca.com.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:49:09', '2018-11-12 17:49:09'),
(24, 'Proteccion Centroamericana, S.A.', NULL, NULL, '24197272', '24197272', 'egarcia@proteccioncentroamericana.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:49:31', '2018-11-12 17:49:31'),
(25, 'Corporacion zuma, S.A.', NULL, NULL, '57555035', '57555035', 'rodrigoarzu@corporacionzuma.com', '57555035', NULL, 'Rodrigo Arzu Matheu', 'Gerente', NULL, NULL, '2018-11-12 17:51:18', '2018-11-12 17:51:18'),
(26, 'Advanced Energy, S.A.', NULL, NULL, '53186817', '53186817', 'josegirongarces@gmail.com', '53186817', NULL, 'Jose Alfredo Firon', 'Gerente', NULL, NULL, '2018-11-12 17:52:14', '2018-11-12 17:52:14'),
(27, 'Tismar, S.A.', NULL, NULL, '23037272', '23037272', 'tismar.auxiliar@gmail.com', '40372423', NULL, 'Walter Marroquin', 'Gerente', NULL, NULL, '2018-11-12 17:53:19', '2018-11-12 17:53:19'),
(28, 'Servicio Tecnico de Extinguidores, S.A.', NULL, NULL, 'directo: 2253-1653', 'pbx. 2463-8624', 'steventasgt@gmail.com', 'pbx. 2463-8624  directo: 2253-1653', NULL, 'SANDY  ARAGÓN', NULL, NULL, NULL, '2018-11-12 17:54:14', '2018-11-12 17:54:14'),
(29, 'appliance Center, S.A.', NULL, NULL, 'Oficina 22618955', 'Oficina 22618955', 'ibanezalbertina@gmail.com aibanez@cocina.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:54:47', '2018-11-12 17:54:47'),
(30, 'Cofrasa', NULL, NULL, NULL, NULL, 'importex@cofrasa.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:55:08', '2018-11-12 17:55:08'),
(31, 'sportmec/ fitness oncite', NULL, NULL, '22459900', '22459900', 'tirsa.monterroso@sportmec.com', '22459900', NULL, 'Monica Roldan', NULL, NULL, NULL, '2018-11-12 17:55:41', '2018-11-12 17:55:41'),
(32, 'Tecnologia Acceso y Seguridad, S.A.', NULL, NULL, '24275959 / 57407980', '24275959 / 57407980', 'facturaciongt@tas-seguridad.com', '24275959 / 57407980', NULL, 'Lybby Acosta', NULL, NULL, NULL, '2018-11-12 17:56:16', '2018-11-12 17:56:16'),
(33, 'Compañía universal de refregeracion, S.A.', NULL, NULL, NULL, NULL, 'jamador@distgranada.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:56:35', '2018-11-12 17:56:35'),
(34, 'Sisdeco', NULL, NULL, NULL, NULL, 'sisdeco.persianas@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 17:56:52', '2018-11-12 17:56:52'),
(35, 'Tikal Doors, S.A.', NULL, NULL, 'Tel.:  (502) 30054857', 'Tel.:  (502) 30054857', 'rramirez@aringuat.com', 'Tel.:  (502) 30054857', NULL, 'Roberto Ramirez', NULL, NULL, NULL, '2018-11-12 17:57:34', '2018-11-12 17:57:34'),
(36, 'Tecno Lum / Jeffrie Alejandro Villalobos Viato', NULL, NULL, '2367-2516 / 2368-2452', '2367-2516 / 2368-2452', 'alejandro.viato@tecnolum.net', '2367-2516 / 2368-2452', NULL, 'Alejandro Villalobos', NULL, NULL, NULL, '2018-11-12 17:58:13', '2018-11-12 17:58:13'),
(37, 'De Motors, S.A.', NULL, NULL, '4154-2814', '4154-2814', 'marvinrolando@demotorsguatemala.com', '4154-2814', NULL, 'Javier Monterroso', NULL, NULL, NULL, '2018-11-12 17:58:54', '2018-11-12 17:58:54'),
(38, 'Multiservicios Cuyan, S.A.', NULL, NULL, 'Tels: 2473-2419 / 2474-4929 / 2472-7239', 'Tels: 2473-2419 / 2474-4929 / 2472-7239', 'cuyan.sa@hotmail.com', 'Cel: 5457-3356', NULL, 'Evelin Estrada', NULL, NULL, NULL, '2018-11-12 17:59:43', '2018-11-12 17:59:43'),
(39, 'Corporacio LG, S.A.', NULL, NULL, '23297900', '23297900', 'cobros@logisticaglobal.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 18:00:09', '2018-11-12 18:00:09'),
(40, 'Sistemas de ingenieria, Electricidad y Comunicaciones', NULL, NULL, '24360063', '24360063', 'ventas1@siete.com.gt', '24360063', NULL, 'Ricardo Colidres', NULL, NULL, NULL, '2018-11-12 18:00:44', '2018-11-12 18:00:44'),
(41, 'Reinventa Solutions, S.A.', NULL, NULL, '4216-8596', '4216-8596', 'jose.lima@deco-art.com.gt', '4216-8596', NULL, 'Carlos Lima', NULL, NULL, NULL, '2018-11-12 18:01:21', '2018-11-12 18:01:21'),
(42, 'Sistemas tecnicos de Guatemala, S.A.', NULL, NULL, '2320 0300', '2320 0300', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 18:01:41', '2018-11-12 18:01:41'),
(43, 'Bimagua s.a./ kalea', NULL, NULL, 'Tel:2367-0090/2490-0000', 'Tel:2367-0090/2490-0000', 'soportetotal@kalea.com.gt', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 18:02:09', '2018-11-12 18:02:09'),
(44, 'Persiluz / Fabrica de percianas y complementos, S.A.', NULL, NULL, NULL, NULL, 'delvin.moran.persiluz@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-12 18:02:33', '2018-11-12 18:02:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listados`
--

CREATE TABLE `listados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `unidad` varchar(2000) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_solicitud` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `listados`
--

INSERT INTO `listados` (`id`, `descripcion`, `unidad`, `cantidad`, `created_at`, `updated_at`, `id_solicitud`) VALUES
(9, 'ladrillos', 'kilo', 15, NULL, NULL, 7),
(10, 'hierro', 'vara', 100, NULL, NULL, 7),
(12, 'hierro', 'kilo', 15, NULL, NULL, 8),
(13, 'hierro', 'kilo', 100, NULL, NULL, 9),
(14, 'ladrillos', 'kilo', 15, NULL, NULL, 10),
(15, 'hierro', 'vara', 100, NULL, NULL, 11),
(16, 'ladrillos', 'vara', 15, NULL, NULL, 12),
(17, 'ladrillos', 'vara', 100, NULL, NULL, 13),
(18, 'ladrillos', 'vara', 100, NULL, NULL, 14),
(19, 'hierro', 'kilo', 15, NULL, NULL, 15),
(20, 'hierro', 'vara', 100, NULL, NULL, 16),
(21, 'ladrillos', 'kilo', 100, NULL, NULL, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_11_08_074029_create_cliente_table', 1),
(4, '2018_11_10_070208_create_empresa_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`id`, `nombre`) VALUES
(15010, 'SEGURIDAD INDUSTRIAL'),
(15020, 'INDIRECTOS DE OBRA'),
(15030, 'OBRAS PRELIMINARES'),
(15040, 'MOVIMIENTO DE TIERRAS'),
(15050, 'GEOTECNIA'),
(15060, 'OBRA GRIS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre_proveedor` varchar(250) DEFAULT NULL,
  `direccion_oficina` varchar(250) DEFAULT NULL,
  `nit_proveedor` varchar(250) DEFAULT NULL,
  `telefono_proveedor` varchar(250) DEFAULT NULL,
  `correo_proveedor` varchar(250) DEFAULT NULL,
  `nombre_banco` varchar(250) DEFAULT NULL,
  `forma_pago` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `nombre_proyecto` varchar(250) DEFAULT NULL,
  `zona_proyecto` varchar(250) DEFAULT NULL,
  `logo_proyecto` varchar(250) DEFAULT NULL,
  `estado_proyecto` varchar(250) DEFAULT NULL,
  `factura_a` varchar(250) DEFAULT NULL,
  `factura_numero` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `nombre_proyecto`, `zona_proyecto`, `logo_proyecto`, `estado_proyecto`, `factura_a`, `factura_numero`, `created_at`, `updated_at`) VALUES
(20, 'RUE 3', '4', 'images/RUE 34Logo_Rue negro.png', 'Proyecto Terminado', 'HEROCHA, S.A.', '8378347-4', '2018-11-22 02:52:31', '2018-11-22 02:52:31'),
(21, 'FABRA, Ciudad Vieja', '10', 'images/FABRA, Ciudad Vieja10Logo_Fabra negro.png', 'Proyecto Terminado', 'HEROCHA, S.A.', '8378347-4', '2018-11-22 02:53:06', '2018-11-22 02:53:06'),
(22, 'GRANAT, Cantón Exposición', '4', 'images/GRANAT, Cantón Exposición4Logo_Granat negro.png', 'Proyecto en Construccion', 'RUTA 4, 6-32 ZONA 4, S.A.', '8838138-2', '2018-11-22 02:54:10', '2018-11-22 02:54:10'),
(23, 'EL PRADO', '1', 'images/EL PRADO1Logo_El Prado negro.png', 'Proyecto en Construccion', 'SUR PROPERTIES, S.A.', '8083276-8', '2018-11-22 02:54:56', '2018-11-22 02:54:56'),
(24, 'ROQUE, Ciudad Nueva', '2', 'images/ROQUE, Ciudad Nueva2Logo_Roque negro.png', 'Proyecto en Planificacion', '13 AVENIDA 11-55 ZONA 2, S.A.', '8968450-8', '2018-11-22 02:55:50', '2018-11-22 02:55:50'),
(25, 'NARAMA', '13', 'images/NARAMA13Logo_Narama negro.png', 'Proyecto en Planificacion', 'LPBC, S.A.', '7518276-9', '2018-11-22 02:56:36', '2018-11-22 02:56:36'),
(26, 'AIRALI', '10', 'images/AIRALI10Logo_Airali negro.png', 'Proyecto en Planificacion', 'AIRALI, S.A.', '9464776-3', '2018-11-22 02:57:23', '2018-11-22 02:57:23'),
(27, 'BALDONE', '2', 'images/BALDONE2Logo_Baldone negro.png', 'Proyecto en Planificacion', 'BALDONE, S.A.', '9463597-8', '2018-11-22 02:57:57', '2018-11-22 02:57:57'),
(28, 'BIROCHA', '18', 'images/BIROCHA18Logo_La Via 8 negro.png', 'Proyecto en Planificacion', 'BIROCHA, S.A.', '9444687-3', '2018-11-22 02:59:32', '2018-11-22 02:59:32'),
(29, 'SUR DEVELOPMENTS, S.A.', NULL, 'images/SUR DEVELOPMENTS, S.A.SUR 01 negro.png', 'Oficina', 'SUR DEVELOPMENTS, S.A.', '9181686-6', '2018-11-22 03:00:25', '2018-11-22 03:00:25'),
(30, 'SUR PROPERTIES, S.A.', NULL, 'images/SUR DEVELOPMENTS, S.A.SUR 01 negro.png', 'Oficina', 'SUR PROPERTIES, S.A.', '8083276-8', '2018-11-22 03:01:03', '2018-11-22 03:01:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `titulo_solicitud` varchar(250) DEFAULT NULL,
  `proveedor` varchar(250) DEFAULT NULL,
  `id_partida` int(11) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `rol` varchar(250) DEFAULT NULL,
  `respondido_manager` varchar(250) DEFAULT NULL,
  `aprobado_manager` varchar(250) DEFAULT NULL,
  `respondido_director` varchar(250) DEFAULT NULL,
  `aprobado_director` varchar(250) DEFAULT NULL,
  `id_proyecto` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `titulo_solicitud`, `proveedor`, `id_partida`, `email`, `rol`, `respondido_manager`, `aprobado_manager`, `respondido_director`, `aprobado_director`, `id_proyecto`, `created_at`, `updated_at`) VALUES
(1, 'asdf', 'asdf', 15050, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 28, '2018-11-30 13:01:30', '2018-11-30 13:01:30'),
(2, 'asdf', 'asdf', 15050, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 28, '2018-11-30 13:01:49', '2018-11-30 13:01:49'),
(3, 'asdf', 'Ladrillera 1', 15040, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 28, '2018-11-30 13:02:45', '2018-11-30 13:02:45'),
(4, 'asdf', 'Ladrillera 1', 15060, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:33:26', '2018-11-30 13:33:26'),
(5, 'asdf', 'asdf', 15060, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:34:22', '2018-11-30 13:34:22'),
(6, 'asdf', 'asdf', 15060, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:36:17', '2018-11-30 13:36:17'),
(7, 'esta', 'Ladrillera 1', 15060, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:39:16', '2018-11-30 13:39:16'),
(8, 'asdf', 'Ladrillera 1', 15010, NULL, 'Haldamir Guzman', '1', '1', '1', '1', 27, '2018-11-30 13:43:07', '2018-12-05 04:19:51'),
(9, 'asdf', 'Ladrillera 1', 15050, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 27, '2018-11-30 13:44:52', '2018-11-30 13:44:52'),
(10, 'asdf', 'Ladrillera 1', 15040, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 26, '2018-11-30 13:46:53', '2018-11-30 13:46:53'),
(11, 'asdf', 'Ladrillera 1', 15010, NULL, 'Haldamir Guzman', '1', '1', '1', '0', 26, '2018-11-30 13:49:40', '2018-12-05 04:20:08'),
(12, 'asdf', 'Ladrillera 1', 15010, NULL, 'Haldamir Guzman', '1', '0', '0', '0', 26, '2018-11-30 13:51:59', '2018-12-03 07:29:51'),
(13, 'asdf', 'qwer', 15010, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 26, '2018-11-30 13:53:43', '2018-11-30 13:53:43'),
(14, 'asdf', 'Ladrillera 1', 15040, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 26, '2018-11-30 13:56:37', '2018-11-30 13:56:37'),
(15, 'asdf', 'Ladrillera 1', 15010, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:57:42', '2018-11-30 13:57:42'),
(16, 'asdf', 'qwer', 15010, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:58:23', '2018-11-30 13:58:23'),
(17, 'asdf', 'qwer', 15010, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 24, '2018-11-30 13:58:30', '2018-11-30 13:58:30'),
(18, 'asdf', 'Ladrillera 1', 15010, NULL, 'Haldamir Guzman', '0', '0', '0', '0', 21, '2018-11-30 13:59:55', '2018-11-30 13:59:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporal_productos`
--

CREATE TABLE `temporal_productos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `unidad` varchar(2000) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `rol`, `name`, `apellido`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Carlos', 'Monterroso', 're4lawliet@gmail.com', NULL, '$2y$10$idMqv8qV3SJH7Pwd1Xs9merrY9kCMgZh1MXrObeQSCRqJ1BLWu1hO', '3ZYQTGkHtwq9N7W2lnBbPzOHYNhI3Sef972MThslcJcjFL5cGvlQuxsSPdgu', '2018-11-09 03:12:16', '2018-11-09 03:12:16'),
(2, 'colaborador', 'Carlos', 'Monterroso', 'colaborador@gmail.com', NULL, '$2y$10$vik9O.puA8WJvRJRLZjCU.W/A/1JMrE6ekKyP7P054KLulSBPyHLW', '6NHIwABFCJwW7WluVZJDyX0j6L36D3dWRCc37pKkcPDzLhEPmNzwdX5ZclPD', '2018-11-09 03:26:30', '2018-11-09 03:26:30'),
(3, 'director', 'omar', 'Argueta', 'omar@gmail.com', NULL, '$2y$10$Wb9YRNXv64BbAbgcH7cjoeXj3HCmFUeSHGNaC1EdkxQ453SLsffm6', 'H2Au5ZOO5RvNsGeiJ3F5lTAGGbnsA13SJgpXYW6ZeRMSC1JVs4SSpThqahGH', '2018-11-12 21:12:42', '2018-11-12 21:12:42'),
(4, 'admin', 'Haldamir', 'Guzman', 'haldamir.95@gmail.com', NULL, '$2y$10$xYHnwC3A33B1DQFcfZp4qu10mOd8EGsiWGttcFTxjf9nc4LZ4O1oy', 'ArQ9r3lg4OmtcMyYSTh68X6fYojzD6Z6MyepKkyiTqNYuvth8YyOdk18ztWb', '2018-11-21 02:41:22', '2018-11-21 02:41:22'),
(5, 'manager', 'Carlos', 'Monterroso', 'manager@gmail.com', NULL, '$2y$10$RE8MZ198CHkdrPIqxU7OAeQo8rjmjXJHwHXGXo7baf8iVmRpOCt/C', 'Cuv9cLKfrePvjSQNrpY0KtEbb9XKwp1TCWl2P00xWjcMQNFCW1PYBxbMBkxl', '2018-11-22 05:37:28', '2018-11-22 05:37:28'),
(6, 'director', 'Carlos', 'Monterroso', 'director@gmail.com', NULL, '$2y$10$QoncW1jpu4nr02sG8i9Fq.VJIyqnXHtm9CzYQ9NOGQGj/Ra0YMVfe', 'XyK1SubRZnPCUsV00roqxQWOjsGMKzfhEzebc6UyCcxXQppxolHCbVjYdPtu', '2018-11-22 05:38:57', '2018-11-22 05:38:57'),
(7, 'admin', 'n', 'n', 'n@gmail.com', NULL, '$2y$10$vFJS1zr/Mh1MUA.glChvy.1isDz470Rs31j3nobi5ifUjyrky2kqm', '9d2T6jao4KrSBV2yJy3KhWJASn4jP7NTA1NqEZOo0nZWnl4DaUqf6swiuXSw', '2018-11-22 06:53:40', '2018-11-22 06:53:40'),
(8, 'compras', 'Carlos', 'Monterroso', 'compras@gmail.com', NULL, '$2y$10$D7M5tHA5jCPoPUd2tgtSZuNnH683feIoNXkURvxbKs9TqfyDzSch6', 'Flr8cTSMmQBesR1o2L0nN7A613o6ZFLpPhEIvl4ZVvsCGACCatJfWkWiZl3e', '2018-11-30 00:39:26', '2018-11-30 00:39:26'),
(9, 'manager', 'Alan', 'Guzman', 'alanmanager@gmail.com', NULL, '$2y$10$Z1Vrw97G3sFtrBjzADqwYOnQMoFtN3Dw1FIqoNXEDEKnGvmRLaVLe', 'sC5UsrnKAU9POszHEIwDZxBx19wFhnsWpEKvRhnFS0bbKLmXq13Gw5aRLBqU', '2018-12-03 04:15:49', '2018-12-03 04:15:49'),
(10, 'director', 'Haldamir', 'Guzman', 'alandirector@gmail.com', NULL, '$2y$10$UnYRrP7GaHvhCBsATRvl.uHY6Lx55kUkFTWKa3Mx4Qu6K4hO3VKSG', '4FbZD5bwYxLxl6WMZFsbD3UKebF1dNVL6abwR4FSHEykTMBSuaej6krWNvTx', '2018-12-05 03:37:37', '2018-12-05 03:37:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `listados`
--
ALTER TABLE `listados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_solicitud` (`id_solicitud`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proyecto` (`id_proyecto`),
  ADD KEY `id_partida` (`id_partida`);

--
-- Indices de la tabla `temporal_productos`
--
ALTER TABLE `temporal_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `listados`
--
ALTER TABLE `listados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `temporal_productos`
--
ALTER TABLE `temporal_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `listados`
--
ALTER TABLE `listados`
  ADD CONSTRAINT `listados_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`id_partida`) REFERENCES `partidas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
