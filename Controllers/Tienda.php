<?php 
        require_once("Models/TCategoria.php");
        require_once("Models/TProducto.php");
    class Tienda extends Controllers{
        use TCategoria, TProducto;
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
            session_start();//con esto puedo usar variables de session
        }

        public function tienda(){

            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA;
            $data['page_name'] = "tienda";
            $data['productos'] = $this->getProductosT();
            $this->views->getView($this,"tienda",$data);
    
        }

        public function categoria($params){
            if(empty($params)){
                header("Location:".base_url());
            }else{
                // echo $params;
                // exit;
                $arrParams = explode(",",$params);//explode es una funcion propia de php para crear un array cuando encuentra una jota ","
				$idcategoria = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
                $infoCategoria = $this->getProductosCategoriaT($idcategoria, $ruta);
                // dep($infoCategoria);
                // exit;
                $categoria = strClean($params);
                // dep($this->getProductosCategoriaT($categoria));
                $data['page_tag'] = NOMBRE_EMPRESA." - ".$infoCategoria['categoria'];
                $data['page_title'] = $infoCategoria['categoria'];
                $data['page_name'] = "categoria";
                $data['productos'] = $infoCategoria['productos'];
                $this->views->getView($this,"categoria",$data);
            }
        }

        public function producto($params){
            // echo $params; exit; 
            if(empty($params)){
                header("Location:".base_url());
            }else{
                $arrParams = explode(",",$params);
                $idproducto = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
                $infoProducto = $this->getProductoT($idproducto,$ruta);
                if(empty($infoProducto)){
                    header("Location:".base_url());
                }
                $data['page_tag'] = NOMBRE_EMPRESA." - ".$infoProducto['nombre'];
                $data['page_title'] = $infoProducto['nombre'];
                $data['page_name'] = "producto";
                $data['producto'] =  $infoProducto;
                //muestra 8 prodducto es random (r)
                $data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],8,"r");
                $this->views->getView($this,"producto",$data);
            }
        }

        public function addCarrito(){
                // dep($_POST);
            if($_POST){
                // elimina la variable de session 
                // unset($_SESSION['arrCarrito']);exit;
                $arrCarrito = array();//$arrCarrito es igual array vacio
                $cantCarrito = 0;
                // Desencripto el id 
                $idproducto = openssl_decrypt($_POST['id'], METHODENCRYPT, KEY);
                $cantidad = $_POST['cant'];
                if(is_numeric($idproducto) and is_numeric($cantidad)){
                    $arrInfoProducto = $this->getProductoIDT($idproducto);
                    // dep($arrInfoProducto);
                    if(!empty($arrInfoProducto)){
                        $arrProducto = array('idproducto' => $idproducto,
                                            'producto' => $arrInfoProducto['nombre'],
                                            'cantidad' => $cantidad,
                                            'precio' => $arrInfoProducto['precio'],
                                            'imagen' => $arrInfoProducto['images'][0]['url_image']//agarra array de imagenes en la posicion 0
                                            );
                        // si existe esta variable de session quiere decir que ya se ha agregado productos a l carrito 
                        if(isset($_SESSION['arrCarrito'])){
                            $on = true;
                            $arrCarrito = $_SESSION['arrCarrito'];
                            for ($pr=0; $pr < count($arrCarrito); $pr++) { 
                                if ($arrCarrito[$pr]['idproducto'] == $idproducto) {
                                    $arrCarrito[$pr]['cantidad'] += $cantidad;
                                    $on = false;
                                }
                            }
                            if($on){// Si es verdadero agrega al carrito 
                                array_push($arrCarrito,$arrProducto);
                            }   
                            $_SESSION['arrCarrito'] = $arrCarrito;//creo la variable de seccion qu otinen el primer producto que se va a enviar product
                        }else{
                            array_push($arrCarrito, $arrProducto);
                            $_SESSION['arrCarrito'] = $arrCarrito;//creo la variable de seccion qu otinen el primer producto que se va a enviar product
                        }
                        foreach ($_SESSION['arrCarrito'] as $pro) {
                            $cantCarrito += $pro['cantidad'];
                            // dep($pro);
                        }
                        $htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
                        $arrResponse = array("status" =>true,
                                                "msg" =>'¡Se agrego al carrito!',
                                                "cantCarrito" => $cantCarrito,
                                                "htmlCarrito" => $htmlCarrito
                                            );
                    }else{
                        $arrResponse = array("status"=>false, "msg" => 'Producto no existente.');
                    }
                }else{
                    $arrResponse = array("status"=>false, "msg" => 'Dato incorrecto.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }   

?>