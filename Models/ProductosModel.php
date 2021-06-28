<?php 
    
    class ProductosModel extends Mysql{

        public $intIdProducto;
        public $intCategoriaId;
        public $strNombre;
        public $strDescripcion;
        public $strCodigo;
        public $intPrecio;
        public $intStock;
        public $intStatus;
        public $strImagen;
        
        public function __construct(){
            parent::__construct();
        }

        public function selectProductos(){
            
            $sql = "SELECT p.idproducto,
                            p.codigo,
                            p.nombre,
                            p.descripcion,
                            p.categoriaid,
                            c.nombre as categoria,
                            p.precio,
                            p.stock,
                            p.status
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE p.status != 0";
                    $request = $this->select_all($sql);
            return $request;
        }

        public function insertProducto(string $nomProducto, string $descripcion, string $codigo, int $categoriaid, string $precio, 
        int $stock, int $status){
            $return = 0;
            $this->strNombre = $nomProducto;
            $this->strDescripcion = $descripcion;
            $this->intCodigo = $codigo;
            $this->intCategoriaId = $categoriaid;
            $this->strPrecio = $precio;
            $this->intStock = $stock;
            $this->intStatus = $status;

            $sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}'";
            $request = $this->select_all($sql);
            //Sí la consulta no exite  se puede insertar 
            if (empty($request)) {//Si no existe el producto lo crea
                $query_insert = "INSERT INTO producto(categoriaid,
                                                        codigo,
                                                        nombre, 
                                                        descripcion, 
                                                        precio, 
                                                        stock, 
                                                        status) 
                                VALUES(?,?,?,?,?,?,?)";
                $arrData = array($this->intCategoriaId,
                                $this->intCodigo,
                                $this->strNombre,
                                $this->strDescripcion,
                                $this->strPrecio,
                                $this->intStock,
                                $this->intStatus);

                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateProducto(int $idProducto,string $nomProducto, string $descripcion, string $codigo, int $categoriaid, string $precio, 
        int $stock, int $status){
            
            $this->intIdProducto = $idProducto;
            $this->strNombre = $nomProducto;
            $this->strDescripcion = $descripcion;
            $this->intCodigo = $codigo;
            $this->intCategoriaId = $categoriaid;
            $this->strPrecio = $precio;
            $this->intStock = $stock;
            $this->intStatus = $status;
            //Busca que se encuentre en la tabla
            //las '{}' indica que es un dato varchar
            $sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}' AND idproducto != $this->intIdProducto";
            // echo $sql; exit;
            $request = $this->select_all($sql);
            //Sí la consulta no exite  se puede insertar 
            if (empty($request)) {//Si no existe el producto lo crea
                $sql = "UPDATE producto
                        SET categoriaid = ?,
                            codigo = ?,
                            nombre = ?, 
                            descripcion = ?, 
                            precio = ?, 
                            stock = ?, 
                            status = ?
                        WHERE idproducto = $this->intIdProducto";
                                //Nota: esto siempre tiene que estar en el orden del query
                $arrData = array($this->intCategoriaId,
                                $this->intCodigo,
                                $this->strNombre,
                                $this->strDescripcion,
                                $this->strPrecio,
                                $this->intStock,
                                $this->intStatus);
               

                $request = $this->update($sql,$arrData);
                $return = $request;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectProducto(int $idproducto){
            $this->intIdProducto = $idproducto;
            $sql = "SELECT p.idproducto,
                           p.codigo,
                           p.nombre,
                           p.descripcion,
                           p.precio,
                           p.stock,
                           p.categoriaid,
                           c.nombre as categoria,
                           p.status
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE idproducto = $this->intIdProducto";
            $request = $this->select($sql);
            return $request;
        }

        public function insertImage(int $idproducto, string $nomImagen){
            $this->intIdProducto = $idproducto;
            $this->strImagen = $nomImagen; 
            $query_insert = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
            $arrData = array($this->intIdProducto, 
                            $this->strImagen);          
            $request_insert = $this->insert($query_insert,$arrData);
            return $request_insert;
        }

        public function selectImages(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "SELECT productoid,img
					FROM imagen
					WHERE productoid = $this->intIdProducto";
			$request = $this->select_all($sql);
			return $request;
		}
    }    