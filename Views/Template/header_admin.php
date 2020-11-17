<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"><!-- meta de codificacion -->
    <meta name="description" content="Tienda Virtual JuanDa97"><!--da un breve descricion cuando se busca la pagina en el navegador--> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!--meta de compatibilidad edge-->
    <meta name="viewport" content="width=device-width, initial-scale=1"><!--meta responsive-->
    <meta name="author" content="JuanDa97">
    <meta name="theme-color" content="#009688"><!-- Este color se va a ver en los telefonos -->
    <link rel="shortcut icon" href="<?= media(); ?>/images/icon8.ico"><!--pone un icono solo para firefox-->
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css"><!-- orden 1 -->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css"><!-- orden 2 -->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css"><!-- orden 3 -->
    <title><?= $data['page_tag'] ?></title>
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?= base_url(); ?>/dashboard">Tienda Virtual</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url(); ?>/opciones"><i class="fa fa-cog fa-lg"></i> Ajustes</a></li>
            <li><a class="dropdown-item" href="<?= base_url(); ?>/usuarios/perfil"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="<?= base_url(); ?>/logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </i>
      </ul>
    </header>
    <?php require_once("nav_admin.php") ?>