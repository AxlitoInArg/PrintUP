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
    <title>Página de Inicio - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/styles/index.css">
</head>

<body>
    <header class="header">
        <img src="/img/logo.png" alt="PrintUP Logo" class="logo">
    </header>

    <div class="navbar">
        <a href="/" data-label="Inicio"><i class="fas fa-home"></i> Inicio</a>
        <a href="../historial/historial.php" data-label="Historial"><i class="fas fa-history"></i> Historial</a>
        <a href="configuracion.php" data-label="Configuración"><i class="fas fa-cog"></i> Configuración</a>
        <a href="perfil.php" data-label="Perfil"><i class="fas fa-user"></i> Perfil</a>
        <a href="nueva-impresion.php" data-label="Nueva Impresión"><i class="fas fa-book"></i> Nueva Impresión</a>
    </div>

    <div class="content">
        <h2>Bienvenido, <?php echo $Nombres; ?>!</h2>
        <p>Estamos encantados de verte de nuevo.</p>
    </div>
    <div class="news-updates">
        <h3>Noticias y Actualizaciones</h3>
        <p>- Nueva función añadida: Impresión a color.</p>
        <p>- Mantenimiento programado el 16 de junio.</p>
        <p>- ¡Sigue nuestras redes sociales para más actualizaciones!</p>
    </div>
    <div class="support">
        <h3>Ayuda y Soporte</h3>
        <p><a href="faq.php">FAQ</a> | <a href="contacto.php">Contactar Soporte</a></p>
    </div>
    <footer class="footer">
        <p>&copy; 2024 PrintUP. Todos los derechos reservados.</p>
        <p><a href="terminos.php">Términos y Condiciones</a> | <a href="privacidad.php">Política de Privacidad</a></p>
    </footer>
    <script src="script.js"></script>
</body>

</html>