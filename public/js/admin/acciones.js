
function Crearusuario() {
    let alerts = document.getElementById("alerts");
    var form = document.getElementById("userForm");
    var formData = new FormData(form);
    fetch("/users/admincrearusuario", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);

            alerts.innerHTML = "";
            let respuesta = ""
            if (primeraParte == "Creado") {
                respuesta += '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else if ("Error") {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            }
        })
}

function crearincidencia() {
    let alerts = document.getElementById("alerts");
    var form = document.getElementById("incidenciaForm");
    var formData = new FormData(form);
    fetch("/incidencias/admincrearincidencia", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);

            alerts.innerHTML = "";
            let respuesta = ""
            if (primeraParte == "Creado") {
                respuesta += '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else if ("Error") {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            }
        })
}

function crearcategoria() {
    let alerts = document.getElementById("alerts");
    var form = document.getElementById("categoriaForm");
    var formData = new FormData(form);
    fetch("/categorias/admincrearcategoria", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);

            alerts.innerHTML = "";
            let respuesta = ""
            if (primeraParte == "Creado") {
                respuesta += '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else if ("Error") {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            }
        })
}

function crearsubcategoria() {
    let alerts = document.getElementById("alerts");
    var form = document.getElementById("subcategoriaForm");
    var formData = new FormData(form);
    fetch("/subcategorias/admincrearsubcategoria", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);

            alerts.innerHTML = "";
            let respuesta = ""
            if (primeraParte == "Creado") {
                respuesta += '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else if ("Error") {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            } else {
                respuesta += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                respuesta += ' <span class="block sm:inline">' + resto + '</span>';
                respuesta += '</div>';
                alerts.innerHTML += respuesta;
            }
        })
}