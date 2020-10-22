<?php 
    class Errors extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function notFound(){
            $this->views->getView($this,'error');
        }
    }

    $notFound = new Errors();
    $notFound->notFound();
?>