
// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', (event) => {
    const incidenciaModal = document.getElementById('incidenciaModal');
    const categoriaModal = document.getElementById('categoriaModal');
    const subcategoriaModal = document.getElementById('subcategoriaModal');
    const userModal = document.getElementById('userModal');
    if (event.target == userModal) {
        closeUserModal();
    }
    if (event.target == incidenciaModal) {
        closeIncidenciaModal();
    }
    if (event.target == categoriaModal) {
        closeCategoriaModal();
    }
    if (event.target == subcategoriaModal) {
        closeSubcategoriaModal();
    }
});

// modal usuarios
function openUserModal() {
    var form = document.getElementById("userForm");
    form.reset()
    document.getElementById('userModal').classList.remove('hidden');
}

function closeUserModal() {
    var form = document.getElementById("userForm");
    form.reset()
    const errorMessages = document.querySelectorAll('.text-red-500');
    errorMessages.forEach(function (error) {
        error.classList.add('hidden');
    });
    document.getElementById('userModal').classList.add('hidden');
}

//modal incidencias

function openIncidenciaModal() {
    var form = document.getElementById("incidenciaForm");
    form.reset()
    document.getElementById('incidenciaModal').classList.remove('hidden');
}

function closeIncidenciaModal() {
    var form = document.getElementById("incidenciaForm");
    form.reset()
    const errorMessages = document.querySelectorAll('.text-red-500');
    errorMessages.forEach(function (error) {
        error.classList.add('hidden');
    });
    document.getElementById('incidenciaModal').classList.add('hidden');
}

// modal categoria

function openCategoriaModal() {
    var form = document.getElementById("categoriaForm");
    form.reset()
    document.getElementById('categoriaModal').classList.remove('hidden');
}

function closeCategoriaModal() {
    var form = document.getElementById("categoriaForm");
    form.reset()
    const errorMessages = document.querySelectorAll('.text-red-500');
    errorMessages.forEach(function (error) {
        error.classList.add('hidden');
    });
    document.getElementById('categoriaModal').classList.add('hidden');
}

function openSubcategoriaModal() {
    var form = document.getElementById("subcategoriaForm");
    form.reset()
    document.getElementById('subcategoriaModal').classList.remove('hidden');
}

function closeSubcategoriaModal() {
    var form = document.getElementById("subcategoriaForm");
    form.reset()
    const errorMessages = document.querySelectorAll('.text-red-500');
    errorMessages.forEach(function (error) {
        error.classList.add('hidden');
    });
    document.getElementById('subcategoriaModal').classList.add('hidden');
}


datosadicionales()

function datosadicionales() {
    let mostrarroles = document.getElementsByClassName("mostrar_roles");
    let mostrarsedes = document.getElementsByClassName("mostrar_sedes");
    let mostrar_estadousuario = document.getElementsByClassName("mostrar_estadousuario");
    let nombreusuario = document.getElementsByClassName("nombreusuario");

    let totalusuarios = document.getElementById("totalusuarios");
    let totalincidencias = document.getElementById("totalincidencias");

    let mostrarsubcategorias = document.getElementsByClassName("mostrar_subcategorias");
    let mostrarcategorias = document.getElementsByClassName("mostrar_categorias");
    let mostrarclientes = document.getElementsByClassName("mostrar_clientes");
    let mostrarestado = document.getElementsByClassName("mostrar_estado_incidencia");
    let mostrarprioridades = document.getElementsByClassName("prioridad_id_incidencia");
    var form = document.getElementById("subcategoriaForm");
    var formData = new FormData(form);
    fetch("/users/datosusuarios", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {

            Array.from(nombreusuario).forEach(element => {
                element.innerHTML = "";
                element.innerHTML += data.nombre;
            });

            totalusuarios.innerHTML = "";
            totalusuarios.innerHTML = data.totalusers;

            totalincidencias.innerHTML = "";
            totalincidencias.innerHTML = data.totalincidencias;

            mostrarroles.innerHTML = "";
            mostrarprioridades.innerHTML = "";
            mostrarsedes.innerHTML = "";
            mostrar_estadousuario.innerHTML = "";
            mostrarcategorias.innerHTML = "";
            mostrarsubcategorias.innerHTML = "";
            mostrarclientes.innerHTML = "";
            mostrarestado.innerHTML = "";


            Array.from(mostrarprioridades).forEach(prioridades => {
                prioridades.innerHTML = '<option value="" >Seleccionar una prioridad</option>';
                data.prioridad.forEach(prioridad => {
                    let respuesta = ""
                    respuesta += ' <option value="' + prioridad.id + '" >' + prioridad.nombre + '</option>';
                    prioridades.innerHTML += respuesta;
                });
            });

            Array.from(mostrarestado).forEach(estados => {
                estados.innerHTML = '<option value="" >Seleccionar una estado</option>';
                data.estadosincidenas.forEach(estadoincidensia => {
                    let respuesta = ""
                    respuesta += ' <option value="' + estadoincidensia.id + '" >' + estadoincidensia.nombre + '</option>';
                    estados.innerHTML += respuesta;
                });
            });

            Array.from(mostrarclientes).forEach(clientes => {
                clientes.innerHTML = '<option value="" >Seleccionar un cliente</option>';
                data.clientes.forEach(cliente => {
                    let respuesta = ""
                    respuesta += ' <option value="' + cliente.id + '" >' + cliente.nombre + '</option>';
                    clientes.innerHTML += respuesta;
                });
            });

            Array.from(mostrarsubcategorias).forEach(subcategorias => {
                subcategorias.innerHTML = '<option value="" >Seleccionar una subcategoria</option>';
                data.subcategorias.forEach(subcategoria => {
                    let respuesta = ""
                    respuesta += ' <option value="' + subcategoria.id + '" >' + subcategoria.nombre + '</option>';
                    subcategorias.innerHTML += respuesta;
                });
            });

            Array.from(mostrarcategorias).forEach(categorias => {
                categorias.innerHTML = '<option value="" >Seleccionar una categoria</option>';
                data.categorias.forEach(categoria => {
                    let respuesta = ""
                    respuesta += ' <option value="' + categoria.id + '" >' + categoria.nombre + '</option>';
                    categorias.innerHTML += respuesta;
                });
            });

            Array.from(mostrarroles).forEach(rols => {
                rols.innerHTML = '<option value="" >Seleccionar una rol</option>';
                data.roles.forEach(rol => {
                    let respuesta = ""
                    respuesta += ' <option value="' + rol.id + '" >' + rol.nombre + '</option>';
                    rols.innerHTML += respuesta;
                });
            });

            Array.from(mostrarsedes).forEach(sedes => {
                sedes.innerHTML = '<option value="" >Seleccionar una sede</option>';
                data.sedes.forEach(sede => {
                    sedes.innerHTML += ' <option value="' + sede.id + '" >' + sede.nombre + '</option>';
                });
            });

            Array.from(mostrar_estadousuario).forEach(mostrarestado => {
                mostrarestado.innerHTML = '';
                data.estados.forEach(estado => {
                    mostrarestado.innerHTML += ' <option value="' + estado + '" >' + estado + '</option>';
                });
            });
        })
}


// Manejar el menú desplegable
const userMenuButton = document.getElementById('user-menu-button');
const userMenu = document.getElementById('user-menu');

userMenuButton.addEventListener('click', () => {
    userMenu.classList.toggle('hidden');
});

// Cerrar el menú si se hace clic fuera de él
document.addEventListener('click', (event) => {
    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.add('hidden');
    }
});

// Cerrar modal al hacer clic fuera de él





