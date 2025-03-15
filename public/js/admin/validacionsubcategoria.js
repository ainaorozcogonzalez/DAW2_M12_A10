document.addEventListener('DOMContentLoaded', () => {
    // Asignar eventos keyup a los inputs
    document.getElementById('nombre_subcategoria_modal').addEventListener('keyup', validarDescripcion);
    // Asignar eventos change al select para la categoría
    document.getElementById('categoria_id_subcategoria').addEventListener('change', validarCategoria);
});

// ✅ Validar nombre de subcategoría
function validarDescripcion() {
    const nombreSubcategoria = document.getElementById('nombre_subcategoria_modal').value.trim();
    const error = document.getElementById('nombre_subcategoria_modal-error');

    if (nombreSubcategoria === "") {
        error.innerText = "El nombre de la subcategoría es obligatorio";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar categoría seleccionada (select)
function validarCategoria() {
    const categoriaId = document.getElementById('categoria_id_subcategoria').value;
    const error = document.getElementById('categoria_id_subcategoria-error');

    if (categoriaId === "") {
        error.innerText = "Seleccione una categoría";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validación antes de enviar el formulario
function validarFormulariosubcategoria(event) {
    event.preventDefault();
    const isValid = validarDescripcion() & validarCategoria();
    return isValid;
}

function crearsubcategoria(event) {
    if (!validarFormulariosubcategoria(event)) {
        return;
    }
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
                form.reset();  // Reset form fields after submission
                datosadicionales();  // Assuming this is a function to update additional data
                document.getElementById('subcategoriaModal').classList.add('hidden');  // Close modal
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
