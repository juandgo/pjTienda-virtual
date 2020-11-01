
document.addEventListener('DOMContentLoaded', function () {

    tableRoles = $('#tableUsuarios').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"//fromato json con configuracion del lenguaje en español
        },
        "ajax":{
            "url": ""+base_url+"/Usuarios/getUsuarios",
            "dataSrc": ""
        },
        "columns":[
            {"data":"idpersona"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},
            {"data":"nombrerol"},
            {"data":"status"},
            {"data":"options"}

        ],
        "responsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
       });
    var formUsuario = document.querySelector('#formUsuario'); 
    formUsuario.onsubmit = function(e){
        e.preventDefault();
        var strIdentificacion = document.querySelector('#txtIdentificacion').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strApellido = document.querySelector('#txtApellido').value;
        var strEmail = document.querySelector('#txtEmail').value;
        var intTelefono = document.querySelector('#txtTelefono').value;
        var intTipoUsuario = document.querySelector('#listRolid').value;
        var strPassword = document.querySelector('#txtPassword').value;
        //Esto probablemente no se va a usar debido a que los campos en html son requeridos
        if (strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || intTelefono =='' || intTipoUsuario =='') {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Usuarios/setUsuario';
        var formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData); 
        request.onreadystatechange = function() {//esta funcion obtiene los resultados del ajax
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#modalFormUsuario').modal("hide");
                    formUsuario.reset();
                    swal("Usuarios", objData.msg ,"success");
                    tableUsuarios.api().ajaxUrl.reload(function(){
                    });
                }else{
                    swal("Error", objData.msg, "error");
                } 
            }    
        }    
    }
}, false);

window.addEventListener('load', function(){//Esta es la funcion que ejecuta todas la funciones del modulo usuario
    fntRolesUsuario();
    fntVewUsuario(); 
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

function fntVewUsuario() {
    var btnViewUsuario = document.querySelectorAll(".btnViewUsuario");
    btnViewUsuario.forEach(function(btnViewUsuario){
        btnViewUsuario.addEventListener('click', function() {
            var idpersona = this.getAttribute('us');//usuario 
            var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send(); 

            $('#modalViewUser').modal('show');//muestra model por su id
        });
    });
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