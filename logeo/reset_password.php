<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/icono.png" type="image/x-icon">
    <title>Restablecer Contraseña - PrintUP</title>
    <link rel="stylesheet" href="recuperacion.css">
</head>
<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <form action="update_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <input type="password" name="new_password" placeholder="Nueva contraseña" required>
            <input type="password" name="confirm_password" placeholder="Confirmar nueva contraseña" required>
            <button type="submit">Restablecer Contraseña</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>