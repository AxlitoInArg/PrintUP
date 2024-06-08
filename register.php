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
            $sql_insert = "INSERT INTO usuarios (DNI_Usuario, Nombres, Apellidos, Edad, Email, Telefono, Contrasena) VALUES ('$DNI_Usuario','$Nombres','$Apellidos', '$Edad', '$Mail', '$Telefono', '$Contrasena')";
            if (mysqli_query($conn, $sql_insert)) {

                if (isset($_POST['Regristrar_Alumno']) && $_POST['Regristrar_Alumno'] == "on") {
                    $Curso = $_POST["Curso"]; // No hace falta cambiar
                    $Preceptor = $_POST["Preceptor"]; // Cambiado de "Contrasena" a "contrasena"

                    $sql_insert = "INSERT INTO `alumnos`(`FK_DNI_Usuario`, `Curso`, `Preceptor`) VALUES ('$DNI_Usuario','$Curso','$Preceptor')";
                    if (mysqli_query($conn, $sql_insert)) {
                        // Redirigir al usuario a la página de inicio
                        header("Location: /login.php");
                        exit; // Finalizar el script para evitar cualquier salida adicional
                    } else {
                        echo "Error en la consulta SQL: " . mysqli_error($conn);
                    }
                } else {
                    // Redirigir al usuario a la página de inicio
                    header("Location: /login.php");
                    exit; // Finalizar el script para evitar cualquier salida adicional
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
            <input type="number" placeholder="Edad" required name="edad" id="edad"> <!-- Corregido de "Edad" a "edad" -->
            <input type="email" placeholder="Gmail" required name="Gmail" id="Gmail"> <!-- Corregido de "Email" a "Gmail" y cambiado a tipo "email" -->
            <input type="tel" placeholder="Teléfono" required name="telefono" id="telefono"> <!-- Cambiado a tipo "tel" -->
            <input type="password" placeholder="Contraseña" required name="contrasena" id="contrasena"> <!-- Corregido de "Contrasena" a "contrasena" -->

            <label>
                <input type="checkbox" name="Regristrar_Alumno" id="Regristrar_Alumno"> <!-- Corregido de "Contrasena" a "contrasena" -->
                Registrarse como Alumno
            </label>
            <select class="opciones" name="Curso" disabled>
                <option value="7mo 2da">7mo 2da</option>
            </select>
            <select class="opciones" name="Preceptor" disabled>
                <option value="Javier Milei">Javier Milei</option>
            </select>
            <button type="submit">Registrarse</button>
        </form>
    </main>
    <footer class="footer">
        <a href="/login.php" class="index">atrás</a>
    </footer>
    <script>
        const Regristrar_Alumno = document.getElementById("Regristrar_Alumno");
        const elementsOpcions = document.querySelectorAll(".opciones");
        Regristrar_Alumno.addEventListener("click", (e) => {
            let checked = e.target.checked;
            elementsOpcions.forEach(x => {
                x.disabled = !checked;
            });
        })
    </script>
</body>

</html>