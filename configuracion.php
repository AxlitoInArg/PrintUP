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
    <title>Configuraciones - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/styles/normalize.css">
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/configuracion.css">
</head>

<body>
    <main class="configuracion-container">
        <div class="perfil">
            <h2>Perfil</h2>
            <p><strong>Nombre:</strong> <?php echo $_SESSION['full_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
            <a href="#" class="editar-perfil-link">Editar Perfil</a>
        </div>

        <div class="acciones">
            <h2>Acciones</h2>
            <ul>
                <li><a href="#">Cambiar Contraseña</a></li>
                <li><a href="#">Notificaciones</a></li>
                <li><a href="#">Preferencias de Cuenta</a></li>
            </ul>
        </div>

        <a href="/logeo/cerrar_sesion.php" class="logout-link">Cerrar sesión <i class="fas fa-sign-out-alt"></i></a>
    </main>

    <?php include "./componets/navbar.php"; ?>
</body>

</html>
