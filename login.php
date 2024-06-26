<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./libs/conn.php";

    $Email = $_POST["email"];
    $Contrasena = $_POST["contrasena"];

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT *, concat(Nombres,' ', Apellidos) AS full_name FROM usuarios WHERE Email = '$Email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // El usuario existe, verificar la contraseña
        $row = mysqli_fetch_assoc($result);
        if ($row['Contrasena'] == $Contrasena) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['email'] = $Email;
            $_SESSION['nombre_usuario'] = $row['Nombres'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['user_id'] = $row['DNI_Usuario'];
            header("Location: index.php");
            exit;
        } else {
            // Contraseña incorrecta
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado en la base de datos
        $error_message = "Usuario no registrado.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Inicio de sesión - PrintUP</title>
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/login.css">
</head>

<body>
    <header class="header">
        <img src="./assets/img/logo.png" alt="PrintUP Logo" class="logo">
    </header>
    <main class="login-form">
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" placeholder="Correo electrónico" name="email" required>
            <input type="password" placeholder="Contraseña" name="contrasena" required>
            <button type="submit">Iniciar sesión</button>
            <?php if (isset($error_message)) { ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
            <a href="logeo/request_password_reset.php" class="forgot-password">¿Olvidaste la contraseña?</a>
        </form>
    </main>
    <footer class="footer">
        <a href="./register.php" class="register">¿No tienes cuenta? Regístrate</a>
        <br>
        <br>
        <a href="ayuda_no.php">Ayuda y soporte</a>
    </footer>
</body>

</html>