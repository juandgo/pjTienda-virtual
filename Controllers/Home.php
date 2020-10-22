<?php 
    class Home extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function home(){
            $data['page_id'] = 1;
            $data['page_tag'] = 'Home';
            $data['page_title'] = "Página principal";
            $data['page_name'] = 'home';
            $data['page_content'] = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eveniet, laudantium pariatur ducimus recusandae nulla impedit nisi iste, veritatis cum earum minima minus iusto doloremque dolorem quas sint eum voluptate. Saepe.  ';
            $this->views->getView($this,'home',$data);
    
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