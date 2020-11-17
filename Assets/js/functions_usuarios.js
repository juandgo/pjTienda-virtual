
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
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
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
        //valida que los campos sean correctos 
        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) {
            if (elementsValid[i].classList.contains('is-invalid')) {
                swal("!Atención", "Por favor verifique los campos en rojo.", "error");
                return false;
            }
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
                    tableUsuarios.api().ajax.reload();
                }else{
                    swal("Error", objData.msg, "error");
                } 
            }    
        }    
    }
}, false);
//Esta es la funcion que ejecuta todas la funciones del modulo usuario
window.addEventListener('load', function(){
    fntRolesUsuario();
    //Comento la funciones por que ya no son utiles debido a que estan siendo cargadas desde los botones en las validacionde Usuaros.php

    // fntViewUsuario(); 
    // fntEditUsuario();
    // fntDelUsuario();
}, false);

function fntRolesUsuario() {
    var ajaxUrl = base_url+'/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');//Valida si es un vegador Chrome o firefox y se obtiene el objeto correspondiente al navegador 
    request.open("GET",ajaxUrl,true);
    request.send(); 

    request.onreadystatechange = function() {//esta funcion obtiene los resultados del ajax
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#listRolid').innerHTML = request.responseText;//Esto le da respuesta  del getSlectRoles del controlador Roles.php
            // document.querySelector('#listRolid').value = 1;
            $('#listRolid').selectpicker('render');
        }
    }    
}

function fntViewUsuario(idpersona) {
    //ya no es util por que esta siendo cargado desde el controlador Usuarios.php
    // var btnViewUsuario = document.querySelectorAll(".btnViewUsuario");
    // btnViewUsuario.forEach(function(btnViewUsuario){
    //     btnViewUsuario.addEventListener('click', function() {
            // var idpersona = this.getAttribute('us');//usuario 
    var idpersona = idpersona;
    var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('MicrosofXMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send(); 
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText)
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
            
    //     });
    // });
}

function fntEditUsuario(idpersona) {
    // var btnEditUsuario = document.querySelectorAll(".btnEditUsuario");
    // btnEditUsuario.forEach(function(btnEditUsuario){
    //     btnEditUsuario.addEventListener('click', function() {
    //Configuracion de Apariencia
    document.querySelector('#titleModal').innerHTML = "Acatualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate" );
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Acatualizar";
    // var idpersona = this.getAttribute('us');//obtine el id del usuario 
    var idpersona = idpersona;//obtine el id del usuario
    var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('MicrosofXMLHTTP');
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
                $('#listRolid').selectpicker('render')
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
            
    //     });
    // });
}

function fntDelUsuario(idpersona) {
    var idUsuario = idpersona;
    swal({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar el Usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm){
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObje('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Usuarios/delUsuario';
            var strData = "idUsuario="+idUsuario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableUsuarios.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });
}

function openModal() {
    //Configuracion de Apariencia
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}
    
