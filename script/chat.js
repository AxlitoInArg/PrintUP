const container_mensajes = document.querySelector(".container_mensajes");
const $mensaje_send = document.getElementById("mensaje_send")
const $button_send = document.getElementById("button_send")

let count_menssage = 0

const render_componet = ({ Fecha_Hora, Mensaje, Autor }) => {
    return /*html*/` <div class="container__mensaje ${Number(Autor) == at ? "right" : "left"}">
                <span class="container__mensaje__text">${Mensaje}</span>
                <!-- <span class="container__mensaje__file"></span> -->
                <div class="triangulo_rectangulo"></div>
                <div class="container__mensaje_fecha_hora">${Fecha_Hora.slice(0, -3)}</div>
            </div>`}

const get_message = async () => {
    try {
        const response = await fetch(`/api/get_mensages.php?emisor=${emisor}&receptor=${receptor}`);
        const data = await response.json()
        return data
    } catch (error) {
        return []
    }
}

async function send_mensaje() {
    const formData = new FormData();

    formData.append("emisor", emisor);
    formData.append("receptor", receptor);
    formData.append("mensaje", $mensaje_send.value);

    try {
        const res = await fetch("/api/send_mensaje.php", {
            method: "POST",
            body: formData,
        })
        return await res.text()
    } catch (error) {
        return undefined
    }
}

get_message().then(data => {
    let component = data.map(render_componet).join("");
    container_mensajes.innerHTML = component
    container_mensajes.scrollTo(0, container_mensajes.scrollHeight)
    count_menssage = data.length

})

setInterval(() => {
    get_message().then(data => {
        let temp_count_menssage = data.length
        if (count_menssage !== temp_count_menssage) {
            let component = data.map(render_componet).join("");
            container_mensajes.innerHTML = component
            container_mensajes.scrollTo(0, container_mensajes.scrollHeight)
            count_menssage = data.length
        }
    })
}, 2000);


$mensaje_send.addEventListener("input", (e) => {
    $button_send.disabled = e.target.value === ""
})

$button_send.addEventListener("click", async () => {
    const res = await send_mensaje()
    if (Number(res)) {
        get_message().then(data => {
            let component = data.map(render_componet).join("");
            container_mensajes.innerHTML = component
            container_mensajes.scrollTo(0, container_mensajes.scrollHeight)
            count_menssage = data.length
        })
        $mensaje_send.value = ""
        $button_send.disabled = true

    }

})
    