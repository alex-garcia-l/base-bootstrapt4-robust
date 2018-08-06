<?php
  include("config.php");
  
  $objLogin = new Login;
  
  $logeo = $objLogin->estaLogeado();
  if(!$logeo || $objLogin->getTipoLogeo() == 2) {
      header('Location: /');
  }
  

  $page = $_GET[page];
  $page = strip_tags($page);
  $page = str_replace("/","",$page);
  $page = str_replace("\\","",$page);
  $page = str_replace("//","",$page);
  $default="home";
  
  if($_SESSION[idRol] == 1) {
    if($page == "roles") {
      $active = 'class="active"';
    }
    //$roles = '<li '.$active.'><a href="roles/" data-i18n="nav.form_elements.privilegios" class="menu-item"><span class="icon-man-woman blue"></span> Roles</a></li>';
    
    $roles = '<li '.$active.'><a href="roles/" data-i18n="nav.icons.roles" class="menu-item"><span class="icon-man-woman blue"></span> Roles</a></li>';
  }
  // https://pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/component-buttons-basic.html
  
  $fotoUser = "img/icono-user.png";
  if($_SESSION["foto"] != "") {
    $fotoUser = "img/uploads/".$_SESSION["foto"];
  }
  
  
  if($page=="pedidos") {
    
  }
?>

<!DOCTYPE html>
<html lang="es" data-textdirection="ltr" class="loading">
  <head>
    <base href="https://<?=$_SERVER['HTTP_HOST']?>/">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app"> -->
    <title><?php echo $objSeo->getTitlePage($page)?></title>

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="css/dash/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="css/dash/icomoon.css">
    <link rel="stylesheet" type="text/css" href="css/dash/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="css/dash/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="css/dash/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="css/dash/app.css">
    <link rel="stylesheet" type="text/css" href="css/dash/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="css/dash/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="css/dash/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="css/dash/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!-- SELECT2 -->
    <link rel="stylesheet" type="text/css" href="css/dash/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/dash/select2-bootstrap4.min.css">
    <!-- SELECT2 -->
    <!-- DataTable -->
    <link rel="stylesheet" type="text/css" href="css/dash/dataTables.bootstrap4.min.css">
    <!--<link rel="stylesheet" type="text/css" href="css/dash/datatables.min.css">-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="css/dash/style.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <!-- END Custom CSS-->
  </head>
  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns fixed-navbar ">

    <!-- navbar-fixed-top-->
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-light navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
            <li class="nav-item"><a href="home/" class="navbar-brand nav-link"><img alt="" src="" data-expand="img/robust-logo-dark.png" data-collapse="img/robust-logo-small.png" class="brand-logo"></a></li>
            <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content container-fluid">
          <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
            <ul class="nav navbar-nav">
              <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5">         </i></a></li>
              <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-xs-right">
              
              <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link"><span class="avatar avatar-online"><img src="<?php echo $fotoUser;?>" alt="avatar"><i></i></span><span class="user-name"><?php echo $_SESSION["user"]?></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="perfil/" class="dropdown-item"><i class="icon-user4 blue"></i>  Mi cuenta</a>
                  <div class="dropdown-divider"></div>
                  <a href="layoff.php" class="dropdown-item"><i class="icon-lock2 blue"></i>  Suspender</a>
                  <a href="logout.php" class="dropdown-item"><i class="icon-switch blue"></i> Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- main menu-->
    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-bordered"> <!-- menu-dark menu-light-->
      <!-- main menu header--
      <div class="main-menu-header">
        <input type="text" placeholder="Buscar" class="menu-search form-control round"/>
      </div>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          <li<?php if($page=="home") echo ' class="active"'; ?>><a href="home/"><i class="icon-home4 blue"></i><span data-i18n="nav.dash.home" class="menu-title">Inicio</span></a></li>
          
          <li class="nav-item has-sub"><a href="#"><i class="icon-street-view blue"></i><span data-i18n="nav.icons.personal" class="menu-title">Personal</span></a>
            <ul class="menu-content" style="">
              <li<?php if($page=="empleados") echo ' class="active"'; ?>><a href="empleados/" data-i18n="nav.icons.empleados" class="menu-item"><span class="icon-user4 blue"></span> Empleados</a></li>
              <?php echo $roles; ?>
              <li<?php if($page=="usuarios") echo ' class="active"'; ?>><a href="usuarios/" data-i18n="nav.icons.usuarios" class="menu-item"><span class="icon-users3 blue"></span> Usuarios</a></li>
            </ul>
          </li>
          
          <li class="nav-item has-sub"><a href="#"><i class="icon-print blue"></i><span data-i18n="nav.icons.reportes" class="menu-title">Reportes</span></a>
            <ul class="menu-content" style="">
              <li<?php if($page=="reporte-ventas") echo ' class="active"'; ?>><a href="reporte-ventas/" data-i18n="nav.icons.reporte-ventas" class="menu-item"><span class="icon-file-pdf-o blue"></span> Reporte de ventas</a></li>
            </ul>
          </li>
          
        </ul>
      </div>
      <!-- main menu footer--
      <div class="main-menu-footer footer-close white ">
        <div class="header text-xs-center"><a href="#" class="col-xs-12 footer-toggle"><span class="icon-ios-arrow-up"></span></a></div>
        <div class="content">
          <div class="insights text-xs-center p-1">
            <?php //echo $_SESSION["user"]?>
          </div>
          <div class="actions">
            <a href="perfil/" data-placement="top" data-toggle="tooltip" data-original-title="Mi cuenta"><span aria-hidden="true" class="icon-cog3"></span></a>
            <a href="layoff.php" data-placement="top" data-toggle="tooltip" data-original-title="Suspender"><span aria-hidden="true" class="icon-lock4"></span></a>
            <a href="logout.php" data-placement="top" data-toggle="tooltip" data-original-title="Cerrar sesión"><span aria-hidden="true" class="icon-power3"></span></a>
          </div>
        </div>
      </div>-->
    </div>
    <!-- / main menu-->

    <div class="app-content content container-fluid">
      <div class="content-wrapper">
        
            <?php
            
      	      if($page == ""){
      	        echo $ObjCtrl->Cargador($default);
      	      } else if ($page=="index") {
      	        echo $ObjCtrl->Cargador($default);
      	      } else {
      	        if(file_exists("php/vistas/".$page.".html")) {
      	          echo $ObjCtrl->Cargador($page);
      	        } else {
      	          echo $ObjCtrl->Cargador("error404");
      	        }   
      	      }
      	    ?>

      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <footer class="footer footer-light navbar-border navbar-fixed-bottom"> <!-- navbar-fixed-bottom  footer-static -->
      <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-right d-xs-block d-md-inline-block">Copyright  &copy; 2018 - [Versión 1.0]</span></p>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="js/dash/jquery.min.js" type="text/javascript"></script>
    <script src="js/dash/tether.min.js" type="text/javascript"></script>
    <script src="js/dash/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/dash/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="js/dash/unison.min.js" type="text/javascript"></script>
    <script src="js/dash/blockUI.min.js" type="text/javascript"></script>
    <script src="js/dash/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="js/dash/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- DataTable -->
    <script src="js/dash/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dash/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="js/dash/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <!--<script src="js/dash/buttons.bootstrap4.min.js" type="text/javascript"></script>
    <!--<script src="js/dash/datatables.min.js" type="text/javascript"></script>-->
    <!-- END DataTable -->
    <!-- validate -->
    <script src="js/dash/jquery.validate.js"></script>
    <script src="js/dash/additional-methods.min.js"></script>
    <!-- validate -->
    <!-- BEGIN ROBUST JS-->
    <script src="js/dash/app-menu.js" type="text/javascript"></script>
    <script src="js/dash/app.js" type="text/javascript"></script>
    <script src="js/dash/screenfull.min.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->

    <!-- GOOGLE CHART -->
    <?php if($page == "home") { ?>

      <script src="js/dash/chart.min.js" type="text/javascript"></script>
    <?php } ?>
    <!-- END GOOGLE CHART -->
    <!-- SELECT2 -->
    <script src="js/dash/select2.full.min.js" type="text/javascript"></script>
    <!-- END SWEETALERT-->
    <!-- SELECT2 -->
    <script src="js/dash/sweetalert.min.js" type="text/javascript"></script>
    <!-- END SWEETALERT-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="js/ctrl.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    
    <?php
      if(file_exists("php/vistas/".$page.".html") && file_exists("js/modulos/$page.js")) {
          switch($page) {
            case "empleados":
              $modulo = "Empleados";
              break;
            case "roles":
              $modulo = "Roles";
              break;
            case "usuarios":
              $modulo = "Usuarios";
              break;
            case "home":
              $modulo = "Home";
              break;
          }
          
          $permisos = explode("|", $objFuncion->getPermisos($_SESSION["idRol"], $modulo)["permisos"]);
          if($permisos[0] || $permisos[1] || $permisos[2] || $permisos[3] || $page=="perfil") {
            $js = $page;
          
            echo '<script type="text/javascript" src="js/modulos/'.$js.'.js"></script>';
          }
      }
    ?>
    
  </body>
</html>
