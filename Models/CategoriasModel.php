<?php 
    
    class CategoriasModel extends Mysql{

        public $intIdCategoria;
        public $strCategoria;
        public $strDescripcion;
        public $strStatus;
        public $strPortada;

        public function __construct(){
            parent::__construct();
        }

        public function insertRol(string $nomCategoria, string $descripcion, string $strPortada, int $status){
            $return = 0;
            $this->strCategoria = $nomCategoria;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $strPortada;
            $this->intStatus = $status;

            $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}'";
            $request = $this->select_all($sql);
            //Sí la consulta no exite  se puede insertar 
            if (empty($request)) {
                $query_insert = "INSERT INTO rol(nombrerol, descripcion, portada, status) values(?,?,?,?)";
                $arrData = array($this->strCategoria,
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

    }
?>