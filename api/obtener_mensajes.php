<?php

function obtenerMensajes()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["emisor"]) && isset($_GET["receptor"])) {
        $emisor = $_GET["emisor"];
        $receptor = $_GET["receptor"];
        require "../libs/conn.php";

        // Consulta para obtener mensajes
        $consulta_sql = "SELECT m.ID_Mensaje, m.Fecha_Hora, m.Mensaje, m.Autor 
                         FROM mensajes m 
                         WHERE ((m.FK_DNI_Usuario = '$emisor' AND m.ID_Kiosquero IN 
                                (SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = '$receptor')) 
                            OR (m.FK_DNI_Usuario = '$receptor' AND m.ID_Kiosquero IN 
                                (SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = '$emisor')))
                         ORDER BY m.Fecha_Hora;";

        $resultado = mysqli_query($conn, $consulta_sql);
        // Crear un arreglo para almacenar los resultados
        $mensajes = array();

        // Verificar si la consulta devolvió resultados
        if (mysqli_num_rows($resultado) > 0) {
            // Recorrer los resultados y agregarlos al arreglo
            while ($fila = mysqli_fetch_assoc($resultado)) {
                // Consulta para obtener archivos asociados al mensaje actual
                $id_mensaje = $fila['ID_Mensaje'];
                $consulta_archivos = "SELECT a.Nombre_Archivo, a.Ruta_Archivo 
                                      FROM archivos a 
                                      WHERE a.ID_Mensaje = '$id_mensaje';";
                $resultado_archivos = mysqli_query($conn, $consulta_archivos);

                // Crear un arreglo para almacenar los archivos del mensaje actual
                $archivos = array();
                if (mysqli_num_rows($resultado_archivos) > 0) {
                    while ($archivo = mysqli_fetch_assoc($resultado_archivos)) {
                        $archivos[] = $archivo;
                    }
                }

                // Añadir los archivos al mensaje
                $fila['archivos'] = $archivos;
                $mensajes[] = $fila;
            }
        }

        mysqli_close($conn);
        return $mensajes;
    }
    return array();
}

// Configurar la cabecera para devolver JSON
header('Content-Type: application/json');
echo json_encode(obtenerMensajes());
