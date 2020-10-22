<?php
//Load
$controller = ucwords($controller); //esto es para poner la primer letra de los contrladores en mayuscula en la url y asi pueda ser detectado por el hosting
$controllerFile = "Controllers/" . $controller . ".php";
if (file_exists($controllerFile)) {
    require_once($controllerFile); //requiere la variable del controlador archivo  
    $controller = new $controller(); //instancia  
    if (method_exists($controller, $method)) {
        $controller->{$method}($params); //pide los parametros del metodo 
    } else {
        require_once("Controllers/Error.php");
    }
} else {
    require_once("Controllers/Error.php");
}
