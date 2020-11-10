<?php 
    class Logout{

        public function __construct(){

            session_start();//crea la sesión
            session_unset();//Limpia la sesión
            session_destroy();//destruye la sesión
            header("location:".base_url()."/login");//direcciona al login 
        }
    }
?>