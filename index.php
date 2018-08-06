<?php
  include("config.php");
  
  $logeo = $objLogin->estaLogeado();
  $img = '<span class="icon-unlock-alt"></span>';
  if($logeo && $objLogin->getTipoLogeo() == 1) {
    header('Location: /home/');
  }
  
  $complementoUser = 'autofocus ';
  $complementoTexto = "Inicio de";
  if($objLogin->getTipoLogeo() == 2) {
      $complementoUser = 'disabled value="'.$_SESSION["user"].'"';
      $complementoPass = 'autofocus';
      $btnCerrar = '<a href="logout.php" class="btn btn-danger btn-block">Cerrar sesión</a>';
      $complementoTexto = "Reanudar";
      $img = '<img src="img/icono-user.png" class="box-shadow-1 avatar-login">';
      if($_SESSION["foto"] != "") {
          $img = '<img src="img/uploads/'.$_SESSION["foto"].'" class="box-shadow-1 avatar-login">';
      }
  }
?>
<!DOCTYPE html>
<html lang="es" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app"> -->
    <title>Login</title>

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="css/dash/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="css/dash/icomoon.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="css/dash/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="css/dash/app.css">
    <link rel="stylesheet" type="text/css" href="css/dash/colors.css">
    <link rel="stylesheet" type="text/css" href="css/dash/style.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <!-- END Custom CSS-->
  </head>
  <body>


    <div class="app-content content container-fluid pt-3">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-1 p-0">
                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-header no-border">
                            <div class="card-title text-xs-center">
                                <div class="icon-login blue"><?php echo $img; ?></div>
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-xs-center pt-1 mb-0"><span><?php echo $complementoTexto; ?> sesión</span></h6>
                        </div>
                        <div class="card-body">
                            <div class="card-block">
                                <form id="form-login" class="form-horizontal form-simple" autocomplete="off" action="#" novalidate="">
                                    <input type="hidden" id="action" name="action" value="login-usuario">
                                    <fieldset id="fieldset-form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="Nombre de usuario" <?php echo $complementoUser.$complementoUser;?>>
                                                <span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Contraseña" <?php echo $complementoPass;?>>
                                                <span class="input-group-addon" id="basic-addon8"><i class="icon-key2"></i></span>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-green btn-block" id="btnLogin">Iniciar</button>
                                        <?php echo $btnCerrar;?>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
            
                    </div>
                </div>
            </section>

        </div>
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
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="js/dash/app-menu.js" type="text/javascript"></script>
    <script src="js/dash/app.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- validate -->
    <script src="js/dash/jquery.validate.js"></script>
    <script src="js/dash/additional-methods.min.js"></script>
    <!-- SWEETALERT JS-->
    <script src="js/dash/sweetalert.min.js" type="text/javascript"></script>
    <!-- END SWEETALERT-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="js/dash/dashboard-lite.js" type="text/javascript"></script>
    <script src="js/ctrl.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        $(document).on("ready", function () {
            /*
            *Formulario Alta
            */
            
            var formLogin = $("#form-login");
            
            formLogin.on("submit", function(evt) {
                evt.preventDefault();
            }).validate({
                rules: {
                    txtUser: {
                      required: true,
                    },
                    txtPass: {
                      required: true,
                    },
                },
                messages: {
                    txtUser: {
                      required: "Campo requerido.",
                    },
                    txtPass: {
                      required: "Campo requerido.",
                    },
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block label-error',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var formData = new FormData(formLogin[0]);
                    formLogin.find("#fieldset-form").attr("disabled", true);
                    $("#btnLogin").html('Iniciando...');
                    
                    $.ajax({
                      type: "POST",  
                      url: "config.php",
                      data: formData,
                      dataType: "json",
                      cache: false,
                      contentType: false,
                      processData: false,
                      success: function(respuesta) {
                        if(!respuesta.error) {
                            location.href = "home/";
                        } else {
                            $("#btnLogin").html('Iniciar');
                            formLogin.find("#fieldset-form").attr("disabled", false);
                            
                            swal({
                              title: "Error",
                              text: "Credenciales incorrecto o estas dado de baja.",
                              icon: "error",
                              dangerMode: true,
                              buttons: false,
                              closeOnClickOutside: false,
                              timer: 2000,
                            });
                            
                        }
                      }
                    });
                }
            });
          
          
        });
    </script>
    
    
  </body>
</html>
