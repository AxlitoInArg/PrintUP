<?php

function obtenerUsuarios()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_usuario"])) {
        $id_usuario = $_GET["id_usuario"];
        require "../libs/conn.php";
        $sql = "SELECT u.DNI_Usuario, CONCAT(u.Nombres, ' ', u.Apellidos) AS 'Nombre_Completo', u.perfil_img, m.Mensaje, m.Fecha_Hora as Ultimo_Mensaje FROM `usuarios` AS u JOIN `mensajes` AS m ON u.DNI_Usuario = m.FK_DNI_Usuario JOIN `kiosqueros` AS k ON m.ID_Kiosquero = k.ID_Kiosquero WHERE k.FK_DNI_Usuario = '$id_usuario' ORDER BY m.Fecha_Hora DESC LIMIT 1;";
        $resultado = mysqli_query($conn, $sql);
        // Crear un arreglo para almacenar los resultados
        $kiosqueros = array();
        // Verificar si la consulta devolvió resultados
        if (mysqli_num_rows($resultado) > 0) {
            // Recorrer los resultados y agregarlos al arreglo
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $kiosqueros[] = $fila;
            }
        }
        return $kiosqueros;
    }
    return array();
}

header('Content-Type: application/json');
echo json_encode(obtenerUsuarios());
