let tableCategorias;
let rowTable = "";//Toma el valor de toda la fila en que se va a actualizar los datos 
let divLoading = document.querySelector('#divLoading');
document.addEventListener('DOMContentLoaded', function(){ // Con esto cargo los eventos al momento de cargar el html

    tableProductos = $('#tableCategorias').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Categorias/getCategorias",
            "dataSrc":""
        },
        "columns":[
            {"data":"idcategoria"},
            {"data":"nombre"},
            {"data":"descripcion"},
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

    //Script para cargar foto
    if(document.querySelector("#foto")){
        let foto = document.querySelector("#foto");
        foto.onchange = function(e) {
            let uploadFoto = document.querySelector("#foto").value;//Captura el valor 
            let fileimg = document.querySelector("#foto").files;
            let nav = window.URL || window.webkitURL;
            let contactAlert = document.querySelector('#form_alert');
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){//Valida el tipo de formato 
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock");
                    foto.value="";
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        if(document.querySelector('#img')){
                            document.querySelector('#img').remove();
                        }
                        document.querySelector('.delPhoto').classList.remove("notBlock");
                        let objeto_url = nav.createObjectURL(this.files[0]);
                        document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
                    }
            }else{
                alert("No selecciono foto");
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
            }
        }
    }
    
    if(document.querySelector(".delPhoto")){
        let delPhoto = document.querySelector(".delPhoto");
        delPhoto.onclick = function(e) {
            document.querySelector("#foto_remove").value = 1;// elimina foto
            removePhoto();
        }
    }
    
    //envio de datos por ajax 
    //NUEVA CATEGORIA
    let formCategoria = document.querySelector("#formCategoria");
    formCategoria.onsubmit = function(e) {
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == ''){
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Categorias/setCategoria'; 
        let formData = new FormData(formCategoria);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
            let objData = JSON.parse(request.responseText);
                if(objData.status){
                    if(rowTable == ""){//si es  igual a vacio se crea otro registro 
                        tableCategorias.api().ajax.reload();//Refresca la tabla de categorias 
                    }else{
                        //Con esto no retrocede a la primer pagina al cargar sino que se queda en la misma que esta el registro 
                        htmlStatus = intStatus == 1 ? //Velida si esta activo 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = strDescripcion;
                        rowTable.cells[3].innerHTML = htmlStatus;//se coloca innerHTML porque lo que se integra el la celda es html 
                        rowTable = "";//Limpia la variable
                    }

                    $('#modalFormCategorias').modal("hide");
                    formCategoria.reset();
                    swal("Categoria", objData.msg ,"success");
                    removePhoto();
                }else{
                    swal("Error", objData.msg , "error");
                }              
            } 
            divLoading.style.display = "none";
            return false;
        }
    }

}, false);

//esto es para ver la modal info de categoria 
function fntViewInfo(idcategoria) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('MicrosofXMLHTTP');
    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send(); 
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                //Agarra los valores y los pone en el modal
                let estado = objData.data.status == 1 ?// si es 1 es activo
                '<span class="badge badge-success">Activo</span>':'<span class="badge badge-danger">Inactivo</span>';     

                document.querySelector("#celId").innerHTML = objData.data.idcategoria;           
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;           
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;           
                document.querySelector("#celEstado").innerHTML = estado;           
                document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';           

                $('#modalViewCategoria').modal('show');//muestra por su id en el modal
            }else{
                swal("Error, objData.msg, error");
            }
        }
        
    }
}

function fntEditInfo(element, idcategoria) {
    rowTable = element.parentNode.parentNode.parentNode;//Obtenemos el elemento padre del elemento como el div, td, tr. Lo que hace es subir tres niveles a partir del boton.
    // rowTable.cells[1].textContent = "Hola estoy aqui";
    // console.log(rowTable);
    //Cambia apariencia del formulario porque es el mismo que se esta usando para crear una nueva categoria.
    document.querySelector('#titleModal').innerHTML = "Acatualizar Categoria";
    document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate" );
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Acatualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('MicrosofXMLHTTP');
    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send(); 
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {//esto quiere decir que esta devolviendo informacion
            let objData = JSON.parse(request.responseText);//esto esta agarrando la respuesta del formato jackson de categorias php//ssi tienes problema con esto el problema puede estar en los parametros de esta funcion 
            if (objData.status) {// si es verdadro  
                //Agarra los valores y los pone en el modal
                document.querySelector("#idCategoria").value = objData.data.idcategoria;
                document.querySelector("#txtNombre").value = objData.data.nombre;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                document.querySelector('#foto_actual').value = objData.data.portada;   
                document.querySelector("#foto_remove").value = 0;// elimina foto
                
                if (objData.data.status == 1) {
                    document.querySelector("#listStatus").value = 1;
                } else {
                    document.querySelector("#listStatus").value = 2;
                }
                
                $('#listStatus').selectpicker('render');

                if (document.querySelector('#img')) {//si existe imagen 
                    document.querySelector('#img').src = objData.data.url_portada;//url de la portada osea de la imagen //pone imagen 
                } else {
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_portada+">";// crea el elemnto y pone imagen por defecto
                }

                if (objData.data.portada == 'portada_categoria.png') {//si es igual a la imagen por defecto 
                    document.querySelector('.delPhoto').classList.add("notBlock");//quita X para borrar foto de categoria
                } else {
                    document.querySelector('.delPhoto').classList.remove("notBlock");//pone X para borrar foto de categoria
                }
                $('#modalFormCategorias').modal('show');//muestra por su id en el modal
            }else{
                swal("Error, objData.msg, error");
            }
        }
    }
}

function removePhoto(){//remueve la foto que se visualiza al ejecuatar la funcion editar 
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if (document.querySelector('#img')) {//si hay foto creada la remueve y si no deja la que esta por defecto para que no salga ningun error 
        document.querySelector('#img').remove();
    }
}

function fntDelInfo(idcategoria) {
    //Alerta
    swal({
        title: "Eliminar Categoria",
        text: "¿Realmente quiere eliminar la categoria?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObje('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Categorias/delCategoria';
            let strData = "idCategoria="+idcategoria;
            request.open("POST",ajaxUrl,true);//Envia la operacion por medio de ajax
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableCategorias.api().ajax.reload();
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
    rowTable = "";//Limpia la variable
    document.querySelector('#idCategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategorias').modal('show');
    removePhoto();// se añade esta fucion para quitar la foto vista en editar categoria
}