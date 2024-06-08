-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2024 a las 23:50:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `printup`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `ID_Alumno` int(11) NOT NULL,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
  `Curso` varchar(50) NOT NULL,
  `Preceptor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `ID_Archivo` int(11) NOT NULL,
  `ID_Mensaje` int(11) DEFAULT NULL,
  `Nombre_Archivo` varchar(255) DEFAULT NULL,
  `Tipo_Archivo` varchar(50) DEFAULT NULL,
  `Tamano_Archivo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `ID_Compra` int(11) NOT NULL,
  `FK_ID_Usuario` int(11) DEFAULT NULL,
  `Fecha_Cobro` date NOT NULL,
  `Monto` int(11) NOT NULL,
  `Metodo_Pago` varchar(100) NOT NULL,
  `FK_ID_Kiosquero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kiosqueros`
--

CREATE TABLE `kiosqueros` (
  `ID_Kiosquero` int(11) NOT NULL,
  `FK_DNI_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `ID_Mensaje` int(11) NOT NULL,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
  `ID_Kiosquero` int(11) DEFAULT NULL,
  `Fecha_Hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Mensaje` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `Email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `DNI_Usuario` int(11) NOT NULL,
  `Nombres` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Edad` int(150) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Contrasena` varchar(50) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `perfil_img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`DNI_Usuario`, `Nombres`, `Apellidos`, `Edad`, `Email`, `Contrasena`, `Telefono`, `perfil_img`) VALUES
(4198234, 'prueba', 'printup', 18, 'printup.t1vl@gmail.com', 'prueba', '112344564', ''),
(523542346, 'Jhomar', 'Mendieta', 17, 'jhomar.mendieta.t1vl@gmail.com', 'jhomar', '118934346', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`ID_Alumno`),
  ADD KEY `FK_DNI_Usuario` (`FK_DNI_Usuario`);

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`ID_Archivo`),
  ADD KEY `ID_Mensaje` (`ID_Mensaje`);

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`ID_Compra`),
  ADD KEY `FK_ID_Usuario` (`FK_ID_Usuario`),
  ADD KEY `FK_ID_Kiosquero` (`FK_ID_Kiosquero`);

--
-- Indices de la tabla `kiosqueros`
--
ALTER TABLE `kiosqueros`
  ADD PRIMARY KEY (`ID_Kiosquero`),
  ADD KEY `FK_DNI_Usuario` (`FK_DNI_Usuario`) USING BTREE;

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`ID_Mensaje`),
  ADD KEY `FK_DNI_Usuario` (`FK_DNI_Usuario`),
  ADD KEY `ID_Kiosquero` (`ID_Kiosquero`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`token`),
  ADD KEY `Email` (`Email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`DNI_Usuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `ID_Alumno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `ID_Compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kiosqueros`
--
ALTER TABLE `kiosqueros`
  MODIFY `ID_Kiosquero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `DNI_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1159106516;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios` (`DNI_Usuario`);

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`ID_Mensaje`) REFERENCES `mensajes` (`ID_Mensaje`);

--
-- Filtros para la tabla `kiosqueros`
--
ALTER TABLE `kiosqueros`
  ADD CONSTRAINT `kiosqueros_ibfk_1` FOREIGN KEY (`ID_Kiosquero`) REFERENCES `historial_compras` (`FK_ID_Kiosquero`),
  ADD CONSTRAINT `kiosqueros_ibfk_2` FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios` (`DNI_Usuario`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios` (`DNI_Usuario`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`ID_Kiosquero`) REFERENCES `kiosqueros` (`ID_Kiosquero`);

--
-- Filtros para la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `usuarios` (`Email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;