<?php 
    
    class UsuariosModel extends Mysql{

        private $intIdUsuario;
        private $strIdentificacion;
        private $strNombre;
        private $strApellido;
        private $intTelefono;
        private $strEmail;
        private $strPassword;
        private $strToken;
        private $intTipoId;
        private $intStatus;

        public function __construct(){
            parent::__construct();
        }

        public function insertUsuario(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status ){

            $this->strIdentificacion = $identificacion;
            $this->strNombre = $nombre;
            $this->strApellido = $apellido;
            $this->intTelefono = $telefono;
            $this->strEmail = $email;
            $this->strPassword = $password;
            $this->intTipoId = $tipoid;
            $this->strStatus = $status;
            $return = 0;

            $sql = "SELECT * FROM persona WHERE email_user = '{$this->strEmail}' or identificacion = $this->strIdentificacion";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,status) VALUES(?,?,?,?,?,?,?,?)";
            }

        }
    }

?>