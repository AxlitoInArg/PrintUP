// script.js
document.getElementById('pay-button').addEventListener('click', function() {
    // Simula el proceso de pago
    processPayment().then(function() {
        // Muestra la ventana modal de confirmación
        document.getElementById('confirmation-modal').classList.remove('hidden');
    });
});

document.getElementById('close-button').addEventListener('click', function() {
    // Oculta la ventana modal de confirmación
    document.getElementById('confirmation-modal').classList.add('hidden');
});

document.getElementById('return-button').addEventListener('click', function() {
    // Redirige al usuario al inicio (puedes cambiar la URL según sea necesario)
    window.location.href = '/';
});

function processPayment() {
    return new Promise(function(resolve, reject) {
        // Simula un retraso para el proceso de pago
        setTimeout(function() {
            resolve();
        }, 2000); // Simula un pago que tarda 2 segundos
    });
}
