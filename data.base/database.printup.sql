DROP DATABASE `printup`;

CREATE DATABASE `printup`;

use `printup`;

CREATE TABLE `usuarios` (
    `DNI_Usuario` int(11) NOT NULL PRIMARY KEY,
    `Nombres` varchar(100) NOT NULL,
    `Apellidos` varchar(100) NOT NULL,
    `Edad` int(150) NOT NULL,
    `Email` varchar(100) NOT NULL UNIQUE KEY,
    `Contrasena` varchar(50) NOT NULL,
    `Telefono` varchar(20) NOT NULL,
    `Imagen_Perfil` varchar(500) NOT NULL
);

CREATE TABLE `alumnos` (
    `ID_Alumno` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `FK_DNI_Usuario` int(11) DEFAULT NULL,
    `Curso` varchar(50) NOT NULL,
    `Preceptor` varchar(200) NOT NULL,
    FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios` (DNI_Usuario)
);

CREATE TABLE `kiosqueros` (
    `ID_Kiosquero` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `FK_DNI_Usuario` int(11) DEFAULT NULL,
    FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios` (DNI_Usuario)
);

CREATE TABLE `mensajes` (
    `ID_Mensaje` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `FK_DNI_Usuario` int(11) DEFAULT NULL,
    `ID_Kiosquero` int(11) DEFAULT NULL,
    `Fecha_Hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `Mensaje` text DEFAULT NULL,
    `Autor` BIT(1) DEFAULT NULL,
    FOREIGN KEY (`FK_DNI_Usuario`) REFERENCES `usuarios` (DNI_Usuario),
    FOREIGN KEY (`ID_Kiosquero`) REFERENCES `kiosqueros` (ID_Kiosquero)
);

INSERT INTO
    `usuarios` (
        `DNI_Usuario`,
        `Nombres`,
        `Apellidos`,
        `Edad`,
        `Email`,
        `Contrasena`,
        `Telefono`,
        `Imagen_Perfil`
    )
VALUES (
        '45931135',
        'carlos daniel',
        'soliz siles',
        '19',
        'carlos.soliz.t1vl@gmail.com',
        '1234',
        '01122529318',
        'image.defaul.webp'
    ),
    (
        '42931135',
        'natalia',
        'natalia',
        '17',
        'tamara.fernandez.t1vl@gmail.com',
        '1234',
        '01142623361',
        'image.natalia.webp'
    );

INSERT INTO
    `alumnos` (
        `FK_DNI_Usuario`,
        `Curso`,
        `Preceptor`
    )
VALUES (
        '45931135',
        '7mo 2da',
        'Javier Milei'
    );

INSERT INTO `kiosqueros` (`FK_DNI_Usuario`) VALUES ('42931135');

CREATE TABLE `password_resets` (
    `token` varchar(255) NOT NULL PRIMARY KEY,
    `Email` varchar(100) NOT NULL,
    `expires` int(11) NOT NULL,
    FOREIGN KEY (Email) REFERENCES `usuarios` (Email)
);

CREATE TABLE `archivos` (
    `ID_Archivo` int(11) NOT NULL,
    `ID_Mensaje` int(11) DEFAULT NULL,
    `Nombre_Archivo` varchar(255) DEFAULT NULL,
    `Tipo_Archivo` varchar(50) DEFAULT NULL,
    `Tamano_Archivo` VARCHAR(10) DEFAULT NULL,
    `Ruta_Archivo` VARCHAR(255) NOT NULL,
    FOREIGN KEY (`ID_Mensaje`) REFERENCES `mensajes` (`ID_Mensaje`)
);

CREATE TABLE `pedidos` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `DNI_Usuario` int(11) NOT NULL,
    `descripcion` varchar(255) NOT NULL,
    `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
    FOREIGN KEY (`DNI_Usuario`) REFERENCES `usuarios` (`DNI_Usuario`)
);

CREATE TABLE `estado_pedido` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `pedido_id` int(11) NOT NULL,
    `estado` tinyint(4) NOT NULL,
    `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`)
);

-- SELECT u.DNI_Usuario, u.Nombres, u.Apellidos, COUNT(m.ID_Mensaje) as Cantidad_Mensajes
-- FROM `usuarios` u
-- JOIN `kiosqueros` k ON u.DNI_Usuario = k.FK_DNI_Usuario
-- LEFT JOIN `mensajes` m ON k.ID_Kiosquero = m.ID_Kiosquero
-- GROUP BY u.DNI_Usuario, u.Nombres, u.Apellidos;