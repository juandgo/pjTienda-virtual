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

        public function setCliente(){
            if ($_POST) {
                //Valida si no existe algun dato en el elemento//Nota: esta validacion ya se hizo en js pero tambien es importante hacerlo aca del lado del backend
            if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) ||  empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) ){
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
                    $idUsuario = intval($_POST['idUsuario']);
                    $strIdentificacion = strClean($_POST['txtIdentificacion']);
                    $strNombre = ucwords(strClean($_POST['txtNombre']));
                    $strApellido = ucwords(strClean($_POST['txtApellido']));
                    $intTelefono = intval(strClean($_POST['txtTelefono']));
                    $strEmail = strtolower(strClean($_POST['txtEmail']));
                    $strNit = strClean($_POST['txtNit']);
                    $strNomFiscal = strClean($_POST['txtNombreFiscal']);
                    $strDirFiscal = strClean($_POST['txtDirFiscal']);
                    $intTipoId = 7;
                    //Si el id no existe es por que s va a gregar un nuevo usuario 
                    //Crea Usuario 
                    if ($idUsuario == 0) {
                        $option = 1;
                        //No se encripta para que el cliente pueda visualizar su clave
                        $strPassword = empty($_POST['txtPassword']) ? passGenerator() : $_POST['txtPassword'];
                        $strPasswordEncript = hash("SHA256",$strPassword);
                        $request_user = $this->model->insertCliente($strIdentificacion,
                                                                        $strNombre,
                                                                        $strApellido,
                                                                        $intTelefono,
                                                                        $strEmail,
                                                                        $strPasswordEncript,
                                                                        $intTipoId,
                                                                        $strNit,
                                                                        $strNomFiscal,
                                                                        $strDirFiscal); 
                    }else{//Actualiza Usuario
                        $option = 2;
                        //la funcion hash encripta la contraceña con SHA256
                        //Si la contraceña es vacia no se actualiza de lo contrario si actualiza
                        $strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
                        
                        $request_user = $this->model->updateCliente($idUsuario,
                                                                    $strIdentificacion, 
                                                                    $strNombre,
                                                                    $strApellido, 
                                                                    $intTelefono, 
                                                                    $strEmail,
                                                                    $strPassword, 
                                                                    $strNit,
                                                                    $strNomFiscal, 
                                                                    $strDirFiscal);
                    }

                    if($request_user > 0){
                        if ($option == 1) {
                            $arrRespose = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                            $nombreUsuario = $strNombre.' '.$strApellido;
                            $dataUsuario = array('nombreUsuario' => $nombreUsuario,
                                            'email' => $strEmail,
                                            'password' => $strPassword,
                                            'asunto' => 'Bienvenido a tu tienda en línea',
                                            'url_recovery' => $url_recovery);
                            $sendEmail = sendEmail($dataUsuario,'email_cambioPassword');
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

        public function getClientes(){
            $arrData = $this->model->selectClientes();
            // dep($arrData);
            // exit;
            //Recorro los registros del array
            for ($i=0; $i < count($arrData) ; $i++) { 
                $btnView = "";
                $btnEdit =  "";
                $btnDelete = "";

                if ($_SESSION['permisosMod']['r']) {
                   $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idpersona'].')" title="Ver cliente"><i class="fas fa-eye"></i></button>'; 
                }

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit =  '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['idpersona'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
                }
                
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpersona'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>
                    <!--el title=Eliminar es un tooltip--> ';  
                }
                //Se concatenan las variables paraque puedan se mostradas en la tabla por medio del array
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
            die();
        }

        public function getCliente(int $idpersona){
            $idusuario = intval($idpersona);
            if ($idusuario > 0) {
                $arrData = $this->model->selectCliente($idusuario);
                // dep($arrData);exit;
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

        public function delCliente(){
            if ($_POST) {
                $intIdUsuario = intval($_POST['idUsuario']);
                $requestDelete = $this->model->deleteCliente($intIdUsuario);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente.');
				}else{
					$arrResponse = array('status' => false, 'data' => 'Error al eliminar el cliente.');
                }
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
			die();
        }

    }
?>