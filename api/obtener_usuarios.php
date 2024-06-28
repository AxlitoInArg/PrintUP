<?php

function obtenerUsuarios()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_usuario"])) {
        $user_id = $_GET["id_usuario"];
        require "../libs/conn.php";

        $sql = "SELECT 
                u.DNI_Usuario, 
                CONCAT(u.Nombres, ' ', u.Apellidos) AS 'Nombre_Completo', 
                u.Imagen_Perfil, 
                m.Mensaje, 
                m.Fecha_Hora AS Ultimo_Mensaje
            FROM 
                usuarios u
            JOIN (
                SELECT 
                    m1.FK_DNI_Usuario, 
                    m1.Mensaje, 
                    m1.Fecha_Hora
                FROM 
                    mensajes m1
                JOIN (
                    SELECT 
                        FK_DNI_Usuario, 
                        MAX(Fecha_Hora) AS Ultimo_Mensaje
                    FROM 
                        mensajes
                    WHERE 
                        ID_Kiosquero = (
                            SELECT k.ID_Kiosquero 
                            FROM kiosqueros k 
                            WHERE k.FK_DNI_Usuario = '$user_id'
                        )
                    GROUP BY 
                        FK_DNI_Usuario
                ) m2 ON m1.FK_DNI_Usuario = m2.FK_DNI_Usuario AND m1.Fecha_Hora = m2.Ultimo_Mensaje
            ) m ON u.DNI_Usuario = m.FK_DNI_Usuario
            ORDER BY 
                m.Fecha_Hora DESC;
        ";

        $result = mysqli_query($conn, $sql);

        // Crear un arreglo para almacenar los resultados
        $usuarios = array();

        // Verificar si la consulta devolvió resultados
        if (mysqli_num_rows($result) > 0) {
            // Recorrer los resultados y agregarlos al arreglo
            while ($row = mysqli_fetch_assoc($result)) {
                $usuarios[] = $row;
            }
        }

        return $usuarios;
    }
    return array();
}

header('Content-Type: application/json');
echo json_encode(obtenerUsuarios());
