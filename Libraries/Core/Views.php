<?php 
    class Views{
        //concatena la ruta para poder encontrar la vista 
        function getView($controller,$view,$data=''){
            $controller = get_class($controller);
            if($controller == "Home"){
                $view ="Views/".$view.".php";
            }else{
                $view = "Views/".$controller."/".$view.".php";
            }
            require_once($view);
        }
    }


?>