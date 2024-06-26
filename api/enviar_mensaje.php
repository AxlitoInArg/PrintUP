<?php
function enviarMensaje()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["emisor"]) && isset($_POST["receptor"]) && isset($_POST["mensaje_id"])) {
        $emisor = $_POST["emisor"];
        $receptor = $_POST["receptor"];
        $mensaje_id = $_POST["mensaje_id"];

        // Definir mensajes predefinidos
        $mensajes_predefinidos = [
            1 => "Mensaje predefinido 1",
            2 => "Mensaje predefinido 2",
            3 => "Mensaje predefinido 3",
            // Añadir más mensajes aquí
        ];

        // Verificar si el ID del mensaje es válido
        if (!isset($mensajes_predefinidos[$mensaje_id])) {
            return 0; // ID del mensaje no válido
        }

        $mensaje = $mensajes_predefinidos[$mensaje_id];

        require "../libs/conn.php";

        // Prepara la consulta para verificar si el usuario1 es un kiosquero
        $stmt = $conn->prepare("SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = ?");
        $stmt->bind_param("i", $receptor);
        $stmt->execute();
        $result = $stmt->get_result();
        $kiosquero1 = $result->fetch_assoc();

        // Prepara la consulta para verificar si el usuario2 es un kiosquero
        $stmt = $conn->prepare("SELECT ID_Kiosquero FROM kiosqueros WHERE FK_DNI_Usuario = ?");
        $stmt->bind_param("i", $emisor);
        $stmt->execute();
        $result = $stmt->get_result();
        $kiosquero2 = $result->fetch_assoc();

        // Prepara la consulta para insertar el mensaje
        $stmt = $conn->prepare("INSERT INTO mensajes (FK_DNI_Usuario, ID_Kiosquero, Mensaje, Autor) VALUES (?, ?, ?, ?)");
        if ($kiosquero1) {
            $autor = 1;
            $stmt->bind_param("iisi", $emisor, $kiosquero1['ID_Kiosquero'], $mensaje, $autor);
        } else if ($kiosquero2) {
            $autor = 0;
            $stmt->bind_param("iisi", $receptor, $kiosquero2['ID_Kiosquero'], $mensaje, $autor);
        }
        $stmt->execute();
        $mensaje_id = $stmt->insert_id; // Obtener el ID del mensaje insertado
        $stmt->close();

        // Manejo de archivos PDF, imagen y Word
        if (isset($_FILES['pdf_files']) && is_array($_FILES['pdf_files']['name']) && !empty($_FILES['pdf_files']['name'][0])) {
            $upload_dir = "../uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $allowedExtensions = ['pdf', 'doc', 'docx', 'jpeg', 'jpg', 'png', 'gif'];
            foreach ($_FILES['pdf_files']['name'] as $key => $file_name) {
                $file_tmp = $_FILES['pdf_files']['tmp_name'][$key];
                $file_type = $_FILES['pdf_files']['type'][$key];
                $file_size = $_FILES['pdf_files']['size'][$key];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (in_array($file_ext, $allowedExtensions)) {
                    $file_new_name = uniqid() . '.' . $file_ext;
                    $file_path = $upload_dir . $file_new_name;

                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $stmt = $conn->prepare("INSERT INTO archivos (ID_Mensaje, Nombre_Archivo, Tipo_Archivo, Tamano_Archivo) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("issi", $mensaje_id, $file_new_name, $file_type, $file_size);
                        $stmt->execute();
                        $stmt->close();
                    }
                } else {
                    return 0; // Tipo de archivo no permitido
                }
            }
        }

        $conn->close();
        return 1;
    }
    return 0;
}

echo enviarMensaje();
