const contenedorMensajes = document.querySelector(".container_mensajes");
const $mensajeEnviar = document.getElementById("mensaje_enviar");
const $botonEnviar = document.getElementById("boton_enviar");
const $files = document.getElementById("files");

let contadorMensajes = 0;

const renderizarComponente = ({ Fecha_Hora, Mensaje, Autor, archivos }) => {
    let files = archivos.map(({ Nombre_Archivo, Ruta_Archivo, Tipo_Archivo, Tamano_Archivo }) => {
        return /* html */ `
        <div class="container__mensaje__file">
            <span>${Nombre_Archivo} ${Tipo_Archivo}</span>
            <span>${Tamano_Archivo}</span>
            <a href="./assets/uploads/${Nombre_Archivo}" download><i class="fa-solid fa-download"></i></a>
        </div>`
    }).join("")
    return /*html*/`
    <div class="container__mensaje ${Number(Autor) == at ? "right" : "left"}">
                <img src="./assets/img/image.defaul.jpg" alt="Tu imagen de perfil">
                <div class="container__mensaje__content">
                    <span class="container__mensaje__text">${Mensaje}</span>
                    ${files}
                    <div class="container__mensaje_fecha_hora">${Fecha_Hora}</div>
                </div>
                <div class="triangulo_rectangulo"></div>
            </div>`;
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
    formData.append("mensaje_id", $mensajeEnviar.value);

    // Añadir archivos PDF al FormData
    const allowedExtensions = ['pdf', 'doc', 'docx', 'jpeg', 'jpg', 'png', 'gif'];
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

$mensajeEnviar.addEventListener("input", (e) => {
    $botonEnviar.disabled = e.target.value === "";
});

$botonEnviar.addEventListener("click", async () => {
    const res = await enviarMensaje();
    if (Number(res)) {
        obtenerMensajes().then(data => {
            let componente = data.map(renderizarComponente).join("");
            contenedorMensajes.innerHTML = componente;
            contenedorMensajes.scrollTo(0, contenedorMensajes.scrollHeight);
            contadorMensajes = data.length;
        });
        $mensajeEnviar.value = "";
        $botonEnviar.disabled = true;
    }
});
