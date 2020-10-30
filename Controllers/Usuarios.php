<?php 
    class Usuarios   extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function Usuarios(){
            $data['page_tag'] = 'Usuarios';
            $data['page_title'] = "Usuarios <small>Tienda Virtual</small>";
            $data['page_name'] = 'usuarios';
            $this->views->getView($this,'usuarios',$data);
    
        }

        public function getUsuario() {
            // dep($_POST);
                echo $_POST['txtNombre'];
            die();
        }
    }

?>