<?php 
    
    //funcion para poder cargar las clases de forma automatica.
    // esta funcion tiene otra funcion interna como parametro.
    spl_autoload_register(function($class){
        if (file_exists("Libraries/".'Core/'.$class.'.php')) {//concatena
            require_once("Libraries/".'Core/'.$class.'.php');
        }
    });


?>

