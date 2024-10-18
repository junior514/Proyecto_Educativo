-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2023 a las 12:43:40
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `syssga2023_carlos_fac`
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
(1, 'CENTRO DE IDIOMAS', 'Jr. Lima', '985256859', '20610638911', NULL, 'logo_paulmuller.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `idAsistencia` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `nroModulo` int(11) NOT NULL,
  `observacion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`idAsistencia`, `idGrupo`, `nroModulo`, `observacion`, `fecha`) VALUES
(6, 12, 1, NULL, '2023-10-01'),
(7, 12, 1, NULL, '2023-10-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `idComprobante` int(11) NOT NULL,
  `idMatricula` int(11) DEFAULT NULL,
  `idPago` int(11) DEFAULT NULL,
  `tipoDoc` varchar(4) DEFAULT NULL,
  `tipoOperacion` varchar(4) DEFAULT NULL,
  `serieComprobante` varchar(4) DEFAULT NULL,
  `numComprobante` int(11) DEFAULT NULL,
  `fechaHora` datetime DEFAULT NULL,
  `tipoPago` varchar(50) DEFAULT NULL,
  `monedaPago` varchar(50) DEFAULT NULL,
  `igv` decimal(5,2) DEFAULT NULL,
  `totalComprobante` decimal(5,2) DEFAULT NULL,
  `descuentoComprobante` decimal(5,2) DEFAULT NULL,
  `sunat_estado` varchar(255) DEFAULT NULL,
  `sunat_descripcion` varchar(255) DEFAULT NULL,
  `sunat_cdr` varchar(255) DEFAULT NULL,
  `sunat_xml` varchar(255) DEFAULT NULL,
  `sunat_pdf` varchar(255) DEFAULT NULL,
  `doc_relacionado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `observacionesCre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `idMatricula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Estructura de tabla para la tabla `detalle_asistencias`
--

CREATE TABLE `detalle_asistencias` (
  `idDetalleAsistencia` int(11) NOT NULL,
  `idEstudiante` int(11) NOT NULL,
  `estado` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `observacion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idAsistencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_asistencias`
--

INSERT INTO `detalle_asistencias` (`idDetalleAsistencia`, `idEstudiante`, `estado`, `observacion`, `idAsistencia`) VALUES
(4, 9, 'ASISTENCIA', NULL, 6),
(5, 9, 'ASISTENCIA', NULL, 7),
(22, 6, 'TARDANZA', NULL, 6),
(23, 6, 'ASISTENCIA', NULL, 7);

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
(3, '32856895', 'JORGE RAMIREZ', '985256859', NULL, NULL, NULL, '$2y$10$RUHYBJ3w8cmal.jl6v0Rt.6FW/fRN3eSNmp0sD4/CE2yuzmu4siqi'),
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
-- Estructura de tabla para la tabla `entrega_tareas`
--

CREATE TABLE `entrega_tareas` (
  `idEntregaTarea` int(11) NOT NULL,
  `fechaEntrega` datetime NOT NULL,
  `comentarioEstudiante` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `archivoEntega` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `fechaRevision` datetime DEFAULT NULL,
  `nota` decimal(18,1) DEFAULT NULL,
  `comentarioDocente` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idRecurso` int(11) NOT NULL,
  `idEstudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `entrega_tareas`
--

INSERT INTO `entrega_tareas` (`idEntregaTarea`, `fechaEntrega`, `comentarioEstudiante`, `archivoEntega`, `fechaRevision`, `nota`, `comentarioDocente`, `idRecurso`, `idEstudiante`) VALUES
(1, '2023-10-11 08:30:37', 'comentario al 75', '1696956903_c) ANEXO 4.pdf', '2023-10-11 11:23:40', '20.0', NULL, 4, 6),
(2, '2023-10-11 10:20:38', 'sdasdasdas 2', '1697037542_c) ANEXO 4.pdf', NULL, NULL, NULL, 4, 7);

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
(6, '1', '73040610', 'CARLOS ANGULO', NULL, 'Jr Manuel Pérez De Tudela', 'MASCULINO', NULL, '1993-12-01', 'layerredes@gmail.com', '$2y$10$TT8EL0pQ2XvefMUpbEEEWOIO.4jBO/cUHRlmYKsM6g4kpkiZWhLL6', '2023-09-04 00:00:00'),
(7, '1', '751276312', 'LUIS VILCHEZ', '967151425', 'Jr Mesa Redonda 998', 'MASCULINO', NULL, '2002-10-08', 'luisvilchez340@gmail', '$2y$10$QR0PFS55UE7dqH0CJCyekuexmwgQixDMgamvzub.oH3UxDX.3jq76', '2023-09-04 00:00:00'),
(8, '1', '78784512', 'LUIS VILCHEZ', '967934694', 'Av Guzmán Blanco 309, Cercado de Lima 15046', 'MASCULINO', NULL, NULL, 'luisvilchez340@gmail.com', '$2y$10$QR0PFS55UE7dqH0CJCyekuexmwgQixDMgamvzub.oH3UxDX.3jq76', '2023-09-05 00:00:00'),
(9, '6', '10770213181', 'ANGEL PEDRAZA VEGA', NULL, NULL, 'MASCULINO', NULL, NULL, NULL, '$2y$10$jAdIPcm24gqJ1mOI3eIK1eIKGinjxyIhBArBnJsZCrwgcW3FgMGfW', '2023-09-16 00:00:00'),
(11, '1', '12345678', 'JOSE PRUEBAS', '948347640', 'CUSCO', 'MASCULINO', NULL, '1999-08-21', 'jose@gmail.com', '$2y$10$AHRC2LP9k1TF4w/qtwP0eOlHq56QjMsRBxqgtqCoZA8yABftTSwYy', '2023-09-21 00:00:00'),
(12, '1', '999999999', 'MIGUEL', '94534333', NULL, 'MASCULINO', 'Rotux tm.png', '2023-09-05', 'gmsasd@sds.com', '$2y$10$wsfHmPQ6yVmPTDTRkwWInuNBcfLu3lSxxo6YCZGIkUs7uHZQ0uEdG', '2023-09-26 00:00:00');

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
  `fechCreacionGru` datetime NOT NULL DEFAULT current_timestamp()
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
-- Estructura de tabla para la tabla `lecciones`
--

CREATE TABLE `lecciones` (
  `idLeccion` int(11) NOT NULL,
  `nombreLeccion` varchar(91) COLLATE utf8_spanish_ci NOT NULL,
  `nroModulo` int(11) NOT NULL,
  `idGrupo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `lecciones`
--

INSERT INTO `lecciones` (`idLeccion`, `nombreLeccion`, `nroModulo`, `idGrupo`) VALUES
(1, 'SESIÓN 01 - SABERES PREVIOS', 1, 12),
(2, 'SESIÓN 02 - EL CONJUNTO', 1, 12),
(3, 'SESIÓN 01 - SABERES PREVIOS', 2, 12);

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
(21, 7, 6, '2023-10-02 15:05:15', 1),
(23, 7, 7, '2023-10-02 15:20:37', 1),
(24, 6, 11, '2023-10-02 15:35:27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `idModulo` int(11) NOT NULL,
  `nroModulo` int(11) NOT NULL,
  `idMatricula` int(11) NOT NULL,
  `nota1` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nota2` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nota3` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `notaExamen` decimal(18,2) DEFAULT NULL,
  `notaRecuperacion` decimal(18,2) DEFAULT NULL,
  `idGrupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`idModulo`, `nroModulo`, `idMatricula`, `nota1`, `nota2`, `nota3`, `notaExamen`, `notaRecuperacion`, `idGrupo`) VALUES
(14, 1, 21, '{\"subNota1\":\"14\",\"subNota2\":\"14\",\"subNota3\":\"14\"}', '{\"subNota1\":\"14\",\"subNota2\":\"14\",\"subNota3\":\"14\"}', NULL, NULL, NULL, 12),
(15, 2, 21, NULL, NULL, NULL, NULL, NULL, 12),
(16, 3, 21, NULL, NULL, NULL, NULL, NULL, 12),
(17, 4, 21, NULL, NULL, NULL, NULL, NULL, 12),
(18, 5, 21, NULL, NULL, NULL, NULL, NULL, 12),
(19, 6, 21, NULL, NULL, NULL, NULL, NULL, 12),
(20, 7, 21, NULL, NULL, NULL, NULL, NULL, 12),
(21, 8, 21, NULL, NULL, NULL, NULL, NULL, 12),
(22, 9, 21, NULL, NULL, NULL, NULL, NULL, 12),
(23, 10, 21, NULL, NULL, NULL, NULL, NULL, 12),
(24, 11, 21, NULL, NULL, NULL, NULL, NULL, 12),
(25, 12, 21, NULL, NULL, NULL, NULL, NULL, 12),
(38, 1, 23, '{\"subNota1\":\"10\",\"subNota2\":\"10\",\"subNota3\":\"10\"}', '{\"subNota1\":\"2\",\"subNota2\":\"2\",\"subNota3\":\"2\"}', '{\"subNota1\":\"10\",\"subNota2\":\"15\",\"subNota3\":\"10\"}', NULL, NULL, 12),
(39, 2, 23, NULL, NULL, NULL, NULL, NULL, 12),
(40, 3, 23, NULL, NULL, NULL, NULL, NULL, 12),
(41, 4, 23, NULL, NULL, NULL, NULL, NULL, 12),
(42, 5, 23, NULL, NULL, NULL, NULL, NULL, 12),
(43, 6, 23, NULL, NULL, NULL, NULL, NULL, 12),
(44, 7, 23, NULL, NULL, NULL, NULL, NULL, 12),
(45, 8, 23, NULL, NULL, NULL, NULL, NULL, 12),
(46, 9, 23, NULL, NULL, NULL, NULL, NULL, 12),
(47, 10, 23, NULL, NULL, NULL, NULL, NULL, 12),
(48, 11, 23, NULL, NULL, NULL, NULL, NULL, 12),
(49, 12, 23, NULL, NULL, NULL, NULL, NULL, 12),
(50, 1, 24, NULL, NULL, NULL, NULL, NULL, 14),
(51, 2, 24, NULL, NULL, NULL, NULL, NULL, 14),
(52, 3, 24, NULL, NULL, NULL, NULL, NULL, 14),
(53, 4, 24, NULL, NULL, NULL, NULL, NULL, 14),
(54, 5, 24, NULL, NULL, NULL, NULL, NULL, 14),
(55, 6, 24, NULL, NULL, NULL, NULL, NULL, 14),
(56, 7, 24, NULL, NULL, NULL, NULL, NULL, 14),
(57, 8, 24, NULL, NULL, NULL, NULL, NULL, 14),
(58, 9, 24, NULL, NULL, NULL, NULL, NULL, 14),
(59, 10, 24, NULL, NULL, NULL, NULL, NULL, 14),
(60, 11, 24, NULL, NULL, NULL, NULL, NULL, 14),
(61, 12, 24, NULL, NULL, NULL, NULL, NULL, 14);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPago` int(11) NOT NULL,
  `fechaPago` date NOT NULL,
  `fechaAsiento` date NOT NULL,
  `detallePago` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `valorPago` decimal(18,2) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '0: anulado, 1: activo',
  `idFormaPago` int(11) NOT NULL,
  `idCredito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `idRecurso` int(11) NOT NULL,
  `titulo` varchar(91) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `horaInicio` time DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `horaFin` time DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `archivo` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idLeccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`idRecurso`, `titulo`, `descripcion`, `fechaInicio`, `horaInicio`, `fechaFin`, `horaFin`, `fechaCreacion`, `tipo`, `archivo`, `idLeccion`) VALUES
(3, 'Tarea de prueba 3', 'asda', '2023-10-09', '14:19:00', '2023-10-09', '15:00:00', '2023-10-09 14:20:16', 'TAREA', '1696879216_Propuesta de datos Asiquim.docx', 1),
(4, 'Asequim', 'Hacer un resumen de la pripuesta de asequim', '2023-10-09', '14:23:00', '2023-10-14', '19:50:00', '2023-10-09 14:24:01', 'TAREA', '1696881242_Propuesta de datos Asiquim.docx', 1),
(6, 'Rellanar el siguiente formulario', NULL, '2023-10-09', '14:54:00', '2023-10-10', '20:00:00', '2023-10-09 14:55:25', 'TAREA', '1696881325_MEMORANDUM MULT N°28.pdf', 2),
(7, 'Tarea de prueba 4', 'Este es un aviso \r\n- A\r\n- B', '2023-10-11', '10:00:00', '2023-10-12', '23:59:00', '2023-10-11 09:07:47', 'TAREA', NULL, 1),
(8, 'Prueba 05', 'Tarea 1', '2023-10-11', '09:18:00', '2023-10-11', '14:19:00', '2023-10-11 09:19:26', 'TAREA', NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series_doc`
--

CREATE TABLE `series_doc` (
  `idSerieDoc` int(11) NOT NULL,
  `idTipoDoc` varchar(2) DEFAULT NULL,
  `nombre` varchar(5) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `series_doc`
--

INSERT INTO `series_doc` (`idSerieDoc`, `idTipoDoc`, `nombre`, `users_id`) VALUES
(1, '03', 'B001', 1),
(2, '01', 'F001', 1),
(3, '00', '0000', 1),
(4, '07', 'FN01', 1),
(5, '07', 'BN01', 1),
(7, '03', 'B001', 8),
(9, '03', 'B001', 10),
(10, '01', 'F001', 10),
(11, '03', 'B002', 1),
(12, '01', 'F002', 1);

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
-- Estructura de tabla para la tabla `tipos_doc`
--

CREATE TABLE `tipos_doc` (
  `idTipoDoc` varchar(2) NOT NULL,
  `nombre` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_doc`
--

INSERT INTO `tipos_doc` (`idTipoDoc`, `nombre`) VALUES
('00', 'NINGUNO'),
('01', 'FACTURA'),
('03', 'BOLETA DE VENTA'),
('07', 'NOTA DE CREDITO');

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
(1, '12345678', 'WILFREDO VARGAS CARDENAS', '949046173', 'ACTIVO', 'ADMINISTRADOR', 'admin@gmail.com', NULL, '$2y$10$zCsYlzDhKFiGqqA70nAg8.38WWL/qsVIRcbKeI8GCi54rGHVphq26', NULL, '2022-09-06 00:13:06', '2023-09-02 14:26:08'),
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
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`idAsistencia`),
  ADD KEY `idGrupo` (`idGrupo`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`idComprobante`),
  ADD KEY `idMatricula` (`idMatricula`),
  ADD KEY `idPago` (`idPago`);

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
-- Indices de la tabla `detalle_asistencias`
--
ALTER TABLE `detalle_asistencias`
  ADD PRIMARY KEY (`idDetalleAsistencia`),
  ADD KEY `idEstudiante` (`idEstudiante`),
  ADD KEY `idAsistencia` (`idAsistencia`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`idDocente`),
  ADD UNIQUE KEY `nroDoc` (`nroDoc`);

--
-- Indices de la tabla `entrega_tareas`
--
ALTER TABLE `entrega_tareas`
  ADD PRIMARY KEY (`idEntregaTarea`),
  ADD KEY `idRecurso` (`idRecurso`),
  ADD KEY `idEstudiante` (`idEstudiante`);

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
-- Indices de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD PRIMARY KEY (`idLeccion`),
  ADD KEY `idGrupo` (`idGrupo`);

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
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`idRecurso`),
  ADD KEY `idLeccion` (`idLeccion`);

--
-- Indices de la tabla `series_doc`
--
ALTER TABLE `series_doc`
  ADD PRIMARY KEY (`idSerieDoc`),
  ADD KEY `idTipoDoc` (`idTipoDoc`),
  ADD KEY `users_id` (`users_id`);

--
-- Indices de la tabla `tipos_descuento`
--
ALTER TABLE `tipos_descuento`
  ADD PRIMARY KEY (`idTipoDescuento`),
  ADD UNIQUE KEY `nombreTP` (`nombreTP`);

--
-- Indices de la tabla `tipos_doc`
--
ALTER TABLE `tipos_doc`
  ADD PRIMARY KEY (`idTipoDoc`);

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
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `idAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `idComprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `concepto_creditos`
--
ALTER TABLE `concepto_creditos`
  MODIFY `idConceptoCredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `idCredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `cuotas_a_pagar`
--
ALTER TABLE `cuotas_a_pagar`
  MODIFY `idCuotaAPagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_asistencias`
--
ALTER TABLE `detalle_asistencias`
  MODIFY `idDetalleAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `idDocente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entrega_tareas`
--
ALTER TABLE `entrega_tareas`
  MODIFY `idEntregaTarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `idEstudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- AUTO_INCREMENT de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  MODIFY `idLeccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `idMatricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `observaciones_creditos`
--
ALTER TABLE `observaciones_creditos`
  MODIFY `idObservacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `idRecurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `series_doc`
--
ALTER TABLE `series_doc`
  MODIFY `idSerieDoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`idGrupo`);

--
-- Filtros para la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD CONSTRAINT `comprobantes_ibfk_1` FOREIGN KEY (`idMatricula`) REFERENCES `matriculas` (`idMatricula`),
  ADD CONSTRAINT `comprobantes_ibfk_2` FOREIGN KEY (`idPago`) REFERENCES `pagos` (`idPago`);

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
-- Filtros para la tabla `detalle_asistencias`
--
ALTER TABLE `detalle_asistencias`
  ADD CONSTRAINT `detalle_asistencias_ibfk_1` FOREIGN KEY (`idEstudiante`) REFERENCES `estudiantes` (`idEstudiante`),
  ADD CONSTRAINT `detalle_asistencias_ibfk_2` FOREIGN KEY (`idAsistencia`) REFERENCES `asistencias` (`idAsistencia`);

--
-- Filtros para la tabla `entrega_tareas`
--
ALTER TABLE `entrega_tareas`
  ADD CONSTRAINT `entrega_tareas_ibfk_1` FOREIGN KEY (`idRecurso`) REFERENCES `recursos` (`idRecurso`),
  ADD CONSTRAINT `entrega_tareas_ibfk_2` FOREIGN KEY (`idEstudiante`) REFERENCES `estudiantes` (`idEstudiante`);

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCurso`),
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`idDocente`) REFERENCES `docentes` (`idDocente`);

--
-- Filtros para la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD CONSTRAINT `lecciones_ibfk_1` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`idGrupo`);

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

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `recursos_ibfk_1` FOREIGN KEY (`idLeccion`) REFERENCES `lecciones` (`idLeccion`);

--
-- Filtros para la tabla `series_doc`
--
ALTER TABLE `series_doc`
  ADD CONSTRAINT `series_doc_ibfk_1` FOREIGN KEY (`idTipoDoc`) REFERENCES `tipos_doc` (`idTipoDoc`),
  ADD CONSTRAINT `series_doc_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
