<?php 
    class Categorias extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//Solo con esto se podran crear variables de sesión
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            //permisos por rol de usuario
            getPermisos(6);
        }

        public function Categorias(){
            //Sí permisosMod en read es igual a true muestra el modulo usuarios 
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_tag'] = 'Categorias';
            $data['page_title'] = "CATEGORIAS <small>Tienda Virtual</small>";
            $data['page_name'] = 'categorias';
            $data['page_functions_js'] = 'functions_categorias.js';
            $this->views->getView($this,'categorias',$data);
    
        }
    }
?>