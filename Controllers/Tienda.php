<?php 
        require_once("Models/TCategoria.php");
        require_once("Models/TProducto.php");
    class Tienda extends Controllers{
        use TCategoria, TProducto;
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
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
                $arrParams = explode(",",$params);
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
    }   

?>