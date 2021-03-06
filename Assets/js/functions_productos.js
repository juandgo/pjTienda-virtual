//Esto es para incluir el plugin de codigo de barras, las comillas invertidas me ayudan para que siva el ${base_url}.
document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableProductos;
let rowTable = "";
//Con esto soluciono  el funcionamiento del tinymce
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
//Agrego los eventos al momento que se cargue todo el documento 
window.addEventListener('load',function(){

    tableProductos = $('#tableProductos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Productos/getProductos",
            "dataSrc":""
        },
        "columns":[
            {"data":"idproducto"},
            {"data":"codigo"},
            {"data":"nombre"},
            {"data":"stock"},
            {"data":"precio"},
            {"data":"status"},
            {"data":"options"}
        ],
        //Con esto configuro las columnas del datat table en la hoja de estilo  
        "columnDefs":[
            {'className': 'textcenter', 'targets': [3]},
            {'className': 'textright', 'targets': [4]},
            {'className': 'textcenter', 'targets': [5]}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary",
                "exportOptions":{
                    "columns": [0,1,2,3,4,5]
                }
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success",
                //esto es para que al exporatar no salga la fila 6 de acciones
                "exportOptions":{
                    "columns": [0,1,2,3,4,5]
                }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions":{
                    "columns": [0,1,2,3,4,5]
                }
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info",
                "exportOptions":{
                    "columns": [0,1,2,3,4,5]
                }
            }
        ],
        "responsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
       });
       //Nuevo Producto
        if(document.querySelector("#formProducto")){
            let formProductos = document.querySelector("#formProducto");
            formProductos.onsubmit = function(e){
                e.preventDefault();
                let strNombre = document.querySelector('#txtNombre').value; 
                let intCodigo = document.querySelector('#txtCodigo').value;
                let strPrecio = document.querySelector('#txtPrecio').value;
                let intStock = document.querySelector('#txtStock').value;
                let intStatus = document.querySelector('#listStatus').value;

                if (strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '') {
                    swal("Atención", "Todos los campos son obligatorios.", "error");
                    return false;
                }
                if (intCodigo.length < 5) {
                    swal("Atención", "El código debe ser mayor que 5 dígitos.", "error");
                    return false;
                }
                //muestra el loading 
                divLoading.style.display = "flex";
                //esto es para evitar que usuario le de varias veces al boton, lo que hace esta funcion es pasar todo lo que tiene el editor de texto a l textarea
                tinyMCE.triggerSave; 
                let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+'/Productos/setProducto';
                let formData = new FormData(formProducto);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if (request.readyState == 4 && request.status == 200) {
                        // console.log(request.responseText);
                        let objData = JSON.parse(request.responseText);
                        console.log("hola");
                        if (objData.status) { // si el status = true en el objeto ajax hace
                            swal("", objData.msg, "success");
                            document.querySelector("#idProducto").value = objData.idproducto;// Uso el id que me da el ajax para las imagenes
                            document.querySelector("#containerGallery").classList.remove("notBlock");
                            if (rowTable == "") {
                                tableProductos.api().ajax.reload();//El dataTable es un api :D
                            }else{
                                 //Con esto no retrocede a la primer pagina al cargar sino que se queda en la misma que esta el registro 
                                htmlStatus = intStatus == 1 ? //Velida si esta activo 
                                '<span class="badge badge-success">Activo</span>' : 
                                '<span class="badge badge-danger">Inactivo</span>';
                                rowTable.cells[1].textContent = intCodigo;
                                rowTable.cells[2].textContent = strNombre;
                                rowTable.cells[3].textContent = intStock;
                                rowTable.cells[4].textContent = smoney+strPrecio;
                                rowTable.cells[5].innerHTML = htmlStatus;//se coloca innerHTML porque lo que se integra el la celda es html 
                                rowTable = "";//Limpia la variable
                            }
                        }else{
                            swal("Error", objData.msg, "error");
                        }
                    }
                divLoading.style.display = "none";
                return false; 
                }
            }
        }
        //Añadir Imagen 
        if (document.querySelector(".btnAddImage")) {
            let btnAddImage = document.querySelector(".btnAddImage");
            btnAddImage.onclick = function(e){
            // Date.now(); retorna la fecha,la hora y los segundos; esto va a funcionar como un id unico.
            let key = Date.now();
            //Muestra una alerta con el id generado 
            // alert(key);
            //creo un elemento div
            let newElement = document.createElement("div");
            newElement.id = "div" + key;//conncateno la llave "key" osea le da el valor a la variable id que es key el html 
            newElement.innerHTML = `
                <div class="prevImage">
                </div>
                <input type="file" id="img${key}" name="foto" class="inputUploadfile">
                <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload"></i></label>
                <button class="btnDeleteImage notBlock" type="button" onclick="fntDelItem('#div${key}')">
                    <i class="fas fa-trash-alt"></i>
                </button>`;
                //Agrega el nuevo html con su id 
            document.querySelector('#containerImages').appendChild(newElement);
            document.querySelector("#div"+key+" .btnUploadfile").click();
            //se invocan cuando se crea el documento
            fntInputFile();
            }
        }
        //se invocan cuando se cargue todo el documento "file"
    fntInputFile();
    fntCategorias();
},false);

if (document.querySelector("#txtCodigo")) {
    let inputCodigo = document.querySelector("#txtCodigo");
    inputCodigo.onkeyup = function(){
        // Si es mayor o igual a 5 muestra el codigo de barras y el boton para impimirlo. 
        if (inputCodigo.value.length >= 5) {
            document.querySelector('#divBarCode').classList.remove('notBlock');
              fntBarCode();
        } else {
            document.querySelector('#divBarCode').classList.add('notBlock');
        }  
    };
}

function fntCategorias() {
    if (document.querySelector('#listCategoria')) {
        let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() :new ActivexObject("Microsoft.XMLHTTP");
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function(){
            if (request.readyState == 4 && request.status == 200){
                //Obtengo todos los options de la lista
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}

//Metodo para mostrar el codigo de barras
function fntBarCode(){
    //Captura el valor 
    let codigo = document.querySelector("#txtCodigo").value;
    //Al id #barcode le doy el valor con codigo 
    JsBarcode("#barcode",codigo);
}

//Este es el metodo para imprimir.
function fntPrintBarCode(area){
    let elementArea = document.querySelector(area);
    let vprint = window.open('', 'popimpr', 'height=400, widht=600');
    vprint.document.write(elementArea.innerHTML);
    vprint.document.close();
    vprint.print();
    vprint.close();
}

//Con esto pongo el area tinymce y tambien lo puedo customisar 
tinymce.init({
    selector: '#txtDescripcion',
    widht: "100%",
    height: 400,
    statusbar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustifys | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
  });

function fntViewInfo(idproducto) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('MicrosofXMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idproducto;
    request.open("GET",ajaxUrl,true);
    request.send(); 
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status){// si el status es true
                //Con esto ya no hago uso de objData.data; para acortar codigo
                let objProducto = objData.data;
                // console.log(objProducto.nombre);
                let estadoProducto = objProducto.status == 1 ?// si es 1 es activo
                '<span class="badge badge-success">Activo</span>':
                '<span class="badge badge-danger">Inactivo</span>';
                let htmlImage = "";     

                document.querySelector("#celCodigo").innerHTML = objProducto.codigo;           
                document.querySelector("#celNombre").innerHTML = objProducto.nombre;           
                document.querySelector("#celPrecio").innerHTML = objProducto.precio;    
                document.querySelector("#celStock").innerHTML = objProducto.stock;         
                document.querySelector("#celCategoria").innerHTML = objProducto.categoria;     
                document.querySelector("#celEstado").innerHTML = estadoProducto;   
                document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion; 

                if (objProducto.images.length > 0) {
                    //Agarra la posicion de la imagen
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++){
                        //Otiene la url de la imagen en el html 
                        htmlImage += `<img src="${objProductos[p].url_image}"></img>`; 
                    }
                }
                document.querySelector("#celFotos").innerHTML = htmlImage; 

                $('#modalViewProducto').modal('show');
            }else{
                swal("Error, objData.msg, error");
            }
        }
    }
}

function fntEditInfo(element, idproducto){
    rowTable = element.parentNode.parentNode.parentNode;//agarrato todo el elemento padre que contiene el boton 
    console.log(rowTable);
    document.querySelector('#titleModal').innerHTML = "Acatualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate" );
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Acatualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('MicrosofXMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idproducto;
    request.open("GET",ajaxUrl,true);
    request.send(); 
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            // console.log(request.responseText);
            let objData = JSON.parse(request.responseText);
            if (objData.status){// si el status es true
                //Con esto ya no hago uso de objData.data; para acortar codigo
                let objProducto = objData.data;
                // console.log(objProducto.nombre);
                document.querySelector("#idProducto").value = objProducto.idproducto;
                document.querySelector("#txtCodigo").value = objProducto.codigo;           
                document.querySelector("#txtNombre").value = objProducto.nombre;    
                document.querySelector("#txtDescripcion").value = objProducto.descripcion; 
                document.querySelector("#txtPrecio").value = objProducto.precio;    
                document.querySelector("#txtStock").value = objProducto.stock;         
                document.querySelector("#listCategoria").value = objProducto.categoriaid;     
                document.querySelector("#listStatus").value = objProducto.status;
                //Para que algunas cosas funcionen se hace esto por que dependen de otras librerias
                tinymce.activeEditor.setContent(objProducto.descripcion);
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
                fntBarCode();

                let htmlImage = "";
                if (objProducto.images.length > 0) {
                    //Agarra la posicion de la imagen
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++){  
                        //Otiene la url de la imagen en el html 
                        let key = Date.now()+p;
                        htmlImage +=`<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objProductos[p].url_image}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
                            <i class="fas fa-trash-alt"></i></button></div>`; 
                    }
                }
                document.querySelector('#containerImages').innerHTML = htmlImage; 
                document.querySelector("#divBarCode").classList.remove("notBlock");
                document.querySelector("#containerGallery").classList.remove("notBlock");
                
                $('#modalFormProductos').modal('show');
            }else{
                swal("Error, objData.msg, error");
            }
        }
    }
}

function fntDelInfo(idproducto) {
    //Alerta
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObje('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/delProducto';
            let strData = "idProducto="+idproducto;
            request.open("POST",ajaxUrl,true);//Envia la operacion por medio de ajax
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableProductos.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });
}

function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile){
        inputUploadfile.addEventListener('change', function(){ 
           //Esta variable correspode a #idProducto de tipo hiden y sirve para saber a que id se le va asignar la imagen 
           let idProducto = document.querySelector("#idProducto").value;
            // console.log(idProducto);
            //Esta variabla agarra el valor de elemento padre que es el id="div24" del html
            let parentId = this.parentNode.getAttribute("id");
            //Agrra el id del elemento file 
            let idFile = this.getAttribute("id");
            //le contcatena el idfile  
            let uploadFoto = document.querySelector("#"+idFile).value;
            //le contcatena el idfile  para obtener la foto 
            let fileimg = document.querySelector("#"+idFile).files;
            //Concatena parentId con el elemento que le sigue prevImg
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            //esto es para que dependa del navegador donde se encuentre 
            let nav = window.URL || window.webkitURL;
            //Valida si tiene una imagen 
            if (uploadFoto != '') {
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false; 
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg">`;
                    
                    let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Productos/setImage'; 
                    let formData = new FormData();
                    formData.append('idproducto',idProducto);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function() {
                        if(request.readyState != 4) return; 
                        if (request.status == 200) {
                            // console.log(request.responseText);
                            let objData = JSON.parse(request.responseText); 
                            // si es verdadero
                            if (objData.status) {
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notBlock");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notBlock");
                            }else{
                                swal("Error", objData.msg, "error");
                            }
                        }
                    }
                }
            }
        }); 
    });
}

function fntDelItem(element){
    let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
    let idProducto = document.querySelector("#idProducto").value;
    let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/delFile';

    let formData = new FormData();
    formData.append('idproducto', idProducto);
    formData.append('file', nameImg);
    request.open('POST', ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function() {
        if(request.readyState != 4) return; 
        if (request.status == 200) {
            // console.log(request.responseText);
            let objData = JSON.parse(request.responseText); 
            // si es verdadero
            if (objData.status) {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg, "error");
            }
        }
    }
}

function openModal() {
    //Configuracion de Apariencia
    rowTable = "";
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProducto").reset();

    document.querySelector("#divBarCode").classList.add("notBlock");
    document.querySelector("#containerGallery").classList.add("notBlock");
    document.querySelector("#containerImages").innerHTML = "";
    $('#modalFormProductos').modal('show');
}