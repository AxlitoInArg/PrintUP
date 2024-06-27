<?php
include "./libs/obtener_tipo_usuario.php";
session_start();
$type_user = obtenerTipoUsuario();
if ($type_user == "no_user") {
    header("Location: login.php");
    exit; // Salir del script después de redirigir
}

// Obtener datos del usuario de las variables de sesión
$DNI = $_SESSION['user_id'] ?? null; // Asegurar que $DNI esté definido
$nombres = $_SESSION['nombre_usuario'] ?? '';
$apellidos = $_SESSION['apellido_usuario'] ?? '';
$email_actual = $_SESSION['email'] ?? '';
$curso = $_SESSION['curso'] ?? '';
$preceptor = $_SESSION['preceptor'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $preceptor = $_POST['preceptor'] ?? '';

    // Actualizar nombre y apellido en la sesión si se cambian
    if (!empty($nombre) && !empty($apellido)) {
        include "./libs/conn.php"; // Asegúrate de incluir correctamente tu archivo de conexión

        $_SESSION['nombre_usuario'] = $nombre;
        $_SESSION['apellido_usuario'] = $apellido;
        $_SESSION['full_name'] = $nombre . " " . $apellido;
        $sql_usuario = "UPDATE `usuarios` SET `Nombres`='$nombre', `Apellidos`='$apellido' WHERE DNI_Usuario = '$DNI';";

        if (mysqli_query($conn, $sql_usuario)) {
            echo "<p class='success'>Nombre y apellido actualizado con éxito.</p>";
        } else {
            echo "<p class='error'>Error al actualizar el nombre y apellido: " . mysqli_error($conn) . "</p>";
        }
    }
    // Actualizar email en la sesión y en la base de datos si es diferente
    if (!empty($email) && $email != $email_actual) {
        $_SESSION['email'] = $email;
        include "./libs/conn.php"; // Asegúrate de incluir correctamente tu archivo de conexión

        $sql_email = "UPDATE `usuarios` SET `Email`='$email' WHERE `Email`= '$email_actual';";
        if (mysqli_query($conn, $sql_email)) {
            echo "<p class='success'>Email actualizado con éxito.</p>";
        } else {
            echo "<p class='error'>Error al actualizar el email: " . mysqli_error($conn) . "</p>";
        }
    }

    // Actualizar datos del alumno si existe
    if (!empty($curso) && !empty($preceptor)) {
        include "./libs/conn.php"; // Asegúrate de incluir correctamente tu archivo de conexión

        $sql_alumno = "UPDATE alumnos SET Curso='$curso', Preceptor='$preceptor' WHERE FK_DNI_Usuario='$DNI'";
        if (mysqli_query($conn, $sql_alumno)) {
            echo "<p class='success'>Datos del alumno actualizados con éxito.</p>";
        } else {
            echo "<p class='error'>Error al actualizar datos del alumno: " . mysqli_error($conn) . "</p>";
        }
    }

    // Eliminar cuenta
    if (isset($_POST['eliminar'])) {
        include "./libs/conn.php"; // Asegúrate de incluir correctamente tu archivo de conexión

        // Eliminar cuenta y sesión
        $sql_delete = "DELETE FROM usuarios WHERE DNI_Usuario='$DNI'";
        if (mysqli_query($conn, $sql_delete)) {
            session_destroy();
            header("Location: /login.php");
            exit;
        } else {
            echo "<p class='error'>Error al eliminar la cuenta: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Editar Perfil - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/configuracion.css">
    <link rel="stylesheet" href="./assets/styles/editar.css">
</head>

<body>
    <main class="editar-perfil-container">
        <h2>Editar Perfil</h2>
        <form action="editar_perfil.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombres); ?>" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellidos); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_actual); ?>" required>

            <label for="curso">Curso:</label>
            <select id="curso" name="curso">
                <option value="7mo 2da" <?php if ($curso == '7mo 2da') echo 'selected'; ?>>7mo 2da</option>
                <!-- Añadir más opciones de curso según sea necesario -->
            </select>

            <label for="preceptor">Preceptor:</label>
            <select id="preceptor" name="preceptor">
                <option value="Javier Milei" <?php if ($preceptor == 'Javier Milei') echo 'selected'; ?>>Javier Milei</option>
                <!-- Añadir más opciones de preceptor según sea necesario -->
            </select>

            <button type="submit">Actualizar Perfil</button>
        </form>

        <form action="editar_perfil.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
            <button type="submit" name="eliminar" class="eliminar-cuenta">Eliminar Cuenta</button>
        </form>
    </main>

    <?php include "./componets/navbar.php"; ?>
</body>

</html>