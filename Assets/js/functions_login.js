$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});
//esta variable se crea para mostrar la animacion loading
var divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector("#formLogin")) {
        
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector("#txtEmail").value;
            let strPassword = document.querySelector("#txtPassword").value;

            if (strEmail == "" || strPassword == "") {
                swal("Por favor", "Escriba usuario y contraceña", "error");
                return false;
            }else{
                divLoading.style.display = "flex";// se le da un estilo al loading y comienza la animacion
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                // console.log(request);

               request.onreadystatechange = function(){

                    if (request.readyState != 4) return;//no hace absolutamente nada si es diferente de 4 
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status){// si el status es true es correcto
                            //al iniciar sesión muestra el dashboard
                            window.location = base_url+'/dashboard';
                        }else{
                            swal("Atención", objData.msg, "error");
                            document.querySelector('#txtPassword').value = "";//limpia campo
                        }
                    }else{
                        swal("Atención", "Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";//oculta la animacion loading cuando termine de cargar 
                    return false;                   
                // console.log(request);
               }
            }
        }
    }

    if(document.querySelector("#formResetPass")){
        let formResetPass = document.querySelector("#formResetPass");
        formResetPass.onsubmit = function (e) {
            e.preventDefault();
            //captura el email que se escribe
            let strEmail = document.querySelector('#txtEmailReset').value;
            if (strEmail == "") {
                swal("Por favor", "Escriba su correo electronico.", "error");
                return false;
            }else{
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/resetPass';
                var formData = new FormData(formResetPass);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    // console.log(request);
                    if(request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {//Sí objData es true 
                            swal({
                                title: "",
                                text: objData.msg,
                                type: "success",
                                confirmButtonText: "Aceptar",
                                closeOnConfirm: false,
                            }, function (isConfirm) {
                                if(isConfirm){
                                    window.location = base_url;
                                }
                            });
                        }else{
                            swal("Atención", objData, "error");
                        }
                    }else{
                        swal("Atención", "Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
        
    }
    //Sí esxixte el elemento formCambiarPass hacer
    if (document.querySelector('#formCambiarPass')) {
        let formCambiarPass = document.querySelector('#formCambiarPass');
        formCambiarPass.onsubmit = function(e){
            e.preventDefault();

            let strPassword = document.querySelector('#txtPassword').value;//obtiene el valor
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
            let idUsuario = document.querySelector('#idUsuario').value;

            if (strPassword == "" || strPasswordConfirm == "") {
                swal("Por favor", "Escribe la nueva contraseña", "error");
                    return false;
            }else{
                if(strPassword.length < 5){
                    swal('Atención', 'La contraseña debe tener un mínimo de 5 caracteres.', "info");
                    return false;
                }else if(strPassword != strPasswordConfirm){
                    swal('Atención', 'Las contraseñas son igualess.', "error");
                    return false;
                }
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? 
                                new XMLHttpRequest() : 
                                new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/setPassword';
                //se crea el obejto formData con el parametro formCambiarPass
                var formData = new FormData(formCambiarPass);
                request.open("POST",ajaxUrl,true);
                request.send(formData);

                request.onreadystatechange = function () {

                    if(request.readyState != 4) return;
                    if (request.status == 200) {
                        // console.log(request.responseText);
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {//Sí objData es true 
                            swal({
                                title: "",
                                text: objData.msg,//recibe el formato json del LoginModel
                                type: "success",
                                confirmButtonText: "Iniciar sesión",
                                closeOnConfirm: false,//Indica que no se cierra la alerta hasta que no se de click en el boton
                            }, function (isConfirm) {
                                if(isConfirm){
                                    window.location = base_url+'/login';
                                }
                            });
                        }else{
                            swal("Atención", objData, "error");
                        }
                    }else{
                        swal("Atención", "Error en el proceso", "error");
                    }
                    divLoading.style.display = "none";
                }
            }
        }
    }
}, false);