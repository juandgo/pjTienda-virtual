<?php
    class Productos extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//Solo con esto se podran crear variables de sesión
            session_regenerate_id(true);//Genera un nuevo Id y Borra el aterior, esto con el fin de que no quede en las cokies 
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            //permisos por el id de productos
            getPermisos(4);
        }

        public function Productos(){
            //Sí permisosMod en read es igual a true muestra el modulo usuarios 
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_tag'] = 'Productos';
            $data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
            $data['page_name'] = 'productos';
            $data['page_functions_js'] = 'functions_productos.js';
            $this->views->getView($this,'productos',$data);
    
        }
    }