<?php
    class Productos extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//Solo con esto se podran crear variables de sesión
            session_regenerate_id(true);//Genera un nuevo Id y Borra el aterior, esto con el fin de que no quede en las cokies 
            //valida si la sesión existe, si no te regresa al formulario login 
            if (empty($_SESSION['login'])) {
                header("Location:".base_url()."/login");
            }
            //permisos por el id de productos
            getPermisos(4);
        }

        public function Productos(){
            //Sí permisosMod en read es igual a true muestra el modulo usuarios 
            if (empty($_SESSION['permisosMod']['r'])) {
                header("Location:".base_url().'/dashboard');//redirecciona al dashboard 
            }
            $data['page_tag'] = 'Productos';
            $data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
            $data['page_name'] = 'productos';
            $data['page_functions_js'] = 'functions_productos.js';
            $this->views->getView($this,'productos',$data);
        }

        public function setProducto(){
            if($_POST){
                //Atencion el dep(); exit(); solo imprime e interrumpe el proceso de la funcion, esto lo ago para ver que informacion se esta enviando por ajax
                // dep($_POST);
                // die();
                // dep($_FILES);
                // exit();
                if (empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus'])) {
                    $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
                }else{
                    $idProducto = intval($_POST['idProducto']);
                    $strNombre = strClean($_POST['txtNombre']);
                    $strDescripcion = strClean($_POST['txtDescripcion']);
                    $strCodigo = strClean($_POST['txtCodigo']);
                    $intCategoriaId = intval($_POST['listCategoria']);
                    $strPrecio= strClean($_POST['txtPrecio']);
                    $intStock= intval($_POST['txtStock']);
                    $intStatus = intVal($_POST['listStatus']);//intVal convierte a entero 

                    $ruta = strtolower(clear_cadena($strNombre));//transforma a minuscula y quita caracteres raros como una ñ o tilde, clear_cadena esta creada en herlpers.
                    $ruta = str_replace(" ","-",$ruta);//Remplaza espacios por guiones
                    //Se envia la informacion al modelo 
                    if ($idProducto == 0 ) {
                        $option = 1;
                        if ($_SESSION['permisosMod']['w']) {
                            $request_producto = $this->model->insertProducto($strNombre,
                                                                            $strDescripcion,
                                                                            $strCodigo,
                                                                            $intCategoriaId,
                                                                            $strPrecio,
                                                                            $intStock,
                                                                            $ruta,
                                                                            $intStatus);
                        }
                    }else{
                        $option = 2;
                        if ($_SESSION['permisosMod']['u']) {
                            $request_producto = $this->model->updateProducto($idProducto,
                                                                            $strNombre,
                                                                            $strDescripcion,
                                                                            $strCodigo,
                                                                            $intCategoriaId,
                                                                            $strPrecio,
                                                                            $intStock,
                                                                            $ruta,
                                                                            $intStatus);
                        }
                    }

                    if($request_producto > 0){//Si es mayor que cero quiere decir que si se almaceno o actualizo.
                        if ($option == 1) {//Si se almacena muestra mensaje.
                            $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
                        }else{
                            $arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Datos Actualizados correcatamente.');
                        }
                    }else if($request_producto == 'exist'){
                        $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código de Barras Ingresado.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
                    }
                    
                }
                // sleep(3);
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();//Se detiene el proceso.
        }

        public function getProductos(){
            //si la variable de session tiene valor 1 en r (read) realiza el proceso para devolver las categorias, esto espor si intentan acceder a este metodo por medio de la url  
            if ($_SESSION['permisosMod']['r']) {//estas validaciones se hacen para ponerle seguridad a la pagina
                $arrData = $this->model->selectProductos();
                // dep($arrData);
                // exit;
                //Recorro los registros del array
                for ($i=0; $i < count($arrData) ; $i++) { 
                    $btnView = "";
                    $btnEdit =  "";
                    $btnDelete = "";
                    //cONCATENO EL SIMBOLO DE LA MODENDA CON EL METODO FORMAT MONEY CREADO EN HELPERS
                    $arrData[$i]['precio'] = SMONEY.'  '.formatMoney($arrData[$i]['precio']);

                    if ($arrData[$i]['status'] == 1) {
                        $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                    } else {
                        $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                    }
                    
 
                    if ($_SESSION['permisosMod']['r']) {
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver producto"><i class="fas fa-eye"></i></button>'; 
                    }
                    if ($_SESSION['permisosMod']['u']) {
                        //con el this ya sé que voy a enviar todo el boton 
                        $btnEdit =  '<button class="btn btn-primary btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if ($_SESSION['permisosMod']['d']) {
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>
                        <!--el title=Eliminar es un tooltip--> ';  
                    }
                    //Se concatenan las variables paraque puedan se mostradas en la tabla por medio del array
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                }
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
            }    
            die();
        }

        public function getProducto($idproducto){
            if ($_SESSION['permisosMod']['r']) {
                $idProducto = intval($idproducto);
                // echo $idProducto;
                // exit;
                if($idProducto > 0){
                    $arrData = $this->model->selectProducto($idProducto);
                    if (empty($arrData)) {
                        $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                    }else{
                        $arrImg = $this->model->selectImages($idproducto);
                        // dep($arrImg);
                        if (count($arrImg) > 0) {
                            for ($i=0; $i < count($arrImg); $i++) { 
                                //tomo la ruta de la imagen 
                                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                            }
                        }
                        //El arrData agarra el arrImg
                        $arrData['images'] = $arrImg;
                        $arrResponse = array('status' => true, 'data' => $arrData);
                    }
                    // dep($arrData);
                    // dep($arrResponse);
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
                }
            }
            die();
        }

        public function setImage(){
            // dep($_POST);
            // dep($_FILES);
            if ($_POST) {
                if (empty($_POST['idproducto'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Error de dato.');
                }else{
                    $idProducto = intval($_POST['idproducto']);
                    // $idProducto = 2; //Esto lo hice para probar que funcionara 
                    $foto = $_FILES['foto'];//esto espara poder acceder a todos los elementos de la imagen
                    $imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';//pro_ abreviatura de producto, esto se concatena para darle un nombre a la imagen con la fecha de creacion 
                    $request_image = $this->model->insertImage($idProducto,$imgNombre);
                    if($request_image){// si hay imagen 
                        $uploadImage = uploadImage($foto,$imgNombre);
                        $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Error de carga.');
                    }
                }
                // $arrResponse = array('status' => true, 'imgname' => "img_654sd65f4654f.jpg");
                // sleep(3);
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
            }
            die();
        }

        public function delFile(){
           
            if ($_POST) {
                if (empty($_POST['idproducto']) || empty($_POST['file'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
                }else{
                    //Eliminar de la DB
                    $idProducto = intval($_POST['idproducto']);
                    $imgNombre = strClean($_POST['file']);//pro_ abreviatura de producto, esto se concatena para darle un nombre a la imagen con la fecha de creacion 
                    $request_image = $this->model->deleteImage($idProducto,$imgNombre);
                    if($request_image){// si hay imagen 
                        $deleteFile = deleteFile($imgNombre);
                        $arrResponse = array('status' => true, 'msg' => 'Archivo eliminado.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Error al eliminar.');
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
            }
            die();
        }

        public function delProducto(){
            if ($_POST) {
                if ($_SESSION['permisosMod']['d']) {{}
                    $intIdProducto = intval($_POST['idProducto']);
                    $requestDelete = $this->model->deleteProducto($intIdProducto);
                    if ($requestDelete) {//Si solicita emilmnar producto
                        $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);//Devuelve un formato JSON
                }
            }
            die();
        }
            
    }
