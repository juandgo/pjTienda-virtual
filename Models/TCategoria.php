<?php

require_once("Libraries/Core/Mysql.php");//Acedo a Libraries 
trait TCategoria{
    private $con;

    public function getCategoriasT(string $categorias){
        $this->con = new Mysql();//Instacio Mysql.php
        $sql = "SELECT idcategoria, nombre, descripcion, portada 
                 FROM categoria WHERE status != 0 AND idcategoria IN ($categorias)";
                 //el and es para hacer una consulta de las categorias que se van a mostrar en el slider
                 $request = $this->con->select_all($sql);
        //esto es para mostrar las fotos
        if (count($request) > 0) {
            for ($c=0; $c < count($request); $c++) { 
                $request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];
            }
        }
        return $request;
    }
}



?>