<?php 
    
    class CategoriasModel extends Mysql{

        public $intIdCategoria;
        public $strCategoria;
        public $strDescripcion;
        public $strStatus;
        public $strPortada;

        public function __construct(){
            parent::__construct();
        }

        public function insertCategoria(string $nomCategoria, string $descripcion, string $portada, int $status){
            $return = 0;
            $this->strCategoria = $nomCategoria;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->intStatus = $status;

            $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}'";
            $request = $this->select_all($sql);
            //Sí la consulta no exite  se puede insertar 
            if (empty($request)) {
                $query_insert = "INSERT INTO categoria(nombre, descripcion, portada, status) VALUES(?,?,?,?)";
                $arrData = array($this->strCategoria,
                                $this->strDescripcion,
                                $this->strPortada,
                                $this->intStatus);

                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectCategorias(){
            
            $sql = "SELECT * FROM categoria 
                    WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectCategoria(int $idcategoria){
            //Extrae una categoria
            $this->intIdCategoria = $idcategoria;
            $sql = "SELECT * FROM categoria WHERE idcategoria = $this->intIdCategoria";
            $request = $this->select($sql);
            return $request;
        }

        public function updateCategoria(int $idcategoria, string $categoria, string $descripcion, string $portada, int $status){
			$this->intIdcategoria = $idcategoria;
			$this->strCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->intStatus = $status;
            //Esto es para que no se dupliquen las categorias
			$sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != $this->intIdcategoria";
			$request = $this->select_all($sql);

			if(empty($request)){// Si esta Vacia
				$sql = "UPDATE categoria SET nombre = ?, descripcion = ?, portada = ?, status = ? WHERE idcategoria = $this->intIdcategoria ";
				$arrData = array($this->strCategoria, 
								 $this->strDescripcion, 
								 $this->strPortada, 
								 $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

        public function deleteCategoria(int $idCategoria){
            $this->intIdCategoria = $idCategoria;
            //Se busca si la categoria esta asociado a un producto y  sí ya lo esta no se debe permitir la eliminacion     
            $sql = "SELECT * FROM producto WHERE categoriaid
             = $this->intIdCategoria";
            $request = $this->select_all($sql);
            //sí no existe el usuario  ejecutael query  
            if (empty($request)) {//Si esta vacio significa que no hay elementos relacionados con esta categoria asi que permite eliminar 
                //No se elimina si no que actualiza, por que es recomendable no eliminar los registros de una base de datos  
                $sql = "UPDATE categoria SET status = ? WHERE idcategoria = $this->intIdCategoria";// es estado va a ser 0
                $arrData = array(0);
                $request = $this->update($sql, $arrData);
                if ($request) { 
                    $request = 'ok';
                }else{
                    $request = 'exist';
                }
            }else{
                $request = 'exist';
            }
            return $request;
        }
    }
?>