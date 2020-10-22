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
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//el unicode forza a que se combierta en un ojeto en caso de que tenga caracteres especiales
            die();//finaliza el proceso
            // dep($arrData);
        }
    }
?> 