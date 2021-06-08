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