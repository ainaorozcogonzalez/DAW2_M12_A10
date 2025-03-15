document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('nombre_categoria_modal').addEventListener('keyup', validarNombreCategoria);
});

// ✅ Validar nombre de la categoría
function validarNombreCategoria() {
    const nombreCategoria = document.getElementById('nombre_categoria_modal').value.trim();
    const error = document.getElementById('nombre_categoria_modal-error');

    if (nombreCategoria === "") {
        error.innerText = "El nombre de la categoría es obligatorio";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validación antes de enviar el formulario
function validarFormulariocategoria(event) {
    event.preventDefault();
    const isValid = validarNombreCategoria();
    return isValid;
}

// Función para crear categoría
function crearcategoria(event) {
    if (!validarFormulariocategoria(event)) {
        return;
    }
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
                form.reset();
                datosadicionales();
                document.getElementById('categoriaModal').classList.add('hidden');
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}
