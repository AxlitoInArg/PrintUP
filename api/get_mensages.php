<?php

// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["user_id"])) {
function get_kiosqueros()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["emisor"]) && isset($_GET["receptor"])) {
        $emisor = $_GET["emisor"];
        $receptor = $_GET["receptor"];
        require "../libs/conn.php";
        $sql = "SELECT m.Fecha_Hora, m.Mensaje, m.Autor FROM mensajes m WHERE ((m.FK_DNI_Usuario = '$emisor' AND m.ID_Kiosquero IN (SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = '$receptor')) OR (m.FK_DNI_Usuario = '$receptor' AND m.ID_Kiosquero IN (SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = '$emisor'))) ORDER BY m.Fecha_Hora;";
        $result = mysqli_query($conn, $sql);
        // Crear un arreglo para almacenar los resultados
        $kiosqueros = array();
        // Verificar si la consulta devolvió resultados
        if (mysqli_num_rows($result) > 0) {
            // Recorrer los resultados y agregarlos al arreglo
            while ($row = mysqli_fetch_assoc($result)) {
                $kiosqueros[] = $row;
            }
        }
        return $kiosqueros;
    }
    return array();
}
// echo $carlos["cad"];
header('Content-Type: application/json');
echo json_encode(get_kiosqueros());
