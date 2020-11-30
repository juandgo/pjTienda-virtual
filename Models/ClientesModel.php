<?php 
    
    class ClientesModel extends Mysql{

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
        private $strNit;
		private $strNomFiscal;
		private $strDirFiscal;

        public function __construct(){
            parent::__construct();
        }

        public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, string $nit, string $nomFiscal, string $dirFiscal){

            $this->strIdentificacion = $identificacion;
            $this->strNombre = $nombre;
            $this->strApellido = $apellido;
            $this->intTelefono = $telefono;
            $this->strEmail = $email;
            $this->strPassword = $password;
            $this->intTipoId = $tipoid;
            $this->strNit = $nit;
            $this->strNomFiscal = $nomFiscal;
            $this->strDirFiscal = $dirFiscal;
            
            $respuesta = 0;
            //Se coloca '{$this->strEmail}'  por que es un dato varchar 
        $sql = "SELECT * FROM persona WHERE email_user = '{$this->strEmail}' OR identificacion = '{$this->strIdentificacion}'";

            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,nit,nombrefiscal,direccionfiscal) VALUES(?,?,?,?,?,?,?,?,?,?)";

                $arrData = array($this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->strPassword,
                                $this->intTipoId,
                                $this->strNit,
                                $this->strNomFiscal,
                                $this->strDirFiscal);
                $request_insert = $this->insert($query_insert,$arrData);
                $respuesta = $request_insert;
            }else{
                $respuesta = "exist";
            }

            return $respuesta;

        }  
        
    }
?>