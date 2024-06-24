<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../libs/conn.php";

    $email = $_POST["email"];

    $query = "SELECT * FROM usuarios WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(50));
            $expires = date("U") + 1800;

            $sql = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $email, $token, $expires);
            $stmt->execute();

            $resetLink = "http://localhost/printup/logeo/reset_password.php";
            $subject = "Recuperación de contraseña - PrintUP";
            $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: $resetLink";
            $headers = "From: printup.t1vl@gmail.com";

            // Enviar el correo electrónico
            mail($email, $subject, $message, $headers);

            header("Location: request_password_reset.php?success=Correo enviado. Revisa tu bandeja de entrada.");
        } else {
            header("Location: request_password_reset.php?error=Correo electrónico no encontrado.");
        }
    }


    $stmt->close();
    $conn->close();
}
