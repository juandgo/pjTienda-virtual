<?php 
    class Usuarios   extends Controllers{
        public function __construct(){
            parent::__construct();//ejecuta el metodo constructor de la clase Controllers
        }

        public function Usuarios(){
            $data['page_tag'] = 'Usuarios';
            $data['page_title'] = "Usuarios <small>Tienda Virtual</small>";
            $data['page_name'] = 'usuarios';
            $this->views->getView($this,'usuarios',$data);
    
        }

        public function setUsuario(){
            if ($_POST) {
                //Valida si no existe algun dato en el elemento//Nota: esta validacion ya se hizo en js pero tambien es importante hacerlo aca dellado del backend
                if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listStatus'])) {
                    $arrRespose = array("status" => false, "msg" =>'Datos incorrectos. ');
                }else{
                    $strIdentificacion = intval($_POST['txtIdentificacion']);
                    $strNombre = strclean($_POST['txtNombre']);
                    $strApellido = strClean($_POST['txtApellido']);
                    $intTelefono= intval($_POST['txtTelefono']);
                    $strEmail = strClean($_POST['txtEmail']);
                    $intTipoUsuario = intval($_POST['listRolid']);
                    $strPassword = intval($_POST['listStatuss']); 
                    
                }
            }
            die();

        }
    }

?>