<?php 
class Conexion{
    private $connect;

    public function __construct(){
        $connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";.DB_CHARSET.";
        try {
            $this->connect = new PDO($connectionString,DB_USER, DB_PASSWORD);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//esto ayuda a detectar con mas facilidad los errores que posibles durante el desarrollo
        } catch (PDOException $e) {
            $this->connect = "Error de conexion";
            echo "ERROR: ".$e->getMessage();
        } 
    }
    //Retorna la variable connect 
    public function getConnect(){
        return $this->connect;
    }
}
?>