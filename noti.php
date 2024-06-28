<?php
require "./libs/conn.php";
include "./libs/obtener_tipo_usuario.php";
session_start();
$type_user = obtenerTipoUsuario();
$id_usuario = $_SESSION['datos_usuario']['id_usuario'];

// Obtener pedidos del usuario
$sql = "SELECT p.id, p.DNI_Usuario, p.descripcion, p.fecha_creacion, e.fecha_actualizacion, e.estado
        FROM pedidos p
        JOIN estado_pedido e ON p.id = e.pedido_id
        WHERE DNI_Usuario = '$id_usuario'";
$result = mysqli_query($conn, $sql);

// Verificar si la consulta tuvo éxito
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}



mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <title>Historial - PrintUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/global.css">
    <!-- <link rel="stylesheet" href="./assets/styles/index.css"> -->
    <link rel="stylesheet" href="./assets/styles/noti.css">
</head>

<body>
    <div class="arriba">
        <div>
            <img src="./assets/img/logo_negro.png" alt="PrintUP Logo" class="logo">
        </div>
        <?php
        if ($type_user == "user_normal") {
            echo "Notificaciones clientes";
        } else {
            echo "Notificaciones kiosco";
        }
        ?>
    </div>
    <main><?php
            $tipos_estados = ["1" => "Enviado", "2" => "Leido", "3" => "En Proceso", "4" => "Impreción finaliozada", "5" => "Entregado"];
            // Mostrar pedidos
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="notificaciones">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="notificacion">';
                    echo '<h3>Pedido #' . $row['id'] . '</h3>';
                    echo '<p>' . $row['descripcion'] . '</p>';

                    echo '<p>Fecha de creación: ' . $row['fecha_creacion'] . '</p>';
                    echo '<p>Ultima Actualizacón: ' . $row['fecha_actualizacion'] . '</p>';
                    echo '<p>Estado: ' . $tipos_estados[$row['estado']] . '</p>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p class="nada_pedidos">No tienes pedidos.</p>';
            } ?></main>
    <?php include "./componets/navbar.php" ?>
</body>

</html>