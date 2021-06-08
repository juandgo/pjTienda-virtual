<?php 
    
    class ProductosModel extends Mysql{

        public $intIdPoducto;
        public $strNombre;
        public $strDescripcion;
        public $strCodigo;
        public $intPrecio;
        public $intStock;
        public $intStatus;


        public function __construct(){
            parent::__construct();
        }

        public function insertProducto(string $nomProducto, string $descripcion, string $portada, int $status){
            $return = 0;
            $this->strProducto = $nomProducto;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->intStatus = $status;

            $sql = "SELECT * FROM producto WHERE nombre = '{$this->strProducto}'";
            $request = $this->select_all($sql);
            //Sí la consulta no exite  se puede insertar 
            if (empty($request)) {
                $query_insert = "INSERT INTO producto(nombre, descripcion, portada, status) VALUES(?,?,?,?)";
                $arrData = array($this->strProducto,
                                $this->strDescripcion,
                                $this->strPortada,
                                $this->intStatus);

                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectProductos(){
            
            $sql = "SELECT * FROM producto 
                    WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }
    }    