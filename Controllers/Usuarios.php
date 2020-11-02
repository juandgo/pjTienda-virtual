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

        public function setUsuario(){
            if ($_POST) {
                //Valida si no existe algun dato en el elemento//Nota: esta validacion ya se hizo en js pero tambien es importante hacerlo aca del lado del backend
                if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])) {
                    $arrRespose = array("status" => false, "msg" =>'Datos incorrectos. ');
                }else{
                    $strIdentificacion = strClean($_POST['txtIdentificacion']);//limpia el campo para tener un dato limpio
                    $strNombre = ucwords(strclean($_POST['txtNombre']));//Limpia el campo //La funcion ucwords convierte las primeras letras de cada palabra en mayuscula
                    $strApellido = ucwords(strClean($_POST['txtApellido']));
                    $intTelefono= intval(strClean($_POST['txtTelefono']));//limpia el campo y convierte a enteros
                    $strEmail = strtolower(strClean($_POST['txtEmail']));//limpia los campos y convierte las palabras en minuscula
                    $intTipoUsuario = intval(strClean($_POST['listRolid']));
                    $intStatus = intval(strclean($_POST['listStatus']));

                    //la funcion hash encripta la contraceña
                    $strPassword = empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256", $_POST['txtPassword']);

                    $request_user = $this->model->insertUsuario($strIdentificacion,
                                                                    $strNombre,
                                                                    $strApellido,
                                                                    $intTelefono,
                                                                    $strEmail,
                                                                    $strPassword,
                                                                    $intTipoUsuario,
                                                                    $intStatus);
                    
                    if($request_user > 0){
                        $arrRespose = array('status' => true, 'msg' => 'Datos guardados correctamente. ');
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
                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                $arrData[$i]['options'] = '<div class="text-center">
                <button class="btn btn-info btn-sm btnViewUsuario" us="'.$arrData[$i]['idpersona'].'" title="Ver usuario"><i class="fas fa-eye"></i></button>                        
                <button class="btn btn-primary btn-sm btnEditUsuario" us="'.$arrData[$i]['idpersona'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelUsuario" us="'.$arrData[$i]['idpersona'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                <!--el title=Eliminar es un tooltip--> 
                </div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//Convierte a formato JSON
            die();
        }

        public function getUsuario(int $idpersona){
            $idusuario = intval($idpersona);
            if ($idusuario > 0) {
                $arrData = $this->model->selectUsuario($idusuario);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
        }
    }

?>