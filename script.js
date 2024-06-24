function changeProfilePic(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const profilePicPreview = document.getElementById('profile-pic-preview');
        profilePicPreview.src = reader.result;
        document.getElementById('profile-link').innerHTML = `<i class="fas fa-user"></i> <img src="${reader.result}" alt="Foto de Perfil">`;
    };
    reader.readAsDataURL(event.target.files[0]);
}

function changeTheme(event) {
    const selectedTheme = event.target.value;
    document.body.className = selectedTheme;
}
document.addEventListener('DOMContentLoaded', (event) => {
    const savedProfilePic = localStorage.getItem('profilePic');
    const savedTheme = localStorage.getItem('theme');

    if (savedProfilePic) {
        updateProfilePic(savedProfilePic);
    }

    if (savedTheme) {
        document.body.className = savedTheme;
        const themeSelect = document.getElementById('theme-select');
        if (themeSelect) {
            themeSelect.value = savedTheme;
        }
    }
});

function changeProfilePic(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const profilePicSrc = reader.result;
        localStorage.setItem('profilePic', profilePicSrc);
        updateProfilePic(profilePicSrc);
    };
    reader.readAsDataURL(event.target.files[0]);
}

function updateProfilePic(src) {
    const profilePicPreview = document.getElementById('profile-pic-preview');
    if (profilePicPreview) {
        profilePicPreview.src = src;
    }
    const profileLink = document.getElementById('profile-link');
    profileLink.innerHTML = `<img src="${src}" alt="Foto de Perfil">`;
}

function changeTheme(event) {
    const selectedTheme = event.target.value;
    document.body.className = selectedTheme;
    localStorage.setItem('theme', selectedTheme);
}

// Función para cambiar al modo oscuro
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}

// Mantener la imagen del perfil visible en la barra de navegación
const profileIcon = document.getElementById('profile-icon');
const profileImg = profileIcon.querySelector('img');

// Función para cambiar el fondo a un degradado de negro a gris en el modo oscuro
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const darkMode = document.body.classList.contains('dark-mode');
    if (darkMode) {
        document.body.style.background = 'linear-gradient(to bottom, #000000, #808080)';
    } else {
        document.body.style.background = '';
    }
}

// Función para mantener la imagen del perfil visible
function updateProfileIcon() {
    const scrollTop = window.scrollY;
    if (scrollTop > 60) {
        profileIcon.style.opacity = '0';
    } else {
        profileIcon.style.opacity = '1';
    }
}

// Llamar a la función al cargar la página y al desplazarse
window.onload = updateProfileIcon;
window.onscroll = updateProfileIcon;

