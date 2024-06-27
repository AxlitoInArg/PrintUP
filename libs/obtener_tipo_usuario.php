<?php
function obtenerTipoUsuario(): string
{
    if (isset($_SESSION['nombre_usuario'])) {
        $nombres = $_SESSION['nombre_usuario'];

        include "./libs/conn.php";

        // Consulta SQL para obtener el tipo de usuario
        $sql = "SELECT * FROM usuarios INNER JOIN kiosqueros ON usuarios.DNI_Usuario = kiosqueros.FK_DNI_Usuario WHERE usuarios.Nombres = '$nombres'";
        $resultado = mysqli_query($conn, $sql);

        // Verificar si se encontró el tipo de usuario
        if (mysqli_num_rows($resultado) > 0) {
            mysqli_close($conn);
            return "user_kiosquero";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
        return "user_normal";
    }
    return "no_user";
}
?>
