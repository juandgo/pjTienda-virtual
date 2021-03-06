let tableRoles;
let divLoading = document.querySelector("#divLoading");
//Se agrega un evento. 
//En el momento que se carge todo ejecuta la funcion.
document.addEventListener('DOMContentLoaded', function() {
     //Aqui pongo el script de datatables
     tableRoles = $('#tableRoles').dataTable({
         "aProcessing":true,
         "aServerSide":true,
         "language":{
             "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"//fromato json con configuracion del lenguaje en español
         },
         "ajax":{
             "url": ""+base_url+"/Roles/getRoles",
             "dataSrc": ""
         },
         "columns":[
             {"data":"idrol"},
             {"data":"nombrerol"},
             {"data":"descripcion"},
             {"data":"status"},
             {"data":"options"}
         ],
         "responsieve":"true",
         "bDestroy": true,
         "iDisplayLength": 10,
         "order": [[0, "desc"]]
        });
        //NUEVO ROL
        //envio de datos por ajax 
        if(document.querySelector("#formRol")){
            let formRol = document.querySelector("#formRol");//se coloca # por que es un id  el . es para una clase
            formRol.onsubmit = function(e){
                e.preventDefault();//previene de que se recarge el formularion con la pagina

                let intIdRol = document.querySelector('#idRol').value;//evita que no se abra otro boton
                let strNombre = document.querySelector("#txtNombre").value;
                let strDescripcion = document.querySelector("#txtDescripcion").value;
                let intStatus = document.querySelector("#listStatus").value;
                if (strNombre == '' || strDescripcion == '' || intStatus == '') {
                    swal("Atención","Todos los campos son obligatorios.", "error");
                    return false;
                }
                divLoading.style.display = "flex";// se le da un estilo al loading y comienza la animacion
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');//Valida si es un vegador Chrome o firefox y se obtiene el objeto correspondiente al navegador 
                let ajaxUrl = base_url+'/Roles/setRol'; 
                let formData = new FormData(formRol);
                request.open("POST",ajaxUrl,true);
                request.send(formData); 
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {

                        let objData = JSON.parse(request.responseText);

                        if (objData.status) {
                            $('#modalFormRol').modal('hide');//Cierra el modal
                            formRol.reset();//limpia los campos
                            swal("Categoria", objData.msg ,"success");
                            tableRoles.api().ajax.reload();
                        }else{
                            swal("Error", objData.msg,"error");//muestra mensaje de error segun  la opcion dada por el controlador
                        }
                    }
                    divLoading.style.display = "none";//oculta la animacion loading cuando termine de cargar 
                    return false;    
                }
            }
        }
},false);

$('#tableRoles').DataTable();

function fntEditRol(idrol){
   
    document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate")
    document.querySelector('#btnActionForm').classList.replace('btn-primary', 'btn-info');
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("MicrosofXMLHTTP");
    let ajaxUrl = base_url+'/Roles/getRol/'+idrol;
    request.open("GET",ajaxUrl,true);
    request.send()
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);//El responseText lo convierto eobjeto
            if (objData.status){
                document.querySelector("#idRol").value = objData.data.idrol;
                document.querySelector("#txtNombre").value = objData.data.nombrerol;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                if (objData.data.status == 1) {
                    let optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                }else{
                    let optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                }
                let htmlSelect = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>`;
                
                document.querySelector("#listStatus").innerHTML = htmlSelect;
                $("#modalFormRol").modal('show');
            }else{
                swal("Error", objData.msg, "error");
            }
        }
        
    }
}

function fntDelRol(idrol) {
    swal({
        title: "Eliminar Rol",
        text: "¿Realmente quiere eliminar el rol?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!", 
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObjec('MicrosoftXMLHTTP');
            let ajaxUrl = base_url+'/Roles/delRol/';
            let strData = "idrol="+idrol;
            request.open("POST", ajaxUrl , true);
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg ,"success");
                        tableRoles.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function fntPermisos(idrol){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#contentAjax').innerHTML = request.responseText;
            $('.modalPermisos').modal('show');
            document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
        }
    }
}

function fntSavePermisos(event){
    event.preventDefault();
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Permisos/setPermisosRol'; 
    let formElement = document.querySelector("#formPermisos");
    let formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                swal("Permisos de usuario", objData.msg ,"success");
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

//funcion que abre modales por su nombre
function openModal() {
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector('#idRol').value="";//Es el id del input tipo hiden que resetea la modal
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");//cambia 
    document.querySelector('#btnText').innerHTML = "Guardar";
    $('#modalFormRol').modal('show');
} 