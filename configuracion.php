<?php
include "./libs/obtener_tipo_usuario.php";
session_start();
$type_user = getUserType();
if ($type_user == "no_user") {
    if (basename($_SERVER['PHP_SELF']) != '' || basename($_SERVER['PHP_SELF']) != 'index.php') {
        header("Location: login.php");
        exit; // Salir del script después de redirigir
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/icono.png" type="image/x-icon">
    <title>Página de configuraciones - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/styles/normalize.css">
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/index.css">
</head>

<body>
    <main>
        <a href="/logeo/cerrar_secion.php">cerrar secion</a>
    </main>
    <?php include "./componets/navbar.php" ?>
</body>

</html>