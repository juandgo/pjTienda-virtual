<?php 
    
    class PermisosModel extends Mysql{
         
        public $intIdPermiso;
        public $intRolId;
        public $intModuloId;
        public $r;
        public $w;
        public $u;
        public $d;

        public function __construct(){
            parent::__construct();
        }

        public function selectModulos(){
            $sql = "SELECT * FROM modulo WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }
    }

?>