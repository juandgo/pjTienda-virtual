<?php 
    class Login extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function login(){
            $data['page_tag'] = 'Login - Tienda Virtual';
            $data['page_title'] = "Login";
            $data['page_name'] = 'login';
            $data['page_functions_js'] = 'function_login.js';
            $this->views->getView($this,'login',$data);
    
        }
    }
?>