-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-09-2023 a las 13:42:15
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `paulmull_centroidiomas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustes`
--

CREATE TABLE `ajustes` (
  `idAjuste` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(191) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `ruc` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(91) COLLATE utf8_spanish_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ajustes`
--

INSERT INTO `ajustes` (`idAjuste`, `nombre`, `direccion`, `telefono`, `ruc`, `correo`, `logo`) VALUES
(1, 'CENTRO DE IDIOMAS', 'Jr. Lima', '985256859', '10235265897', NULL, 'logo_paulmuller.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_creditos`
--

CREATE TABLE `concepto_creditos` (
  `idConceptoCredito` int(11) NOT NULL,
  `valorUnidad` decimal(18,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `porcenDescuento` int(11) NOT NULL,
  `valorDescontado` decimal(18,2) NOT NULL,
  `valorTotal` decimal(18,2) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idCredito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `concepto_creditos`
--

INSERT INTO `concepto_creditos` (`idConceptoCredito`, `valorUnidad`, `cantidad`, `porcenDescuento`, `valorDescontado`, `valorTotal`, `idProducto`, `idCredito`) VALUES
(16, '100.00', 13, 0, '0.00', '1300.00', 2, 30),
(17, '50.00', 1, 20, '10.00', '40.00', 3, 31),
(18, '70.00', 9, 0, '0.00', '630.00', 1, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `idCredito` int(11) NOT NULL,
  `fechaCre` date NOT NULL,
  `valorCre` decimal(18,2) NOT NULL,
  `pagoAnticipado` decimal(18,2) NOT NULL,
  `fechaPrimCuota` date NOT NULL,
  `periodoCuotas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nroCuotas` int(11) NOT NULL,
  `observacionesCre` text COLLATE utf8_spanish_ci,
  `idMatricula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `creditos`
--

INSERT INTO `creditos` (`idCredito`, `fechaCre`, `valorCre`, `pagoAnticipado`, `fechaPrimCuota`, `periodoCuotas`, `nroCuotas`, `observacionesCre`, `idMatricula`) VALUES
(30, '2023-09-05', '1300.00', '0.00', '2023-09-05', 'Mensual', 13, NULL, 11),
(31, '2023-09-05', '40.00', '40.00', '2023-09-05', 'NINGUNO', 1, NULL, 12),
(32, '2023-09-05', '630.00', '0.00', '2023-09-05', 'Mensual', 9, NULL, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas_a_pagar`
--

CREATE TABLE `cuotas_a_pagar` (
  `idCuotaAPagar` int(11) NOT NULL,
  `fechAPagar` date NOT NULL,
  `montoAPagar` decimal(18,2) NOT NULL,
  `idCredito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cuotas_a_pagar`
--

INSERT INTO `cuotas_a_pagar` (`idCuotaAPagar`, `fechAPagar`, `montoAPagar`, `idCredito`) VALUES
(54, '2023-09-05', '100.00', 30),
(55, '2023-10-05', '100.00', 30),
(56, '2023-11-05', '100.00', 30),
(57, '2023-12-05', '100.00', 30),
(58, '2024-01-05', '100.00', 30),
(59, '2024-02-05', '100.00', 30),
(60, '2024-03-05', '100.00', 30),
(61, '2024-04-05', '100.00', 30),
(62, '2024-05-05', '100.00', 30),
(63, '2024-06-05', '100.00', 30),
(64, '2024-07-05', '100.00', 30),
(65, '2024-08-05', '100.00', 30),
(66, '2024-09-05', '100.00', 30),
(67, '2023-09-05', '40.00', 31),
(68, '2023-09-05', '70.00', 32),
(69, '2023-10-05', '70.00', 32),
(70, '2023-11-05', '70.00', 32),
(71, '2023-12-05', '70.00', 32),
(72, '2024-01-05', '70.00', 32),
(73, '2024-02-05', '70.00', 32),
(74, '2024-03-05', '70.00', 32),
(75, '2024-04-05', '70.00', 32),
(76, '2024-05-05', '70.00', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idCurso` int(11) NOT NULL,
  `nomCur` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `estadoCur` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`idCurso`, `nomCur`, `estadoCur`) VALUES
(6, 'INGLES BÁSICO', '1'),
(7, 'INGLES INTERMEDIO', '1'),
(8, 'INGLES AVANZADO', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `idDocente` int(11) NOT NULL,
  `nroDoc` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nomDoc` varchar(191) COLLATE utf8_spanish_ci NOT NULL,
  `telDoc` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dirDoc` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `espDoc` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`idDocente`, `nroDoc`, `nomDoc`, `telDoc`, `dirDoc`, `espDoc`, `email`, `password`) VALUES
(3, '32856895', 'JORGE RAMIREZ', '985256859', NULL, NULL, NULL, '$2y$10$xd4Rp59ZPljWmsOshJcYB.S8rhIgOmWiJrPCQGIXl7Xg9StaSweVi'),
(4, '78945612', 'ANDRES CACERES', '987654321', NULL, NULL, NULL, '$2y$10$UX1KNEv2HlXtraBI2P4Xeuhzx3boK7v.uAoiXQSoULSyvsyrA5yv.'),
(5, '65994822', 'RAMIRO MARTINEZ', '963852963', 'Av Brasil 345, Breña', 'INGLES', 'ramiromartin22@gmail.com', '$2y$10$2Ylavj5qPBumuK42mq42JeL578R/VNyVhciyhAfiOeSnbfJIReFGu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `idEmpresa` int(11) NOT NULL,
  `nomEmp` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `dirEmp` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `telEmp` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `rucEmp` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `emaEmp` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `logEmp` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`idEmpresa`, `nomEmp`, `dirEmp`, `telEmp`, `rucEmp`, `emaEmp`, `logEmp`) VALUES
(0, 'PAUL MULLER SAC', 'Jr. Lima 45', '985256859', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `idEstudiante` int(11) NOT NULL,
  `tipoDoc` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `nroDoc` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nomEst` varchar(191) COLLATE utf8_spanish_ci NOT NULL,
  `telEst` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dirEst` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `generoEst` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fotoEst` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `f_nacimiento` date DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_spanish_ci NOT NULL,
  `fecCre` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`idEstudiante`, `tipoDoc`, `nroDoc`, `nomEst`, `telEst`, `dirEst`, `generoEst`, `fotoEst`, `f_nacimiento`, `email`, `password`, `fecCre`) VALUES
(6, '1', '73040610', 'CARLOS ANGULO', NULL, 'Jr Manuel Pérez De Tudela', 'MASCULINO', NULL, '1993-12-01', 'layerredes@gmail.com', '$2y$10$hiquDOLnwvY5AslrHmytl.u0efxg6U40hQ1hpbX6QA9VqT71Y2b1a', '2023-09-04 00:00:00'),
(7, '1', '751276313', 'LUIS VILCHEZ', '967151425', 'Jr Mesa Redonda 998', 'MASCULINO', NULL, '2002-10-08', 'luisvilchez340@gmail', '$2y$10$2sN3l3PfROdKS9fvDsFTd.gXplPormw34YKoOomJPp0A8gvEc0PuW', '2023-09-04 00:00:00'),
(8, '1', '78784512', 'LUIS VILCHEZ', '967934694', 'Av Guzmán Blanco 309, Cercado de Lima 15046', 'MASCULINO', NULL, NULL, 'luisvilchez340@gmail.com', '$2y$10$QR0PFS55UE7dqH0CJCyekuexmwgQixDMgamvzub.oH3UxDX.3jq76', '2023-09-05 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_pago`
--

CREATE TABLE `formas_pago` (
  `idFormaPago` int(11) NOT NULL,
  `nombreFP` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `formas_pago`
--

INSERT INTO `formas_pago` (`idFormaPago`, `nombreFP`) VALUES
(1, 'EFECTIVO'),
(2, 'TRANSFERENCIA'),
(5, 'YAPE - POS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `idGrupo` int(11) NOT NULL,
  `nombreGrupo` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `fechCreacionGru` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`idGrupo`, `nombreGrupo`, `idCurso`, `idDocente`, `fechCreacionGru`) VALUES
(10, '2023 SA - DO', 6, 3, '2023-09-03 10:45:45'),
(11, '2023 LU -MIE- VIE', 6, 4, '2023-09-03 10:50:10'),
(12, '2023 LU -MIE- VIE (Noche)', 7, 3, '2023-09-03 10:50:56'),
(13, '2023  SAB 8 - 11', 6, 4, '2023-09-04 15:07:21'),
(14, 'SBADO 4PM-PM', 6, 4, '2023-09-05 15:54:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `idMatricula` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idEstudiante` int(11) NOT NULL,
  `fecMat` datetime NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`idMatricula`, `idCurso`, `idEstudiante`, `fecMat`, `id`) VALUES
(9, 6, 6, '2023-09-04 10:35:53', 1),
(10, 7, 6, '2023-09-04 10:52:24', 1),
(11, 6, 7, '2023-09-05 16:35:13', 1),
(12, 6, 8, '2023-09-05 17:11:21', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `idModulo` int(11) NOT NULL,
  `nroModulo` int(11) NOT NULL,
  `idMatricula` int(11) NOT NULL,
  `nota1` decimal(18,2) DEFAULT NULL,
  `nota2` decimal(18,2) DEFAULT NULL,
  `nota3` decimal(18,2) DEFAULT NULL,
  `notaExamen` decimal(18,2) DEFAULT NULL,
  `notaRecuperacion` decimal(18,2) DEFAULT NULL,
  `idGrupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`idModulo`, `nroModulo`, `idMatricula`, `nota1`, `nota2`, `nota3`, `notaExamen`, `notaRecuperacion`, `idGrupo`) VALUES
(7, 1, 11, NULL, NULL, NULL, NULL, NULL, 11),
(8, 2, 11, NULL, NULL, NULL, NULL, NULL, 10),
(9, 3, 11, NULL, NULL, NULL, NULL, NULL, 13),
(10, 1, 9, NULL, NULL, NULL, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones_creditos`
--

CREATE TABLE `observaciones_creditos` (
  `idObservacion` int(11) NOT NULL,
  `fechaObs` date NOT NULL,
  `detalleObs` text COLLATE utf8_spanish_ci NOT NULL,
  `idCredito` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `observaciones_creditos`
--

INSERT INTO `observaciones_creditos` (`idObservacion`, `fechaObs`, `detalleObs`, `idCredito`, `id`) VALUES
(6, '2023-09-05', 'PAGP FELIZ', 30, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPago` int(11) NOT NULL,
  `fechaPago` date NOT NULL,
  `fechaAsiento` date NOT NULL,
  `detallePago` text COLLATE utf8_spanish_ci,
  `valorPago` decimal(18,2) NOT NULL,
  `idFormaPago` int(11) NOT NULL,
  `idCredito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`idPago`, `fechaPago`, `fechaAsiento`, `detallePago`, `valorPago`, `idFormaPago`, `idCredito`) VALUES
(27, '2023-09-05', '2023-09-05', 'PAGO', '100.00', 1, 30),
(28, '2023-09-05', '2023-09-05', 'Matricula Básico', '40.00', 1, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombreProducto` varchar(191) COLLATE utf8_spanish_ci NOT NULL,
  `precio` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `precio`) VALUES
(1, 'LIBRO INGLES', '70.00'),
(2, 'PENSIÓN MENSUAL INGLES', '100.00'),
(3, 'MATRICULA 2023', '50.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_descuento`
--

CREATE TABLE `tipos_descuento` (
  `idTipoDescuento` int(11) NOT NULL,
  `nombreTP` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `valorPorcentaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_descuento`
--

INSERT INTO `tipos_descuento` (`idTipoDescuento`, `nombreTP`, `valorPorcentaje`) VALUES
(1, 'Descuento 50%', 50),
(2, 'Descuento 20%', 20),
(5, 'DESCUENTO BECA  100%', 100),
(6, 'Descuento 75%', 75),
(7, 'municipalidad lima', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nroDoc` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telUse` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estUse` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipUse` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nroDoc`, `name`, `telUse`, `estUse`, `tipUse`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '12345678', 'WILFREDO VARGAS CARDENAS', '949046173', 'ACTIVO', 'ADMINISTRADOR', 'admin@gmail.com', NULL, '$2y$10$6p4.XVUzgbQCsq5iiO5D8.1T0E5bpeDMWVbN8UhnWNsSwlE/d6L0C', NULL, '2022-09-06 00:13:06', '2023-09-02 14:26:08'),
(7, '12345676', 'JORGE HUAMAN', NULL, 'ACTIVO', 'ADMINISTRADOR', 'jorge@gmail.com', NULL, '$2y$10$sA0Lgpl3QqJDcswmqnuES.06.mikB52w0e0pPgehEBGAAf1jek1YC', NULL, '2023-09-03 05:46:37', '2023-09-06 03:52:32'),
(8, '63635262', 'ANGEL GAVIRIA', '999888777', 'ACTIVO', 'ADMINISTRADOR', 'angelgaviria@gmail.com', NULL, '$2y$10$wYDdvMjhX3u/7zK6CIN9ceV.hSjc.5pztnI4BTPwnRpzrex7ka.Xe', NULL, '2023-09-06 01:10:24', '2023-09-06 01:10:24'),
(9, '46400614', 'Paola jaramillo', '.', 'ACTIVO', 'ADMINISTRADOR', 'layerredes@gmail.com', NULL, '$2y$10$MbnrhlFUT3dWyZRGSiP6ouC/ZzaBLdRPKY1ODcrJiekc2ojFq4GdK', NULL, '2023-09-06 04:21:54', '2023-09-06 04:21:54'),
(10, '42569004', 'Milagros saenz', '.', 'ACTIVO', 'ADMINISTRADOR', 'caja1@gmail.com', NULL, '$2y$10$TIrCYLmTW/8Q7O5dY5l9l.5EUpgLVDMT14AyqcirFXfml1P7ZD3ke', NULL, '2023-09-06 04:23:48', '2023-09-06 04:23:48'),
(11, '71729875', 'katty cueva', '.', 'ACTIVO', 'ADMINISTRADOR', 'layerredes1@gmail.com', NULL, '$2y$10$6717d7jP1wCGdLGB.NQ73eWaYuH2htd.CvCCCXHzuR0YF466JxGSC', NULL, '2023-09-06 04:37:37', '2023-09-06 04:37:37'),
(12, '48381578', 'maria paiva', '.', 'ACTIVO', 'ADMINISTRADOR', 'layerrede1s@gmail.com', NULL, '$2y$10$SzcDnb3LZ13M3WsFtS41YOmcLEM0LCEUwJDFWVdZT6hHoFQFStkye', NULL, '2023-09-06 04:38:27', '2023-09-06 04:38:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD PRIMARY KEY (`idAjuste`);

--
-- Indices de la tabla `concepto_creditos`
--
ALTER TABLE `concepto_creditos`
  ADD PRIMARY KEY (`idConceptoCredito`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `idCredito` (`idCredito`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`idCredito`),
  ADD KEY `idMatricula` (`idMatricula`);

--
-- Indices de la tabla `cuotas_a_pagar`
--
ALTER TABLE `cuotas_a_pagar`
  ADD PRIMARY KEY (`idCuotaAPagar`),
  ADD KEY `idCredito` (`idCredito`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idCurso`),
  ADD UNIQUE KEY `nomCur` (`nomCur`) USING BTREE;

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`idDocente`),
  ADD UNIQUE KEY `nroDoc` (`nroDoc`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`idEstudiante`),
  ADD UNIQUE KEY `nroDoc` (`nroDoc`);

--
-- Indices de la tabla `formas_pago`
--
ALTER TABLE `formas_pago`
  ADD PRIMARY KEY (`idFormaPago`),
  ADD UNIQUE KEY `nombreFP` (`nombreFP`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`idGrupo`),
  ADD UNIQUE KEY `nombreGrupo` (`nombreGrupo`,`idCurso`,`idDocente`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `idDocente` (`idDocente`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`idMatricula`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `idEstudiante` (`idEstudiante`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`idModulo`),
  ADD KEY `idMatricula` (`idMatricula`),
  ADD KEY `idGrupo` (`idGrupo`);

--
-- Indices de la tabla `observaciones_creditos`
--
ALTER TABLE `observaciones_creditos`
  ADD PRIMARY KEY (`idObservacion`),
  ADD KEY `id` (`id`),
  ADD KEY `idCredito` (`idCredito`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPago`) USING BTREE,
  ADD KEY `idCredito` (`idCredito`),
  ADD KEY `idFormaPago` (`idFormaPago`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `nombreProducto` (`nombreProducto`);

--
-- Indices de la tabla `tipos_descuento`
--
ALTER TABLE `tipos_descuento`
  ADD PRIMARY KEY (`idTipoDescuento`),
  ADD UNIQUE KEY `nombreTP` (`nombreTP`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `nroDoc` (`nroDoc`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ajustes`
--
ALTER TABLE `ajustes`
  MODIFY `idAjuste` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `concepto_creditos`
--
ALTER TABLE `concepto_creditos`
  MODIFY `idConceptoCredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `idCredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `cuotas_a_pagar`
--
ALTER TABLE `cuotas_a_pagar`
  MODIFY `idCuotaAPagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `idDocente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `idEstudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `formas_pago`
--
ALTER TABLE `formas_pago`
  MODIFY `idFormaPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `idMatricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `observaciones_creditos`
--
ALTER TABLE `observaciones_creditos`
  MODIFY `idObservacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_descuento`
--
ALTER TABLE `tipos_descuento`
  MODIFY `idTipoDescuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `concepto_creditos`
--
ALTER TABLE `concepto_creditos`
  ADD CONSTRAINT `concepto_creditos_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`),
  ADD CONSTRAINT `concepto_creditos_ibfk_3` FOREIGN KEY (`idCredito`) REFERENCES `creditos` (`idCredito`);

--
-- Filtros para la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD CONSTRAINT `creditos_ibfk_1` FOREIGN KEY (`idMatricula`) REFERENCES `matriculas` (`idMatricula`);

--
-- Filtros para la tabla `cuotas_a_pagar`
--
ALTER TABLE `cuotas_a_pagar`
  ADD CONSTRAINT `cuotas_a_pagar_ibfk_1` FOREIGN KEY (`idCredito`) REFERENCES `creditos` (`idCredito`);

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCurso`),
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`idDocente`) REFERENCES `docentes` (`idDocente`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCurso`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`idEstudiante`) REFERENCES `estudiantes` (`idEstudiante`),
  ADD CONSTRAINT `matriculas_ibfk_3` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD CONSTRAINT `modulos_ibfk_1` FOREIGN KEY (`idMatricula`) REFERENCES `matriculas` (`idMatricula`),
  ADD CONSTRAINT `modulos_ibfk_2` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`idGrupo`);

--
-- Filtros para la tabla `observaciones_creditos`
--
ALTER TABLE `observaciones_creditos`
  ADD CONSTRAINT `observaciones_creditos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `observaciones_creditos_ibfk_2` FOREIGN KEY (`idCredito`) REFERENCES `creditos` (`idCredito`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`idCredito`) REFERENCES `creditos` (`idCredito`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`idFormaPago`) REFERENCES `formas_pago` (`idFormaPago`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
