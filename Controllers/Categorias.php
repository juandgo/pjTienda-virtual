<?php 
    class Categorias extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//Solo con esto se podran crear variables de sesión
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            //permisos por rol de usuario
            getPermisos(6);
        }

        public function Categorias(){
            //Sí permisosMod en read es igual a true muestra el modulo usuarios 
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_tag'] = 'Categorias';
            $data['page_title'] = "CATEGORIAS <small>Tienda Virtual</small>";
            $data['page_name'] = 'categorias';
            $data['page_functions_js'] = 'functions_categorias.js';
            $this->views->getView($this,'categorias',$data);
    
        }
        public function setCategoria(){
            if($_POST){
                if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus'])) {
                    $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
                }else{
                    $intIdCategoria = intval($_POST['idCategoria']);
                    $strCategoria = strClean($_POST['txtNombre']);
                    $strDescripcion = strClean($_POST['txtDescripcion']);
                    $intStatus = intVal($_POST['listStatus']);//intVal convierte a entero 
                    //Se envia la informacion al modelo 
                    $foto              = $_FILES['foto'];
                    $nombre_foto       = $foto['name'];
                    $type              = $foto['type'];
                    $url_temp          = $foto['tmp_name'];
                    $imgPortada        = 'portada_categoria.png';

                    if ($nombre_foto != '') {
                        $imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';//La funcion md5 encripta la imagen  y con esto se le daun nombre aleatorio para que no se repita, esto es por si no se le da imagen a la categoria  
                    }
                    if ($intIdCategoria == 0) {
                        //Crear
                        $request_categoria = $this->model->insertCategoria($strCategoria, $strDescripcion, $imgPortada, $intStatus);
                        $option = 1;
                    }else {
                        //Acrtualizar
                        $request_categoria = $this->model->updateRol($intIdCategoria, $strCategoria, $strDescripcion, $intStatus);
                        $option = 2;
                    }
                    //Si la respuesta anterior es igual a 1 o 2 quiere decir que si se guardo o se actualizo la categoria 
                    if ($request_categoria > 0) {
                        if ($option == 1) {
                            $arrResponse = array('status'=> true, 'msg'=>'Datos guardados correctamente');
                            if($nombre_foto != ''){
                                uploadImage($foto, $imgPortada);
                            }
                        }else {
                            $arrResponse = array('status'=> true, 'msg'=>'Datos actualizados correctamente');
                        }
                    }else if($request_categoria == 'exist'){
                        $arrResponse = array('status'=> false, 'msg'=>'¡Atención! La csategoria ya existe.');
                    }else {
                        $arrResponse = array('status'=> false, 'msg'=>'No es posible almacenar los datos.');
                    }
                }
                // sleep(3);
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();//Se detiene el proceso.
        }

        public function getCategorias(){
            if ($_SESSION['permisosMod']['r']) {//estas validaciones se hacen para ponerle seguridad a la pagina
                $arrData = $this->model->selectCategorias();
                // dep($arrData);
                // exit;
                //Recorro los registros del array
                for ($i=0; $i < count($arrData) ; $i++) { 
                    $btnView = "";
                    $btnEdit =  "";
                    $btnDelete = "";

                    if ($arrData[$i]['status'] == 1) {
                        $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                    } else {
                        $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                    }
                    
 
                    if ($_SESSION['permisosMod']['r']) {
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idcategoria'].')" title="Ver categoria"><i class="fas fa-eye"></i></button>'; 
                    }

                    if ($_SESSION['permisosMod']['u']) {
                        $btnEdit =  '<button class="btn btn-primary btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idcategoria'].')" title="Editar categoria"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    
                    if ($_SESSION['permisosMod']['d']) {
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idcategoria'].')" title="Eliminar categoria"><i class="far fa-trash-alt"></i></button>
                        <!--el title=Eliminar es un tooltip--> ';  
                    }
                    //Se concatenan las variables paraque puedan se mostradas en la tabla por medio del array
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
            }    
            die();
        }

        public function getCategoria(int $idcategoria){

            $intIdCategoria = intval(strClean($idcategoria));//se convierte a int con intval y el strClean limpia en caso de que sea un string o inyeccion sql
            if ($intIdCategoria > 0) {
                $arrData = $this->model->selectCategoria($intIdCategoria);
                // dep($arrData);exit;
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else {
                    $arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];//la direccion es agregada al array
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                // dep($arrData);
                // exit;
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);//da la respuesta
            }
            die();
        }
    }
?>