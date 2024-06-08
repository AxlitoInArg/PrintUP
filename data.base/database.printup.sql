DROP DATABASE `printup1`;
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
  `ID_Alumno` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
  `Curso` varchar(50) NOT NULL,
  `Preceptor` varchar(200) NOT NULL,
  FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `printup1`.`usuarios`(DNI_Usuario)
);

CREATE TABLE `printup1`.`kiosqueros` (
  `ID_Kiosquero` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
    FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `printup1`.`usuarios`(DNI_Usuario)
);

INSERT INTO `printup1`.`usuarios` (`DNI_Usuario`, `Nombres`, `Apellidos`, `Edad`, `Email`, `Contrasena`, `Telefono`, `perfil_img`)
  VALUES ('45931135','carlos daniel','soliz siles','19','carlos.soliz.t1vl@gmail.com','1234','01122529318','/img/image.defaul.jpeg'), 
  ('42931135','tamara','fernandez','17','tamara.fernandez.t1vl@gmail.com','1234','01142623361','/img/image.defaul.jpeg');

INSERT INTO `printup1`.`alumnos`(`FK_DNI_Usuario`, `Curso`, `Preceptor`) 
  VALUES ('45931135','7mo 2da','Javier Milei');

INSERT INTO `printup1`.`kiosqueros`(`FK_DNI_Usuario`) VALUES ('42931135');