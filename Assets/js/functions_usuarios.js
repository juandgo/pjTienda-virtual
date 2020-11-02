
document.addEventListener('DOMContentLoaded', function () {

    tableUsuarios = $('#tableUsuarios').dataTable({
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
    //Registrar un Usuario 
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
                    tableUsuarios.api().ajax.reload(function(){
                        fntRolesUsuario();
                        fntViewUsuario(); 
                        fntEditUsuario();
                        fntDelUsuario();
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
    fntViewUsuario(); 
    fntEditUsuario();
    fntDelUsuario();
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

function fntViewUsuario() {
    var btnViewUsuario = document.querySelectorAll(".btnViewUsuario");
    btnViewUsuario.forEach(function(btnViewUsuario){
        btnViewUsuario.addEventListener('click', function() {
            var idpersona = this.getAttribute('us');//usuario 
            var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send(); 
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);

                    if (objData.status) {
                        var estadoUsuario = objData.data.status == 1 ?
                        '<span class="badge badge-success">Activo</span>' :
                        '<span class="badge badge-danger">Inactivo</span>' ;
                        //Agarra los valores
                        document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                        document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                        document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                        document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                        document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                        document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
                        document.querySelector("#celEstado").innerHTML = estadoUsuario;
                        document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                        $('#modalViewUser').modal('show');//muestra model por su id
                    }else{
                        swal("Error, objData.msg, error");
                    }
                }

            }
            
        });
    });
}

function fntEditUsuario() {
    var btnEditUsuario = document.querySelectorAll(".btnEditUsuario");
    btnEditUsuario.forEach(function(btnEditUsuario){
        btnEditUsuario.addEventListener('click', function() {
            //Configuracion de Apariencia
            document.querySelector('#titleModal').innerHTML = "Acatualizar Usuario";
            document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate" );
            document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
            document.querySelector('#btnText').innerHTML = "Acatualizar";

            var idpersona = this.getAttribute('us');//obtine el id del usuario 
            var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send(); 
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        //Agarra los  valores
                        document.querySelector("#idUsuario").value = objData.data.idpersona;
                        document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                        document.querySelector("#txtNombre").value = objData.data.nombres;
                        document.querySelector("#txtApellido").value = objData.data.apellidos;
                        document.querySelector("#txtTelefono").value = objData.data.telefono;
                        document.querySelector("#txtEmail").value = objData.data.email_user;
                        document.querySelector("#listRolid").value = objData.data.idrol;
                        //esto se usa para renderizar los options y asi poder colocarle su valor
                        $('#listRolid').selectpicker('render');

                        if(objData.data.status == 1){
                            document.querySelector("#listStatus").value = 1;
                        }else{
                            document.querySelector("#listStatus").value = 2;
                        }
                        //esto se usa para renderizar los options y asi poder colocarle su valor
                        $('#listStatus').selectpicker('render');
                        }
                    }
                
                    $('#modalFormUsuario').modal('show');
                }
            
        });
    });
}

function fntDelUsuario() {
    var btnDelUsuario = document.querySelectorAll(".btnDelUsuario =");//se refiere a todos los elementos que tengan esta clase del usuario
    btnDelUsuario.forEach(function(btnDelUsuario){
        btnDelUsuario.addEventListener("click", function(){
            var idUsuario = this.getAttribute("us");//Se obtiene el id del usuario

            swal({
                title: "Eliminar Usuario",
                text: "¿Realmente quiere eliminar el usuario?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar!", 
                cancelButtonText: "No, cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {

                if (isConfirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url+'/Usuarios/delUsurio/';
                    var strData = "idUsuario="+idUsuario;
                    request.open("POST", ajaxUrl , true);
                    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal("Eliminar!", objData.msg ,"success");
                                tableUsuarios.api().ajax.reload(function(){
                                    fntRolesUsuario();
                                    fntViewUsuario(); 
                                    fntEditUsuario();
                                    fntDelUsuario();
                                });
                            }else{
                                swal("Atención!", objData.msg, "error");
                            }
                        }
                    }
                }

            });
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