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
            $this->views->getView($this,"home",$data);
    
        }

        public function categoria($params){
            if(empty($params)){
                header("Location:".base_url());
            }else{
                $categoria = strClean($params);
                // dep($this->getProductosCategoriaT($categoria));
                $data['page_tag'] = NOMBRE_EMPRESA." | ".$categoria;
                $data['page_title'] = $categoria;
                $data['page_name'] = "categoria";
                $data['productos'] = $this->getProductosCategoriaT($categoria);
                $this->views->getView($this,"categoria",$data);
            }
        }
    }   

?>