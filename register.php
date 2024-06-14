<!DOCTYPE html>
<html lang="es">

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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "./libs/conn.php";

        $DNI_Usuario = $_POST["DNI"];
        $Nombres = $_POST["nombre_Usuario"];
        $Apellidos = $_POST["apellido"];
        $Edad = $_POST["edad"];
        $Mail = $_POST["Gmail"];
        $Telefono = $_POST["telefono"];
        $Contrasena = $_POST["contrasena"];

        $sql = "SELECT * FROM usuarios WHERE email = '$Mail' OR DNI_Usuario = '$DNI_Usuario' OR Telefono = '$Telefono'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<p class='error'>El correo electrónico, DNI o teléfono ya están registrados.</p>";
        } else {
            $sql_insert = "INSERT INTO usuarios (DNI_Usuario, Nombres, Apellidos, Edad, Email, Telefono, Contrasena) VALUES ('$DNI_Usuario','$Nombres','$Apellidos', '$Edad', '$Mail', '$Telefono', '$Contrasena')";
            if (mysqli_query($conn, $sql_insert)) {
                if (isset($_POST['Regristrar_Alumno']) && $_POST['Regristrar_Alumno'] == "on") {
                    $Curso = $_POST["Curso"];
                    $Preceptor = $_POST["Preceptor"];

                    $sql_insert = "INSERT INTO `alumnos`(`FK_DNI_Usuario`, `Curso`, `Preceptor`) VALUES ('$DNI_Usuario','$Curso','$Preceptor')";
                    if (mysqli_query($conn, $sql_insert)) {
                        header("Location: /login.php");
                        exit;
                    } else {
                        echo "Error en la consulta SQL: " . mysqli_error($conn);
                    }
                } else {
                    header("Location: /login.php");
                    exit;
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
            <input type="text" placeholder="Nombre de Usuario" required name="nombre_Usuario" id="nombre_Usuario">
            <input type="text" placeholder="Apellido" required name="apellido" id="apellido">
            <input type="number" placeholder="Edad" required name="edad" id="edad">
            <input type="email" placeholder="Gmail" required name="Gmail" id="Gmail">
            <input type="tel" placeholder="Teléfono" required name="telefono" id="telefono">
            <input type="password" placeholder="Contraseña" required name="contrasena" id="contrasena">

            <label>
                <input type="checkbox" name="Regristrar_Alumno" id="Regristrar_Alumno">
                Registrarse como Alumno
            </label>
            <div class="opciones-container">
                <select class="opciones" name="Curso" disabled>
                    <option value="7mo 2da">7mo 2da</option>
                </select>
                <select class="opciones" name="Preceptor" disabled>
                    <option value="Javier Milei">Javier Milei</option>
                </select>
            </div>
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
                if (checked) {
                    x.parentElement.style.display = 'block';
                } else {
                    x.parentElement.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
