<?php 
    class Login extends Controllers{
        public function __construct(){
            session_start();//con esto se puenden crear varibles de sesión
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
            // die();
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
    }
?>