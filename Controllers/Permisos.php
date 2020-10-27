<?php 
    
	class Permisos extends Controllers{
		public function __construct(){
			parent::__construct();
		}

		public function getPermisosRol(int $idrol){
			$rolid = intval($idrol);
			if($rolid > 0){
				$arrModulos = $this->model->selectModulos();
				$arrPermisosRol = $this->model->selectPermisosRol($rolid);
				$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                $arrPermisoRol = array('idrol' => $rolid );
                //dep sirve para depurar y visualizar en consola los array
                // dep($arrModulos);
                // dep($arrPermisosRol);

				if(empty($arrPermisosRol)){
					for ($i=0; $i < count($arrModulos) ; $i++) { 

						$arrModulos[$i]['permisos'] = $arrPermisos;
                    }
                }else{
                    for ($i=0; $i < count($arrModulos); $i++) { 
                        $arrPermiso =  array('r' => $arrPermisoRol[i]['r'],
                                             'w' => $arrPermisoRol[i]['w'],
                                             'u' => $arrPermisoRol[i]['u'],
                                             'd' => $arrPermisoRol[i]['d']
                                            ); 
                        if ($arrModulos[$i]['idmodulo'] == $arrPermisosRol[$i]['moduloid']) {
                            $arrModulos[$i]['permisos'] =$arrPermisos;
                        }
                    }
                }
                $arrPermisoRols['modulos'] = $arrModulos;
                dep($arrModulos);


            }
        }
        
        
    }

?>