function openUserModal() {
    document.getElementById('userModal').classList.remove('hidden');
    document.getElementById("userForm").onsubmit = function (event) {
        event.preventDefault();
        Crearusuario();
    };
    document.getElementById("userForm").reset();
}

function closeUserModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById("userForm").onsubmit = function (event) {
        event.preventDefault();
        Crearusuario();
    };
    document.getElementById("userForm").reset();
}