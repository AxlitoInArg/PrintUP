<?php
function getUserType(): string
{
    if (isset($_SESSION['nombre_usuario'])) {
        $Nombres = $_SESSION['nombre_usuario'];

        include "./libs/conn.php";

        // Consulta SQL para obtener el nombre del usuario
        $sql = "SELECT * FROM usuarios INNER JOIN kiosqueros ON usuarios.DNI_Usuario = kiosqueros.FK_DNI_Usuario WHERE usuarios.Nombres = '$Nombres'";
        $result = mysqli_query($conn, $sql);

        // Verificar si se encontró el nombre del usuario
        if (mysqli_num_rows($result) > 0) {
            mysqli_close($conn);
            return "user_kiosquero";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
        return "user_normal";
    }
    return "no_user";
}
