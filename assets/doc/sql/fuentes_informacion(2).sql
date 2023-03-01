-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2020 a las 20:31:57
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `propld_access`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuentes_informacion`
--

CREATE TABLE `fuentes_informacion` (
  `id` int(11) NOT NULL,
  `id_entidad` int(11) DEFAULT 0,
  `clave` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estatus` enum('active','inactive') DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fuentes_informacion`
--

INSERT INTO `fuentes_informacion` (`id`, `id_entidad`, `clave`, `nombre`, `estatus`, `url`, `created_at`, `pais`) VALUES
(1, 1500, 'SNIM', 'Sistema Nacional de Información Municipa', 'active', 'http://www.snim.rami.gob.mx/', '2020-01-14', 'México'),
(2, 1500, 'INAI', 'Instituto Nacional de Transparencia, Acceso a la información y Protección de Datos Personales', 'active', 'http://inicio.ifai.org.mx/SitePages/ifai.aspx', '2020-01-14', 'México'),
(3, 1500, 'DOF', 'Diario oficial de la federación', 'active', 'https://www.dof.gob.mx/', '2020-01-14', 'México'),
(4, 1500, '', 'Portal de Transparencia: Directorio de Gobiernos Estatales', 'active', 'http://portaltransparencia.gob.mx/pot/directorio/begin.do?method=begin&_idDependencia=06101', '2020-01-14', 'México');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fuentes_informacion`
--
ALTER TABLE `fuentes_informacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fuentes_informacion`
--
ALTER TABLE `fuentes_informacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
