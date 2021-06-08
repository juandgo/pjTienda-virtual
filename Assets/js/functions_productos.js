//Esto es para incluir el plugin de codigo de barras, las comillas invertidas me ayudan para que siva el ${base_url}.
document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableProductos;
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

        if(documento.querySelector("#formProducto")){
            let formProductos = document.querySelector("#formProductos");
            formProductos.onsubmit = function(e){
                e.preventDefault();
                let strNombre = document.querySelector('#txtNombre').value; 
                let intCodigo = document.querySelector('#txtCodigo').value;
                let strPrecio = document.querySelector('#txtPrecio').value;
                let strStock = document.querySelector('#txtStock').value;
                if (strNombre == '' || intCodigo == '' || strPrecio == '' || strStock == '') {
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
                let ajaxUrl = base_url+'/Productos/setProductos';
                let formData = new FormData(formProducto);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if (request.readyState == 4 && request.status == 200) {
                        
                    }
                }
            }
        }

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

function openModal() {
    //Configuracion de Apariencia
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProducto").reset();
    $('#modalFormProductos').modal('show');
}