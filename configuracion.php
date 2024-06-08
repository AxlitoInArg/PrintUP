<?php
session_start();
// Verificar si el usuario está conectado
if (isset($_SESSION['nombre_usuario'])) {
    $Nombres = $_SESSION['nombre_usuario'];

    include "./libs/conn.php";

    // Consulta SQL para obtener el nombre del usuario
    $sql = "SELECT Nombres FROM usuarios WHERE Nombres = '$Nombres'";
    $result = mysqli_query($conn, $sql);

    // Verificar si se encontró el nombre del usuario
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $Nombres = $row['Nombres'];
    } else {
        $Nombres = "Usuario Desconocido";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    // Si no está conectado, redirigirlo a la página de inicio de sesión
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