<?php 
    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers

            session_start();
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            getPermisos(1);
        }

        public function dashboard(){
            $data['page_id'] = 2;
            $data['page_tag'] = 'Dashboard - Tenda Virtual';
            $data['page_title'] = "Dashboard - Tienda Virtual";
            $data['page_name'] = 'dashboard';
            $data['page_functions_js'] = 'functions_dashboard.js';
            $this->views->getView($this,"dashboard",$data);//Se utitiliza la vista dasboard 
    
        }
    }
?> 