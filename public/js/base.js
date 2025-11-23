document.body.addEventListener('htmx:configRequest', (event) => {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    event.detail.headers['X-CSRF-TOKEN'] = token;
});



const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const closeSidebar = document.getElementById('closeSidebar');

const btnNotifDesktop = document.getElementById('btnNotifDesktop');
const btnNotifMobile = document.getElementById('btnNotifMobile');



[btnNotifDesktop, btnNotifMobile].forEach(btn => {
    btn?.addEventListener('click', () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    });
});

closeSidebar.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
});








document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.buttonMore');

    buttons.forEach(button => {
        const menu = button.querySelector('.menuMore');

        button.addEventListener('click', (event) => {
            event.stopPropagation();


            document.querySelectorAll('.menuMore.openMenuMore').forEach(m => {
                if (m !== menu) m.classList.remove('openMenuMore');
            });

            menu.classList.toggle('openMenuMore');
        });
    });

    // Fecha o menu se clicar fora
    document.addEventListener('click', (event) => {
        document.querySelectorAll('.menuMore.openMenuMore').forEach(menu => {
            if (!menu.contains(event.target)) {
                menu.classList.remove('openMenuMore');
            }
        });
    });
});



const anim = lottie.loadAnimation({
    container: document.getElementById('animacao'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: '../imagens/astronaut.json'
});



const fileInput = document.getElementById('fileInput');
const preview = document.getElementById('preview');
const placeholder = document.getElementById('placeholder');



fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});




