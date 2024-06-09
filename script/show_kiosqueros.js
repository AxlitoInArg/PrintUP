const container_kiosqueros = document.querySelector(".container_kiosqueros");

const get_kiosqueros = async () => {
    try {
        const response = await fetch("/api/get_kiosqueros.php?user_id=" + ud);
        const data = await response.json()
        return data
    } catch (error) {
        return []
    }
}
get_kiosqueros().then(data => {
    let component = data.map(({ Nombres, Ultimo_Mensaje, Mensaje, perfil_img, ID_Kiosquero }) => {
        return /*html*/`<a href="/chat.php?c=${ID_Kiosquero}" class="chat"><img src="/img/${perfil_img}" alt="" class="chat__img"><div class="chat_container"><div><span class="chat_container_name">${Nombres}</span><span class="chat_container_date">${Ultimo_Mensaje ?? ""}</span></div><div class="chat_container_mensagge">${Mensaje ?? ""}</div></div></a>`
    });
    container_kiosqueros.innerHTML = component.join("")
})