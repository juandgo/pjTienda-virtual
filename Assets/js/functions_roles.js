var tableRoles;

//Se agrega un evento. 
//En el momento que se carge todo ejecuta la funcion.
document.addEventListener('DOMContentLoaded', function() {
     //Aqui pongo el script de datatables
     tableRoles = $('#tableRoles').dataTable({
         "aProcessing":true,
         "aServerSide":true,
         "languages":{
             "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"//fromato json con configuracion del lenguaje
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
        var formRol = document.querySelector("#formRol");//se coloca # por que es un id . es para una clase
        formRol.onsubmit = function(e){
            e.preventDefault();//previene de que se recarge el formularion con la pagina

            var strNombre = document.querySelector("#txtNombre").value;
            var strDescripcion = document.querySelector("#txtDescripcion").value;
            var intStatus = document.querySelector("#listStatus").value;
            if (strNombre == '' || strDescripcion == '' || intStatus == '') {
                swal("Atención","Todos los campos son obligatorios.", "error");
                return false;
            }
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');//Valida si es un vegador Chrome o firefox y se obtiene cada uno de los objetos de acuerdo al navegador 
            var ajaxUrl = base_url+'/Roles/setRol'; 
            var formData = new FormData(formRol);
            request.open("POST",ajaxUrl,true);
            request.send(formData); 
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                    var objData = JSON.parse(request.responseText);

                    if (objData.status) {
                        $('#modalFormRol').modal('hide');//Cierra el modal
                        formRol.reset();//limpia los campos
                        swal("Roles de usuarios", objData.msg ,"success");
                        tableRoles.api().ajax.reload(function(){
                            // ftnEditRole();
                            // ftnDelRol();
                            // ftnPermisos();
                        });
                    }else{
                        swal("Error", objData.msg,"error");//muestra mensaje de error segun el controlador
                    }
                }
            }
        }
    });

$('#tableRoles').DataTable();

//funcion que abre modales por su nombre
function openModal() {
    $('#modalFormRol').modal('show');
} 
