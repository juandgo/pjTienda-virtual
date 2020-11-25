<?php 
    class Clientes  extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//Solo con esto se podran crear variables de sesión
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            //permisos por rol de usuario
            getPermisos(3);//este es el id del usuario 
        }

        public function Clientes(){
            //Sí permisosMod en read es igual a true muestra el modulo clientes
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_tag'] = 'Clientes';
            $data['page_title'] = "Clientes <small>Tienda Virtual</small>";
            $data['page_name'] = 'clientes';
            $data['page_functions_js'] = 'functions_clientes.js';
            $this->views->getView($this,'clientes',$data);
    
        }

    }
?>