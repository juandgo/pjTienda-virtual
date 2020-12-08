function openModal() {
    //Configuracion de Apariencia
    document.querySelector('#idCategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategorias').modal('show');
}