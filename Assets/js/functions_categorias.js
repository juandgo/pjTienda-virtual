document.addEventListener('DOMContentLoaded', function(){ // Con esto cargo los eventos al momento de cargar el html
    //Script para cargar foto
    if(document.querySelector("#foto")){
        var foto = document.querySelector("#foto");
        foto.onchange = function(e) {
            var uploadFoto = document.querySelector("#foto").value;//Captura el valor 
            var fileimg = document.querySelector("#foto").files;
            var nav = window.URL || window.webkitURL;
            var contactAlert = document.querySelector('#form_alert');
            if(uploadFoto !=''){
                var type = fileimg[0].type;
                var name = fileimg[0].name;
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
                        var objeto_url = nav.createObjectURL(this.files[0]);
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
        var delPhoto = document.querySelector(".delPhoto");
        delPhoto.onclick = function(e) {
            removePhoto();
        }
    }
    
    //NUEVA CATEGORIA
    //envio de datos por ajax 
    var formRol = document.querySelector("#formCategoria");//se coloca # por que es un id  el . es para una clase
    formRol.onsubmit = function(e){
        e.preventDefault();//previene de que se recarge el formularion con la pagina

        var intICategoria = document.querySelector('#idCategoria').value;//evita que no se abra otro boton
        var strNombre = document.querySelector("#txtNombre").value;
        var strDescripcion = document.querySelector("#txtDescripcion").value;
        var intStatus = document.querySelector("#listStatus").value;
        if (strNombre == '' || strDescripcion == '' || intStatus == '') {
            swal("Atención","Todos los campos son obligatorios.", "error");
            return false;
        }
        divLoading.style.display = "flex";// se le da un estilo al loading y comienza la animacion
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');//Valida si es un vegador Chrome o firefox y se obtiene el objeto correspondiente al navegador 
        var ajaxUrl = base_url+'/Categorias/setCategoria'; 
        var formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData); 
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                var objData = JSON.parse(request.responseText);

                if (objData.status) {
                    $('#modalFormCategorias').modal('hide');//Cierra el modal
                    formRol.reset();//limpia los campos
                    swal("Roles de usuarios", objData.msg ,"success");
                    tableRoles.api().ajax.reload();
                }else{
                    swal("Error", objData.msg,"error");//muestra mensaje de error segun  la opcion dada por el controlador
                }
            }
            divLoading.style.display = "none";//oculta la animacion loading cuando termine de cargar 
            return false;    
        }
    }

    
    
    function removePhoto(){
        document.querySelector('#foto').value ="";
        document.querySelector('.delPhoto').classList.add("notBlock");
        document.querySelector('#img').remove();
    }

}, false);

function openModal() {
    //Configuracion de Apariencia
    document.querySelector('#idCategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
    document.querySelector("#formCategoria").reset();
    $('#modalFormCategorias').modal('show');
}