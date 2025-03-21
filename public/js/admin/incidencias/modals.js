function openIncidenciaModal() {
    var form = document.getElementById("incidenciaForm")
    document.getElementById('incidenciaModal').classList.remove('hidden');
    form.onsubmit = function (event) {
        crearincidencia(event);
    };
    form.reset();
}

function closeIncidenciaModal() {
    var form = document.getElementById("incidenciaForm")
    document.getElementById('incidenciaModal').classList.add('hidden');
    form.onsubmit = function (event) {
        crearincidencia(event);
    };
    const errorMessages = document.querySelectorAll('.text-red-500');
    errorMessages.forEach(function (error) {
        error.classList.add('hidden');
    });
    const modalTitle = document.getElementById('modalTitle');
    modalTitle.innerText = 'Crear Nueva Incidencia';
    form.reset();
}

window.onclick = function (event) {
    if (event.target == document.getElementById('incidenciaModal')) {
        closeIncidenciaModal();
    }
}
// Modal para cerrar sesion
const userMenuButton = document.getElementById('user-menu-button');
const userMenu = document.getElementById('user-menu');

userMenuButton.addEventListener('click', () => {
    userMenu.classList.toggle('hidden');
});

document.addEventListener('click', (event) => {
    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.add('hidden');
    }
});