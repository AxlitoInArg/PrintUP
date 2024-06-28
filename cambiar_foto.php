<?php
session_start();
require "./libs/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto_perfil'])) {
    $id_usuario = $_SESSION['datos_usuario']['id_usuario'];
    $targetDir = "./assets/img/";
    $targetFile = $targetDir . basename($_FILES["foto_perfil"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar si es una imagen real
    $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Verificar tamaño del archivo
    if ($_FILES["foto_perfil"]["size"] > 500000) {
        echo "Lo sentimos, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Lo sentimos, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está establecido en 0 por un error
    if ($uploadOk == 0) {
        echo "Lo sentimos, tu archivo no fue subido.";
    } else {
        // Si todo está bien, intenta subir el archivo
        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $targetFile)) {
            // Actualizar ruta de foto en la base de datos
            $Imagen_Perfil = basename($_FILES["foto_perfil"]["name"]);
            $sql = "UPDATE usuarios SET Imagen_Perfil ='$Imagen_Perfil' WHERE DNI_Usuario='$id_usuario'";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['datos_usuario']['Imagen_Perfil'] = $Imagen_Perfil;
                
                echo "La foto de perfil ha sido actualizada.";
                header("Location: configuracion.php"); // Redirigir a la página de configuración
                exit;
            } else {
                echo "Error al actualizar la base de datos: " . mysqli_error($conn);
            }
        } else {
            echo "Lo sentimos, hubo un error al subir tu archivo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/icono.png" type="image/x-icon">
    <title>Configuraciones - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <link rel="stylesheet" href="./assets/styles/cambiar_foto.css">
</head>

<body>

        <div class="cambiar-foto">
            <h2>Cambiar foto de perfil</h2>
            <form action="cambiar_foto.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="foto_perfil" required>
                <br/>
                <button type="submit">Subir Foto</button>
            </form>
            <h2>Aviso: la resolución optima de las imagenes es 512x512</h2>
        </div>
    </main>

    <?php include "./componets/navbar.php"; ?>
</body>

</html>
