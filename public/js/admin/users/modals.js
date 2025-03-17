function openUserModal() {
    document.getElementById('userModal').classList.remove('hidden');
    document.getElementById("userForm").onsubmit = function (event) {
        Crearusuario(event);
    };
    document.getElementById("userForm").reset();
}

function closeUserModal() {
    document.getElementById('userModal').classList.add('hidden');

    const btfrmcrear = document.getElementById('btfrmcrear');
    btfrmcrear.innerHTML = 'Crear Usuario';
    document.getElementById("userForm").onsubmit = function (event) {
        Crearusuario(event);
    };
    const errorMessages = document.querySelectorAll('.text-red-500');
    errorMessages.forEach(function (error) {
        error.classList.add('hidden');
    });
    document.getElementById("userForm").reset();
}