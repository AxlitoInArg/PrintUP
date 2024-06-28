<?php
include "../libs/conn.php";

header('Content-Type: application/json');

// Verificar método HTTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido_id = $_POST['pedido_id'];
    $nuevo_estado = $_POST['nuevo_estado'];

    // Verificar que se hayan proporcionado los datos necesarios
    if (isset($pedido_id) && isset($nuevo_estado)) {
        // Actualizar el estado del pedido en la base de datos
        $sql = "UPDATE estado_pedido SET estado = ?, fecha_actualizacion = CURRENT_TIMESTAMP WHERE pedido_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nuevo_estado, $pedido_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Estado del pedido actualizado correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el estado del pedido."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método HTTP no permitido."]);
}

$conn->close();
