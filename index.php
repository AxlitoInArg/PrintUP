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
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Inicio - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/normalize.css">
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/index.css">
</head>

<body>
    <main>
        <div class="kiosqueros_chats"><div>
            <img src="img/logo_negro.png" alt="PrintUP Logo" class="logo"></div>
            <?php
            if ($type_user == "user_normal") {
                echo "para clientes";
            } else {
                echo "para el kiosco";
            }
            ?>
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
        var ud = <?php echo $_SESSION['user_id']. ";"; ?>
        <?php
        if ($type_user == "user_normal") {
            echo "var at = 1;";
        } else {
            echo "var at = 0;";
        }
        ?>
    </script>
    <script src="/script/show.js"></script>
</body>

</html>