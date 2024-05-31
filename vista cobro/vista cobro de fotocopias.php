<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Pago</title>
    <link rel="stylesheet" href="cobro.css">
</head>

<body>
    <div class="container">
        <div class="delivery-details">
            <p><strong>Detalle de entrega</strong></p>
            <p>documento</p>
            <p>costo</p>
        </div>
        <div class="payment-method">
            <p><strong>Medios de pago</strong></p>
            <div id="paymentOptions">
                <div class="payment-card">
                    <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" alt="MasterCard">
                    <span></span>
                    <span></span>
                    <button class="delete-button">Eliminar</button>
                </div>
            </div>
            <button id="addPaymentButton" class="add-payment-method">Agregar medio de pago</button>
        </div>
        <div class="tip-section">
            <p><strong>Propina para quien reparte</strong></p>
            <p>Irá directamente a su bolsillo</p>
            <div class="tip-buttons">
                <button class="tip-button" data-tip="0">Ahora no</button>
                <button class="tip-button" data-tip="280">$280</button>
                <button class="tip-button" data-tip="400">$400</button>
                <button class="tip-button" data-tip="530">$530</button>
                <button class="tip-button" data-tip="650">$650</button>
                <button class="tip-button" data-tip="other">Otro</button>
            </div>
        </div>
        <div class="payment-summary">
            <p><strong>Resumen</strong></p>
            <p>Productos:</p>
            <p>Envío:</p>
            <p>Tarifa de servicio:</p>
            <p>Propina:</p>
            <p>Total:</p>
        </div>
        <button class="order-button">Pedir</button>
    </div>

    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Agregar medio de pago</h2>
            <form id="paymentForm">
                <label for="cardNumber">Número de tarjeta</label>
                <input type="text" id="cardNumber" name="cardNumber" required>

                <label for="expiryDate">Fecha de expiración</label>
                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/AAAA" required>

                <label for="cardType">Tipo de tarjeta</label>
                <select id="cardType" name="cardType">
                    <option value="MasterCard">MasterCard</option>
                    <option value="Visa">Visa</option>
                    <option value="Amex">American Express</option>
                </select>

                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>

    <script src="cobro.js"></script>
</body>

</html>