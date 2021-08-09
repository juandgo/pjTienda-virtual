<?php

    // define("BASE_URL","http://localhost:8082/www/tienda_virtual");
    const BASE_URL = "http://localhost:8082 -,m./www/pjTienda-virtual";//variable constante
    //Zona horaria 
    date_default_timezone_set("America/Bogota");
    //Variables Globales 
    //Datos de conexión a Base de Datos
    const DB_HOST = "localhost";
    const DB_NAME = "db_tiendavirtual";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_CHARSET = "utf8";

    //Delimitadores decimal y millar Ej. 24,1989.00
    const SPD = ".";//separador de decimales
    const SPM = ",";//separador de millares 

    //Simbolo de moneda
    const SMONEY = "$";

    //Datos de envio de correo
    const NOMBRE_REMITENTE = "Tienda Virtual";
    const EMAIL_REMITENTE = "no-reply@jd97.com";
    const NOMBRE_EMPRESA = "Tienda Virtual";
    const WEB_EMPRESA = "wwww.jd97.com";


    const CAT_SLIDER = "1,2,3,4";
    const CAT_BANNER = "4,5,6";
    
?>