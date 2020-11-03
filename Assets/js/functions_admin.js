//Esta funcion bloquea las teclas y solo permite el ingreso de numeros 
function controlTag(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if(tecla == 8) return true;
    else if(tecla == 0 || tecla == 9) return true;
    patron =/[0-9\s]/;//va a permitir numeros del 0 al 9
    n = String.fromCharCode(tecla);
    return patron.test(n);
}
//Esta funcion se usa para vallidar los nombres y apellidos 
function testText(txtString) {
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);//crea un objeto con una expresion regular
    //Si cumple con la expresion anterior retorna true
    if (stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}

function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if (intCantidad.test(intCant)) {
        return true;
    }else{
        return false;
    }
}

function fntEmailValidate(email) {
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    if (string.test(email)) {
        return true;
    }else{
        return false;
    }
}