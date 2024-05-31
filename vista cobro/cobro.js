document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("paymentModal");
  const addPaymentButton = document.getElementById("addPaymentButton");
  const closeButton = document.querySelector(".close-button");
  const paymentForm = document.getElementById("paymentForm");
  const paymentOptions = document.getElementById("paymentOptions");

  // Abrir el modal para agregar una tarjeta
  addPaymentButton.addEventListener("click", function () {
    modal.style.display = "flex";
  });

  // Cerrar el modal cuando se hace clic en la 'x'
  closeButton.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Cerrar el modal cuando se hace clic fuera del contenido del modal
  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });

  // Manejar el envío del formulario para agregar una tarjeta
  paymentForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const cardNumber = document.getElementById("cardNumber").value;
    const expiryDate = document.getElementById("expiryDate").value;
    const cardType = document.getElementById("cardType").value;

    // Crear un nuevo elemento de tarjeta de pago
    const newPaymentCard = document.createElement("div");
    newPaymentCard.className = "payment-card";
    newPaymentCard.innerHTML = `
            <img src="https://img.icons8.com/color/48/000000/${cardType.toLowerCase()}-logo.png" alt="${cardType}">
            <span>**** ${cardNumber.slice(-4)}</span>
            <span>${cardType} - Exp: ${expiryDate}</span>
            <button class="delete-button">Eliminar</button>
        `;

    // Agregar la nueva tarjeta a la lista de métodos de pago
    paymentOptions.insertBefore(newPaymentCard, addPaymentButton);
    modal.style.display = "none";
    paymentForm.reset();
  });

  // Manejar la eliminación de una tarjeta de pago
  paymentOptions.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-button")) {
      event.target.parentElement.remove();
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("paymentModal");
  const addPaymentButton = document.getElementById("addPaymentButton");
  const closeButton = document.querySelector(".close-button");
  const paymentForm = document.getElementById("paymentForm");
  const paymentOptions = document.getElementById("paymentOptions");

  // Abrir el modal para agregar una tarjeta
  addPaymentButton.addEventListener("click", function () {
    modal.style.display = "flex";
  });

  // Cerrar el modal cuando se hace clic en la 'x'
  closeButton.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Cerrar el modal cuando se hace clic fuera del contenido del modal
  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });

  // Manejar el envío del formulario para agregar una tarjeta
  paymentForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const cardNumber = document.getElementById("cardNumber").value;
    const expiryDate = document.getElementById("expiryDate").value;
    const cardType = document.getElementById("cardType").value;

    // Crear un nuevo elemento de tarjeta de pago
    const newPaymentCard = document.createElement("div");
    newPaymentCard.className = "payment-card";
    newPaymentCard.innerHTML = `
            <img src="https://img.icons8.com/color/48/000000/${cardType.toLowerCase()}-logo.png" alt="${cardType}">
            <span>**** ${cardNumber.slice(-4)}</span>
            <span>${cardType} - Exp: ${expiryDate}</span>
            <button class="delete-button">Eliminar</button>
        `;

    // Agregar la nueva tarjeta a la lista de métodos de pago
    paymentOptions.insertBefore(newPaymentCard, addPaymentButton);
    modal.style.display = "none";
    paymentForm.reset();
  });

  // Manejar la eliminación de una tarjeta de pago
  paymentOptions.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-button")) {
      event.target.parentElement.remove();
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("paymentModal");
  const addPaymentButton = document.getElementById("addPaymentButton");
  const closeButton = document.querySelector(".close-button");
  const paymentForm = document.getElementById("paymentForm");
  const paymentOptions = document.getElementById("paymentOptions");

  // Abrir el modal para agregar una tarjeta
  addPaymentButton.addEventListener("click", function () {
    modal.style.display = "flex";
  });

  // Cerrar el modal cuando se hace clic en la 'x'
  closeButton.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Cerrar el modal cuando se hace clic fuera del contenido del modal
  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });

  // Manejar el envío del formulario para agregar una tarjeta
  paymentForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const cardNumber = document.getElementById("cardNumber").value;
    const expiryDate = document.getElementById("expiryDate").value;
    const cardType = document.getElementById("cardType").value;

    // Crear un nuevo elemento de tarjeta de pago
    const newPaymentCard = document.createElement("div");
    newPaymentCard.className = "payment-card";
    newPaymentCard.innerHTML = `
            <img src="https://img.icons8.com/color/48/000000/${cardType.toLowerCase()}-logo.png" alt="${cardType}">
            <span>**** ${cardNumber.slice(-4)}</span>
            <span>${cardType} - Exp: ${expiryDate}</span>
            <button class="delete-button">Eliminar</button>
        `;

    // Agregar la nueva tarjeta a la lista de métodos de pago
    paymentOptions.insertBefore(newPaymentCard, addPaymentButton);
    modal.style.display = "none";
    paymentForm.reset();
  });

  // Manejar la eliminación de una tarjeta de pago
  paymentOptions.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-button")) {
      event.target.parentElement.remove();
    }
  });
});
