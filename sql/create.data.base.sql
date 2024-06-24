CREATE DATABASE `printup1`;

CREATE TABLE `printup1`.`usuarios` (
  `DNI_Usuario` int(11) NOT NULL PRIMARY KEY,
  `Nombres` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Edad` int(150) NOT NULL,
  `Email` varchar(100) NOT NULL UNIQUE KEY,
  `Contrasena` varchar(50) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `perfil_img` varchar(500) NOT NULL
);

CREATE TABLE `printup1`.`alumnos` (
  `ID_Alumno` int(11) NOT NULL,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
  `Curso` varchar(50) NOT NULL,
  `Preceptor` int(11) NOT NULL,
  FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios`(`DNI_Usuario`)
);

CREATE TABLE `printup1`.`kiosqueros` (
  `ID_Kiosquero` int(11) NOT NULL,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
  FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios`(`DNI_Usuario`)
);
-- DROP DATABASE `printup1`;