function openIncidenciaModal() {
    var form = document.getElementById("incidenciaForm")
    document.getElementById('incidenciaModal').classList.remove('hidden');
    form.onsubmit = function (event) {
        event.preventDefault();
        crearincidencia();
    };
    form.reset();
}

function closeIncidenciaModal() {
    var form = document.getElementById("incidenciaForm")
    document.getElementById('incidenciaModal').classList.add('hidden');
    form.onsubmit = function (event) {
        event.preventDefault();
        crearincidencia();
    };
    form.reset();
}