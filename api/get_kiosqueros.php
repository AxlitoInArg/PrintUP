<?php

// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["user_id"])) {
function get_kiosqueros()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
        require "../libs/conn.php";
        $sql = "SELECT u.DNI_Usuario, CONCAT(u.Nombres, ' ', u.Apellidos) AS 'Nombre_Completo', u.perfil_img, COUNT(m.ID_Mensaje) as Cantidad_Mensajes, t.Ultimo_Mensaje, t.Mensaje FROM `kiosqueros` k JOIN `usuarios` u ON k.FK_DNI_Usuario = u.DNI_Usuario LEFT JOIN `mensajes` m ON k.ID_Kiosquero = m.ID_Kiosquero AND m.FK_DNI_Usuario = '$user_id' LEFT JOIN (SELECT m.ID_Kiosquero, MAX(m.Fecha_Hora) as Ultimo_Mensaje, m.Mensaje FROM `mensajes` m WHERE m.FK_DNI_Usuario = '$user_id' GROUP BY m.Fecha_Hora DESC) t ON k.ID_Kiosquero = t.ID_Kiosquero GROUP BY k.ID_Kiosquero, u.DNI_Usuario, u.Nombres, u.Apellidos ORDER BY t.Ultimo_Mensaje DESC;";
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
