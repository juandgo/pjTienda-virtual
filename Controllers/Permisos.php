<?php 
    class Permisos extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        function getPermisosRol(int $idrol){
            
            $rolid = intval($idrol);
            if ($rolid > 0) {
                $arrModulos = $this->model->selectModulos();
                $arrPermisosRol = $this->model->selectPermisosRol($rolid);
                //dep sirve para depurar y visualizar en consola los array
                // dep($arrModulos);
                // dep($arrPermisosRol);
                $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                $arrPermisosRol = array('idrol' => $rolid);

            }
        }
        
        
    }

?>