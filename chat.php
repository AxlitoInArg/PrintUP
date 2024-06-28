<?php
include "./libs/obtener_tipo_usuario.php";
session_start();
$tipo_usuario = obtenerTipoUsuario();
if ($tipo_usuario == "no_user" && (basename($_SERVER['PHP_SELF']) != '' && basename($_SERVER['PHP_SELF']) != 'index.php')) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["receptor"])) {
    $receptor = htmlspecialchars($_GET["receptor"]);
    $emisor = $_SESSION['user_id'];
    require "./libs/conn.php";
    $sql = "SELECT u.DNI_Usuario, CONCAT(u.Nombres, ' ', u.Apellidos) AS Nombre_Completo, u.perfil_img AS Imagen_Perfil FROM usuarios u WHERE u.DNI_Usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receptor);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        // El usuario existe, obtener los datos
        $fila = $resultado->fetch_assoc();
        $imagen_receptor = $fila["Imagen_Perfil"];
        $nombre_completo = $fila["Nombre_Completo"];
    } else {
        // Usuario no encontrado en la base de datos
        $mensaje_error = "Usuario no registrado.";
    }

    $stmt->close();
    $conn->close();
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
    <title>Chat - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/chat.css">
    <style>
        /* Estilos adicionales para el modal */
        #modalArchivo {
            display: none;
            position: fixed;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            color: white;
            z-index: 1000;
            text-align: center;
        }

        #modalArchivo span {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <main>
        <header class="header_chat">
            <a href="/"><i class="fa-solid fa-arrow-left"></i></a>
            <img src="assets/img/<?php echo htmlspecialchars($imagen_receptor); ?>" alt="Imagen de perfil del receptor">
            <span><?php echo htmlspecialchars($nombre_completo); ?></span>
        </header>
        <main class="container_mensajes">
            <!-- Aquí van los mensajes -->
            <div class="container__mensaje right">
                <img src="./assets/img/image.defaul.jpg" alt="Tu imagen de perfil">
                <div class="container__mensaje__content">
                    <span class="container__mensaje__text">Hola quiero que me hagas una impresión de estos archivos</span>
                    <div class="container__mensaje__file">
                        <span>PDF</span>
                        <span>2 MB</span>
                        <a href="./assets/uploads/667ddc7c31996.pdf" download><i class="fa-solid fa-download"></i></a>
                    </div>
                    <div class="container__mensaje_fecha_hora">2024-06-27 21:05</div>
                </div>
                <div class="triangulo_rectangulo"></div>
            </div>
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

    <div id="modalArchivo">
        <span>Archivos seleccionados.</span>
        <button id="cerrarModal" onclick="cerrarModal()">Aceptar</button>
    </div>

    <script>
        <?php
        echo "var emisor = " . json_encode($emisor) . ";";
        echo "var receptor = " . json_encode($receptor) . ";";
        echo "var at = " . ($tipo_usuario == "user_normal" ? 1 : 0) . ";";
        ?>

        document.getElementById('files').addEventListener('change', function () {
            var modal = document.getElementById('modalArchivo');
            modal.style.display = 'block';
        });

        function cerrarModal() {
            var modal = document.getElementById('modalArchivo');
            modal.style.display = 'none';
        }

        document.getElementById('boton_enviar').addEventListener('click', function () {
            cerrarModal();
        });
    </script>
    <script src="/assets/script/chat.js"></script>
</body>

</html>
