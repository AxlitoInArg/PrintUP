<?php
include "./libs/obtener_tipo_usuario.php";
session_start();
$type_user = obtenerTipoUsuario();
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
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Ayuda y Soporte - PrintUP</title>
    <link rel="stylesheet" href="./assets/styles/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/ayuda.css">
</head>

<body>
    <div class="arriba">
        <div>
            <img src="./assets/img/logo_negro.png" alt="PrintUP Logo" class="logo">
        </div>
        <?php
        if ($type_user == "user_normal") {
            echo "Ayuda para clientes";
        } else {
            echo "Ayuda para el kiosco";
        }
        ?>
    </div>

    <main class="help-container">
        <h1>Ayuda y Soporte</h1>

        <!-- Preguntas Frecuentes -->
        <section class="faq">
            <h2>Preguntas Frecuentes</h2>
            <div class="faq-item">
                <h3>¿Cómo puedo registrarme?</h3>
                <p>Puedes registrarte haciendo clic en el botón "Registrarse" en la página de inicio y llenando el formulario con tu información personal.</p>
            </div>
            <div class="faq-item">
                <h3>¿Cómo restablezco mi contraseña?</h3>
                <p>Para restablecer tu contraseña, haz clic en "Olvidé mi contraseña" en la página de inicio de sesión y sigue las instrucciones.</p>
            </div>
            <div class="faq-item">
                <h3>¿Cómo contacto al soporte técnico?</h3>
                <p>Puedes contactarnos a través del formulario de contacto que se encuentra en esta página o enviando un correo a printup.t1vl@gmail.com.</p>
            </div>
        </section>

        <!-- Formulario de Contacto -->
        <section class="contact-form">
            <h2>Formulario de Contacto</h2>
            <form action="./send_contact_form.php" method="POST">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Mensaje</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>

    <script src="/scripts/help.js"></script>
    <?php include "./componets/navbar.php"; ?>
</body>

</html>