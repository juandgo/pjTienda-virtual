<?php 
    //retorna la url del proyecto 
    function base_url() {
        return BASE_URL;
    }
    //Esta funcion es por si alguna ves se olvida poner /Assets con la letra en mayuscula en el url y asi pueda ser detectada por el hosting
    function media(){
        return BASE_URL."/Assets";//concatena con la url
    }
    //Estas funciones retornan el header, footer  y nav
    function headerAdmin($data =""){
        $view_header = "Views/Template/header_admin.php";
        require_once($view_header);
    }
    function footerAdmin($data =""){
        $view_footer= "Views/Template/footer_admin.php";
        require_once($view_footer);
    }
    //------------------------------------------------
    function headerTienda($data =""){
        $view_header = "Views/Template/header_tienda.php";
        require_once($view_header);
    }
    function footerTienda($data =""){
        $view_footer= "Views/Template/footer_tienda.php";
        require_once($view_footer);
    }
    //Imprime por consola la  informacion formateada
    function dep($data){
        $format = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }
    //Esta funcion se ejecuta cada vez que se va ejecutar un modal
    function getModal(string $nameModal, $data){
        $view_modal = "Views/Template/Modals/{$nameModal}.php";
        require_once $view_modal;
    }

    function getFile(string $url, $data){
        require_once("Views/{$url}.php");
        $file = ob_get_clean();//Levanta el archivo {$url} para tenerlo en buffer y de esta forma se pueden usar variables que se esta pasando por parametro
        return $file; 
    }

    function sendEmail($data,$template){
        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $empresa = NOMBRE_REMITENTE;
        $remitente = EMAIL_REMITENTE;
        //ENVIO DE CORREO
        $de = "MIME-Version: 1.0\r\n";
        $de .= "Content-type: text/html; charset=UTF8\r\n";//se le coloca el retorno de carro y un salto de linea
        $de .= "FROM: {$empresa}<{$remitente}>\r\n";
        ob_start();//Carga en memoria un archivo especifico el caul es el siguiente
        require_once("Views/Template/Email/".$template.".php");
        $mensaje = ob_get_clean();
        $send = mail($emailDestino, $asunto, $mensaje, $de);
        return $send;
    }

    function getPermisos(int $idmodulo) {
        require_once("Models/PermisosModel.php");
        $objPermisos = new PermisosModel($idmodulo);
        $idrol = $_SESSION['userData']['idrol'];
        $arrPermisos = $objPermisos->permisosModulo($idrol);
        $permisos = '';
        $permisosMod = '';
        if (count($arrPermisos) > 0) {
            $permisos = $arrPermisos;//recibe todo el array
            //Sí existe la variable agarra todos los datos del array 
            $permisosMod = isset($arrPermisos[$idmodulo]) ?  $arrPermisos[$idmodulo]: "";
        }
        //Variables de sesión
        $_SESSION['permisos'] = $permisos;//almacena permisos de todos los modulos 
        $_SESSION['permisosMod'] = $permisosMod;//almacena los permisos de modulo segun el rol
    }

    function sessionUser(int $idpersona){
        require_once("Models/loginModel.php");
        // se crea el objeto para poder usar todos los metodos del loginModel
        $objLogin = new LoginModel();
        $request = $objLogin->sessionLogin($idpersona);
        return $request;
    }

    function uploadImage(array $data, string $name){
        $url_temp = $data['tmp_name'];
        $destino = 'Assets/images/uploads/'.$name;        
        $move = move_uploaded_file($url_temp, $destino);
        return $move;
    }

    function deleteFile(string $name){
        unlink('Assets/images/uploads/'.$name); //unlink es una funcion propia de php, lo que hace es buscar el archivo por el nombre y eliminarlo 
    }

    //Elimina exceso de espacions entre palabaras 
    //Esto es para evitar una Inyeccion SQL
    function strClean($strCadena){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''],$strCadena);
        $string = trim($string);//Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string);//Elimina los \ invertidas
        $string = str_ireplace("<script>","", $string);// si esto es escrito en el campo usuario  va a ser elimnado
        $string = str_ireplace("</script>","", $string);
        $string = str_ireplace("<script src>","", $string);
        $string = str_ireplace("<script types=>","", $string);
        $string = str_ireplace("SELECT * FROM","", $string);
        $string = str_ireplace("DELETE FROM","", $string);
        $string = str_ireplace("INSERT INTO","", $string);
        $string = str_ireplace("SELECT COUNT(*) FROM","", $string);
        $string = str_ireplace("DROP TABLE","", $string);
        $string = str_ireplace("OR '1'='1","", $string);
        $string = str_ireplace('OR "1"="1"',"", $string);
        $string = str_ireplace('OR ´1´=´1´',"", $string);
        $string = str_ireplace("is NULL; --'","", $string);
        $string = str_ireplace("is NULL; --","", $string);
        $string = str_ireplace("LIKE '","", $string);
        $string = str_ireplace('LIKE "',"", $string);
        $string = str_ireplace("LIKE ´","", $string);
        $string = str_ireplace("OR 'a'='a","", $string);
        $string = str_ireplace('OR "a"="a"',"", $string);
        $string = str_ireplace('OR ´a´=´a´',"", $string);
        $string = str_ireplace("--","", $string);
        $string = str_ireplace("^","", $string);
        $string = str_ireplace("","", $string);
        $string = str_ireplace("[","", $string);
        $string = str_ireplace("]","", $string);
        $string = str_ireplace("==","", $string);
        $string = str_ireplace("++","", $string);
        return $string;
    }

    function clear_cadena(string $cadena){
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
 
        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
        array('N', 'n', 'C', 'c','','','',''),
        $cadena
        );
        return $cadena;
    }

    //Genera una contraceña de 10 caracteres
    function passGenerator($length = 10){
        $pass = "";
        $longitudPass = $length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoprstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);

        for ($i=1; $i <= $longitudPass; $i++) { 
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena, $pos,1);//Devuelve los caracteres extraídos de una cadena según la posición del carácter especificado para una cantidad especificada de caracteres y concatena.
        }
        return $pass;
        echo $longitudCadena;
    }
    //Genera Token 
    //Esto se usa para reestablecer contraceñas 
    function token(){
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1 .'-'. $r2 .'-'. $r3 .'-'. $r4;
        return $token;//el codigo se envia por correo para que la cntraceña pueda ser reestablecida
    }
    //Formato para valores monetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad, 2, SPD, SPM);
        return $cantidad;
    }
    

?>