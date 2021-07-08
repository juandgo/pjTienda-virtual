<?php 
    class Home extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function home(){
            $data['page_tag'] = NOMBRE_EMPRESA;
            $data['page_title'] = NOMBRE_EMPRESA;
            $data['page_name'] = "tienda_virtual";
            $this->views->getView($this,"home",$data);
    
        }

        // public function insertar(){
        //     $data = $this->model->setUser("Rodrig", 16);
        //     print_r($data);
        // }

        // public function verUsuario($id){
        //     $data = $this->model->getUser($id);
        //     print_r($data); 
        // }

        // public function actualzar(){
        //     $data = $this->model->updateUser(1,"Robert", 20);
        //     print_r($data);
        // }

        // public function verUsuarios(){
        //     $data = $this->model->getUsers();
        //     print_r($data);
        // }

        // public function eliminarUsuario($id){
        //     $data = $this->model->deleteUser($id);
        //     print_r($data);
        // }
    }
?>