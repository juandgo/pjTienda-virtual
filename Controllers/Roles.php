<?php 
    class Roles extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function roles(){
            $data['page_id'] = 3;
            $data['page_tag'] = 'Roles Usuario';
            $data['page_name'] = "rol_usuario";
            $data['page_title'] = "Roles Usuario <small>Tienda Virtual</small>";
            $this->views->getView($this,"roles",$data);//Se utitiliza la vista dasboard 
        }

        public function getRoles(){
            $arrData = $this->model->selectRoles(); 
            //Convierto el array a un formato jSon para que pueda ser interpretado por cualquier lenguaje de programacion 
            for ($i=0; $i < count($arrData) ; $i++) { 
                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                $arrData[$i]['options'] = '<div class="text-center">
                <button class="btn btn-secondary btn-sm btnPermisosRol" rl="'.$arrData[$i]['idrol'].'" title="Permisos"><i class="fas fa-key"></i></button>                        
                <button class="btn btn-primary btn-sm btnEditRol" rl="'.$arrData[$i]['idrol'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelRol" rl="'.$arrData[$i]['idrol'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                <!--el title=Eliminar es un tooltip--> 
                                            </div>';
                
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//el unicode forza a que se combierta en un ojeto en caso de que tenga caracteres especiales
            die();//finaliza el proceso
            // dep($arrData);
        }
    }
?> 