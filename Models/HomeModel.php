<?php 
    // require_once("CategoriasModel.php"); // Es una instacia 
    class HomeModel extends Mysql{

        private $objCategoria;
        public function __construct(){
            parent::__construct();
            // $this->objCategoria = new CategoriasModel();
        }

        //Utilizo metodo que esta en CategoriasModel.php
        public function getCategorias(){
            // return $this->objCategoria->selectCategorias();
        }



        //Esto fue un ejercio que hice al comenzar el curso 
        
        // public function setUser(string $nombre, int $edad){
        //     $query_insert = "INSERT INTO usuario(nombre,edad) VALUES(?,?)";
        //     $arrData = array($nombre, $edad);
        //     $request_insert = $this->insert($query_insert,$arrData);
        //     return $request_insert;
        // }

        // public function getUser($id) {
        //     $sql = "SELECT * FROM usuario WHERE id = $id";
        //     $request = $this->select($sql);
        //     return $request;
        // }

        // public function updateUser(int $id,string $nombre, int $edad){
        //     $sql = "UPDATE usuario set nombre = ?, edad = ? WHERE id = $id";
        //     $arrData = array($nombre,$edad);
        //     $request = $this->update($sql, $arrData);
        //     return $request;

        // }

        // public function getUsers(){
        //     $sql  = "SELECT * FROM usuario";
        //     $request = $this->select_all($sql);
        //     return $request;
        // }

        // public function deleteUser($id){
        //     $sql = "DELETE FROM usuario WHERE id = $id";
        //     $request = $this->delete($sql);
        //     return $request;
        // }
    }


?>