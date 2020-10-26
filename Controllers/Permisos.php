<?php 
    class Permisos extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        function getPermisosRol(int $idrol){
            
            $rolid = intval($idrol);
            if ($rolid > 0) {
                $arrModulos = $this->model->selectModulos();
            }
        }
        
    }

?>