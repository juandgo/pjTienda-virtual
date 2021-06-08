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

    tableCategorias = $('#tableCategorias').dataTable( {
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