<?php
    $uri=$_SERVER['REQUEST_URI'];
            
    session_start();
    include("php/controladores/controlador_bd.php");
    include("php/modulos/login.php");
    include("php/modulos/seo.php");
    include("php/modulos/funciones.php");
    include("php/modulos/usuarios.php");
    include("php/modulos/empleado.php");
    include("php/modulos/roles.php");
    
    include("php/modulos/home.php");
    include("php/controladores/controlador_frontal.php");
    
    $ObjCtrl = new ctrlFrontal;
    $objLogin = new Login;
    $objSeo = new SEO;
    $objUsuarios = new Usuarios;
    $objEmpleado = new Empleado;
    $objRoles = new Roles;
    
    $objHome = new Home;
    $objFuncion = new MisFunciones;
    
    define('PASSWORD_BCRYPT_COST', "13"); // 
    define('PASSWORD_SALT', "4433.lATiGiidD.gNIdoCmDa"); // aDmCodINg.DdiGiTAl.3344
    
    if(isset($_POST["action"])) { // Si necesita mucha seguradad usar metodo GET
    	
    	$ac = $_POST["action"];
    	
    	// Comparaciones para los módulos
        
        switch($ac) {
            
            // Funciones
            case "get-permisos":
                echo $objFuncion->getPermisosModulo($_SESSION["idRol"], $_POST["modulo"]);
                break;
            // Fin funciones

            // Login
            case "login-usuario":
                echo $objLogin->iniciarSesion($_POST["txtUser"], $_POST["txtPass"]);
                break;
            // Fin Login
            
            // Modificar perfil usuario
            case "modificar-perfil-usuario":
                echo $objUsuarios->modificarDatosPerfil($_SESSION["idUsuario"], $_SESSION["idPersonal"]);
                break;
            case "confirmar-password":
                echo $objUsuarios->verificarContraseña($_POST["pass"]);
                break;
            // Fin Modificar perfil usuario
            
            // Empleados
            case "tabla-empleado":
                $SQL = "SELECT id, nombres, apellidos, direccion, tel_casa, tel_cel, status, foto FROM personal";
                $complementoWhere = "id!=1";
                echo $objEmpleado->getBodyTable($SQL, $complementoWhere);
                break;
            case "nuevo-empleado":
                echo $objEmpleado->nuevo();
                break;
            case "datos-empleado":
                echo $objEmpleado->getDatosModificar($_POST[x]);
                break;
            case "modificar-empleado":
                echo $objEmpleado->modificar();
                break;
            case "baja-nomina":
                echo $objEmpleado->bajaLogica();
                break;
            
            // Fin Empleados
            
            // Roles
            case "tabla-roles":
                $SQL = "SELECT * FROM roles";
                $complementoWhere = "id!=1";
                echo $objRoles->getBodyTable($SQL, $complementoWhere);
                break;
            case "nuevo-roles":
                echo $objRoles->nuevo();
                break;
            case "datos-roles":
                echo $objRoles->getDatosModificar($_POST[x]);
                break;
            case "modificar-roles":
                echo $objRoles->modificar($_POST[xDato]);
                break;
            case "eliminar-roles":
                echo $objRoles->bajaFisica($_POST[mydata]);
                break;
            case "existe-roles":
                $valActual = "";
                if(isset($_POST[txtNombreActual])) {
                    $valActual = $_POST[txtNombreActual];
                }
                echo $objFuncion->existeRegistro($_POST[txtNombre], $valActual, "roles", "nombre");
                break;
            // Fin Roles
            
            // Usuarios
            case "tabla-usuarios":
                $SQL = "SELECT user.id, user.status, user.nom_usuario, per.nombres, per.apellidos, rol.nombre FROM usuarios user, personal per, roles rol";
                $complementoWhere = "user.id!=1 AND user.personal_id=per.id AND per.status=1 AND user.roles_id=rol.id";
                echo $objUsuarios->getBodyTable($SQL, $complementoWhere);
                break;
            case "nuevo-usuarios":
                echo $objUsuarios->nuevo();
                break;
            case "datos-usuarios":
                echo $objUsuarios->getDatosModificar($_POST[x]);
                break;
            case "modificar-usuarios":
                echo $objUsuarios->modificar($_POST[xDato]);
                break;
            case "eliminar-usuarios":
                echo $objUsuarios->bajaLogica($_POST[mydata]);
                break;
            case "existe-usuarios":
                $valActual = "";
                if(isset($_POST[txtUserActual])) {
                    $valActual = $_POST[txtUserActual];
                }
                echo $objFuncion->existeRegistro($_POST[txtUser], $valActual, "usuarios", "nom_usuario");
                break;
            // Fin Usuarios
            
            
            
        }

    }  else {
        if(substr($uri, 0, 11) == "/config.php") {
            header('Location: /biblioteca-cobach/');
        }
    }
?>
