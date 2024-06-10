<?php
function get_kiosqueros()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["emisor"]) && isset($_POST["receptor"]) && isset($_POST["mensaje"])) {
        $emisor = $_POST["emisor"];
        $receptor = $_POST["receptor"];
        $mensaje = $_POST["mensaje"];

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

        $stmt->close();
        $conn->close();
        return 1;
    }
    return 0;
}

echo get_kiosqueros();
