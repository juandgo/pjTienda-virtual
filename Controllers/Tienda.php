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
                echo $params;
                exit();
                $categoria = strClean($params);
                // dep($this->getProductosCategoriaT($categoria));
                $data['page_tag'] = NOMBRE_EMPRESA." | ".$categoria;
                $data['page_title'] = $categoria;
                $data['page_name'] = "categoria";
                $data['productos'] = $this->getProductosCategoriaT($categoria);
                $this->views->getView($this,"categoria",$data);
            }
        }

        public function producto($params){
            if(empty($params)){
                header("Location:".base_url());
            }else{
                $producto = strClean($params);
                $arrProducto = $this->getProductoT($producto);
                // dep($this->getProductoT($producto));
                // dep($data['productos'] = $this->getProductosRandom($arrProducto['categoriaid'],8,'r'));
                $data['page_tag'] = NOMBRE_EMPRESA." | ".$producto;
                $data['page_title'] = $producto;
                $data['page_name'] = "producto";
                $data['producto'] =  $arrProducto;
                //muestra 8 prodducto es random (r)
                $data['productos'] = $this->getProductosRandom($arrProducto['categoriaid'],8,"r");
                $this->views->getView($this,"producto",$data);
            }
        }
    }   

?>