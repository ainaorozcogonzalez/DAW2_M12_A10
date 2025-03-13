
function Crearusuario() {
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
            if (primeraParte == 'success') {
                form.reset()
                datosadicionales()
                document.getElementById('userModal').classList.add('hidden');
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });

        })
}

function crearincidencia() {
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
            if (primeraParte == 'success') {
                form.reset()
                datosadicionales()
                document.getElementById('incidenciaModal').classList.add('hidden');
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}

function crearcategoria() {
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
            if (primeraParte == 'success') {
                form.reset()
                datosadicionales()
                document.getElementById('categoriaModal').classList.add('hidden');
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}

function crearsubcategoria() {
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
            if (primeraParte == 'success') {
                form.reset()
                datosadicionales()
                document.getElementById('subcategoriaModal').classList.add('hidden');
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
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
    let mostrarestado = document.getElementsByClassName("mostrar_estado");
    let mostrarprioridades = document.getElementsByClassName("mostrar_prioridades");
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
                prioridades.innerHTML = "";
                data.prioridad.forEach(prioridad => {
                    let respuesta = ""
                    respuesta += ' <option value="' + prioridad.id + '" >' + prioridad.nombre + '</option>';
                    prioridades.innerHTML += respuesta;
                });
            });

            Array.from(mostrarestado).forEach(estados => {
                estados.innerHTML = "";
                data.estadosincidenas.forEach(estadoincidensia => {
                    let respuesta = ""
                    respuesta += ' <option value="' + estadoincidensia.id + '" >' + estadoincidensia.nombre + '</option>';
                    estados.innerHTML += respuesta;
                });
            });

            Array.from(mostrarclientes).forEach(clientes => {
                clientes.innerHTML = "";
                data.clientes.forEach(cliente => {
                    let respuesta = ""
                    respuesta += ' <option value="' + cliente.id + '" >' + cliente.nombre + '</option>';
                    clientes.innerHTML += respuesta;
                });
            });

            Array.from(mostrarsubcategorias).forEach(subcategorias => {
                subcategorias.innerHTML = "";
                data.subcategorias.forEach(subcategoria => {
                    let respuesta = ""
                    respuesta += ' <option value="' + subcategoria.id + '" >' + subcategoria.nombre + '</option>';
                    subcategorias.innerHTML += respuesta;
                });
            });

            Array.from(mostrarcategorias).forEach(categorias => {
                categorias.innerHTML = "";
                data.categorias.forEach(categoria => {
                    let respuesta = ""
                    respuesta += ' <option value="' + categoria.id + '" >' + categoria.nombre + '</option>';
                    categorias.innerHTML += respuesta;
                });
            });

            Array.from(mostrarroles).forEach(rols => {
                rols.innerHTML = "";
                data.roles.forEach(rol => {
                    let respuesta = ""
                    respuesta += ' <option value="' + rol.id + '" >' + rol.nombre + '</option>';
                    rols.innerHTML += respuesta;
                });
            });

            Array.from(mostrarsedes).forEach(sedes => {
                sedes.innerHTML = "";
                data.sedes.forEach(sede => {
                    sedes.innerHTML += ' <option value="' + sede.id + '" >' + sede.nombre + '</option>';
                });
            });

            Array.from(mostrar_estadousuario).forEach(mostrarestado => {
                mostrarestado.innerHTML = "";
                data.estados.forEach(estado => {
                    mostrarestado.innerHTML += ' <option value="' + estado + '" >' + estado + '</option>';
                });
            });
        })
}