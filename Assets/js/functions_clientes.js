document.addEventListener('DOMContentLoaded', function(){
    if (document.querySelector('#formCliente')) {
        var formCliente = document.querySelector('#formCliente'); 
        formCliente.onsubmit = function(e){
            e.preventDefault();
            var strIdentificacion = document.querySelector('#txtIdentificacion').value;
            var strNombre = document.querySelector('#txtNombre').value;
            var strApellido = document.querySelector('#txtApellido').value;
            var strEmail = document.querySelector('#txtEmail').value;
            var intTelefono = document.querySelector('#txtTelefono').value;
            var strNit = document.querySelector('#txtNit').value;
            var strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
            var strDirFiscal = document.querySelector('#txtDirFiscal').value;
            var strPassword = document.querySelector('#txtPassword').value;
            //Esto probablemente no se va a usar debido a que los campos en html son requeridos
            if (strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || intTelefono =='' || strNit =='' || strNombreFiscal =='' || strDirFiscal =='') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            //valida que los campos sean correctos 
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    swal("!Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }
            divLoading.style.display = "flex";// se le da un estilo al loading y comienza la animacion
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Clientes/setCliente';
            var formData = new FormData(formCliente);
            request.open("POST",ajaxUrl,true);
            request.send(formData); 
            request.onreadystatechange = function() {//esta funcion obtiene los resultados del ajax
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status){
                        $('#modalFormCliente').modal("hide");
                        formUsuario.reset();
                        swal("Usuarios", objData.msg ,"success");
                        //tableUsuarios.api().ajax.reload();
                    }else{
                        swal("Error", objData.msg, "error");
                    } 
                } 
                divLoading.style.display = "none";//oculta la animacion loading cuando termine de cargar 
                return false;        
            }    
        }
    }

}, false);

function openModal() {
    //Configuracion de Apariencia
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector("#formCliente").reset();
    $('#modalFormCliente').modal('show');
}