function openModal() {
    //Configuracion de Apariencia
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProducto").reset();
    $('#modalFormProductos').modal('show');
    removePhoto();// se añade esta fucion para quitar la foto vista en editar categoria
}