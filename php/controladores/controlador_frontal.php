<?php
class ctrlFrontal{
  private $bd;
  private $objUsuarios;
  private $objEmpleado;
  private $objRoles;
  private $objLogin;
  private $objHome;
  private $objFunciones;

	public function __construct(){
	    $this->bd = new DB;
	    $this->objUsuarios = new Usuarios;
	    $this->objEmpleado = new Empleado;
	    $this->objLogin = new Login;
	    $this->objRoles = new Roles;
	    $this->objHome = new Home;
	    $this->objFunciones = new MisFunciones;
	}


  public function imprimir_template($diccionario, $template) {
    foreach ($diccionario as $clave => $valor) {
      $template = str_replace('{'.$clave.'}', $valor, $template);
    }
    return $template;
  }

  public function keys($page) {
    $keys = array(
        );
      
    switch($page) {
        case "home":
          $keys = array(
              CARDEMPLEADOS => $this->objHome->getCardEmpleados(),
              CARDUSUARIOS => $this->objHome->getCardUsuarios()
          );
          break;
          
        case "usuarios":
          $keys = array(
              BOTONNUEVO => $this->objUsuarios->getBotonAgregar(),
              MODALNUEVO => $this->objUsuarios->getModalAlta(),
              MODALMODIFICAR => $this->objUsuarios->getModalModificar(),
              OPTIONEMPLEADO => $this->objFunciones->getOptionSelect("SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre FROM personal WHERE id!=1 AND status=1 AND id NOT IN (SELECT personal_id FROM usuarios) ORDER BY nombres, apellidos", "nombre"),
              OPTIONROL => $this->objFunciones->getOptionSelect("SELECT id, nombre FROM roles WHERE id!=1 ORDER BY nombre", "nombre")
          );
          break;
          
        case "perfil":
          $datosUsuarios = $this->objUsuarios->getDatosGenerales($_SESSION["idUsuario"]);
          $keys = array(
              NOMBRE => $datosUsuarios["nombreCompleto"],
              DIRECCION => $datosUsuarios["direccion"],
              TELEFONO => $datosUsuarios["tel_casa"],
              CELULAR => $datosUsuarios["tel_cel"],
              CORREO => $datosUsuarios["correo"],
              USER => $datosUsuarios["nom_usuario"]
          );
          break;
          
        case "empleados":
          $keys = array(
              BOTONNUEVO => $this->objEmpleado->getBotonAgregar(),
              MODALNUEVO => $this->objEmpleado->getModalAlta(),
              MODALMODIFICAR => $this->objEmpleado->getModalModificar(),
              MODALFOTO => $this->objEmpleado->getModalVerFoto()
          );
          break;
          
        case "roles":
          $keys = array(
              BOTONNUEVO => $this->objRoles->getBotonAgregar(),
              MODALNUEVO => $this->objRoles->getModalAlta(),
              MODALMODIFICAR => $this->objRoles->getModalModificar()
          );
          break;
          
    }
    
    return $keys;
  }

  public function areapriv8($page){
    
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
    
    $permisos = explode("|", $this->objFunciones->getPermisos($_SESSION["idRol"], $modulo)["permisos"]);
    if($permisos[0] || ($permisos[1] && $permisos[3]) || ($permisos[2] && $permisos[3]) || $page=="perfil" || $page=="error404") {
      $page = $page;
    } else {
      $page = "error-permiso";
    }

    return $page;
  }


    public function Cargador($page) {
      $page=$this->areapriv8($page);
      $keys=$this->keys($page);
      return $this->imprimir_template($keys, file_get_contents("php/vistas/".$page.".html"));
    }
}
?>
