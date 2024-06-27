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
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["receptor"])) {
    $receptor = $_GET["receptor"];
    $emisor = $_SESSION['user_id'];
    require "./libs/conn.php";
    $sql = "SELECT u.DNI_Usuario, CONCAT(u.Nombres, ' ', u.Apellidos) AS Nombre_Completo, u.perfil_img AS Imagen_Perfil FROM usuarios u WHERE u.DNI_Usuario = '$receptor';";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        // El usuario existe, obtener los datos
        $fila = mysqli_fetch_assoc($resultado);
        $imagen = $fila["Imagen_Perfil"];
        $nombre_completo = $fila["Nombre_Completo"];
    } else {
        // Usuario no encontrado en la base de datos
        $mensaje_error = "Usuario no registrado.";
    }

    mysqli_close($conn);
} else {
    header("Location: /");
    exit; // Salir del script después de redirigir
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
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/chat.css">
</head>

<body>
    <main>
        <header class="header_chat">
            <a href="/"><i class="fa-solid fa-arrow-left"></i></a>
            <img src="assets/img/<?php echo $imagen; ?>" alt="">
            <span><?php echo $nombre_completo; ?></span>
        </header>
        <main class="container_mensajes">
            <!-- <div class="container__mensaje right">
                <span class="container__mensaje__text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et tempore cupiditate neque modi similique veniam, architecto voluptatem? Officiis eaque quis deserunt aspernatur sunt expedita recusandae quas velit magni, consectetur unde!</span>
                <span class="container__mensaje__file"></span>
                <div class="triangulo_rectangulo"></div>
            </div> -->
        </main>
        <footer class="container">
            <div class="container__submit_mensaje">
                <button type="button" id="archivo_enviar"><label for="files"><i class="fa-solid fa-plus"></i></label></button>
                <input type="file" id="files" name="pdf_files[]" multiple accept=".pdf,.doc,.docx,.jpeg,.jpg,.png,.gif">
                <input type="text" placeholder="Tu Mensaje..." id="mensaje_enviar">
                <button type="button" id="boton_enviar" disabled><i class="fa-regular fa-paper-plane"></i></button>
            </div>
        </footer>
    </main>
    <script>
        <?php
        echo "var emisor = " . $emisor . ";";
        echo "var receptor = " . $receptor . ";";
        if ($tipo_usuario == "user_normal") {
            echo "var at = 1;";
        } else {
            echo "var at = 0;";
        }
        ?>
    </script>
    <script src="/assets/script/chat.js"></script>
</body>

</html>