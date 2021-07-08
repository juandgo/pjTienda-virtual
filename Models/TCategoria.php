<?php

require_once("Libraries/Core/Mysql.php");
trait TCategoria{
    public $con;

    public function selectCategoriasT(string $categorias){
        $this->con = new Mysql();//Instacio Mysql.php
        $sql = "SELECT idcategoria, nombre, descripcion, portada 
                 FROM categoria WHERE status != 0 AND idcategoria IN ($categorias)";
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c=0; $c < count($request); $c++) { 
                $request[$c]['portada'] = BASE_URL.'/Asets/images/uploads/'.$request[$c]['portada'];
            }
        }
        return $request;
    }
}



?>