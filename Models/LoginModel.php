<?php 
    
    class LoginModel extends Mysql{

        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;

        public function __construct(){
            parent::__construct();
        }
        
        public function loginUser(string $username, string $password){
            $this->strUsuario = $username;
            $this->strPassword = $password;
            $sql = "SELECT idpersona,status FROM persona 
                        WHERE email_user = '$this->strUsuario'
                        and password = '$this->strPassword'
                        and status != 0";
                        
            $request = $this->select($sql);
            return $request;        
        }

        public function sessionLogin(int $iduser){
            $this->intIdUsuario = $iduser;
            //Buscar Rol
            $sql = "SELECT p.idpersona,
                            p.identificacion,
                            p.nombres,
                            p.apellidos,
                            p.telefono,
                            p.email_user,
                            p.nit,
                            p.nombrefiscal,
                            p.direccionfiscal,
                            r.idrol,
                            r.nombrerol,
                            p.status
                    FROM persona p
                    INNER JOIN rol r
                    ON p.rolid = r.idrol
                    WHERE p.idpersona = $this->intIdUsuario";

            $request = $this->select($sql);
            return $request;
        }

        public function getUserEmail(string $email){
            $this->strUsuario = $email;
            $sql = "SELECT idpersona,nombres,apellidos,status FROM persona WHERE email_user = '$this->strUsuario' and  status = 1";
            $request = $this->select($sql);
            return $request; 
        }

        public function setTokenUser(int $idpersona, string $token){
            $this->intIdUsuario = $idpersona;
            $this->strToken = $token;
            $sql = "UPDATE persona SET token = ? WHERE idpersona = '$this->intIdUsuario'";
            $arrData = array($this->strToken);
            $request = $this->update($sql,$arrData);
            return  $request;
        }

        public function getUsuario(string $email, string $token){
            $this->strUsuario = $email;
            $this->strToken = $token;
            $sql= "SELECT idpersona FROM persona WHERE email_user = '$this->strUsuario' and token = '$this->strToken' and  status = 1";
            $request = $this->select($sql);
            return $request;

        }

        public function insertPassword(int $idPersona, string $password){
			$this->intIdUsuario = $idPersona;
			$this->strPassword = $password;
			$sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = $this->intIdUsuario ";
            $arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
        }
        
    }

    
    
?>    