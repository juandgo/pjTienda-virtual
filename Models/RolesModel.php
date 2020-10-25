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

        public function selectRol(int $idrol){
            //Extrae un rol
            $this->intIdRol = $idrol;
            $sql = "SELECT * FROM rol WHERE idrol = $this->intIdRol";
            $request = $this->select($sql);
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

        public function updateRol(int $idrol, string $rol, string $descripcion, int $status){
            $this->intIdRol = $idrol;
            $this->strRol = $rol;
            $this->strDescripcion = $descripcion;
            $this->intStatus = $status;
            //Valida si el nombre del rol concuerda con el id del rol 
            $sql = "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND idrol != $this->intIdRol";

            if (empty($request)) {
                $sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdRol";
                $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
                $request = $this->update($sql, $arrData);
            }else {
                $request = "exist";
            }
            return $request;
        }
    }
    

?>