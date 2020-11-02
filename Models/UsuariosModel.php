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
            $respuesta = 0;
            //Se coloca '{$this->strEmail}'  por que es un dato varchar 
        $sql = "SELECT * FROM persona WHERE email_user = '{$this->strEmail}' OR identificacion = '{$this->strIdentificacion}'";

            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,status) VALUES(?,?,?,?,?,?,?,?)";

                $arrData = array($this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->strPassword,
                                $this->intTipoId,
                                $this->strStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $respuesta = $request_insert;
            }else{
                $respuesta = "exist";
            }

            return $respuesta;

        }   

        public function selectUsuarios(){
            $sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono,  
                            p.email_user, p.status, r.nombrerol
                    FROM persona p
                    INNER JOIN rol r
                    ON p.rolid = r.idrol
                    WHERE p.status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectUsuario(int $idpersona){
            //la funcion DATE_FORMAT sirve para mostra la fecha a preferecia del desarrollados ya sea con hora o sin hora  o tambien su orden. 
            $this->intIdUsuario = $idpersona;
            $sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono,  
                            p.email_user, p.nit, p.nombrefiscal, p.direccionfiscal,r.idrol, r.nombrerol, p.status,
                    DATE_FORMAT(p.datecreated, '%d-%m-%y') as fechaRegistro
                    FROM persona p
                    INNER JOIN rol r
                    ON p.rolid = r.idrol
                    WHERE p.idpersona = $this->intIdUsuario";
                    // echo $sql;exit;
            $request = $this->select($sql);
            return $request;
        }
        
        public function updateUsuario(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){

			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;

            //Valida sí la identificacion y el correro solo estan siendo usados por el usuario ingresado y no que otro no los tiene.  
			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
			$request = $this->select_all($sql);
          
        $request = $this->select_all($sql);

        if(empty($request)){
				if($this->strPassword  != ""){
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, rolid=?, status=? 
							WHERE idpersona = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
	        						$this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->strPassword,
	        						$this->intTipoId,
	        						$this->intStatus);
				}else{
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, rolid=?, status=? 
							WHERE idpersona = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
	        						$this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->intTipoId,
	        						$this->intStatus);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}
} 

?>