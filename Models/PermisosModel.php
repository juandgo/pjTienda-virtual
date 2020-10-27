<?php 
    	class PermisosModel extends Mysql{
            public $intIdpermiso;
            public $intRolid;
            public $intModuloid;
            public $r;
            public $w;
            public $u;
            public $d;
    
            public function __construct()
            {
                parent::__construct();
            }
    
            public function selectModulos()
            {
                $sql = "SELECT * FROM modulo WHERE status != 0";
                $request = $this->select_all($sql);
                return $request;
            }	
            public function selectPermisosRol(int $idrol)
            {
                $this->intRolid = $idrol;
                $sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
                $request = $this->select_all($sql);
                return $request;
            }
    }

?>