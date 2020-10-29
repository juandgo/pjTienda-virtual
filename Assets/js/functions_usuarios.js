
function openModal() {
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector('#idUsuario').value="";//Es el id del input tipo hiden que resetea la modal
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");//cambia 
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
} 