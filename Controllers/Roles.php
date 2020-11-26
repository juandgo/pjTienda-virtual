<?php 
    class Roles extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            } 
            //Permisos por rol  de usuario
            getPermisos(2);
        }

        public function roles(){
            //Sí permisosMod en read es igual a true muestra el modulo usuarios 
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_id'] = 3;
            $data['page_tag'] = 'Roles Usuario';
            $data['page_name'] = "rol_usuario";
            $data['page_title'] = "Roles Usuario <small>Tienda Virtual</small>";
            $data['page_functions_js'] = 'functions_roles.js';
            $this->views->getView($this,"roles",$data);//Se utitiliza la vista dasboard 
        }

        public function getRoles(){
            $btnPermisosRol = "";
            $btnEditRol =  "";
            $btnDeleteRol = "";

            $arrData = $this->model->selectRoles(); 
            //Convierto el array a un formato jSon para que pueda ser interpretado por cualquier lenguaje de programacion 
            for ($i=0; $i < count($arrData) ; $i++) { 
                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }
 
                 if ($_SESSION['permisosMod']['u']) {
                    $btnPermisosRol = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol'].')" title="Permisos"><i class="fas fa-key"></i></button>';
                    $btnEditRol =  '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                 }
 
                 if ($_SESSION['permisosMod']['d']) {
                     $btnDeleteRol = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                 }
                 //Se concatenan las variables paraque puedan se mostradas en la tabla por medio del array
                 $arrData[$i]['options'] = '<div class="text-center">'.$btnPermisosRol.' '.$btnEditRol.' '.$btnDeleteRol.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//el unicode forza a que se combierta en un ojeto en caso de que tenga caracteres especiales
            die();//finaliza el proceso
            // dep($arrData);
        }

        public function getSelectRoles(){
            $htmlOptions= "";
            $arrData = $this->model->selectRoles();
            if(count($arrData) > 0){
                for ($i=0; $i < count($arrData); $i++) { 
                    if ($arrData[$i]['status'] == 1){
                    $htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombrerol'].'</option>';
                    }
                }
            }
            echo $htmlOptions;
            die();
        }

        public function getRol(int $idrol){

            $intIdRol = intval(strClean($idrol));//se convierte a int con intval y el strClean limpia en caso de que sea un string o inyeccion sql
            if ($intIdRol > 0) {
                $arrData = $this->model->selectRol($intIdRol);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);//da la respuesta
            }
            die();
        }

        public function setRol(){

            $intIdRol = intval($_POST['idRol']);// Este es el idRol del modal
            //la funcion strClean limpa los campos
            $strRol = strClean($_POST['txtNombre']);
            $strDescripcion = strClean($_POST['txtDescripcion']);
            $intStatus = intVal($_POST['listStatus']);//intVal convierte a entero 
            //Se envia la informacion al modelo 

            if ($intIdRol == 0) {
                //Crear
                $request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
                $option = 1;
            }else {
                //Acrtualizar
                $request_rol = $this->model->updateRol($intIdRol, $strRol, $strDescripcion, $intStatus);
                $option = 2;
            }
            //Si la respuesta anterior es igual a 1 o 2 quiere decir que si se inserto el query 
            if ($request_rol > 0) {
                if ($option == 1) {
                    $arrResponse = array('status'=> true, 'msg'=>'Datos guardados correctamente');
                }else {
                    $arrResponse = array('status'=> true, 'msg'=>'Datos actualizados correctamente');
                }
            }else if($request_rol == 'exist'){
                $arrResponse = array('status'=> false, 'msg'=>'¡Atención! El Rol ya existe.');
            }else {
                $arrResponse = array('status'=> false, 'msg'=>'No es posible almacenar los datos.');
            }
            // sleep(3);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();//Se detiene el proceso.
        }

        public function delRol(){

            if ($_POST) {
                $intIdRol = intval($_POST['idrol']);//Este es el idrol del dato
                $requestDelete = $this->model->deleteRol($intIdRol);
                if ($requestDelete == 'ok'){
                    $arrResponse = array('status'=> true, 'msg'=>'Se ha eliminado el Rol.');
                }else if($requestDelete == 'exist'){
                    $arrResponse = array('status'=> false, 'msg'=>'No es posible eliminar un Rol asociado a usuarios.');
                }else {
                    $arrResponse = array('status'=> false, 'msg'=>'Error al elimnar el Rol.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();//Se detiene el proceso.
        }
    }
?> 