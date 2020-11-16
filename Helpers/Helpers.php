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
    //Muestra informacion formateada
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