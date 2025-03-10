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
                        <p class="text-sm">${mensaje.mensaje}</p>
                        ${mensaje.archivo ? `<a href="${mensaje.archivo.url_archivo}" target="_blank" class="text-blue-500 hover:text-blue-700">Ver archivo adjunto</a>` : ''}
                        <p class="text-xs text-gray-500 mt-1">${new Date(mensaje.created_at).toLocaleString()}</p>
                    </div>
                </div>
            `).join('');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chatForm');
    if (form) {
        console.log('Formulario encontrado');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario enviado');
            
            const formData = new FormData(this);
            const archivo = formData.get('archivo');
            const mensaje = formData.get('mensaje');

            // Verificar que al menos uno de los campos esté presente
            if (!mensaje && !archivo) {
                alert('Debes escribir un mensaje o adjuntar un archivo.');
                return;
            }

            // Verificar el tipo MIME del archivo solo si se adjunta uno
            if (archivo && archivo.size > 0 && !['image/jpeg', 'image/png', 'application/pdf'].includes(archivo.type)) {
                alert('El archivo debe ser de tipo JPG, JPEG, PNG o PDF.');
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
                console.log('Respuesta del servidor:', response);
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if(data.success) {
                    cargarMensajes(document.getElementById('chatIncidenciaId').value);
                    document.getElementById('chatMensaje').value = '';
                    document.getElementById('chatArchivo').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.');
            });
        });
    } else {
        console.error('Formulario no encontrado');
    }
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
        alert('Debes escribir un mensaje o adjuntar un archivo.');
        return false;
    }
    return true;
}
