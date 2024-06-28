<?php
include "./libs/obtener_tipo_usuario.php";
session_start();
$tipo_usuario = obtenerTipoUsuario();
if ($tipo_usuario == "no_user") {
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
    <title>Inicio - PrintUP</title>
    <link rel="stylesheet" href="./assets/styles/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>

<body>
    <main>
        <div class="kiosqueros_chats">
            <div>
                <img src="./assets/img/logo_negro.png" alt="PrintUP Logo" class="logo">

            </div>
            <?php
            if ($tipo_usuario == "user_normal") {
                echo "para clientes";
            } else {
                echo "para el kiosco";
            }
            ?>
        </div>
        <div class="horario_atencion">
            <h2>Horario de Atención</h2>
            <p>Lunes a Viernes: 7:15am - 8:15pm</p>
        </div>
        <div class="container_kiosqueros">
            <!-- <div class="chat">
                <img src="/img/image.defaul.webp" alt="" class="chat__img">
                <div class="chat_container">
                    <div>
                        <span class="chat_container_name">Natalia Natalia</span>
                        <span class="chat_container_date">12:21p.m</span>
                    </div>
                    <div class="chat_container_mensagge">TRABAJAN LOS GILES!!! Nosotros nos vamos de putas…</div>
                </div>
            </div> -->
        </div>
    </main>
    <?php include "./componets/navbar.php" ?>
    <script>
        var id_usuario = <?php echo $_SESSION['datos_usuario']["id_usuario"] . ";"; ?>
        <?php
        if ($tipo_usuario == "user_normal") {
            echo "var tipo_usuario = 1;";
        } else {
            echo "var tipo_usuario = 0;";
        }
        ?>
    </script>
    <script src="/assets/script/mostrar_usuarios_kiosqueros.js"></script>
</body>

</html>