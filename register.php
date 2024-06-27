<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/register.css">
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
                    header("Location: ./login.php");
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
        <img src="/assets/img/logo.png" alt="PrintUP Logo" class="logo">
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
                <select class="opciones" name="Curso" disabled aria-placeholder="Curso">
                    <option value="" disabled selected>Seleccione un Curso</option>
                    <option value="7mo 2da">7mo 2da</option>
                    <option value="7mo 1ra">7mo 1ra</option>
                    <option value="6to 3ra">6to 3ra</option>
                    <option value="6to 2da">6to 2da</option>
                    <option value="6to 1ra">6to 1ra</option>
                    <option value="5to 3ra">5to 3ra</option>
                    <option value="5to 2da">5to 2da</option>
                    <option value="5to 1ra">5to 1ra</option>
                    <option value="4to 4ta">4to 4ta</option>
                    <option value="4to 3ra">4to 3ra</option>
                    <option value="4to 2da">4to 2da</option>
                    <option value="4to 1ra">4to 1ra</option>
                    <option value="3ro 4ta">3ro 4ta</option>
                    <option value="3ro 3ra">3ro 3ra</option>
                    <option value="3ro 2da">3ro 2da</option>
                    <option value="3ro 1ra">3ro 1ra</option>
                    <option value="2do 5ta">2do 5ta</option>
                    <option value="2do 4ta">2do 4ta</option>
                    <option value="2do 3ra">2do 3ra</option>
                    <option value="2do 2da">2do 2da</option>
                    <option value="2do 2da">2do 1ra</option>
                    <option value="1ro 5ta">1ro 5ta</option>
                    <option value="1ro 4ta">1ro 4ta</option>
                    <option value="1ro 3ra">1ro 3ra</option>
                    <option value="1ro 2da">1ro 2da</option>
                    <option value="1ro 1ra">1ro 1ra</option>
                </select>
                <select class="opciones" name="Preceptor" disabled>
                    <option value="" disabled selected>Seleccione un Preceptor</option>
                    <option value="Alejandro">Alejandro</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                    <option value="Javier Milei">Javier Milei</option>
                </select>
            </div>

            <button type="submit">Registrarse</button>
        </form>
    </main>
    <footer class="footer">
        <a href="./login.php" class="index">Atrás</a>
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