//Esta funcion bloquea las teclas y solo permite el ingreso de numeros 
//unicamente permite digitar numeros, borrar y dar enter.
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

function testEmail(email) {
    //Esta es la exprecion regular que tiene un correo
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    if (stringEmail.test(email) == false) {
        return false;
    }else{
        return true;
    }
}

function fntValidText(){
    let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText){
        validText.addEventListener('keyup', function(){//keyup se refiere a terminar de precionar la tecla
            let inputValue = this.value;//obtiene el valor que se escribio
            //usa la testText ya antes creada 
            //Sí es falso le da clase valor de is-invalid  de locontrario le quita ese valor
            if (!testText(inputValue)) {
                this.classList.add("is-invalid");
            }else{
                this.classList.remove("is-invalid");
            }
        });
    });
}

function fntValidNumber(){
    let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber){
        validNumber.addEventListener('keyup', function(){
            let inputValue = this.value;//obtiene el valor que se escribio 
            if (!testEntero(inputValue)) {//usa la testEntero ya antes creada 
                this.classList.add("is-invalid");
            }else{
                this.classList.remove("is-invalid");
            }
        });
    });
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEmail(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

window.addEventListener('load', function(){
    fntValidEmail();
    fntValidNumber();
    fntValidText();
}, false);