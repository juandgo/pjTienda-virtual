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
        var format = document.querySelector("#formRol");//se coloca # por que es un id . es para una clase
        formRol.onsubmit = function(e){
            e.preventDefault();//previene de que se recarge el formularion con la pagina
            var strnombre = document.querySelector("#txtnombre").value;

        }
    });

$('#tableRoles').DataTable();

//funcion que abre modales por su nombre
function openModal() {
    $('#modalFormRol').modal('show');
} 
