
document.addEventListener('DOMContentLoaded', function () {
    var formUsuario = documet.querySelector('#formUsuario'); 
    formUsuario.onsubmit = function(e){
        e.preventDefault();
        var strIdentificacion = document.querySelector('#txtIdentificacion');
        var strNombre = document.querySelector('#txtNombre');
        var strApellido = document.querySelector('#txtApellido');
        var strEmail = document.querySelector('#txtEmail');
        var intTelefono = document.querySelector('#txtTelefono');
        var intTipoUsuario = document.querySelector('#listRolid');
        var strPassword = document.querySelector('#txtPassword');

        

    }
}, false);

window.addEventListener('load', function(){//Esta es la funcion que ejecuta  la funcion fntRolesUsuario();
        fntRolesUsuario();
}, false);

function fntRolesUsuario() {
    var ajaxUrl = base_url+'/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');//Valida si es un vegador Chrome o firefox y se obtiene el objeto correspondiente al navegador 
    request.open("GET",ajaxUrl,true);
    request.send(); 

    request.onreadystatechange = function() {//esta funcion obtiene los resultados del ajax
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#listRolid').innerHTML = request.responseText;//Esto le da respuesta  del getSlectRoles del controlador Roles.php
            document.querySelector('#listRolid').value = 1;
            $('#listRolid').selectpicker('render');
        }
    }    
}

function openModal() {
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector('#idUsuario').value="";//Es el id del input tipo hiden que resetea la modal
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");//cambia 
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}