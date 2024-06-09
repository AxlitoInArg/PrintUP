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
  FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `printup1`.`usuarios`(DNI_Usuario),
  FOREIGN KEY (`ID_Kiosquero`) REFERENCES `printup1`.`kiosqueros`(ID_Kiosquero)
);

INSERT INTO `printup1`.`usuarios` (`DNI_Usuario`, `Nombres`, `Apellidos`, `Edad`, `Email`, `Contrasena`, `Telefono`, `perfil_img`)
  VALUES ('45931135','carlos daniel','soliz siles','19','carlos.soliz.t1vl@gmail.com','1234','01122529318','/img/image.defaul.jpeg'), 
  ('42931135','tamara','fernandez','17','tamara.fernandez.t1vl@gmail.com','1234','01142623361','/img/image.defaul.jpeg');

INSERT INTO `printup1`.`alumnos`(`FK_DNI_Usuario`, `Curso`, `Preceptor`) 
  VALUES ('45931135','7mo 2da','Javier Milei');

INSERT INTO `printup1`.`kiosqueros`(`FK_DNI_Usuario`) VALUES ('42931135');

-- Insertamos 10 usuarios
INSERT INTO `printup1`.`usuarios` (`DNI_Usuario`, `Nombres`, `Apellidos`, `Edad`, `Email`, `Contrasena`, `Telefono`, `perfil_img`) VALUES
(1, 'Usuario', 'Uno', 30, 'usuario1@email.com', 'contrasena1', '1111111111', 'url_imagen1'),
(2, 'Usuario', 'Dos', 31, 'usuario2@email.com', 'contrasena2', '2222222222', 'url_imagen2'),
(3, 'Usuario', 'Tres', 32, 'usuario3@email.com', 'contrasena3', '3333333333', 'url_imagen3'),
(4, 'Usuario', 'Cuatro', 33, 'usuario4@email.com', 'contrasena4', '4444444444', 'url_imagen4'),
(5, 'Usuario', 'Cinco', 34, 'usuario5@email.com', 'contrasena5', '5555555555', 'url_imagen5'),
(6, 'Usuario', 'Seis', 35, 'usuario6@email.com', 'contrasena6', '6666666666', 'url_imagen6'),
(7, 'Usuario', 'Siete', 36, 'usuario7@email.com', 'contrasena7', '7777777777', 'url_imagen7'),
(8, 'Usuario', 'Ocho', 37, 'usuario8@email.com', 'contrasena8', '8888888888', 'url_imagen8'),
(9, 'Usuario', 'Nueve', 38, 'usuario9@email.com', 'contrasena9', '9999999999', 'url_imagen9'),
(10, 'Usuario', 'Diez', 39, 'usuario10@email.com', 'contrasena10', '1010101010', 'url_imagen10');

-- Insertamos 2 kiosqueros (los usuarios con DNI 1 y 2)
INSERT INTO `printup1`.`kiosqueros` (`FK_DNI_Usuario`) VALUES
(1),
(2);

INSERT INTO `printup1`.`mensajes` (`ID_Mensaje`, `FK_DNI_Usuario`, `ID_Kiosquero`, `Fecha_Hora`, `Mensaje`) 
  VALUES (NULL, '45931135', '1', current_timestamp(), 'Laburamos para que mierda laburamos'),
  (NULL, '45931135', '3', current_timestamp(), 'Si podemos conseguir plata sin laburar'),
  (NULL, '45931135', '1', current_timestamp(), '¿Para qué trabajar si podemos ganar dinero sin hacerlo?'),
  (NULL, '3 ', '1', current_timestamp(), 'Trabajamos, pero ¿para qué?'),
  (NULL, '4', '1', current_timestamp(), 'Podemos conseguir dinero sin trabajar');


-- SELECT u.DNI_Usuario, u.Nombres, u.Apellidos, COUNT(m.ID_Mensaje) as Cantidad_Mensajes
-- FROM `usuarios` u
-- JOIN `kiosqueros` k ON u.DNI_Usuario = k.FK_DNI_Usuario
-- LEFT JOIN `mensajes` m ON k.ID_Kiosquero = m.ID_Kiosquero
-- GROUP BY u.DNI_Usuario, u.Nombres, u.Apellidos;
