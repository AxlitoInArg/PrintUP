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
    $emisor = $_SESSION['datos_usuario']['id_usuario'];
    require "./libs/conn.php";
    $sql = "SELECT u.DNI_Usuario, CONCAT(u.Nombres, ' ', u.Apellidos) AS Nombre_Completo, u.Imagen_Perfil FROM usuarios u WHERE u.DNI_Usuario = ?";
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
    <link rel="stylesheet" href="./assets/styles/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/chat.css">
    <style>
        /* Estilos adicionales para el modal */
        #modalFondo {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        #modal {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 80%;
            overflow: auto;
            display: flex;
            flex-direction: column;
        }

        #modal button {
            background-color: #0084ff;
            border: none;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        #modal button:hover {
            background-color: #005bb5;
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
        </main>

       <?php 
       if ($tipo_usuario == "user_normal") {
        echo "<footer class='container'>
            <div class='container__submit_mensaje'>
                <label for='files' id='archivo_enviar'>
                    <i class='fa-solid fa-plus'></i>
                </label>
                <input type='file' id='files' name='pdf_files[]' multiple accept='.pdf,.jpeg,.png,.tiff,.gif,.bmp,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.html,.ps'>
                <button type='button' id='boton_abrir_modal' data-id='0'>Selecione una opción...</button>
                <button type='button' id='boton_enviar' disabled><i class='fa-regular fa-paper-plane'></i></button>
            </div>
        </footer>";
       }
       else {
        echo "<style>.container_mensajes {max-height: calc(100vh - 101.39px) !important;}</style>";
       }
       ?>
    </main>

    <div id="modalFondo">
        <div id="modal">
            <?php
            $opciones = [1 => "¿Podrías imprimir estos archivos por favor? Adjunto. Gracias."];
            foreach ($opciones as $key => $value) {
                echo "<button data-id='$key'>$value</button>";
                // <button data-id="2">Botón 2</button>
            }

            ?>
            <button id="cerrarModal">Cerrar</button>
        </div>
    </div>
    <script>
        <?php
        echo "var emisor = " . json_encode($emisor) . ";";
        echo "var receptor = " . json_encode($receptor) . ";";
        echo "var at = " . ($tipo_usuario == "user_normal" ? 1 : 0) . ";";
        ?>
    </script>
    <script src="/assets/script/chat.js" defer></script>
</body>

</html>