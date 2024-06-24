const container_kiosqueros = document.querySelector(".container_kiosqueros");

const get_kiosqueros = async () => {
    try {
        const response = await fetch(`/api/${at ? "get_kiosqueros.php" :"get_usuarios.php"}?user_id=${ud}`);
        const data = await response.json()
        return data
    } catch (error) {
        return []
    }
}
get_kiosqueros().then(data => {
    let component = data.map(({ Nombre_Completo, Ultimo_Mensaje, Mensaje, perfil_img, DNI_Usuario }) => {
        return /*html*/`<a href="/chat.php?receptor=${DNI_Usuario}" class="chat"><img src="/img/${perfil_img}" alt="" class="chat__img"><div class="chat_container"><div><span class="chat_container_name">${Nombre_Completo}</span><span class="chat_container_date">${(Ultimo_Mensaje ?? "").slice(0, -3)}</span></div><div class="chat_container_mensagge">${Mensaje ?? ""}</div></div></a>`
    }).join("");
    container_kiosqueros.innerHTML = component;
})
