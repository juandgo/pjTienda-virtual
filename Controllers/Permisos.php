<?php 
    class Permisos extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function getPermisosRol(int $idrol){
            
            $rolid = intval($idrol);
            if ($rolid > 0) {
                
                $arrModulos = $this->model->selectModulos();
                $arrPermisosRol = $this->model->selectPermisosRol($rolid);
                $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                $arrPermisosRol = array('idrol' => $rolid );
                //dep sirve para depurar y visualizar en consola los array
                // dep($arrModulos);
                // dep($arrPermisosRol);
               

                if (empty($arrPermisosRol)) {
                    
                    for ($i=0; $i < count($arrModulos) ; $i++) { 

                        $arrModulos[$i]['permisos'] = $arrPermisos;
                    }
                }
                dep($arrModulos);
                // dep($arrPermisosRol);


            }
        }
        
        
    }

?>