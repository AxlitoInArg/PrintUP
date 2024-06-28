const contenedorMensajes = document.querySelector(".container_mensajes");
const $botonEnviar = document.getElementById("boton_enviar");
const $files = document.getElementById("files");
const $modalFondo = document.getElementById('modalFondo');
const $modal = document.getElementById('modal');
const $botonAbrirModal = document.getElementById('boton_abrir_modal');
const $botonCerrarModal = document.getElementById('cerrarModal');

const allowedExtensions = ['pdf', 'jpeg', 'png', 'tiff', 'gif', 'bmp', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'html', 'ps'];
let contadorMensajes = 0;

const renderizarComponente = ({ Fecha_Hora, Mensaje, Autor, archivos, Imagen_Perfil }) => {
    let mensajeFile = archivos.map(({ Nombre_Archivo, Ruta_Archivo, Tamano_Archivo }) => {
        return /* html */ `<div class="container__mensaje__file"><span>${Nombre_Archivo}</span><span>${Tamano_Archivo}</span><a href="./assets/uploads/${Ruta_Archivo}" download="${Nombre_Archivo}"><i class="fa-solid fa-download"></i></a></div>`
    }).join("")
    return /*html*/`<div class="container__mensaje ${Number(Autor) == at ? "right" : "left"}"><img src="./assets/img/${Imagen_Perfil}" alt="Tu imagen de perfil"><div class="container__mensaje__content"><span class="container__mensaje__text">${Mensaje}</span>${mensajeFile}<div class="container__mensaje_fecha_hora">${Fecha_Hora}</div></div><div class="triangulo_rectangulo"></div></div>`;
}

const obtenerMensajes = async () => {
    try {
        const response = await fetch(`/api/obtener_mensajes.php?emisor=${emisor}&receptor=${receptor}`);

        const data = await response.json();
        return data;
    } catch (error) {

        return [];
    }
}

async function enviarMensaje() {
    const pdfFiles = $files.files
    const formData = new FormData();
    formData.append("emisor", emisor);
    formData.append("receptor", receptor);
    formData.append("mensaje_id", $botonAbrirModal.getAttribute("data-id"));

    // Añadir archivos PDF al FormData

    for (let i = 0; i < pdfFiles.length; i++) {
        const file = pdfFiles[i];
        const fileExt = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExt)) {
            alert('Solo se permiten archivos PDF, Word o imágenes.');
            return;
        }
        formData.append("pdf_files[]", file);
    }

    try {
        const res = await fetch("/api/enviar_mensaje.php", {
            method: "POST",
            body: formData,
        });
        return await res.text();
    } catch (error) {
        console.error("Error al enviar el mensaje:", error);
        return undefined;
    }
}

obtenerMensajes().then(data => {
    let componente = data.map(renderizarComponente).join("");
    contenedorMensajes.innerHTML = componente;
    contenedorMensajes.scrollTo(0, contenedorMensajes.scrollHeight);
    contadorMensajes = data.length;
});

setInterval(() => {
    obtenerMensajes().then(data => {
        let tempContadorMensajes = data.length;
        if (contadorMensajes !== tempContadorMensajes) {
            let componente = data.map(renderizarComponente).join("");
            contenedorMensajes.innerHTML = componente;
            contenedorMensajes.scrollTo(0, contenedorMensajes.scrollHeight);
            contadorMensajes = data.length;
        }
    });
}, 2000);

$files.addEventListener("change", () => {
    const dataId = $botonAbrirModal.getAttribute('data-id');
    if (dataId === "1" && $files.files.length !== 0) {
        $botonEnviar.disabled = false;
    }
    $modalFondo.style.display = 'none'; // Cierra el modal después de seleccionar
})

$botonEnviar.addEventListener("click", async () => {
    const res = await enviarMensaje();

    if (Number(res)) {
        obtenerMensajes().then(data => {
            let componente = data.map(renderizarComponente).join("");
            contenedorMensajes.innerHTML = componente;
            contenedorMensajes.scrollTo(0, contenedorMensajes.scrollHeight);
            contadorMensajes = data.length;
        });
        $botonAbrirModal.textContent = "Selecione una opción...";
        $botonAbrirModal.setAttribute("data-id", 0);
        $files.files.length = 0
        $botonEnviar.disabled = true;
    }
});


$botonAbrirModal.addEventListener('click', () => {
    $modalFondo.style.display = 'flex';
});

$botonCerrarModal.addEventListener('click', () => {
    $modalFondo.style.display = 'none';
});

// Puedes manejar la acción de cada botón dentro del modal usando los data-id
$modal.querySelectorAll('button[data-id]').forEach(button => {
    button.addEventListener('click', () => {
        const dataId = button.getAttribute('data-id');
        if (dataId === "1" && $files.files.length !== 0) {
            $botonEnviar.disabled = !true;
        }
        $botonAbrirModal.setAttribute("data-id", dataId)
        $botonAbrirModal.textContent = button.textContent
        $modalFondo.style.display = 'none'; // Cierra el modal después de seleccionar
    });
});
