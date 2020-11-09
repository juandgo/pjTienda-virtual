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
            $data['page_functions_js'] = 'functions_login.js';
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
                }
            }
            die();
        }
    }
?>