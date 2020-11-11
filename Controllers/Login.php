<?php 
    class Login extends Controllers{
        public function __construct(){
            session_start();//con esto se puenden crear varibles de sesión
            //valida si la sesión existe  redirecciona a dashboard, si no te devuelve al form login 
            if (isset($_SESSION['login'])) {
                header("Location:".base_url()."/dashboard");
            }
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function login(){
            $data['page_tag'] = 'Login - Tienda Virtual';
            $data['page_title'] = "Tienda Virtual";
            $data['page_name'] = 'login';
            $data['page_functions_js'] = 'functions_login.js';//esto se usa para el cambio de pagina
            $this->views->getView($this,'login',$data);
    
        }

        public function loginUser(){
            // dep($_POST);
            if ($_POST) {
                if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos');
                }else{
                    $strUsuario = strtolower(strClean($_POST['txtEmail']));
                    $strPassword = hash("SHA256",$_POST['txtPassword']);
                    $requestUser = $this->model->loginUser($strUsuario,$strPassword);
                    // dep($requestUser);
                    if (empty($requestUser)) {
                        $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
                    }else{
                        $arrData = $requestUser;
                        if ($arrData['status'] == 1) {
                            $_SESSION['idUser'] = $arrData['idpersona'];
                            $_SESSION['login'] = true;

                            $arrData = $this->model->sessionLogin($_SESSION['idUser']);//Se envia por parametro el id del usuario
                            $_SESSION['userData'] = $arrData;//Se crea la variable user data para almacenar todos los datos allí

                            $arrResponse = array('status' => true, 'msg' => 'ok');
                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
                        }
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);//retorna la respuesta 
            }
            die();
        }

        public function resetPass(){
            if ($_POST) {
                if (empty($_POST['txtEmailReset'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos');
                }else{
                    $token = token();
                    $strEmail = strtolower(strClean($_POST['txtEmailReset']));
                    $arrData = $this->model->getUserEmail($strEmail);

                    if (empty($arrData)) {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario no existente.');
                    }else{
                        $idpersona = $arrData['idpersona'];
                        $nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

                        $url_recovery = base_url().'/Login/confirmUser/'.$strEmail.'/'.$token;
                        $requestUpdate =  $this->model->setTokenUser($idpersona,$token);

                        if($requestUpdate){
                            $arrResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo electronico para cambiar tu contraceña');
                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
                        }
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function confirmUser(string $params){
            //si es diferente a los datos pedidos redirecciona al index
            if (empty($params)) {
                header("Location:".base_url());
            }else{
                // echo $params;
                $arrParamas = explode(',',$params);
                $strEmail = strClean($arrParamas[0]);
                $strToken = strClean($arrParamas[1]);
                $arrResponse = $this->model->getUsuario($strEmail,$strToken);
                if(empty($arrResponse)){
                    header('location: '.base_url());//redireciona a la ruta raiz del proyecto
                }else{
                    $data['page_tag'] = 'Cambiar Contraseña';
                    $data['page_name'] = 'cambiar_contrasenia';
                    $data['page_title'] = "Cambiar Contraseña ";
                    $data['token'] = $strToken;
                    $data['email'] = $strEmail;
                    $data['idpersona'] = $arrResponse['idpersona'];//recive la variable idpersona
                    $data['page_functions_js'] = 'functions_login.js';//esto se usa para el cambio de pagina
                    $this->views->getView($this,'cambiar_password',$data);
                }
            }
            die();
        }

        public function setPassword(){
            // dep($_POST);
            if (empty($_POST['idUsuario']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            }
            die();
        }
    }
?>