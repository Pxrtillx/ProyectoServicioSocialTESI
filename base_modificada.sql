-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2026 a las 22:44:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `login_register_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` int(11) NOT NULL,
  `matricula` int(9) NOT NULL,
  `ap_paterno` varchar(20) DEFAULT NULL,
  `ap_materno` varchar(20) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `matricula`, `ap_paterno`, `ap_materno`, `nombre`) VALUES
(1, 202612345, 'JUAREZ', 'ELIAS', 'EBNER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumno` int(9) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `ap_paterno` varchar(20) DEFAULT NULL,
  `ap_materno` varchar(20) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `creditos_acad` int(11) DEFAULT NULL,
  `creditos_dep` int(11) DEFAULT NULL,
  `creditos_cult` int(11) DEFAULT NULL,
  `estatus_servicio` varchar(20) DEFAULT NULL,
  `estatus_residencia` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `matricula`, `ap_paterno`, `ap_materno`, `nombre`, `creditos_acad`, `creditos_dep`, `creditos_cult`, `estatus_servicio`, `estatus_residencia`) VALUES
(1, '202310788', 'BAUTISTA', 'CRUZ', 'JOSE GAYATRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(2, '202310852', 'BRAVO', 'LOPEZ', 'HUGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(3, '202310204', 'CARRASCO', 'ORTEGA', 'STHEPANY LISSET', 0, 0, 0, 'Inactivo', 'Inactivo'),
(4, '202310624', 'CASTILLO', 'ROMERO', 'BRANDON GAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(5, '202310102', 'DURAN', 'MENDOZA', 'GILDA YULIANA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(6, '202310297', 'ESPINOZA', 'LOPEZ', 'EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(7, '202310182', 'FLORES', 'PEREZ', 'ALAN CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(8, '202310858', 'FUENTES', 'ITURBE', 'AMINI ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(9, '202310008', 'GALICIA ', 'ANDRADE', 'EDUARDO ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(10, '202310112', 'GALINDO', 'RICO', 'OSCAR IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(11, '202310636', 'GONZALEZ', 'BECERRA', 'RODRIGO IÑAKY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(12, '202310762', 'GONZALEZ ', 'ROBLEDO', 'DANIELA ', 0, 0, 0, 'Inactivo', 'Inactivo'),
(13, '202310073', 'GONZALEZ ', 'VIVANCO', 'MARA JOCELYN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(14, '202310117', 'HERNANDEZ', 'CORREA', 'ANA LILIA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(15, '202310632', 'HERNANDEZ', 'ESCOBAR', 'LUIS YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(16, '202310206', 'HERRERA', 'PEREZ', 'DIEGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(17, '202310166', 'HURTADO', 'RAMIREZ', 'EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(18, '202310002', 'LANDA', 'MARTINEZ', 'PEDRO RICARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(19, '202310686', 'LOPEZ', 'AGUILAR', 'GUSTAVO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(20, '202310331', 'LOPEZ', 'MARTINEZ', 'OSCAR ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(21, '202310029', 'LUNA', 'ALVAREZ', 'EVELYN ITZEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(22, '202310682', 'MARTINEZ', 'SANCHEZ', 'ALAN ISAAC', 0, 0, 0, 'Inactivo', 'Inactivo'),
(23, '202310040', 'MEDINA', 'CERVANTES', 'HAZEL OBED', 0, 0, 0, 'Inactivo', 'Inactivo'),
(24, '202310001', 'MENA', 'BERNABE', 'FERNANDA AURELIA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(25, '202310059', 'MONJARAZ', 'CORONEL', 'ERICK', 0, 0, 0, 'Inactivo', 'Inactivo'),
(26, '202310330', 'MONTEJO', 'DOMINGUEZ', 'ALEXIS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(27, '201917548', 'ALIZOTA', 'GALVAN', 'SALMA DANIELA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(28, '201917616', 'ALONSO', 'ORTEGA', 'ALBERTO AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(29, '201816702', 'CECILIANO', 'ZEPEDA', 'NANCY PAULINA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(30, '201917750', 'COLORADO', 'MENDOZA', 'MARIA FERNANDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(31, '201917874', 'DOMIGUEZ', 'GUTIERREZ', 'LUIS ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(32, '201816945', 'ESCALANTE', 'TELLEZ', 'ADRIAN ISAAC', 0, 0, 0, 'Inactivo', 'Inactivo'),
(33, '201917738', 'ESPEJEL', 'CHAVEZ', 'MARIA MARIANA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(34, '201917227', 'ESPINOZA', 'CERON', 'JAIME', 0, 0, 0, 'Inactivo', 'Inactivo'),
(35, '201917509', 'ESQUIVEL', 'VARGAS', 'ETHAN JHAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(36, '201917573', 'FUENTES', 'CORTINA', 'DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(37, '201917163', 'GARCIA', 'COCOLETZI', 'ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(38, '201917690', 'GARRIDO', 'VALLE', 'SAMUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(39, '201917869', 'GOMEZ', 'VILLA', 'FERNANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(40, '202310894', 'GONZALEZ', 'CRESPO', 'OSCAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(41, '202118287', 'GUTIERREZ', 'CAMERO', 'BRENDA  ', 0, 0, 0, 'Inactivo', 'Inactivo'),
(42, '201917199', 'HORTA', 'VILCHIS', 'JONATHAN ORLANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(43, '201917597', 'LOPEZ', 'GARCIA', 'YADZIRI PAULINA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(44, '201917661', 'MARIN', 'SAUCEDA', 'JOSE ERICK', 0, 0, 0, 'Inactivo', 'Inactivo'),
(45, '201917476', 'ORTIZ', 'CRUZ', 'ROBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(46, '201917746', 'PEREZ', 'ROSAS', 'AMADO JESUS RAMIRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(47, '202219232', 'RAMIREZ', 'HERRADA', 'MIGUEL ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(48, '201917719', 'RAMOS', 'SALAS', 'JESUS REYMUNDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(49, '201917663', 'RESENDIZ', 'SEGURA ', 'EDWIN JOSUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(50, '201917842', 'ROGRIGUEZ', 'LUNA', 'VICTOR EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(51, '201917845', 'ROGRIGUEZ', 'ZUÑIGA', 'DANIEL OSWALDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(52, '201917709', 'ROMERO', 'CORONA', 'ROGELIO JAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(53, '201816453', 'SANCHEZ', 'DIAZ', 'KEVIN EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(54, '201917213', 'SANCHEZ ', 'SAAVEDRA', 'MARIA JOSE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(55, '201917683', 'SANTOS ', 'VAXIN', 'JOSE URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(56, '201917367', 'URIBE', 'FLORES', 'OSVALDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(57, '2019171276', 'VARGAS', 'ESCOBAR', 'GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(58, '201917758', 'CONTRERAS', 'LOMAN', 'HUGO ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(59, '201917174', 'CRUZ ', 'MARIN', 'LUIS ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(60, '201917296', 'CRUZ ', 'TEJAS', 'ROGELIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(61, '201917320', 'DE LA CRUZ', 'NICOLAS', 'LAURA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(62, '201917554', 'DOMINGUEZ ', 'MARTINEZ', 'VIRIDIANA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(63, '201917902', 'GARCIA', 'TORRALBA', 'LUIS EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(64, '201917481', 'GONZALEZ', 'GONZALEZ ', 'JENIFER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(65, '201917463', 'GUTIERREZ', 'LARA', 'JUAN ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(66, '201917024', 'HERNANDEZ', 'HERNANDEZ', 'TIFFANY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(67, '201917328', 'HERNADEZ', 'TAPIA', 'KEVIN YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(68, '201917794', 'LEYTE', 'CASTORENA', 'BRENDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(69, '201917352', 'LOPEZ', 'HERNANDEZ', 'MAURICIO ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(70, '201917170', 'LOZADA', 'SANCHEZ', 'EDWIN RENE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(71, '201917287', 'MARTINEZ', 'OSORIO ', 'JUAN GUSTAVO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(72, '201917426', 'MARTINEZ', 'PICHARDO', 'CHRISTOPHER IAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(73, '201917542', 'MILA', 'AVILES', 'GABRIELA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(74, '201917433', 'MONTES', 'ZAMORA', 'ENRIQUE PAUL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(75, '201917737', 'MORENO', 'PEREZ', 'MONTSERRAT', 0, 0, 0, 'Inactivo', 'Inactivo'),
(76, '201917736', 'OCHOA', 'RODRIGUEZ', 'KARLA JUDITH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(77, '201917560', 'PEREZ', 'SANCHEZ', 'CHRISTIAN EMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(78, '201917918', 'RAMIREZ', 'PORRAS', 'MARTHA CECILIA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(79, '201917574', 'RODRIGUEZ', 'LOPEZ', 'VICTOR DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(80, '201917753', 'RODRIGUEZ', 'OCHOA', 'LETICIA YARET', 0, 0, 0, 'Inactivo', 'Inactivo'),
(81, '201917583', 'ROMERO', 'GARCIA', 'RODRIGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(82, '201917216', 'SALINAS', 'CANTU', 'VICTOR MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(83, '201917802', 'SOTERO', 'NAJERA', 'DIANA SHARENI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(84, '201917879', 'VERAS', 'SANCHEZ', 'VICTOR MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(85, '201917197', 'ARROYO', 'LOPEZ', 'RAFAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(86, '202310896', 'CABRERA ', 'RAMIREZ', 'LUIS ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(87, '202018129', 'DELGADO', 'CORTES', 'OSCAR ISRAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(88, '202018074', 'FLORES ', 'AGUILAR', 'YAEL ARTURO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(89, '202018053', 'GARCIA', 'DINORIN', 'JUAN FRANCISCO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(90, '202018126', 'GONZALEZ', 'LOPEZ', 'JOSE HUMBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(91, '202018166', 'LARA', 'GARCIA', 'JOSE ARMANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(92, '201917456', 'LEAL', 'MORALES', 'FERNANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(93, '201917350', 'MENDIOLA', 'GALICIA ', 'ENRIQUE  URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(94, '201917703', 'PEREZ', 'MORA', 'ROBERTO CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(95, '202018117', 'RAMIREZ', 'OROZCO', 'GERARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(96, '201917783', 'VAZQUEZ', 'LOPEZ', 'JOSUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(97, '202011371', 'ALVARADO ', 'YESCAS', 'CARLOS ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(98, '202011375', 'CAZARES ', 'DOMINGUEZ', 'DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(99, '202011423', 'CENOBIO', 'MORAN', 'TADEO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(100, '202118286', 'ESPINOZA', 'BERNAL', 'ALEJANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(101, '202011382', 'FLORES', 'CABRERA', 'LUIS ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(102, '202011377', 'FLORES', 'SOTOMAYOR', 'LUIS ALFREDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(103, '202310993', 'GARCIA', 'MORENO', 'FRANCISCO XAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(105, '202011402', 'GONZALEZ', 'BERNAL', 'FERNANDA MARLENE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(106, '202011410', 'LUNA', 'CORONA', 'SALVADOR IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(107, '202011418', 'LUNA', 'OJEDA', 'LUIS EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(108, '201715817', 'NIEVES', 'HERNANDEZ', 'JOSE JUAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(109, '202011420', 'ROSAS', 'AVALOS', 'VICTOR DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(110, '202011387', 'SUAREZ', 'HIGUERA', 'GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(111, '202011389', 'TORRES', 'BARRIENTOS', 'JOVANNY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(112, '202011388', 'TORRES', 'SEGUNDO', 'ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(113, '202011390', 'VIDAL', 'HERNANDEZ', 'ROBERTO JAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(114, '202011417', 'VIRUEL', 'MOLINA', 'OSVALDO JOSHUA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(115, '202011329', 'ALVAREZ', 'FERNANDEZ', 'JULIO CESAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(116, '202011330', 'BAEZ', 'LOPEZ ', 'PAOLA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(117, '202011331', 'BARCEINAS', 'CARMONA', 'BRAYAN DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(118, '202011332', 'BEZARES', 'DE LOS RIOS', 'OSCAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(119, '202011374', 'CAMPOS', 'RONQUILLO', 'JESUS ', 0, 0, 0, 'Inactivo', 'Inactivo'),
(120, '202011333', 'CARRANZA', 'CERVANTES', 'JOSE ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(121, '202011335', 'CHICO', 'LOPEZ', 'JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(122, '202011376', 'ESPINOSA', 'TOLEDO', 'ALAN RICARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(123, '202211127', 'ESPINOZA', 'PLACENCIA', 'ABRAHAM', 0, 0, 0, 'Inactivo', 'Inactivo'),
(124, '202011339', 'FALCON', 'CAMACHO', 'SALMA FABIOLA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(125, '202011342', 'GARCIA', 'HUERTA', 'CRISTIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(126, '202011427', 'GONZALEZ ', 'BARRON', 'JOSUE MOISES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(127, '202011344', 'GONZALEZ', 'RAMIREZ', 'JUAN CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(128, '202011345', 'GUERRERO', 'HIGUERA', 'AMAURY ADAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(129, '202011407', 'HERNANDEZ ', 'BAUTISTA', 'JUAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(130, '202011347', 'HERNANDEZ', 'CRUZ', 'OLIVER BARUCH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(131, '202011068', 'HERNANDEZ', 'VAZQUEZ', 'EDUARDO RAFAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(132, '202011348', 'JUAREZ', 'MARTINEZ', 'JOSE DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(133, '202011349', 'LAGUNA', 'CASTRO', 'YAOTEKATL DE JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(134, '202011416', 'MANZANO', 'MENDEZ', 'ALVARO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(135, '202011351', 'MARTINEZ', 'SANCHEZ', 'JOSE EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(136, '202011352', 'MONTES', 'SANCHEZ', 'BRUNO ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(137, '202011354', 'NAVA', 'VELA', 'MIRIAM LIZBET', 0, 0, 0, 'Inactivo', 'Inactivo'),
(138, '202011355', 'OLIVA', 'HIDALGO', 'EDWIN CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(139, '202011399', 'ORTEGA', 'CORDOVA', 'CARLOS ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(140, '202011403', 'RESENDIZ', 'MARCIAL', 'ALECSIS FERNANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(141, '202011357', 'RESENDIZ', 'VAZQUEZ', 'XIMENA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(142, '202011358', 'ROBLEDO ', 'PEREZ', 'JAN MARCOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(143, '202011419', 'RODRIGUEZ', 'GONZALEZ', 'BRYAN GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(144, '202011384', 'RODRIGUEZ', 'MENDEZ', 'BRYAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(145, '202011359', 'RODRIGUEZ', 'ROJAS', 'LUIS ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(146, '202011360', 'ROJAS', 'ORTEGA', 'REY GEOVANNI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(147, '202011361', 'SAAVEDRA', 'VENTURA', 'ANA LAURA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(148, '202011385', 'SANCHEZ ', 'GALAN', 'EMILIO KEVIN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(149, '202011425', 'SANCHEZ', 'HERNANDEZ', 'ALAN DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(150, '201917411', 'SOLANO', 'ORTEGA', 'ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(151, '202011362', 'SORIANO', 'FLORES', 'LUIS ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(152, '202011364', 'TOVAR', 'HERNANDEZ', 'ARTURO UZIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(153, '202011366', 'VAZQUEZ', 'TORRES', 'MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(154, '202011367', 'VILCHIS', 'HERNANDEZ', 'SERGIO DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(155, '202011369', 'ZAMORA', 'RANGEL', 'AXEL ETHIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(156, '202118377', 'ALCANTARA', 'GARCIA', 'BRANDON ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(157, '202119043', 'ARRIETA', 'GUZMAN', 'JULIO ISAIAS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(158, '202118756', 'BARRAGAN', 'GUZMAN', 'BRNADOM KALETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(159, '202118986', 'CASARROJA ', 'FRANCO ', 'XIMENA ', 0, 0, 0, 'Inactivo', 'Inactivo'),
(160, '202219274', 'DOMIGUEZ', 'RODRIGUEZ', 'BRYAN ANTHONY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(161, '202118698', 'GALINDO', 'LOPEZ', 'EDGAR ARTURO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(162, '202118645', 'GARCIA', 'CUEVAS', 'ANGEL MIGUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(163, '2021310346', 'ALONSO', 'CONTRERAS', 'BRANDON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(199, '202310517', 'ROJAS', 'RAMOS', 'JESUS ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(212, '202310346', 'ALONSO', 'CONTRERAS', 'BRANDON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(213, '202310323', 'ARROYO', 'ESCAMILLA', 'IRVIN ZADQUIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(214, '202310804', 'BAÑOS', 'GALINDO', 'DIEGO EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(215, '202310094', 'CABRERA', 'CASTILLO', 'MIGUEL ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(216, '202310379', 'CANO', 'ARISTIZABAL', 'CARLOS STIVEN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(217, '202310103', 'CASTILLO', 'CASTILLO', 'FERNANDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(218, '202310218', 'CASTILLO', 'DIAZ', 'DIEGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(219, '202310280', 'CASTILLO', 'FLORES', 'DEREK JOEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(220, '202310836', 'CASTRO', 'RIVAS', 'RICARDO DONOVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(221, '202310425', 'CORDERO', 'GONZALEZ', 'JULIO CESAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(222, '202310266', 'CRUZ', 'SANCHEZ', 'DANIEL ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(223, '202310357', 'DE JESUS', 'ALMAZAN', 'JULIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(224, '202310895', 'ESPINOZA', 'RODRIGUEZ', 'ALAN HASSAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(225, '202310309', 'ESQUIVEL', 'ROBLEDO', 'EDSON IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(226, '202310311', 'FUENTES', 'ALVARADO', 'JOSE LUIS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(227, '202310329', 'GARCIA', 'CAPORAL', 'ALEJANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(228, '202310193', 'GARCIA', 'MEDINA', 'ROBERTO YAHIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(229, '202310292', 'GONZALEZ', 'TOCOHUA', 'RUTH NOEMI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(230, '202219211', 'HERNANDEZ', 'ZARATE', 'LUIS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(231, '202310121', 'JUAREZ', 'DE JESUS', 'EDGAR YOVANI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(232, '202310203', 'LARA', 'CARDENAS', 'HUGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(233, '202219595', 'LEVYA', 'MARTINEZ', 'MARCO ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(234, '202310588', 'LOPEZ', 'CARCAMO', 'BRYAN EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(235, '202310161', 'LUNA', 'GOMEZ', 'CITLALLI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(236, '202310381', 'MANRIQUEZ', 'CISNEROS', 'DIEGO EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(237, '202310472', 'MARQUEZ', 'TAPIA', 'IAN ZABDIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(238, '202310477', 'MARTINEZ', 'MARTINEZ', 'RICARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(239, '202310645', 'MARTINEZ', 'RODRIGUEZ', 'CESAR ALMIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(240, '202310261', 'MEDINA', 'GUERRA', 'KEVIN MICHEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(241, '202310447', 'MENDOZA', 'VELAZQUEZ', 'JESUS IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(242, '202310195', 'MIRANDA', 'LEVYA', 'OSCAR URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(243, '202310240', 'MONES', 'SALGUERO', 'GUSTAVO ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(244, '202310527', 'NIÑO', 'TAPIA', 'LESLIC MAYRIN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(245, '202310046', 'QUINTERO', 'HERNANDEZ', 'KEVYN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(246, '202310374', 'RAMIREZ', 'SANCHEZ', 'HECTOR EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(247, '202310512', 'RODRIGUEZ', 'ESTRADA', 'ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(248, '202310158', 'RODRIGUEZ', 'GUTIERREZ', 'VIVIANA MONTSERRAT', 0, 0, 0, 'Inactivo', 'Inactivo'),
(249, '202310415', 'RODRIGUEZ', 'LEYVA', 'FERNANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(250, '202310105', 'ROSAS', 'SERRANO', 'JAEL JORGE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(251, '202310325', 'SANCHEZ', 'SANTOYO', 'OWEN OSWALDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(252, '202310823', 'SAN MIGUEL', 'CAYETANO', 'MARIA DE LOURDES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(253, '202310597', 'SANTOS', 'SANCHEZ', 'ANAHI LIZBET', 0, 0, 0, 'Inactivo', 'Inactivo'),
(254, '202310246', 'SEVILLA', 'MURILLO', 'GAEL ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(255, '202310124', 'SIMON', 'HERNANDEZ', 'ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(256, '202310657', 'TAPIA', 'GONZALEZ', 'ADRIAN RODRIGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(257, '202219228', 'TOLEDO', 'MALDONADO', 'VALERIA MONTSERRAT', 0, 0, 0, 'Inactivo', 'Inactivo'),
(258, '202310393', 'TORRES', 'REYES', 'OSCAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(259, '202310366', 'TRUJILLO', 'NAHUACATL', 'EDGAR ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(260, '202310307', 'VALERIO', 'TERAN', 'JORGE ABDIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(261, '202118760', 'VARGAS', 'MARTINEZ', 'DAVID OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(262, '202310092', 'VAZQUEZ', 'LOPEZ', 'ALAN GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(263, '202310209', 'VELAZQUEZ', 'MARTINEZ', 'ALEXIS JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(264, '202310145', 'VIDALS', 'DE LA LUZ', 'ANGEL ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(265, '202310510', 'VILLALPANDO', 'GALICIA', 'DIEGO YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(266, '202310372', 'VILLEGAS', 'HERNANDEZ', 'LOURDES XIMENA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(267, '202310818', 'VIRUEL', 'MOLINA', 'DANTE JOSEPH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(268, '202219087', 'ALCOCER', 'MARTINEZ', 'MIGUEL ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(269, '202219103', 'BECERRIL', 'VARGAS', 'ALDO IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(270, '202219944', 'BOJORGE', 'MORENO', 'JOSE ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(271, '202219380', 'BORJA', 'PATLAN', 'ERIC JAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(272, '202219489', 'CARMONA', 'LOPEZ', 'EMILIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(273, '202219398', 'CERNA', 'SANCHEZ', 'JOSE ROBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(274, '202219428', 'CHAZARI', 'MARTINEZ', 'LEONARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(275, '20221994', 'CONTRERAS', 'LUNA', 'AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(276, '202219227', 'CORTES', 'AGUILAR', 'KARLA CAROLINA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(277, '202219493', 'CRISTOBAL', 'CRUZ', 'KEVIN ADAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(278, '202219221', 'ESCOBEDO', 'GARRIDO', 'LUIS DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(279, '202219352', 'ESPITIA', 'ZAVALA', 'GERARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(280, '202219616', 'FLORES', 'RUIZ', 'BRENDA GABRIELA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(281, '202219878', 'HERNANDEZ', 'ZERMEÑO', 'ARIELA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(282, '202219096', 'LUCIANO ', 'HERNANDEZ', 'CECILIA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(283, '202219180', 'MANZANO', 'JIMENEZ', 'JURGEN DAMIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(284, '202219899', 'MARTINEZ', 'FLORES', 'FABIAN URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(285, '202219471', 'MARTINEZ', 'GONZALEZ', 'BRANDON GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(286, '202211084', 'OCAMPO', 'AGUILAR', 'ORLANDO DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(287, '202219521', 'OLIVARES', 'ESPADA', 'AXEL YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(288, '202219245', 'OLVERA', 'RODRIGUEZ', 'BRUNO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(289, '202219804', 'PONCE', 'VALLE', 'XOCHILTL KUMARY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(290, '202211071', 'RAMIREZ', 'MONTERRUBIO', 'JULIO CESAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(291, '202219348', 'RAMIREZ', 'QUIROZ', 'LIZETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(292, '202219317', 'RAMOS', 'VELEZ', 'JESUS EMILIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(293, '202219156', 'RESENDIZ', 'RESENDIZ', 'NAOMI JACQUELINE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(294, '202219840', 'ROMERO', 'OSORIO', 'JONATHAN MIGUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(295, '202219559', 'RUBI', 'CABRERA', 'JOSE ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(296, '202219339', 'RUBIO', 'GALEANA', 'SAUL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(297, '202219896', 'SANCHEZ', 'CARREON', 'LUIS ALEXANDER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(298, '202219778', 'SANDOVAL', 'LUNA', 'ANDRES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(299, '202219397', 'TORRES', 'LUCERO', 'URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(300, '2022118760', 'VARGAS', 'MARTINEZ', 'DAVID OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(301, '202219131', 'VENTURA', 'SANTIAGO', 'ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(302, '202219418', 'ZETINA', 'LUNA', 'ANA PAOLA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(303, '202219229', 'ALONSO', 'ORTEGA', 'FRANCISCO DE JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(304, '202219744', 'AVENDANO', 'SANTOS', 'FELIPE ISRAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(305, '202219553', 'BACA', 'RUIZ', 'DEMIAN ABEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(306, '202219780', 'BASURTO', 'HERNANDEZ', 'GEREMY SAID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(307, '202211039', 'BAUTISTA', 'SANTIAGO', 'ALMA ARACELI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(308, '202219297', 'CARRASCO', 'ORTEGA', 'JESUS DE NILSON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(309, '202219323', 'CASTILLO', 'MACIAS', 'ANGEL JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(310, '202219946', 'CRUZ', 'MARTINEZ', 'ANNETTE JOHANA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(311, '202219865', 'DEGANTE', 'TAPIA', 'JUAN FELIPE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(312, '202219272', 'ESCOBAR', 'AGUILAR', 'ALDAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(313, '202219571', 'ESQUIVEL', 'MORAN', 'HECTOR ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(314, '202219822', 'GIL', 'MATIAS', 'DAVID EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(315, '202219090', 'GONZALEZ', 'UGALDE', 'DEREK', 0, 0, 0, 'Inactivo', 'Inactivo'),
(316, '202219315', 'GUERRERO', 'ARROYO', 'DANA YURITZI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(317, '202219766', 'GUEVARA', 'CEBALLOS', 'ARI SAID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(318, '202219147', 'GUZMAN', 'LOPEZ', 'JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(319, '202219092', 'HERNANDEZ', 'BUSTAMANTE', 'MAYRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(320, '202219599', 'HERNANDEZ', 'LAZARO', 'MOISES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(321, '202219412', 'HERNANDEZ', 'MIRAMONTES', 'LUIS CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(322, '202219239', 'IGLECIAS', 'GUZMAN', 'GUILLERMO GUSTAVO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(323, '202219940', 'LOPEZ', 'BARBOSA', 'BRUNO JOSHEPH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(324, '202219237', 'LORENZO', 'DE LA CRUZ', 'JULIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(325, '202219149', 'MARQUEZ', 'LOPEZ', 'JOSE CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(326, '202219678', 'MARTINEZ', 'LOPEZ', 'DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(327, '202219249', 'MARTINEZ', 'QUIROZ', 'ITALIA HETZEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(328, '202219895', 'MECALCO', 'ALEGRE', 'JUAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(329, '202211025', 'MORALES', 'NERI', 'IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(330, '202118918', 'MUÑOZ', 'ALEJANDRO', 'DUSTIN ELOY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(331, '202219292', 'PERALTA', 'RAMIREZ', 'ANGEL ADAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(332, '202219504', 'ROMERO', 'GOMEZ', 'ARON ISAAC', 0, 0, 0, 'Inactivo', 'Inactivo'),
(333, '202211065', 'SANCHEZ', 'LOPEZ', 'CHISTOPHER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(334, '202219168', 'SOTO', 'AVENDAÑO', 'ALEJANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(335, '202211007', 'TOSCANO', 'VILLALOBOS', 'ABARHAM MOISES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(337, '202219983', 'ALBINO', 'LOPEZ', 'ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(338, '202219379', 'BENITEZ', 'PACHECO', 'CARLOS DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(339, '202211079', 'CARRILO', 'RUEDA', 'CARLOS EMILIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(340, '202211077', 'CASTRO', 'VIDAL', 'ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(341, '202219580', 'CORRO', 'HERNANDEZ', 'AMARIS YURAI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(342, '202219499', 'CRUZ', 'GARCIA', 'LUIS ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(343, '202219968', 'CRUZ', 'MARTINEZ', 'LIBNITAI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(344, '202118647', 'DELGADO', 'LAUREANO', 'OSCAR OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(345, '202219215', 'DOMINGUEZ', 'CRUZ', 'YARCOV THONATIU', 0, 0, 0, 'Inactivo', 'Inactivo'),
(346, '202219159', 'DOMINGUEZ', 'HERNANDEZ', 'DONOVAN DAFET', 0, 0, 0, 'Inactivo', 'Inactivo'),
(347, '202219693', 'ESCALONA', 'PINEDA', 'ANGEL EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(348, '202219510', 'FUENTES', 'MENDIETA', 'FRANCISCO XOCOYOTZIN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(349, '202219789', 'GONZALEZ', 'ELIAS', 'ANGEL JAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(350, '202219675', 'GONZALEZ', 'GARCIA', 'JIMENA YAAHMELL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(351, '202219285', 'JIMENEZ', 'SORIANO', 'OSCAR JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(352, '202219354', 'LOPEZ', 'SANCHEZ', 'BRAYAN GIOVANNY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(353, '201917848', 'MARTINEZ', 'CISNEROS', 'MARIO EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(354, '202219492', 'MARTINEZ', 'LOPEZ', 'ISAAC GAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(355, '202219359', 'MENDEZ', 'RODRIGUEZ', 'IAN ALESSANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(356, '202211028', 'MONTES', 'LOPEZ', 'ARTURO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(357, '202219107', 'MORA', 'PEREZ', 'ISRAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(358, '202219676', 'MORALES', 'CASTAÑEDA', 'ISAAC ALI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(359, '202219934', 'OLVERA', 'MAURINO', 'ILENA NAOMI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(360, '202219490', 'PEREZ', 'AMPARO', 'ERIKA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(361, '202219788', 'RAMIREZ', 'GONZALEZ', 'YUNUEM DESSIRE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(362, '202219864', 'REYES', 'REYES', 'GUADALUPE ARELY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(363, '202219900', 'RUIZ', 'PEREZ', 'MIGUEL SAUL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(364, '202219203', 'SALAZAR', 'GARCIA', 'DIANA ELIZABATH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(365, '202219097', 'SANTIAGO', 'ALVAREZ', 'CARLOS IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(366, '202219717', 'UGALDE', 'UGALDE', 'LUIS ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(367, '202219924', 'VALVERDE', 'BERMEJO', 'JOSE EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(368, '202118899', 'AGUILAR', 'AGUILAR', 'DANIELA GUADALUPE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(369, '202118642', 'ALCANTAR', 'MELO', 'STEVEN YOSKAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(370, '202118323', 'ALVARADO', 'DURAN', 'IRVIN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(371, '202118535', 'AVALOS', 'HERNANDEZ', 'JUAN MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(372, '202118450', 'BARCENAS', 'GONZALEZ', 'LAURA CASANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(373, '202118309', 'BORJA', 'BUSTAMANTE ', 'ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(374, '202011336', 'CHINO', 'CRISTOBAL', 'BENIGNO JAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(375, '202118610', 'DORANTES', 'ESPINOSA', 'RICARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(376, '202118829', 'FOSADO', 'GALINDO', 'HANNIA JOALIV', 0, 0, 0, 'Inactivo', 'Inactivo'),
(377, '202118340', 'GALLARDO', 'HERNANDEZ', 'EVELYN ALINE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(378, '202118726', 'GONZALEZ', 'CONTRERAS', 'DANIEL MICHELLE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(379, '202118832', 'GONZALEZ', 'GONZALEZ', 'BRANDON YAHIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(380, '202118516', 'GONZALEZ', 'HERNANDEZ', 'EDGAR EMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(381, '202118927', 'GONZALEZ', 'DE LA ROSA', 'LESLIE FERNANDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(382, '202118828', 'GUZMAN', 'ARGUELLO', 'YAEL DE JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(383, '202118468', 'HERNANDEZ', 'GARCIA', 'AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(384, '202118495', 'JARERO', 'ALONSO', 'TERESA GUADALUPE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(385, '202118634', 'LOPEZ', 'GOMEZ', 'ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(386, '202118392', 'LOPEZ', 'JAIME', 'EDGAR FELIPE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(387, '202118470', 'MARTINEZ', 'BARAJAS', 'FRANCISCO MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(388, '202118429', 'MORALES', 'IBARRA', 'SANDIVEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(389, '202118699', 'PEREZ', 'GARDUÑO', 'RICARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(390, '202118342', 'PEREZ', 'GONZALEZ', 'ANGEL JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(391, '202118404', 'RAMIREZ', 'ISLAS', 'JESUS XIUHTEKUHTLI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(392, '202118739', 'RODRIGUEZ', 'DE LA ROSA', 'NICOLL SHERELL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(393, '202118455', 'SIMIANO', 'ANDRADE', 'ARTURO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(394, '202118652', 'SOLARES', 'FLORES', 'JOAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(395, '202118965', 'SOSA', 'GRANADOS', 'DAVID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(396, '202118330', 'VALDEZ', 'CONTRERAS', 'ANGEL GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(397, '202118372', 'ALONSO', 'SALINAS', 'DAVID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(398, '202118924', 'ALVARADO', 'AMADOR', 'YAZMIN EVELYN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(399, '202119013', 'ARGUELLO', 'CHAVEZ', 'DAVID DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(400, '202118440', 'AYALA', 'LEDEZMA', 'ANTONIO SAUL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(401, '202118479', 'AYALA', 'PINEDA', 'OSCAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(402, '202118293', 'BRACHO', 'SANCHEZ', 'WENDY MICHELLE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(403, '202118859', 'CASTRO', 'VALVERDE', 'FRANCISCO JAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(404, '20211769', 'CISNEROS', 'SAMANIEGO', 'ANGEL DE JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(405, '202118529', 'CORDOBA', 'ROSAS', 'URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(406, '202118617', 'DIONICIO', 'ORTIZ', 'JOSE CRUZ', 0, 0, 0, 'Inactivo', 'Inactivo'),
(407, '202118783', 'DOMINGUEZ', 'ROMAN', 'BRAYAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(408, '202118712', 'DURAN', 'GARCIA', 'YAEL URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(409, '202118906', 'FLORES', 'MORA', 'JOSE ARMANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(410, '202118533', 'GARCIA', 'LEON', 'ANGEL DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(411, '202118990', 'GUTIERREZ', 'GONZALEZ', 'KEILA JIRETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(412, '202118425', 'HERNANDEZ', 'LUIS', 'JOSE DE JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(413, '202118341', 'LUNA', 'PEREZ', 'AXEL ISRAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(414, '202118842', 'MARTINEZ', 'SALINAS', 'NOE EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(415, '202118410', 'MILIAN', 'MURRIETA', 'TANIA ELIZABETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(416, '202118936', 'ORTIZ', 'RODRIGUEZ ', 'MARCO ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(417, '202118405', 'PEREZ', 'MARTINEZ', 'EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(418, '202118401', 'RIVERA', 'RUBIO', 'IGNACIO ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(419, '202118663', 'ROJAS', 'HERNANDEZ', 'CRISTIAN YORAM', 0, 0, 0, 'Inactivo', 'Inactivo'),
(420, '202118311', 'SALGADO', 'MORA', 'ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(421, '202118538', 'SALINAS', 'TREJO', 'DIEGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(422, '202118521', 'SANCHEZ', 'VILLEGAS', 'JOSE IGNACIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(423, '202118991', 'SANDOVAL', 'YAÑEZ', 'DIEGO ARMANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(424, '202118600', 'TORRES', 'PEREZ', 'ELIOTH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(425, '202118653', 'VALENCIA', 'PONCE', 'LUIS ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(426, '202118559', 'VELASCO', 'MALDONADO', 'DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(427, '202118968', 'GARCIA', 'VALENCIA', 'MARIO ORLANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(428, '202118636', 'GONZALEZ', 'RAMIREZ', 'ALFONSO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(429, '202011379', 'HERNANDEZ', 'CANO', 'AXEL ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(430, '202118961', 'HERRERA', 'SOSA', 'OSCAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(431, '202118612', 'LOPEZ', 'MONTEJO ', 'ALFREDO ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(432, '202118476', 'MENDOZA', 'RIVERA', 'JUAN DIEGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(433, '202118687', 'POLO', 'AVILA', 'ELIAS MOISES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(434, '202118312', 'RAMIREZ', 'CHAVEZ', 'LESLI AMAIRAINI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(435, '202118426', 'RAMIREZ', 'TAPIA', 'LEONARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(436, '202118635', 'RAMIREZ', 'VEGA', 'CARLOS GERMAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(437, '202118622', 'RAMOS', 'SANCHEZ', 'ALEXIS IMANOL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(438, '202118871', 'RIVERA', 'GUERRA', 'ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(439, '202118557', 'ROJAS', 'ESTRADA', 'BERENICE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(440, '202119023', 'ROSAS', 'MENDOZA', 'BRAYAN SAUL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(441, '202118777', 'SAN JUAN', 'HERNANDEZ', 'LEONARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(442, '202118299', 'SANCHEZ', 'MENDIOLA', 'JESUS EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(443, '202118668', 'TORRES', 'LOPEZ', 'CITLALI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(444, '202118998', 'VALENCIA', 'SOSA', 'DEREK CAMILO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(445, '202310812', 'MORALES', 'RODRIGUEZ', 'ROGELIO EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(446, '202310202', 'MORAN', 'PALMA', 'ALEJANDRO ETO.O', 0, 0, 0, 'Inactivo', 'Inactivo'),
(447, '202310920', 'MOTA', 'SOTO', 'JESUS EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(448, '202310191', 'NERI', 'CARRASCO', 'JORGE LUIS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(449, '202310303', 'ORTEGA', 'ABURTO', 'IAN DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(450, '202310681', 'ORTIZ', 'DELGADO', 'BRYAN JOSUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(451, '202219820', 'GONZALEZ', 'MENDOZA', 'FAUSTINO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(452, '202310278', 'PORTILLO ', 'CALDERON', 'BRANDON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(453, '202310088', 'REYES', 'REYES', 'MARIO ABEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(454, '202310044', 'RIVERA ', 'ALCALA', 'DONOVAN THONATIHU', 0, 0, 0, 'Inactivo', 'Inactivo'),
(455, '202310285', 'RUIZ', 'ROMERO', 'ULISES DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(456, '202310045', 'SALAZAR', 'VIVEROS', 'DERECK', 0, 0, 0, 'Inactivo', 'Inactivo'),
(457, '202310927', 'SANCHEZ', 'LOPEZ', 'VICTOR MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(458, '202310289', 'TAMAYO', 'DURAN', 'ANGEL ESAU', 0, 0, 0, 'Inactivo', 'Inactivo'),
(459, '202310033', 'TORRES ', 'GARCIA', 'LEILANY XIMENA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(460, '202310929', 'TRANQUILINO', 'HERNANDEZ', 'ADRIAN ARMANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(461, '202310026', 'VARGAS', 'MORENO', 'ETEL YERAY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(462, '202310153', 'VICTORIA', 'RUIZ', 'ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(463, '202310350', 'VILLEGAS', 'ALVA', 'JOSE EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(464, '202310019', 'ZUÑIGA', 'ESPINOSA', 'SANTIAGO BRANDON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(465, '202310013', 'VILCHIS', 'HERNANDEZ', 'VICTOR MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(466, '202219812', 'GOMEZ', 'AGUILAR', 'NOE AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(468, '202219527', 'LOPEZ', 'MORALES', 'ELIZABETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(469, '202118800', 'GOMEZ', 'REYES', 'BRENDA ANAHI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(470, '202011356', 'OLIVARES', 'MARTINEZ', 'MOISES EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(568, '202410089', 'CALLETANO', 'FRANCISCO ', 'ULISES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(570, '202210612', 'CORRO', 'HERNANDEZ', 'DAMARIS YURAI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(574, '20221094', 'CONTRERAS', 'LUNA', 'AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(581, '202410097', 'SANCHEZ', ' CHAPA ', 'LUIS ALAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(583, '201917329', 'CONTRERAS', 'ALTAMIRANO', 'JOSE EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(606, '202410019', 'GUTIERREZ', 'HERNANDEZ', 'JOSE ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(607, '202410047', 'MARTINEZ', 'ESCUTIA', 'ANA PATRICIA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(608, '202410234', 'SOTELO', 'MONESINO', 'VANESSA NOEMI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(610, '202310939', 'GARCIA ', 'MORENO', 'FRANCISCO XAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(616, '2024100119', 'GUTIERREZ', 'HERNANDEZ', 'JOSE ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(625, '2020', 'DIONICIO', 'ORTIZ', 'JOSE CRUZ', 0, 0, 0, 'Inactivo', 'Inactivo'),
(626, '202340755', 'HUERTA', 'HERNANDEZ', 'JENNYFER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(628, '202410342', 'ACOSTA', 'CRUZ', 'DAVID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(629, '202410307', 'AGUIRRE', 'ALBERTO', 'EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(630, '202410308', 'ALAGUNA', 'VAZQUEZ', 'LEONARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(631, '202410733', 'ARCOS', 'DE LA ROSA', 'ANGEL EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(632, '202410322', 'BAUTISTA', 'DIAZ', 'KEVIN EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(633, '202410373', 'BONILLA', 'SUMANO', 'LUIS LEONARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(634, '202410361', 'CARDENAS', 'SANCHEZ', 'CALEB ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(635, '202410338', 'CASTRO', 'SORIANO', 'CESAR GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(636, '202410393', 'CELESTINO', 'LUIS', 'ELIZABETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(637, '202410029', 'CONTRERAS', 'VARGAS', 'ABIGAIL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(638, '202410065', 'CRUZ', 'DE ALVAREZ', 'LUIS GERMAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(639, '202310434', 'ARELLANOS', 'MARTINEZ', 'NICOL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(640, '202310390', 'ARREOLA', 'BELTRAN', 'DAVID ABRAHAM', 0, 0, 0, 'Inactivo', 'Inactivo'),
(641, '202310735', 'BANDA', 'AYALA', 'KEVIN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(642, '202310678', 'CANDIA', 'MARTINEZ', 'DIEGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(643, '202310514', 'CARRASCO', 'PEREZ', 'DIEGO ALDAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(644, '202310382', 'CAYETANO', 'LOBATO', 'ERIKA SAYURI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(645, '202310556', 'CONEJO', 'SANCHEZ', 'JOSE ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(646, '202310612', 'CONTRERAS', 'GARCES', 'OWEN ROBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(647, '202310275', 'DE LA LUZ', 'SANCHEZ', 'ABRIL ITZEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(648, '202310356', 'DELGADO', 'DURAN', 'RICARDO AARON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(649, '202310433', 'GARCIA', 'LOPEZ', 'TATIANA AYLIN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(650, '202310241', 'GARCIA', 'MIJARES', 'ANGEL MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(651, '202310264', 'GUTIERREZ', 'MUÑOZ', 'SAYURI ANNELIESE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(652, '202310614', 'HERNANDEZ', 'BERNABE', 'CRISTIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(653, '202310609', 'HERNANDEZ', 'CORTES', 'OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(654, '202310411', 'LEON', 'PEÑA', 'KAREN HARUMI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(655, '202310341', 'LIRA', 'GARCIA', 'NADIA ABIGAIL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(656, '202310383', 'LOPEZ', 'GONZALEZ', 'BRAYAN URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(657, '202310618', 'MARQUEZ', 'MAGALLON', 'XOCHILTL GABRIELA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(658, '202310766', 'MARTINEZ', 'CHIÑAS', 'MEDWIN MAURICIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(659, '202310446', 'MARTINEZ', 'LOZANO', 'SHERLYN ALESSANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(660, '202310853', 'MENDOZA', 'ARELLANES', 'JONATHAN URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(661, '202310694', 'MENDOZA', 'CABRERA', 'SEBASTIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(662, '202310822', 'MIRANDA', 'BAEZA', 'ANGEL EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(663, '202310364', 'MOZO', 'MONTERO', 'FERNANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(664, '202310749', 'NUÑEZ', 'GUTIERREZ', 'JORGE EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(665, '202310230', 'PEREZ', 'CONTRERAS', 'DAHAN SINUHE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(666, '202310769', 'RAMIREZ', 'TAPIA', 'ADRIAN RAFAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(667, '202310407', 'RAZO', 'PAREDES', 'DONOVAN CRISTOPHER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(668, '202310623', 'REYES', 'CASTILLO', 'ALEXAI YARED', 0, 0, 0, 'Inactivo', 'Inactivo'),
(670, '202310439', 'ROSALES', 'TOLENTINO', 'MELANI MONSERRAT', 0, 0, 0, 'Inactivo', 'Inactivo'),
(671, '202310457', 'RUIZ', 'CRUZ', 'JOSE EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(672, '202310592', 'SAAVEDRA ', 'SAMPEDRO', 'ALISON ENID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(673, '202310591', 'SAAVEDRA ', 'SAMPEDRO', 'MIA YATZIRI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(674, '202310358', 'SANCHEZ', 'TELLO', 'JOSE ARTURO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(676, '202310220', 'SUAREZ', 'RAYON', 'IBRAHIM CANDELARIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(677, '202310575', 'TAPIA', 'ALMARAZ', 'JUAN MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(678, '202310581', 'VALENCIA', 'CABELLO', 'BRANDON ANTONIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(679, '202310353', 'VALENZUELA', 'GONZALEZ', 'AARON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(683, '202310216', 'SANCHEZ', 'ZAMORA', 'BRANDON GEOVANI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(684, '202310875', 'PEREZ', 'LOPEZ', 'DAVID FRANCISCO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(685, '202310391', 'JIMENEZ', 'SEGURA', 'ANGEL OSWALDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(686, '202310458', 'CRUZ', 'OROZCO', 'OSVALDO URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(687, '202310243', 'ESCOBAR', 'SOTOMAYOR', 'MARLON ALONSO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(688, '202310781', 'GUEVARA', 'TRANQUILINO', 'EDGAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(689, '202310544', 'HIDALGO', 'TADEO', 'ALEXIS DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(702, '202410278', 'ACOSTA', 'VEGA', 'LUIS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(704, '202410012', 'DE LA CRUZ', 'VILLEDA', 'CARLOS ADAHIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(705, '202410060', 'DOMINGUEZ', 'MARTINEZ', 'EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(706, '202410402', 'DOMINGUEZ', 'CARRERA', 'ALESSANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(707, '202410250', 'ESTEBANES ', 'GARCIA', 'ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(708, '202410425', 'ESTRADA', 'MONROY', 'ALAN JAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(709, '202410102', 'FLORES ', 'SILVA', 'AARON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(710, '202410428', 'FLORES', 'RODRIGUEZ', 'ALEXEI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(711, '202410172', 'GARCIA ', 'SANCHEZ', 'ANGEL LEONARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(712, '202410294', 'GONZALEZ', 'HERNANDEZ', 'LUIS GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(713, '202410313', 'GUTIERREZ', 'FRANCISCO', 'CARLOS DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(714, '202410141', 'HERNANDEZ', 'GONZALEZ', 'ELIZABETH YAMILETH', 0, 0, 0, 'Inactivo', 'Inactivo'),
(715, '202410031', 'HERNANDEZ', 'LUIS', 'DAVID ERNESTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(716, '202410303', 'JUAREZ', 'DIAZ', 'YOSEF JARED', 0, 0, 0, 'Inactivo', 'Inactivo'),
(717, '202410274', 'LEON', 'MANZANAREZ', 'JOSUE TAJIHEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(718, '202410182', 'LOPEZ', 'CRUZ', 'ILEANA KETZALLI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(719, '202410707', 'LOPEZ', 'CEDILLO', 'JORDAN URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(720, '202410095', 'MEDINA', 'VIDAL', 'DAVID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(721, '202410792', 'MEDINA', 'SANCHEZ', 'JIMENA MELANY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(722, '202410169', 'MONDRAGON', 'MONDRAGON', 'ERICK DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(723, '202410782', 'MORA', 'GONZALEZ', 'BRAULIO SAMUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(724, '202410021', 'MORENO ', 'ESCAMILLA', 'SEBASTIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(725, '202410352', 'OREA', 'CHAVEZ', 'GERARDO VADIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(726, '202410100', 'PEREZ', 'SANCHEZ.', 'LAEL URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(727, '202410159', 'PEREZ', 'ASIEL', 'SANTIAGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(728, '202410103', 'PEREZ', 'ALVARADO', 'CARLOS ARTURO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(729, '202410306', 'PORRAS', 'CARMONA', 'HAROLD JAVIER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(730, '202410179', 'REYES', 'MIGUEL', 'DULCE DANAE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(731, '202410355', 'REYES', 'LOPEZ', 'SOFIA LEARSI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(732, '202410293', 'RUIZ', 'GUTIERREZ', 'ESTEFANY NICOLE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(733, '202410442', 'SANTILLAN', 'HERNANDEZ', 'YEHOSUA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(734, '202410049', 'TELLEZ', 'CASTILLO', 'GERARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(736, '202410795', 'CARDEÑA', 'DIAZ', 'MARIA DE LOS ANGELES', 0, 0, 0, 'Inactivo', 'Inactivo'),
(737, '202410521', 'ARIAS', 'OSORNIO', 'KANON ARGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(738, '202410772', 'BENITEZ', 'AYALA', 'MANUEL EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(739, '202410702', 'BOVERTH', 'CERNA', 'JHONATAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(740, '202410434', 'BUCIO', 'CASTILLO', 'RODRIGO ADAIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(741, '202410681', 'CHAVEZ', 'LOPEZ', 'ALAN AMAURY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(742, '202410693', 'CORTEZ', 'SOTOMAYOR', 'DAFNE VALERIA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(743, '202410416', 'CRUZ', 'MONDRAGON', 'MARCOS AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(744, '202410498', 'DOMINGUEZ', 'GALLEGOS', 'ALEXIS YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(745, '202410684', 'DOMINGUEZ', 'PALACIOS', 'ERIK', 0, 0, 0, 'Inactivo', 'Inactivo'),
(746, '202410481', 'DURAN', 'LUEVANO', 'ANTHONY CRAIG', 0, 0, 0, 'Inactivo', 'Inactivo'),
(747, '202410685', 'FLORES', 'VAZQUEZ', 'JUAN DANIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(748, '202410427', 'FLORES', 'ALVARADO', 'JESUS EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(749, '202410525', 'GALINDO', 'MENDOZA', 'JEREMY EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(750, '202410701', 'GOMEZ', 'CERNA', 'JOHAN JALIL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(751, '202410627', 'GONZALEZ', 'BAUTISTA', 'SANTIAGO ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(752, '202410601', 'GUERRERO', 'AVILA', 'BRISA GUADALUPE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(753, '202410545', 'GUTIERREZ', 'BAUTISTA', 'VICTOR RODRIGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(754, '202410497', 'HERNANDEZ', 'ALFARO', 'JESUS ISRAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(755, '202410432', 'HERNANDEZ', 'BERNABE', 'DIEGO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(756, '202410644', 'HERNANDEZ', 'CORREA', 'MARIO ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(757, '202410554', 'ITURBE', 'TELLEZ', 'YOSEF YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(758, '202410457', 'JIMENEZ', 'HERNANDEZ', 'OLGA ALEJANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(759, '202410658', 'JIMENEZ', 'MORALES', 'DIEGO ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(760, '202410747', 'LEON', 'CASTRO', 'JOSUE ISAI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(761, '202410532', 'LOPEZ', 'NIETO', 'ARAHM', 0, 0, 0, 'Inactivo', 'Inactivo'),
(762, '202410247', 'MARQUEZ', 'SANTIAGO', 'JONATHAN OSIRIS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(763, '202410553', 'MARTINEZ', 'SANTOS', 'KATIA MICHELLE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(764, '202410660', 'MICHAUS', 'SOSA', 'HILDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(765, '202410419', 'MIRANDA', 'OBLEA', 'EDWIN EMIR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(766, '202410597', 'MUÑOZ', 'SIERRA', 'LUIS FRANCISCO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(767, '20241756', 'NIETO', 'FLORES', 'IRMA GEOVANNA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(768, '202410640', 'PASCUAL', 'BAEZA', 'DAYRA ALEXANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(769, '202410592', 'PEREZ', 'RODRIGUEZ', 'ESMERALDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(770, '202410499', 'RAMIREZ', 'ANGUIANO', 'BRYAN GERARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(771, '202410496', 'RODRIGUEZ', 'DEL VALLE', 'JOSE YAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(772, '202010583', 'RODRIGUEZ', 'SANCHEZ', 'OSCAR ALEJANDRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(773, '202010568', 'SANTIAGO', 'MARTINEZ', 'AARON ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(774, '202410589', 'TORRES', 'SUASTEGI', 'REYMARK JOSUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(775, '202410473', 'VALDES', 'CESAREO', 'INGRID ARELY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(776, '202410454', 'VARGAS', 'MORALES', 'ANDREA MICHEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(777, '202410390', 'VEGA', 'RODRIGUEZ', 'ISRAEL EDUARDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(778, '202410638', 'ZAMORA', 'BECERRA', 'SANTIAGO AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(779, '202410154', 'AGUILAR', 'HERNANDEZ', 'IRVIN JHOVANY', 0, 0, 0, 'Inactivo', 'Inactivo'),
(780, '202410779', 'AGUILERA', 'MEJIA', 'DAVID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(781, '202410254', 'ALONSO', 'BURGOS', 'SERGIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(782, '202410407', 'ARELLANO', 'CRUZ', 'FRANCISCO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(783, '202410347', 'AYALA.', 'ANGELES', 'JUAN PABLO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(784, '202410365', 'BECERRA', 'LOPEZ', 'AXEL FABIAN', 0, 0, 0, 'Inactivo', 'Inactivo');
INSERT INTO `alumnos` (`id_alumno`, `matricula`, `ap_paterno`, `ap_materno`, `nombre`, `creditos_acad`, `creditos_dep`, `creditos_cult`, `estatus_servicio`, `estatus_residencia`) VALUES
(786, '202410372', 'BRETON', 'RUIZ', 'ROBERTO CARLOS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(787, '202410476', 'CALDERON', 'ROJAS', 'ANGEL ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(788, '202410276', 'CARREON ', 'VILLAGRA', 'DEVON ALEXANDER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(790, '202410564', 'CHAVEZ', 'IGNACIO', 'EDNA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(793, '202410056', 'CRUZ', 'DE ALVAREZ', 'MARIA FERNANDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(794, '202410257', 'DIAZ', 'MONTIEL', 'CESAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(795, '202410104', 'FRARFAN', 'ARAOZ', 'MIGUEL ENRIQUE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(796, '202410318', 'FIGUEROA', 'SEDANO', 'MARTIN ISAI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(797, '202410125', 'FLORES', 'MORA', 'EDWIN ADRIAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(798, '202410270', 'FLORES', 'DE PAZ', 'BRANDON', 0, 0, 0, 'Inactivo', 'Inactivo'),
(799, '202410188', 'GALVAN', 'MORALES', 'EVELIN LISSET', 0, 0, 0, 'Inactivo', 'Inactivo'),
(800, '202410075', 'GARCIA', 'MARTINEZ', 'DANIELA BERENICE', 0, 0, 0, 'Inactivo', 'Inactivo'),
(801, '202410761', 'HERNANDEZ', 'CORONA', 'JENZEN SHERIDAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(802, '202410720', 'HERNANDEZ', 'BARAJAS', 'KATE ALONDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(803, '202410404', 'HERNANDEZ', 'MACIAS', 'IVAN TADEO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(804, '202410225', 'HIGADERA', 'MARTINEZ', 'JUAN PABLO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(805, '202410255', 'MALDONADO', 'BARRIOS', 'EMMANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(806, '202410765', 'MEJIA', 'PEDRAZA', 'KEVIN ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(807, '202410433', 'MEZA', 'FLORES', 'EDGAR URIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(808, '202410722', 'MEZA', 'DEL RIO', 'GAEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(809, '202410420', 'MORALES', 'HERNANDEZ', 'JOEL ALEXANDER', 0, 0, 0, 'Inactivo', 'Inactivo'),
(810, '202410759', 'MORIN', 'COBOS', 'ALBERTO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(811, '202410185', 'ORONOS', 'MATEO', 'YAHIR IVAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(812, '202410192', 'ORTIZ', 'ACUATLA', 'JANNY NAOMI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(813, '202410302', 'ORTIZ', 'HUERTA', 'GLORIA ISABEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(814, '202410164', 'PEREZ', 'REYES', 'BRANDON EMILIANO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(815, '202410671', 'PEREZ', 'PASTELIN', 'MIGUEL ANGEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(816, '202410183', 'QUIROZ', 'PEREZ', 'BRAYAN', 0, 0, 0, 'Inactivo', 'Inactivo'),
(817, '202410546', 'RESENDIZ', 'FERNANDEZ', 'JESUS', 0, 0, 0, 'Inactivo', 'Inactivo'),
(818, '202410670', 'RICARDO', 'AVILA', 'GABRIEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(819, '202410070', 'RIVERA', 'ESCALANTE', 'AXEL OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(821, '202410142', 'RIVERA', 'NUÑEZ', 'MARIA FERNANDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(822, '202410200', 'RODRIGUEZ', 'LARIOS', 'BRAYAN AXEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(823, '202410690', 'RUIZ', 'SAAVEDRA', 'ANUAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(824, '202410664', 'SALGADO', 'JIMENEZ', 'ROGELIO ROSALIO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(825, '202410227', 'SOTO', 'AVELDAÑO', 'HERNANDO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(826, '202410120', 'TAPIA', 'AMBROSIO', 'CAROL FERNANDA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(827, '202410178', 'TREJO', 'SAUCEDO', 'MARIA ALEJANDRA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(828, '202410588', 'VARGAS', 'GONZALEZ', 'TOMAS YASHIRO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(829, '202410500', 'VELAZQUEZ', 'CRUZ', 'JOSE DAVID', 0, 0, 0, 'Inactivo', 'Inactivo'),
(830, '202410441', 'ZACARIAS', 'ABELITO', 'VICTOR MANUEL', 0, 0, 0, 'Inactivo', 'Inactivo'),
(838, '202118697', 'DELGADO', 'LAUREANO', 'OSCAR OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(839, '2022118697', 'DELGADO', 'LAUREANO', 'OSCAR OMAR', 0, 0, 0, 'Inactivo', 'Inactivo'),
(859, '202010234', 'SOTELO', 'MONTESINOS', 'VANESSA NOEMI', 0, 0, 0, 'Inactivo', 'Inactivo'),
(861, '201917598', 'ALIZOTA', 'GALVAN', 'SALMA DANIELA', 0, 0, 0, 'Inactivo', 'Inactivo'),
(865, '202410041', 'CHATELAIN', 'MERCADO', 'OMAR PAULINO', 0, 0, 0, 'Inactivo', 'Inactivo'),
(869, '202119092', 'APANGO', 'CAMARGO', 'CHRISTOPHER', 0, 0, 0, 'Inactivo', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avance_ingles`
--

CREATE TABLE `avance_ingles` (
  `id_avance` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `doc_colocacion` varchar(255) DEFAULT NULL,
  `doc_certificacion` varchar(255) DEFAULT NULL,
  `doc_nivel1` varchar(255) DEFAULT NULL,
  `doc_nivel2` varchar(255) DEFAULT NULL,
  `doc_nivel3` varchar(255) DEFAULT NULL,
  `doc_nivel4` varchar(255) DEFAULT NULL,
  `doc_nivel5` varchar(255) DEFAULT NULL,
  `doc_liberacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_residencias`
--

CREATE TABLE `documentos_residencias` (
  `id_residencia` int(11) NOT NULL,
  `doc_soli_carta_pre` varchar(255) DEFAULT NULL,
  `doc_carta_presentacion` varchar(255) DEFAULT NULL,
  `doc_aceptacion` varchar(255) DEFAULT NULL,
  `doc_propuesta_antepro` varchar(255) DEFAULT NULL,
  `doc_caratula_antepro` varchar(255) DEFAULT NULL,
  `doc_carta_asesor_inter` varchar(255) DEFAULT NULL,
  `doc_carta_asesor_exter` varchar(255) DEFAULT NULL,
  `doc_carta_asesor_metodo` varchar(255) DEFAULT NULL,
  `doc_reportes_mensuales` varchar(255) DEFAULT NULL,
  `doc_termino_empresa` varchar(255) DEFAULT NULL,
  `doc_evaluacion` varchar(255) DEFAULT NULL,
  `doc_checklist` varchar(255) DEFAULT NULL,
  `doc_caratula_proyecto` varchar(255) DEFAULT NULL,
  `doc_termino_final` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias_creditos`
--

CREATE TABLE `evidencias_creditos` (
  `id_evidencia` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_residencias`
--

CREATE TABLE `registro_residencias` (
  `id_residencia` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `empresa` varchar(150) DEFAULT NULL,
  `nombre_proyecto` varchar(255) DEFAULT NULL,
  `asesor_interno` varchar(150) DEFAULT NULL,
  `asesor_externo` varchar(150) DEFAULT NULL,
  `asesor_metodologico` varchar(150) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_servicio`
--

CREATE TABLE `registro_servicio` (
  `id_registro` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `empresa` varchar(150) DEFAULT NULL,
  `responsable` varchar(150) DEFAULT NULL,
  `area_desempeno` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `doc_presentacion` varchar(255) DEFAULT NULL,
  `doc_aceptacion` varchar(255) DEFAULT NULL,
  `doc_informe1` varchar(255) DEFAULT NULL,
  `doc_informe2` varchar(255) DEFAULT NULL,
  `doc_termino` varchar(255) DEFAULT NULL,
  `doc_liberacion` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salones`
--

CREATE TABLE `salones` (
  `id_salon` int(11) NOT NULL,
  `salon` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salones`
--

INSERT INTO `salones` (`id_salon`, `salon`) VALUES
(1, 'k-01'),
(2, 'k-02'),
(3, 'K-03'),
(4, 'K-04'),
(5, 'K-05'),
(6, 'K-06'),
(7, 'K-07'),
(8, 'K-08'),
(9, 'K-09'),
(10, 'K-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_admin`
--

CREATE TABLE `usuarios_admin` (
  `id_acceso` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios_admin`
--

INSERT INTO `usuarios_admin` (`id_acceso`, `id_admin`, `correo`, `password`, `fecha_registro`) VALUES
(1, 1, 'ebner@gmail.com', '$2y$10$f144xQmRUM9hHuTMVOS2B.npAzf6DDA2SX4ANc6XUrPWisgpwdzPq', '2026-03-17 15:13:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_servicio`
--

CREATE TABLE `usuarios_servicio` (
  `id_acceso` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumno`);

--
-- Indices de la tabla `avance_ingles`
--
ALTER TABLE `avance_ingles`
  ADD PRIMARY KEY (`id_avance`),
  ADD KEY `fk_alumno_ingles` (`id_alumno`);

--
-- Indices de la tabla `documentos_residencias`
--
ALTER TABLE `documentos_residencias`
  ADD PRIMARY KEY (`id_residencia`);

--
-- Indices de la tabla `evidencias_creditos`
--
ALTER TABLE `evidencias_creditos`
  ADD PRIMARY KEY (`id_evidencia`),
  ADD KEY `fk_alumno_evidencia` (`id_alumno`);

--
-- Indices de la tabla `registro_residencias`
--
ALTER TABLE `registro_residencias`
  ADD PRIMARY KEY (`id_residencia`),
  ADD KEY `fk_alumno_residencia` (`id_alumno`);

--
-- Indices de la tabla `registro_servicio`
--
ALTER TABLE `registro_servicio`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_alumno_registro` (`id_alumno`);

--
-- Indices de la tabla `salones`
--
ALTER TABLE `salones`
  ADD PRIMARY KEY (`id_salon`);

--
-- Indices de la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  ADD PRIMARY KEY (`id_acceso`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_admin_acceso` (`id_admin`);

--
-- Indices de la tabla `usuarios_servicio`
--
ALTER TABLE `usuarios_servicio`
  ADD PRIMARY KEY (`id_acceso`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_alumno_servicio` (`id_alumno`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumno` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=871;

--
-- AUTO_INCREMENT de la tabla `avance_ingles`
--
ALTER TABLE `avance_ingles`
  MODIFY `id_avance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `documentos_residencias`
--
ALTER TABLE `documentos_residencias`
  MODIFY `id_residencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `evidencias_creditos`
--
ALTER TABLE `evidencias_creditos`
  MODIFY `id_evidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `registro_residencias`
--
ALTER TABLE `registro_residencias`
  MODIFY `id_residencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `registro_servicio`
--
ALTER TABLE `registro_servicio`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  MODIFY `id_acceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios_servicio`
--
ALTER TABLE `usuarios_servicio`
  MODIFY `id_acceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avance_ingles`
--
ALTER TABLE `avance_ingles`
  ADD CONSTRAINT `fk_alumno_ingles` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_residencias`
--
ALTER TABLE `documentos_residencias`
  ADD CONSTRAINT `fk_residencia_docs` FOREIGN KEY (`id_residencia`) REFERENCES `registro_residencias` (`id_residencia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `evidencias_creditos`
--
ALTER TABLE `evidencias_creditos`
  ADD CONSTRAINT `fk_alumno_evidencia` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_residencias`
--
ALTER TABLE `registro_residencias`
  ADD CONSTRAINT `fk_alumno_residencia` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_servicio`
--
ALTER TABLE `registro_servicio`
  ADD CONSTRAINT `fk_alumno_registro` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  ADD CONSTRAINT `fk_admin_acceso` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_servicio`
--
ALTER TABLE `usuarios_servicio`
  ADD CONSTRAINT `fk_alumno_servicio` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
