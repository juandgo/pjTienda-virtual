$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});

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
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                console.log(request);

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
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/resetPass';
                var formData = new FormData(formResetPass);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    
                }
            }
        }
    }
}, false);