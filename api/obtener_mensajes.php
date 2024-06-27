<?php

function obtenerMensajes()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["emisor"]) && isset($_GET["receptor"])) {
        $emisor = $_GET["emisor"];
        $receptor = $_GET["receptor"];
        require "../libs/conn.php";
        $consulta_sql = "SELECT m.Fecha_Hora, m.Mensaje, m.Autor FROM mensajes m WHERE ((m.FK_DNI_Usuario = '$emisor' AND m.ID_Kiosquero IN (SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = '$receptor')) OR (m.FK_DNI_Usuario = '$receptor' AND m.ID_Kiosquero IN (SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = '$emisor'))) ORDER BY m.Fecha_Hora;";
        $resultado = mysqli_query($conn, $consulta_sql);
        // Crear un arreglo para almacenar los resultados
        $mensajes = array();
        // Verificar si la consulta devolvió resultados
        if (mysqli_num_rows($resultado) > 0) {
            // Recorrer los resultados y agregarlos al arreglo
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $mensajes[] = $fila;
            }
        }
        return $mensajes;
    }
    return array();
}

// Configurar la cabecera para devolver JSON
header('Content-Type: application/json');
echo json_encode(obtenerMensajes());
