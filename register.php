<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/register.css">
    <title>Registro - PrintUP</title>
</head>

<body>
    <?php
    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Procesar los datos del formulario
        include "./libs/conn.php";

        $DNI_Usuario = $_POST["DNI"];
        $Nombres = $_POST["nombre_Usuario"]; // Cambiado de "Nombres" a "nombre_Usuario"
        $Apellidos = $_POST["apellido"]; // Cambiado de "Apellidos" a "apellido"
        $Edad = $_POST["edad"]; // Cambiado de "Edad" a "edad"
        $Mail = $_POST["Gmail"]; // Cambiado de "Email" a "Gmail"
        $Telefono = $_POST["telefono"]; // No hace falta cambiar
        $Contrasena = $_POST["contrasena"]; // Cambiado de "Contrasena" a "contrasena"

        // Verificar si el email, DNI y teléfono ya están registrados
        $sql = "SELECT * FROM usuarios WHERE email = '$Mail' OR DNI_Usuario = '$DNI_Usuario' OR Telefono = '$Telefono'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<p class='error'>El correo electrónico, DNI o teléfono ya están registrados.</p>";
        } else {
            // Insertar nuevo usuario en la base de datos
            $sql_insert = "INSERT INTO usuarios (DNI_Usuario, Nombres, Apellidos, Edad, Email, Telefono, Contrasena) VALUES ('$DNI_Usuario','$Nombres','$Apellidos', '$Edad', '$Mail', '$Telefono', '$Contrasena');";

            if (mysqli_query($conn, $sql_insert)) {

                if (isset($_POST['registrar_alumno']) && $_POST['registrar_alumno'] == "on") {
                    $Curso = $_POST["curso"];
                    $Preceptor = $_POST["preceptor"];
                    $sql_insert = "INSERT INTO alumnos (FK_DNI_Usuario, Curso, Preceptor) VALUES ('$DNI_Usuario','$Curso','$Preceptor');";

                    if (mysqli_query($conn, $sql_insert)) {
                        // Redirigir al usuario a la página de inicio
                        header("Location: /login.php");
                        exit; // Finalizar el script para evitar cualquier salida adicional
                    } else {
                    }
                }
            } else {
                echo "Error en la consulta SQL: " . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    }
    ?>

    <header class="header">
        <img src="img/logo.png" alt="PrintUP Logo" class="logo">
    </header>
    <main class="login-form">
        <form action="" method="POST">
            <input type="number" placeholder="DNI" required name="DNI" id="DNI">
            <input type="text" placeholder="Nombre de Usuario" required name="nombre_Usuario" id="nombre_Usuario"> <!-- Corregido de "Nombres" a "nombre_Usuario" -->
            <input type="text" placeholder="Apellido" required name="apellido" id="apellido"> <!-- Corregido de "Apellidos" a "apellido" -->
            <input type="text" placeholder="Edad" required name="edad" id="edad"> <!-- Corregido de "Edad" a "edad" -->
            <input type="email" placeholder="Gmail" required name="Gmail" id="Gmail"> <!-- Corregido de "Email" a "Gmail" y cambiado a tipo "email" -->
            <input type="tel" placeholder="Teléfono" required name="telefono" id="telefono"> <!-- Cambiado a tipo "tel" -->
            <input type="password" placeholder="Contraseña" required name="contrasena" id="contrasena"> <!-- Corregido de "Contrasena" a "contrasena" -->
            <label for="register_alumno">
                <input type="checkbox" placeholder="Contraseña" name="registrar_alumno" id="register_alumno"> <!-- Corregido de "Contrasena" a "contrasena" -->
                Registrarse como alumno
            </label>
            <select id="opciones" name="curso" disabled>
                <option name value="1ro 2da">1ro 2da</option>
                <option value="7mo 2da">7mo 2da</option>
            </select>
            <select id="opciones" name="preceptor" disabled>
                <option name value="Alejandro Manrique">Alejandro Manrique</option>
            </select>
            <button type="submit">Registrarse</button>
        </form>
    </main>
    <footer class="footer">
        <a href="/login.php" class="index">atrás</a>
    </footer>
    <script>
        const $registrar_alumno = document.getElementById("register_alumno");
        const $opciones = document.querySelectorAll("#opciones");
        $registrar_alumno.addEventListener('click', (e) => {
            if (e.target.value) {
                console.log(e.target)
            }
        })
    </script>
</body>

</html>