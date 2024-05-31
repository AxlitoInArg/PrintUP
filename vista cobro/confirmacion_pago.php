<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link rel="stylesheet" href="confirmacion_pago.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Contenedor de la confirmación -->
    <div id="confirmation-modal" class="modal hidden">
        <div class="modal-content">
            <span class="close-button" id="close-button">&times;</span>
            <div class="confirmation-message">
                <div class="checkmark-container">
                    <i class="fas fa-check-circle checkmark"></i>
                </div>
                <p>Tu Pedido ha sido enviado correctamente!</p>
                <a href="printup-main/inicio/inicio.php" id="return-button" class="return-button">Volver al inicio</a>
            </div>
        </div>
    </div>

    <!-- Botón de pago para simular la acción -->
    <button id="pay-button">Pagar</button>

    <script src="confirmacion_pago.js"></script>
</body>
</html>
