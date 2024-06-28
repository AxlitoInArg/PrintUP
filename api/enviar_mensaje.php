<?php
function convertirTamano($bytes)
{
    $kb = $bytes / 1024;
    if ($kb < 1024) {
        return round($kb, 2) . 'KB';
    } else {
        $mb = $kb / 1024;
        return round($mb, 2) . 'MB';
    }
}

function enviarMensaje()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["emisor"]) && isset($_POST["receptor"]) && isset($_POST["mensaje_id"])) {
        $emisor = $_POST["emisor"];
        $receptor = $_POST["receptor"];
        $mensaje_id = $_POST["mensaje_id"];

        // Definir mensajes predefinidos
        $mensajes_predefinidos = [
            1 => "¿Podrías imprimir estos archivos por favor? Adjunto. Gracias.",
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

        // Si el mensaje_id es 1, verificar si hay archivos adjuntos
        if ($mensaje_id == 1) {
            if (!isset($_FILES['pdf_files']) || !is_array($_FILES['pdf_files']['name']) || empty($_FILES['pdf_files']['name'][0])) {
                return 0; // No hay archivos adjuntos
            }
        }

        if ($mensaje_id != 1 && is_array($_FILES['pdf_files']['name']) || empty($_FILES['pdf_files']['name'][0])) {
            return 0; // Si hay archivos adjuntos
        }

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
            $upload_dir = "../assets/uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $allowedExtensions = ['PDF', 'JPEG', 'PNG', 'TIFF', 'GIF', 'BMP', 'DOC', 'DOCX', 'XLS', 'XLSX', 'PPT', 'PPTX', 'TXT', 'HTML', 'PS'];
            // Tamaño en MB que queremos convertir a bytes
            $tamano_en_mb = 30;

            // Convertir MB a bytes
            $maxFileSizeBYTES = $tamano_en_mb * 1024 * 1024;

            foreach ($_FILES['pdf_files']['name'] as $key => $file_name) {
                $file_tmp = $_FILES['pdf_files']['tmp_name'][$key];
                $file_type = $_FILES['pdf_files']['type'][$key];
                $file_size_bytes = $_FILES['pdf_files']['size'][$key];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                $file_size_text = convertirTamano($file_size_bytes);

                if (in_array(strtoupper($file_ext), $allowedExtensions) && $file_size_bytes <= $maxFileSizeBYTES) {
                    $file_new_name = uniqid() . '.' . $file_ext;
                    $file_path = $upload_dir . $file_new_name;

                    if (move_uploaded_file($file_tmp, $file_path)) {
                        // Dividir el tipo de archivo
                        $file_type_parts = explode('/', $file_type);
                        // $file_type_main = $file_type_parts[0];
                        $file_type_sub = $file_type_parts[1];

                        $stmt = $conn->prepare("INSERT INTO `archivos`(`ID_Mensaje`, `Nombre_Archivo`, `Tipo_Archivo`, `Tamano_Archivo`, `Ruta_Archivo`) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("issss", $mensaje_id, $file_name, $file_type_sub, $file_size_text, $file_new_name);
                        $stmt->execute();
                        $stmt->close();
                    }
                } else {
                    return 0; // Tipo de archivo no permitido o tamaño de archivo excede el límite
                }
            }
            // Inserta el pedido en la tabla `pedidos`
            $stmt = $conn->prepare("INSERT INTO `pedidos` (`DNI_Usuario`, `descripcion`) VALUES (?, ?)");
            $stmt->bind_param("is", $emisor, $mensaje);
            $stmt->execute();
            $pedido_id = $stmt->insert_id; // Obtener el ID del pedido insertado
            $stmt->close();

            // Inserta el estado inicial del pedido en la tabla `estado_pedido`
            $estado_inicial = 1; // Puedes ajustar este valor según el estado inicial deseado
            $stmt = $conn->prepare("INSERT INTO `estado_pedido` (`pedido_id`, `estado`) VALUES (?, ?)");
            $stmt->bind_param("ii", $pedido_id, $estado_inicial);
            $stmt->execute();
            $stmt->close();
        }

        $conn->close();
        return 1;
    }
    return 0;
}

echo enviarMensaje();
