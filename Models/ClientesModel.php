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
        
        public function selectClientes(){
            
            $sql = "SELECT idpersona, identificacion, nombres, apellidos, telefono, email_user, status
                    FROM persona 
                    WHERE rolid = 7 and status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectCliente(int $idpersona){
            //la funcion DATE_FORMAT sirve para mostra la fecha a preferecia del desarrollados ya sea con hora o sin hora  o tambien su orden. 
            $this->intIdUsuario = $idpersona;
            $sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,nit,nombrefiscal,         
                            direccionfiscal, status, DATE_FORMAT(datecreated, '%d-%m-%y') as fechaRegistro
                    FROM persona 
                    WHERE idpersona = $this->intIdUsuario AND rolid = 7";
                    // echo $sql;exit;
            $request = $this->select($sql);
            return $request;
        }

        public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, $nit, $nomFiscal, $dirFiscal){

			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->strNit = $nit;
			$this->strNomFiscal = $nomFiscal;
			$this->strDirFiscal = $dirFiscal;

            //Valida sí la identificacion y el correro solo estan siendo usados por el usuario ingresado y no que otro no los tiene.  
			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
			$request = $this->select_all($sql);
          
        $request = $this->select_all($sql);

        if(empty($request)){
                //Actualiza con password
				if($this->strPassword  != ""){
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, nit=?, nombrefiscal=?, direccionfiscal=? 
							WHERE idpersona = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
	        						$this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->strPassword,
                                    $this->strNit,
                                    $this->strNomFiscal,
                                    $this->strDirFiscal);
				}else{
                    //Actualiza sin password
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, nit=?, nombrefiscal=?, direccionfiscal=? 
							WHERE idpersona = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
	        						$this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
                                    $this->strNit,
                                    $this->strNomFiscal,
                                    $this->strDirFiscal);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
        }
        
    }
?>