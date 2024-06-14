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

CREATE TABLE `printup1`.`mensajes` (
  `ID_Mensaje` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `FK_DNI_Usuario` int(11) DEFAULT NULL,
  `ID_Kiosquero` int(11) DEFAULT NULL,
  `Fecha_Hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Mensaje` text DEFAULT NULL,
  `Autor` BIT(1) DEFAULT NULL,
  FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `printup1`.`usuarios`(DNI_Usuario),
  FOREIGN KEY (`ID_Kiosquero`) REFERENCES `printup1`.`kiosqueros`(ID_Kiosquero)
);

INSERT INTO `printup1`.`usuarios` (`DNI_Usuario`, `Nombres`, `Apellidos`, `Edad`, `Email`, `Contrasena`, `Telefono`, `perfil_img`)
  VALUES ('45931135','carlos daniel','soliz siles','19','carlos.soliz.t1vl@gmail.com','1234','01122529318','image.defaul.webp'), 
  ('42931135','natalia','natalia','17','tamara.fernandez.t1vl@gmail.com','1234','01142623361','image.natalia.webp');

INSERT INTO `printup1`.`alumnos`(`FK_DNI_Usuario`, `Curso`, `Preceptor`) 
  VALUES ('45931135','7mo 2da','Javier Milei');

INSERT INTO `printup1`.`kiosqueros`(`FK_DNI_Usuario`) VALUES ('42931135');

-- Insertamos 10 usuarios
INSERT INTO `printup1`.`usuarios` (`DNI_Usuario`, `Nombres`, `Apellidos`, `Edad`, `Email`, `Contrasena`, `Telefono`, `perfil_img`) VALUES
(1, 'Usuario', 'Uno', 30, 'usuario1@email.com', 'contrasena1', '1111111111', 'image.defaul.webp'),
(2, 'Usuario', 'Dos', 31, 'usuario2@email.com', 'contrasena2', '2222222222', 'image.defaul.webp'),
(3, 'Usuario', 'Tres', 32, 'usuario3@email.com', 'contrasena3', '3333333333', 'image.defaul.webp'),
(4, 'Usuario', 'Cuatro', 33, 'usuario4@email.com', 'contrasena4', '4444444444', 'image.defaul.webp'),
(5, 'Usuario', 'Cinco', 34, 'usuario5@email.com', 'contrasena5', '5555555555', 'image.defaul.webp'),
(6, 'Usuario', 'Seis', 35, 'usuario6@email.com', 'contrasena6', '6666666666', 'image.defaul.webp'),
(7, 'Usuario', 'Siete', 36, 'usuario7@email.com', 'contrasena7', '7777777777', 'image.defaul.webp'),
(8, 'Usuario', 'Ocho', 37, 'usuario8@email.com', 'contrasena8', '8888888888', 'image.defaul.webp'),
(9, 'Usuario', 'Nueve', 38, 'usuario9@email.com', 'contrasena9', '9999999999', 'image.defaul.webp'),
(10, 'Usuario', 'Diez', 39, 'usuario10@email.com', 'contrasena10', '1010101010', 'image.defaul.webp');

-- Insertamos 2 kiosqueros (los usuarios con DNI 1 y 2)
INSERT INTO `printup1`.`kiosqueros` (`FK_DNI_Usuario`) VALUES
(1),
(2),
(3),
(4);



-- SELECT u.DNI_Usuario, u.Nombres, u.Apellidos, COUNT(m.ID_Mensaje) as Cantidad_Mensajes
-- FROM `usuarios` u
-- JOIN `kiosqueros` k ON u.DNI_Usuario = k.FK_DNI_Usuario
-- LEFT JOIN `mensajes` m ON k.ID_Kiosquero = m.ID_Kiosquero
-- GROUP BY u.DNI_Usuario, u.Nombres, u.Apellidos;
