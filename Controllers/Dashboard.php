<?php 
    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function dashboard(){
            $data['page_id'] = 2;
            $data['page_tag'] = 'Dashboard - Tenda Virtual';
            $data['page_title'] = "Dashboard - Tienda Virtual";
            $data['page_name'] = 'dashboard';
            $this->views->getView($this,"dashboard",$data);//Se utitiliza la vista dasboard 
    
        }
    }
?> 