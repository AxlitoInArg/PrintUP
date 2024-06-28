<?php

// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_usuario"])) {
function get_kiosqueros()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_usuario"])) {
        $id_usuario = $_GET["id_usuario"];
        require "../libs/conn.php";
        $sql = "SELECT u.DNI_Usuario, CONCAT(u.Nombres, ' ', u.Apellidos) AS 'Nombre_Completo', u.Imagen_Perfil, m.Mensaje, m.Fecha_Hora as Ultimo_Mensaje FROM `usuarios` AS u JOIN `mensajes` AS m ON u.DNI_Usuario = m.FK_DNI_Usuario JOIN `kiosqueros` AS k ON m.ID_Kiosquero = k.ID_Kiosquero WHERE k.FK_DNI_Usuario = '$id_usuario' ORDER BY m.Fecha_Hora DESC;";
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
