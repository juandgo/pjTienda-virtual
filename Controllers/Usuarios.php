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
                    $strIdentificacion = strClean($_POST['txtIdentificacion']);//limpia el campo para tener un dato limpio
                    $strNombre = ucwords(strclean($_POST['txtNombre']));//Limpia el campo //La funcion ucwords convierte las primeras letras de cada palabra en mayuscula
                    $strApellido = ucwords(strClean($_POST['txtApellido']));
                    $intTelefono= intval(strClean($_POST['txtTelefono']));//limpia el campo y convierte a enteros
                    $strEmail = strtolower(strClean($_POST['txtEmail']));//limpia los campos y convierte las palabras en minuscula
                    $intTipoUsuario = intval(strClean($_POST['listRolid']));
                    $strPassword = intval(strClean($_POST['listStatus'])); 
                    
                }
            }
            die();

        }
    }

?>