function openChatModal(incidenciaId) {
    document.getElementById('chatIncidenciaId').value = incidenciaId;
    document.getElementById('chatModal').classList.remove('hidden');
    cargarMensajes(incidenciaId);
}

function closeChatModal() {
    document.getElementById('chatModal').classList.add('hidden');
}

function cargarMensajes(incidenciaId) {
    const userId = document.body.getAttribute('data-user-id');
    fetch(`/incidencias/${incidenciaId}/mensajes`)
        .then(response => response.json())
        .then(data => {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.innerHTML = data.map(mensaje => `
                <div class="mb-2 ${mensaje.usuario_id == userId ? 'text-right' : 'text-left'}">
                    <div class="inline-block max-w-2/3 px-4 py-2 rounded-lg ${mensaje.usuario_id == userId ? 'bg-blue-100' : 'bg-gray-100'}">
                        ${mensaje.mensaje ? `<p class="text-sm">${escapeHtml(mensaje.mensaje)}</p>` : ''}
                        ${mensaje.archivo ? `<a href="${mensaje.archivo.url_archivo}" target="_blank" class="text-blue-500 hover:text-blue-700">Ver archivo adjunto</a>` : ''}
                        <p class="text-xs text-gray-500 mt-1">${new Date(mensaje.created_at).toLocaleString()}</p>
                    </div>
                </div>
            `).join('');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
}

// Función para escapar HTML
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chatForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Primero validamos el formulario
            if (!validateForm()) {
                e.preventDefault();  // Detenemos el envío si la validación falla
                return;
            }

            e.preventDefault();
            
            const formData = new FormData(this);
            const archivo = formData.get('archivo');
            const mensaje = formData.get('mensaje');

            // Verificar que al menos uno de los campos esté presente
            if (!mensaje?.trim() && !archivo) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes escribir un mensaje o adjuntar un archivo.',
                });
                return;
            }

            // Verificar el tipo MIME del archivo solo si se adjunta uno
            if (archivo && archivo.size > 0 && !['image/jpeg', 'image/png', 'application/pdf', 'image/webp', 'application/zip', 'application/x-rar-compressed', 'application/x-tar', 'application/gzip'].includes(archivo.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de archivo',
                    text: 'El archivo debe ser de tipo JPG, JPEG, PNG, PDF, WEBP, ZIP, RAR, TAR o GZ.',
                });
                return;
            }

            fetch('/incidencias/mensajes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    cargarMensajes(document.getElementById('chatIncidenciaId').value);
                    document.getElementById('chatMensaje').value = '';
                    document.getElementById('chatArchivo').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.',
                });
            });
        });
    } else {
        console.error('Formulario no encontrado');
    }

    // Asegurarse de que se asignen los listeners correctamente
    asignarEventListeners();
});

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    if (event.target == document.getElementById('chatModal')) {
        closeChatModal();
    }
}

function validateForm() {
    const mensaje = document.getElementById('chatMensaje').value.trim();
    const archivo = document.getElementById('chatArchivo').files[0];
    
    if (!mensaje && !archivo) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes escribir un mensaje o adjuntar un archivo.',
        });
        return false;
    }
    return true;
}

document.getElementById('chatArchivo').addEventListener('change', function(e) {
    const archivo = e.target.files[0];
    const label = document.querySelector('label[for="chatArchivo"]');
    
    if (archivo) {
        const tiposAceptados = [
            'image/jpeg', 
            'image/png', 
            'application/pdf', 
            'image/webp', 
            'application/zip', 
            'application/x-rar-compressed', 
            'application/x-tar', 
            'application/gzip'
        ];
        
        if (!tiposAceptados.includes(archivo.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de archivo',
                text: 'El archivo debe ser de tipo JPG, JPEG, PNG, PDF, WEBP, ZIP, RAR, TAR o GZ.',
            });
            e.target.value = '';  // Limpiar el input de archivo
            label.innerHTML = `<i class="fas fa-paperclip"></i><span>Adjuntar archivo</span>`;
        } else {
            label.innerHTML = `<i class="fas fa-check-circle"></i><span>${archivo.name}</span>`;
        }
    } else {
        label.innerHTML = `<i class="fas fa-paperclip"></i><span>Adjuntar archivo</span>`;
    }
});

// Función para manejar el cambio de estado
function manejarCambioEstado(e) {
    const select = e.target;
    const form = select.closest('form');
    if (!form) {
        console.error('No se encontró el formulario');
        return;
    }

    const incidenciaId = form.action.split('/').pop();
    const estadoId = select.value;
    const nuevoEstado = select.options[select.selectedIndex].text;

    // Seleccionar la tarjeta de la incidencia
    const card = select.closest('.bg-white');
    if (!card) {
        console.error('No se encontró la tarjeta de la incidencia');
        return;
    }

    // Seleccionar el span del estado de manera más precisa
    const estadoSpan = card.querySelector('.estado-badge');
    if (!estadoSpan) {
        console.error('No se encontró el elemento estado-badge');
        return;
    }

    // Deshabilitar el select mientras se procesa el cambio
    select.disabled = true;

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ estado_id: estadoId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Actualizar el texto del estado
            estadoSpan.textContent = nuevoEstado;
    
            // Remover todas las clases de estado anteriores
            estadoSpan.classList.remove('bg-yellow-100', 'text-yellow-800',
                                        'bg-blue-100', 'text-blue-800',
                                        'bg-green-100', 'text-green-800',
                                        'bg-gray-100', 'text-gray-800');
    
            // Agregar las nuevas clases según el estado
            if (nuevoEstado == 'Pendiente') {
                estadoSpan.classList.add('bg-yellow-100', 'text-yellow-800');
            } else if (nuevoEstado == 'En progreso') {
                estadoSpan.classList.add('bg-blue-100', 'text-blue-800');
            } else if (nuevoEstado == 'Resuelta') {
                estadoSpan.classList.add('bg-green-100', 'text-green-800');
            } else {
                estadoSpan.classList.add('bg-gray-100', 'text-gray-800');
            }

            // Mostrar SweetAlert de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Estado actualizado!',
                text: `El estado de la incidencia se ha cambiado a "${nuevoEstado}".`,
                timer: 2000, // Cierra automáticamente después de 2 segundos
                showConfirmButton: false
            });
        } else {
            throw new Error('No se pudo cambiar el estado');
        }
    })
    
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al cambiar el estado. Por favor, inténtalo de nuevo.',
        });
    })
    .finally(() => {
        // Rehabilitar el select después de procesar el cambio
        select.disabled = false;
    });
}

function asignarEventListeners() {
    // Eliminar todos los listeners existentes primero
    document.querySelectorAll('.cambiar-estado-form select').forEach(select => {
        select.removeEventListener('change', manejarCambioEstado);
    });

    // Agregar los nuevos listeners
    document.querySelectorAll('.cambiar-estado-form select').forEach(select => {
        select.addEventListener('change', manejarCambioEstado);
    });
    
    // Reasignar el listener para abrir el chat
    document.querySelectorAll('[onclick^="openChatModal"]').forEach(button => {
        button.removeEventListener('click', openChatModal);
        button.addEventListener('click', function() {
            const incidenciaId = this.getAttribute('onclick').match(/\d+/)[0];
            openChatModal(incidenciaId);
        });
    });
}
