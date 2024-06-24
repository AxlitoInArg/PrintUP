<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/icono.png" type="image/x-icon">
    <title>Recuperación de Contraseña - PrintUP</title>
    <link rel="stylesheet" href="recuperacion.css">
</head>
<body>
    <header class="header">
        <img src="/img/logo.png" alt="PrintUP Logo" class="logo">
    </header>
    <div class="container">
        <h2>Recuperar contraseña</h2>
        <form action="process_password_reset.php" method="post">
            <input type="email" name="email" placeholder="Ingresa tu correo electrónico" required>
            <button type="submit">Enviar enlace de recuperación</button>
        </form>
        <footer class="footer">
        <a href="/login.php" class="index">Atrás</a>
        </footer>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
