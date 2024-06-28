<?php
session_start();

if (!isset($_SESSION['datos_usuario']['email'])) {
    header("Location: login.php");
    exit;
}

include "./libs/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validaciones básicas
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error_message = "Todos los campos son obligatorios.";
    } elseif ($newPassword !== $confirmPassword) {
        $error_message = "Las nuevas contraseñas no coinciden.";
    } else {
        // Obtener DNI del usuario desde la sesión
        $DNI = $_SESSION['user_id'];

        // Verificar la contraseña actual
        $sql = "SELECT Contrasena FROM usuarios WHERE DNI_Usuario = '$DNI'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row['Contrasena'];

            if ($currentPassword === $storedPassword) {
                // Actualizar la contraseña
                $updateSql = "UPDATE usuarios SET Contrasena = '$newPassword' WHERE DNI_Usuario = '$DNI'";
                if (mysqli_query($conn, $updateSql)) {
                    $success_message = "Contraseña actualizada correctamente.";
                } else {
                    $error_message = "Error al actualizar la contraseña: " . mysqli_error($conn);
                }
            } else {
                $error_message = "La contraseña actual no es válida.";
            }
        } else {
            $error_message = "Error al verificar la contraseña actual: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Cambiar Contraseña - PrintUP</title>
    <link rel="stylesheet" href="./assets/styles/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/editar.css">
</head>

<body>
    <main class="editar-perfil-container">
        <h2>Cambiar Contraseña</h2>
        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        } elseif (isset($success_message)) {
            echo "<p class='success'>$success_message</p>";
        }
        ?>
        <form action="cambiar_contrasena.php" method="POST">
            <label for="current_password">Contraseña Actual:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirmar Nueva Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Cambiar Contraseña</button>
        </form>
    </main>

    <?php include "./componets/navbar.php"; ?>
</body>

</html>