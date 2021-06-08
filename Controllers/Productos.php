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
                // dep($_FILES);
                // exit();
                // die();
                if (empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus'])) {
                    $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
                }else{
                    $idProducto = intval($_POST['idProducto']);
                    $strNombre = strClean($_POST['txtNombre']);
                    $strDescripcion = strClean($_POST['txtDescripcion']);
                    $strCodigo = strClean($_POST['txtCodigo']);
                    $intCategoriaId = intval(strClean($_POST['listCategoria']));
                    $strPrecio= strClean($_POST['txtPrecio']);
                    $intStock= intval(strClean($_POST['txtStock']));
                    $intStatus = intVal($_POST['listStatus']);//intVal convierte a entero 
                    //Se envia la informacion al modelo 
                    
                    if ($idProducto == 0 ) {
                        $option = 1;
                        $request_producto = $this->model->insertProducto
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
                        //con el this ya se que voy a enviar todo el boton 
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

        
    }