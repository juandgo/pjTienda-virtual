<?php 
    
    class RolesModel extends Mysql{

        public function __construct(){
            parent::__construct();
        }

        public function selectRoles(){
            //Extrae Roles 
            $sql = "SELECT * FROM rol WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }
    }

?>