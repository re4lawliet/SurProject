-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-11-2018 a las 17:13:39
-- Versión del servidor: 5.6.35
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `Sur`
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
(1, 'Carlos', 'Monterroso', '12 Ave 27-66', '123', '35304753', '2018-11-12 12:05:32', '2018-11-12 12:05:32');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre_empresa`, `nit_empresa`, `direccion_empresa`, `telefono_oficina`, `telefono_empresa`, `correo_empresa`, `telefono_encargado`, `correo_encargado`, `nombre_encargado`, `puesto_encargado`, `created_at`, `updated_at`) VALUES
(2, 'Distribuidora Alvarez Wong / Daw', NULL, NULL, 'Oficina (502) 2473-3652', NULL, 'daw@alvarezwong.com', 'Celular (502) 3077-2399', NULL, 'Ing. Gustavo Alvarez W.', 'Gerente Comercial', '2018-11-12 11:14:42', '2018-11-12 11:14:42'),
(3, 'Samboro, S.A.', NULL, NULL, 'Oficinas: (502) 2202-6900', NULL, NULL, 'Móvil: (502) 5697-2548', 'apadilla@samboro.com', 'Alfonso Padilla', 'Proyectos - Samboro', '2018-11-12 11:16:43', '2018-11-12 11:16:43'),
(4, 'Materiales de construccion importados de Taiwan,S.A. / ezet', NULL, NULL, NULL, 'Tel.23370167', 'ventas.ezet@gmail.com', 'Cel. 59365954', 'ventas.ezeset@gmail.com', 'Vanessa Argueta Cerraduras Ezset', NULL, '2018-11-12 11:18:10', '2018-11-12 11:18:10'),
(5, 'Hidroconfort / Jose Americo Estrada', NULL, NULL, '4721 1507- 4693 7214', '4721 1507- 4693 7214', 'jaestrada@hidroconfort.com.gt', '4721 1507- 4693 7214', 'jaestrada@hidroconfort.com.gt', 'Jose Américo Estrada', 'Gerente de Ventas', '2018-11-12 11:19:43', '2018-11-12 11:19:43'),
(6, 'Viglass, S.A.', NULL, NULL, 'Móvil: 30025092', 'Móvil: 30025092', 'lissie@viglass.com', 'Móvil: 30025092', 'lissie@viglass.com', 'Elvis Lanuza', 'Encargado', '2018-11-12 11:21:52', '2018-11-12 11:21:52'),
(7, 'Suministro Instalacion y Construccion, S.A. / Sicsa', NULL, NULL, '22021010- 24347019', '22021010- 24347019', 'c.quevedo@sicsa.com.gt', '22021010- 24347019', 'c.quevedo@sicsa.com.gt', 'Julie Castillo de Guzman', 'Gerente', '2018-11-12 11:30:21', '2018-11-12 11:30:21'),
(8, 'Grupo Adhere / Jose Luis Rodriguez Lucas', NULL, NULL, NULL, NULL, 'servipin.jl@gmail.com', NULL, NULL, NULL, NULL, '2018-11-12 11:31:15', '2018-11-12 11:31:15'),
(9, 'Modus / Tio, S.A.', NULL, NULL, '56961415 - 2494-6400', '56961415 - 2494-6400', 'ventas@modus.com.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:32:05', '2018-11-12 11:32:05'),
(10, 'Cotyssa, S.A.', NULL, NULL, NULL, NULL, 'karoche@cotyssa.com', NULL, NULL, NULL, NULL, '2018-11-12 11:32:36', '2018-11-12 11:32:36'),
(11, 'Rotulos Molina', NULL, NULL, '66341801', '66341801', 'rotulos@intelnet.net.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:33:21', '2018-11-12 11:33:21'),
(12, 'Proyectos de ahorro energetico / Proa', NULL, NULL, '55958923', '55958923', 'gervin@proa.com.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:34:15', '2018-11-12 11:34:15'),
(13, 'Servicios de mano de obra, S.A. / Sermasa', NULL, NULL, NULL, NULL, 'be2767@gmail.com', NULL, NULL, NULL, NULL, '2018-11-12 11:34:45', '2018-11-12 11:34:45'),
(14, 'Gruas y formaletas, S.A.', NULL, NULL, NULL, NULL, 'grufosa@gmail.com', NULL, NULL, NULL, NULL, '2018-11-12 11:35:13', '2018-11-12 11:35:13'),
(15, 'Durman Esquivel Guatemala, S.A.', NULL, NULL, 'Tel: +502.6636-1111', 'Tel: +502.6636-1111', 'acaal@aliaxis-la.com', 'Movil: 55101111', NULL, 'Anabela Caal', NULL, '2018-11-12 11:37:02', '2018-11-12 11:37:02'),
(16, 'Equipos y fijaciones de Guatemala / Efisa', NULL, NULL, '2388 0606 - 59909922', '2388 0606 - 59909922', 'servicioconstruccion@efisaguate.com', '2388 0606 - 59909922', NULL, 'Mario Cuque', NULL, '2018-11-12 11:38:03', '2018-11-12 11:38:03'),
(17, 'Cisa / Cerraduras Internacionales, S.A.', NULL, NULL, 'T +502 2323-8723', 'T +502 2323-8723', 'ecadenas@corpcisa.com', 'M +502 5201-0021', 'grb@corpcisa.com', 'Ing. Guillermo Ramos Bianchi', NULL, '2018-11-12 11:39:29', '2018-11-12 11:39:29'),
(18, 'Solpro', NULL, NULL, NULL, NULL, 'ventas@solpro.com', 'Cel. 4049-1265', NULL, 'Nancy Tobar González', NULL, '2018-11-12 11:40:16', '2018-11-12 11:40:16'),
(19, 'Recsa', NULL, NULL, '23669180', '23669180', 'ventas@recsacorp.com', NULL, NULL, NULL, NULL, '2018-11-12 11:40:48', '2018-11-12 11:40:48'),
(20, 'Euro Morteros, S.A.', NULL, NULL, '23858642', '23858642', 'recepcion@euromorteros.com.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:41:35', '2018-11-12 11:41:35'),
(21, 'Grupo Moed, S.A.', NULL, NULL, 'Tel: 2363-5335', 'Tel: 2363-5335', 'ovillatoro@grupomoed.com', 'Tel: 2363-5335', NULL, 'Omar Orellana', NULL, '2018-11-12 11:42:13', '2018-11-12 11:42:13'),
(22, 'Distribuidora electronica, S.A. / Distelsa', NULL, NULL, '24230100/56908490', '24230100/56908490', 'max.zona10@distelsa.com.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:43:26', '2018-11-12 11:43:26'),
(23, 'Inmobiliaria la Roca, S.A.', NULL, NULL, '2209-4141', '2209-4141', 'hmendoza@laroca.com.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:49:09', '2018-11-12 11:49:09'),
(24, 'Proteccion Centroamericana, S.A.', NULL, NULL, '24197272', '24197272', 'egarcia@proteccioncentroamericana.com', NULL, NULL, NULL, NULL, '2018-11-12 11:49:31', '2018-11-12 11:49:31'),
(25, 'Corporacion zuma, S.A.', NULL, NULL, '57555035', '57555035', 'rodrigoarzu@corporacionzuma.com', '57555035', NULL, 'Rodrigo Arzu Matheu', 'Gerente', '2018-11-12 11:51:18', '2018-11-12 11:51:18'),
(26, 'Advanced Energy, S.A.', NULL, NULL, '53186817', '53186817', 'josegirongarces@gmail.com', '53186817', NULL, 'Jose Alfredo Firon', 'Gerente', '2018-11-12 11:52:14', '2018-11-12 11:52:14'),
(27, 'Tismar, S.A.', NULL, NULL, '23037272', '23037272', 'tismar.auxiliar@gmail.com', '40372423', NULL, 'Walter Marroquin', 'Gerente', '2018-11-12 11:53:19', '2018-11-12 11:53:19'),
(28, 'Servicio Tecnico de Extinguidores, S.A.', NULL, NULL, 'directo: 2253-1653', 'pbx. 2463-8624', 'steventasgt@gmail.com', 'pbx. 2463-8624  directo: 2253-1653', NULL, 'SANDY  ARAGÓN', NULL, '2018-11-12 11:54:14', '2018-11-12 11:54:14'),
(29, 'appliance Center, S.A.', NULL, NULL, 'Oficina 22618955', 'Oficina 22618955', 'ibanezalbertina@gmail.com aibanez@cocina.gt', NULL, NULL, NULL, NULL, '2018-11-12 11:54:47', '2018-11-12 11:54:47'),
(30, 'Cofrasa', NULL, NULL, NULL, NULL, 'importex@cofrasa.com', NULL, NULL, NULL, NULL, '2018-11-12 11:55:08', '2018-11-12 11:55:08'),
(31, 'sportmec/ fitness oncite', NULL, NULL, '22459900', '22459900', 'tirsa.monterroso@sportmec.com', '22459900', NULL, 'Monica Roldan', NULL, '2018-11-12 11:55:41', '2018-11-12 11:55:41'),
(32, 'Tecnologia Acceso y Seguridad, S.A.', NULL, NULL, '24275959 / 57407980', '24275959 / 57407980', 'facturaciongt@tas-seguridad.com', '24275959 / 57407980', NULL, 'Lybby Acosta', NULL, '2018-11-12 11:56:16', '2018-11-12 11:56:16'),
(33, 'Compañía universal de refregeracion, S.A.', NULL, NULL, NULL, NULL, 'jamador@distgranada.com', NULL, NULL, NULL, NULL, '2018-11-12 11:56:35', '2018-11-12 11:56:35'),
(34, 'Sisdeco', NULL, NULL, NULL, NULL, 'sisdeco.persianas@gmail.com', NULL, NULL, NULL, NULL, '2018-11-12 11:56:52', '2018-11-12 11:56:52'),
(35, 'Tikal Doors, S.A.', NULL, NULL, 'Tel.:  (502) 30054857', 'Tel.:  (502) 30054857', 'rramirez@aringuat.com', 'Tel.:  (502) 30054857', NULL, 'Roberto Ramirez', NULL, '2018-11-12 11:57:34', '2018-11-12 11:57:34'),
(36, 'Tecno Lum / Jeffrie Alejandro Villalobos Viato', NULL, NULL, '2367-2516 / 2368-2452', '2367-2516 / 2368-2452', 'alejandro.viato@tecnolum.net', '2367-2516 / 2368-2452', NULL, 'Alejandro Villalobos', NULL, '2018-11-12 11:58:13', '2018-11-12 11:58:13'),
(37, 'De Motors, S.A.', NULL, NULL, '4154-2814', '4154-2814', 'marvinrolando@demotorsguatemala.com', '4154-2814', NULL, 'Javier Monterroso', NULL, '2018-11-12 11:58:54', '2018-11-12 11:58:54'),
(38, 'Multiservicios Cuyan, S.A.', NULL, NULL, 'Tels: 2473-2419 / 2474-4929 / 2472-7239', 'Tels: 2473-2419 / 2474-4929 / 2472-7239', 'cuyan.sa@hotmail.com', 'Cel: 5457-3356', NULL, 'Evelin Estrada', NULL, '2018-11-12 11:59:43', '2018-11-12 11:59:43'),
(39, 'Corporacio LG, S.A.', NULL, NULL, '23297900', '23297900', 'cobros@logisticaglobal.com', NULL, NULL, NULL, NULL, '2018-11-12 12:00:09', '2018-11-12 12:00:09'),
(40, 'Sistemas de ingenieria, Electricidad y Comunicaciones', NULL, NULL, '24360063', '24360063', 'ventas1@siete.com.gt', '24360063', NULL, 'Ricardo Colidres', NULL, '2018-11-12 12:00:44', '2018-11-12 12:00:44'),
(41, 'Reinventa Solutions, S.A.', NULL, NULL, '4216-8596', '4216-8596', 'jose.lima@deco-art.com.gt', '4216-8596', NULL, 'Carlos Lima', NULL, '2018-11-12 12:01:21', '2018-11-12 12:01:21'),
(42, 'Sistemas tecnicos de Guatemala, S.A.', NULL, NULL, '2320 0300', '2320 0300', NULL, NULL, NULL, NULL, NULL, '2018-11-12 12:01:41', '2018-11-12 12:01:41'),
(43, 'Bimagua s.a./ kalea', NULL, NULL, 'Tel:2367-0090/2490-0000', 'Tel:2367-0090/2490-0000', 'soportetotal@kalea.com.gt', NULL, NULL, NULL, NULL, '2018-11-12 12:02:09', '2018-11-12 12:02:09'),
(44, 'Persiluz / Fabrica de percianas y complementos, S.A.', NULL, NULL, NULL, NULL, 'delvin.moran.persiluz@gmail.com', NULL, NULL, NULL, NULL, '2018-11-12 12:02:33', '2018-11-12 12:02:33');

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

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre_proveedor`, `direccion_oficina`, `nit_proveedor`, `telefono_proveedor`, `correo_proveedor`, `nombre_banco`, `forma_pago`, `created_at`, `updated_at`) VALUES
(2, 'proveedor1', NULL, 'nit proveedor 1', '55009533', 'proveedor1@gmail.com', 'banrural', 'deposito', '2018-11-10 16:31:22', '2018-11-10 16:31:22'),
(6, 'proveedor2', 'ofi 2', 'nit proveedor 2', '55009533', 'proveedor2@gmail.com', 'bi', 'cheque', '2018-11-10 16:48:06', '2018-11-10 16:48:06'),
(7, 'proveedor3', NULL, NULL, NULL, NULL, NULL, 'cheque', '2018-11-10 16:48:11', '2018-11-10 16:48:11'),
(8, 'proveedor4', 'ofi4', 'nit proveedor 2', NULL, NULL, NULL, 'cheque', '2018-11-10 16:48:25', '2018-11-10 16:50:03');

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
(1, 'admin', 'Carlos', 'Monterroso', 're4lawliet@gmail.com', NULL, '$2y$10$idMqv8qV3SJH7Pwd1Xs9merrY9kCMgZh1MXrObeQSCRqJ1BLWu1hO', 'kWgtzBM1g1sIfN6b3599UGAUVbbVV495V0u0r8aTW4z70abyWyZ20ATmZwuo', '2018-11-09 03:12:16', '2018-11-09 03:12:16'),
(2, 'colaborador', 'Carlos', 'Monterroso', 'correo@gmail.com', NULL, '$2y$10$vik9O.puA8WJvRJRLZjCU.W/A/1JMrE6ekKyP7P054KLulSBPyHLW', '0ltMuCANg6n1o2R6YpMF6mkVKInaBdSpBxRwJg2Z3yVz8Kw6Tpo8sjNlOC1F', '2018-11-09 03:26:30', '2018-11-09 03:26:30'),
(3, 'director', 'omar', 'Argueta', 'omar@gmail.com', NULL, '$2y$10$Wb9YRNXv64BbAbgcH7cjoeXj3HCmFUeSHGNaC1EdkxQ453SLsffm6', 'z97FeUcxLKCJRZqEd9zGGxqFC7Xq5jQVGaBbjGvtlP1dY9yuGdaVO8OGGTk2', '2018-11-12 21:12:42', '2018-11-12 21:12:42');

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
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
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
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;