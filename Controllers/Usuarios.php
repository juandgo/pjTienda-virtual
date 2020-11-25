<?php 
    class Usuarios   extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//Solo con esto se podran crear variables de sesión
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            //permisos por rol de usuario
            getPermisos(2);
        }

        public function Usuarios(){
            //Sí permisosMod en read es igual a true muestra el modulo usuarios 
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_tag'] = 'Usuarios';
            $data['page_title'] = "Usuarios <small>Tienda Virtual</small>";
            $data['page_name'] = 'usuarios';
            $data['page_functions_js'] = 'functions_usuarios.js';
            $this->views->getView($this,'usuarios',$data);
    
        }

        public function setUsuario(){
            if ($_POST) {
                //Valida si no existe algun dato en el elemento//Nota: esta validacion ya se hizo en js pero tambien es importante hacerlo aca del lado del backend
                if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])) {
                    $arrRespose = array("status" => false, "msg" =>'Datos incorrectos. ');
                }else{
                    $idUsuario = intval($_POST['idUsuario']);
                    $strIdentificacion = strClean($_POST['txtIdentificacion']);//limpia el campo para tener un dato limpio
                    $strNombre = ucwords(strclean($_POST['txtNombre']));//Limpia el campo //La funcion ucwords convierte las primeras letras de cada palabra en mayuscula
                    $strApellido = ucwords(strClean($_POST['txtApellido']));
                    $intTelefono= intval(strClean($_POST['txtTelefono']));//limpia el campo y convierte a enteros
                    $strEmail = strtolower(strClean($_POST['txtEmail']));//limpia los campos y convierte las palabras en minuscula
                    $intTipoUsuario = intval(strClean($_POST['listRolid']));
                    $intStatus = intval(strclean($_POST['listStatus']));
                    //Si el id no existe es por que s va a gregar un nuevo usuario 
                    if ($idUsuario == 0) {
                        $option = 1;
                        //la funcion hash encripta la contraceña con SHA256
                        $strPassword = empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256", $_POST['txtPassword']);
                        
                        $request_user = $this->model->insertUsuario($strIdentificacion,
                                                                        $strNombre,
                                                                        $strApellido,
                                                                        $intTelefono,
                                                                        $strEmail,
                                                                        $strPassword,
                                                                        $intTipoUsuario,
                                                                        $intStatus); 
                    }else{//Actualiza Datos 
                        $option = 2;
                        //la funcion hash encripta la contraceña con SHA256
                        //Si la contraceña es vacia no se actualiza de lo contrario si actualiza
                        $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
                        
                        $request_user = $this->model->updateUsuario($idUsuario,
                                                                    $strIdentificacion,
                                                                    $strNombre,
                                                                    $strApellido,
                                                                    $intTelefono,
                                                                    $strEmail,
                                                                    $strPassword,
                                                                    $intTipoUsuario,
                                                                    $intStatus); 
                    }

                    if($request_user > 0){
                        if ($option == 1) {
                            $arrRespose = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        }else{
                            $arrRespose = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                        }
                    }elseif ($request_user == "exist") {
                        $arrRespose = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro. ');
                    }else{
                        $arrRespose = array('status' => false, 'msg' => 'No es posible almacenar los datos. ');
                    }
                    echo json_encode($arrRespose,JSON_UNESCAPED_UNICODE);//El array se convierte en formato json
                }
            }
            die();

        }

        public function getUsuarios(){
            $arrData = $this->model->selectUsuarios();
            
            for ($i=0; $i < count($arrData) ; $i++) { 
                $btnView = "";
                $btnEdit =  "";
                $btnDelete = "";

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                   $btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="fas fa-eye"></i></button>'; 
                }

                if ($_SESSION['permisosMod']['u']) {
                    //Sí es el usuario administrador  y si tiene el rol 1(Administrador)
                    //O sí la variable de sesion en elemento idrol es igul 1 y del array que recorre el for en la posicion que se encuentra en el elemento idrol es diferente de 1, no es un usuario administrador   
                    if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || 
                        ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)){
                        $btnEdit =  '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['idpersona'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
                    }else{
                        $btnEdit =  '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';              
                    }
                }
        

                if ($_SESSION['permisosMod']['d']) {
                    //Sí es el usuario administrador  y si tiene el rol 1(Administrador)                    
                    //O sí la variable de sesion en elemento idrol es igul 1 y del array que recorre el for en la posicion que se encuentra en el elemento idrol es diferente de 1, no es un usuario administrador 
                    if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || 
                        ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and 
                        ($_SESSION['userData']['idpersona'] != $arrData[$i]['idpersona'])){//Le bloquea el boton eliminarse a si mismo al super administrador y a los otros admiinistradores no los deja eliminarse a ellos mismos ni a otros administradores y a los usuarios comunes no los deja borrar ningun usuario 
                        $btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>
                        <!--el title=Eliminar es un tooltip--> ';
                    }else{
                        $btnDelete =  '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-trash-alt"></i></button>';  
                    }    
                }
                //Se concatenan las variables paraque puedan se mostradas en la tabla por medio del array
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
            die();
        }

        public function getUsuario(int $idpersona){
            $idusuario = intval($idpersona);
            if ($idusuario > 0) {
                $arrData = $this->model->selectUsuario($idusuario);
				if(empty($arrData)){
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            // dep($arrResponse);
			die();
        }

        public function delUsuario(){
            if ($_POST) {
                $intIdUsuario = intval($_POST['idUsuario']);
                $requestDelete = $this->model->deleteUsuario($intIdUsuario);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
				}else{
					$arrResponse = array('status' => false, 'data' => 'Error al eliminar el usuario.');
                }
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
			die();
        }

        public function perfil(){
            $data['page_tag'] = 'Perfil';
            $data['page_title'] = "Perfil de usuario";
            $data['page_name'] = 'perfil';
            $data['page_functions_js'] = 'functions_usuarios.js';
            $this->views->getView($this,'perfil',$data);
        }
        //Actualiza datos del usuario
        public function putPerfil(){
            // dep($_POST);
            if($_POST){
                if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono'])){
                    $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
                }else{
                    $idUsuario = $_SESSION['idUser'];//Esta variable de sisión se crea al momento de logearse 
                    $strIdentificacion = strClean($_POST['txtIdentificacion']);
                    $strNombre = ucwords(strclean($_POST['txtNombre']));
                    $strApellido = ucwords(strClean($_POST['txtApellido']));
                    $intTelefono= intval(strClean($_POST['txtTelefono']));
                    $strPassword = "";
                    if (!empty($_POST['txtPassword'])){//Si hay password la encripta 
                        $strPassword = hash("SHA256", $_POST['txtPassword']);
                    }
                    //$request_user obtiene el valor de acuerdo a lo que se haga en el metodo updatePelfil
                    $request_user = $this->model->updatePerfil($idUsuario, 
                                                                $strIdentificacion,
                                                                $strNombre,
                                                                $strApellido,
                                                                $intTelefono,
                                                                $strPassword);
                    
                    if ($request_user) {
                        //esta funcion esta creada en helpers
                        sessionUser($_SESSION['idUser']);
                       $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                    }
                }
                // sleep(5);
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function putDFiscal(){
            // dep($_POST);// esto se hace para ver que se esta enviando por el metodo post
            if($_POST){
                if (empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtNombreFiscal'])){
                    $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
                }else{
                    $idUsuario = $_SESSION['idUser'];
                    $strNit = strClean($_POST['txtNit']);
                    $strNombreFiscal = strclean($_POST['txtNombreFiscal']);
                    $strDirFiscal = strClean($_POST['txtDirFiscal']);

                    $request_user = $this->model->updateDataFiscal($idUsuario, 
                                                                    $strNit,
                                                                    $strNombreFiscal,
                                                                    $strDirFiscal);

                    if ($request_user) {
                        sessionUser($_SESSION['idUser']);
                       $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                    }
                }   
                // sleep(3);
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
