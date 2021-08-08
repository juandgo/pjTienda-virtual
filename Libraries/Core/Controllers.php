<?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    class Controllers{

        public function __construct(){
            $this->views  = new Views();
            $this->loadModel();
        }

        //carga los modelos
        public function loadModel(){
            //HomeModel.php
            $model = get_class($this)."Model";
            $routClass = "Models/".$model.".php";
            if (file_exists($routClass)) {
                require_once($routClass);
                $this->model = new $model();
            }
        }
    }

?>