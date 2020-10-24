<?php 
    
    class RolesModel extends Mysql{

        public $intIdRol;
        public $strRol;
        public $strDescripcion;
        public $intStatus;

        public function __construct(){
            parent::__construct();
        }

        public function selectRoles(){
            //Extrae Roles 
            $sql = "SELECT * FROM rol WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function insertRol(string $rol, string $descripcion, int $status){
            $return = "";
            $this->strRol = $rol;
            $this->strDescripcion = $descripcion;
            $this->intStatus = $status;

            $sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}'";
            $request = $this->select_all($sql);
            //Si la consulta no exite  se puede insertar 
            if (empty($request)) {
                $query_insert = "INSERT INTO rol(nombrerol, descripcion, status) values(?,?,?)";
                $arrData = array($this->strRol,$this->strDescripcion,$this->intStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
    }

?>