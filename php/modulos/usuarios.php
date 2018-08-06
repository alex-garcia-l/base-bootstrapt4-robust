<?php
    class Usuarios {
        
        private $bd;
        private $objFun;
        private $objLogin;
        private $permisos;
        private $SQL_PRIVILEGIOS = "SELECT nombre_modulo FROM privilegios WHERE roles_id=1 ORDER BY nombre_modulo ASC;";
        public function __construct(){
            $this->bd = new DB;
            $this->objFun = new MisFunciones;
            $this->objLogin = new Login;
            if(isset($_SESSION["idRol"])) {
              $this->permisos = explode("|", $this->objFun->getPermisos($_SESSION["idRol"], "Usuarios")["permisos"]);
            }
            /*
            Alta: $permisos[0]
            Baja: $permisos[1]
            Modificar: $permisos[2]
            Consulta: $permisos[3] */
        }
        
        public function getModalAlta() {
          $html = "";
          if($this->permisos[0]) {
              
            // Especial cuidado, se tiene que cambiar el valor del input hidden llamado action al evento a realizar
            // además se tiene que cambiar el nombre del formulario y del modal
            $html = '<div class="modal fade text-xs-left" id="modal-alta" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <form class="form" id="form-alta">
                                <fieldset id="fieldset-form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel18">Nuevo usuario</h4>
                                        </div>
                                        <input type="hidden" id="action" name="action" value="nuevo-usuarios">
                                        <div class="modal-body">
                                            <div class="form-body">
                                            
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="opEmpleado" class="control-label">Nombre del empleado</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                              <select id="opEmpleado" class="form-control" name="opEmpleado">
                                                                <option value="">Seleccione un empleado</option>
                                                                {OPTIONEMPLEADO}
                                                              </select>
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtUser" class="control-label">Nombre de usuario</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtUser" class="form-control" placeholder="Nombre de usuario" name="txtUser" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="opRol" class="control-label">Rol</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                              <select id="opRol" class="form-control" name="opRol">
                                                                <option value="">Seleccione un rol</option>
                                                                {OPTIONROL}
                                                              </select>
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-check-square-o"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtPass" class="control-label">Contraseña</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtPass" class="form-control" placeholder="Contraseña" name="txtPass" type="password">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-lock2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtConfirmarPass" class="control-label">Confirmar contraseña</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtConfirmarPass" class="form-control" placeholder="Confirmar contraseña" name="txtConfirmarPass" type="password">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-lock2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <span class="text-danger float-sm-left"><i class="icono-campos-obligatorios icon-asterisk2"></i> Campos requeridos</span>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-green" id="btnNuevo">Guardar</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>';
            }
            return $html;
        }
        
        public function getModalModificar() {
          $html = "";
          if($this->permisos[2]) {
              
            // Especial cuidado, se tiene que cambiar el valor del input hidden llamado action al evento a realizar, 
            // y colocar debajo del mismo el input <input type="hidden" id="xDato" name="xDato" value="">
            // además se tiene que cambiar el nombre del formulario y del modal
            $html = '<div class="modal fade text-xs-left" id="modal-modificar" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <form class="form" id="form-modificar">
                                <fieldset id="fieldset-form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel18">Modificar usuario</h4>
                                        </div>
                                        <input type="hidden" id="action" name="action" value="modificar-usuarios">
                                        <input type="hidden" id="txtUsuarioActual" name="txtUsuarioActual" value="">
                                        <input type="hidden" id="xDato" name="xDato" value="">
                                        <div class="modal-body">
                                            <div class="form-body">
                                            
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtNombre" class="control-label">Nombre del empleado</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                              <input id="txtNombre" class="form-control" placeholder="Nombre de usuario" name="txtNombre" type="text" disabled>
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtUser" class="control-label">Nombre de usuario</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtUser" class="form-control" placeholder="Nombre de usuario" name="txtUser" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="opRol" class="control-label">Rol</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                              <select id="opRol" class="form-control" name="opRol">
                                                                <option value="">Seleccione un rol</option>
                                                                {OPTIONROL}
                                                              </select>
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-check-square-o"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtPass" class="control-label">Contraseña</label>
                                                            <div class="input-group">
                                                            	<input id="txtPass" class="form-control" placeholder="Contraseña" name="txtPass" type="password">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-lock2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtConfirmarPass" class="control-label">Confirmar contraseña</label>
                                                            <div class="input-group">
                                                            	<input id="txtConfirmarPass" class="form-control" placeholder="Confirmar contraseña" name="txtConfirmarPass" type="password">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-lock2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <span class="text-danger float-sm-left"><i class="icono-campos-obligatorios icon-asterisk2"></i> Campos requeridos</span>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-green" id="btnModificar">Guardar</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>';
          }
          return $html;
        }
        
        public function getBotonAgregar() {
          $html="";
          if($this->permisos[0]) {
            $html = '<button class="btn btn-icon btn-green btn-round btn-sm button-right-header" data-toggle="modal" data-target="#modal-alta" data-backdrop="static" data-keyboard="false">Nuevo <i class="icon-plus-circle"></i></button>';
          }
          return $html;
        }
    
        public function nuevo() {
           if($this->permisos[0]) {
                
                $dat = array(
                    nom_usuario => $_POST["txtUser"],
                    pass_usuario => $this->objLogin->getHashProtectPasword($_POST["txtPass"]),
                    personal_id => $_POST["opEmpleado"],
                    roles_id => $_POST["opRol"]
                );
                $this->bd->insert_update("usuarios", $dat, "INSERT INTO ");
                
                $respuesta = array(
                    'error' => false,
                );
                
                return json_encode($respuesta, JSON_FORCE_OBJECT);
                
            } else {
             $respuesta = array(
                'error' => true,
                'tipo' => 'privilegios'
            );
            
            return json_encode($respuesta, JSON_FORCE_OBJECT);
           }
        }
        
        public function getBodyTable($SQL, $complementoWhere) {
            if($this->permisos[3]) {
                /* Useful $_POST Variables coming from the plugin */
                $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
                $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
                $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
                $orderType = $_POST['order'][0]['dir']; // ASC or DESC
                $start  = $_POST["start"];//Paging first record indicator.
                $length = $_POST['length'];//Number of records that the table can display in the current draw
                $opSelect = $_POST['opSelect'];
                /* END of POST variables */
                
                if($opSelect == 1) {
                    $complementoWhere .= " AND user.status=1";
                } else if($opSelect == 2) {
                    $complementoWhere .= " AND user.status=0";
                }
                
                //$recordsTotal = count(getData("SELECT * FROM ".MyTable));
                if(strlen($complementoWhere) > 0) {
                    $complementoWhere2 = " WHERE ".$complementoWhere;
                }
                
                $recordsTotal = $this->bd->num_rows($SQL.$complementoWhere2);
            
                /* SEARCH CASE : Filtered data */
                if(!empty($_POST['search']['value'])){
            
                    /* WHERE Clause for searching */
                    for($i=0 ; $i<count($_POST['columns']);$i++){
                        $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
                        if($column=="status") {
                            $column = "user.".$column;
                        }
                        $where[]="$column like '%".$_POST['search']['value']."%'";
                    }
                    $where = "WHERE ".$complementoWhere." AND (".implode(" OR " , $where).")";// id like '%searchValue%' or name like '%searchValue%' ....
                    /* End WHERE */
            
                    $sql = sprintf($SQL." %s" , $where);//Search query without limit clause (No pagination)
                    //$recordsFiltered = count(getData($sql));//Count of search result
                    $recordsFiltered = $this->bd->num_rows($sql);
            
                    /* SQL Query for search with limit and orderBy clauses*/
                    $sql = sprintf($SQL." %s ORDER BY %s %s limit %d , %d ", $where ,$orderBy, $orderType ,$start,$length  );
                    $data = $this->bd->fetch_assoc($sql);
                }
                /* END SEARCH */
                else {
                    $sql = sprintf($SQL.$complementoWhere2." ORDER BY %s %s limit %d , %d ",$orderBy,$orderType ,$start , $length);
                    $data = $this->bd->fetch_assoc($sql);
            
                    $recordsFiltered = $recordsTotal;
                }
                
                if($recordsFiltered == 0) {
                    $data = array(
                        nom_usuario => "",
                    );
                }
                
                /* Response to client before JSON encoding */
                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $recordsTotal,
                    "recordsFiltered" => $recordsFiltered,
                    "data" => $data
                );
            
                echo json_encode($response);
            } else {
                $data = array(
                    nombres => "",
                );
                    
                $respuesta = array(
                    "draw" => 0,
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => $data
                );
                return json_encode($respuesta, JSON_FORCE_OBJECT);
          }
        }
        
        public function getDatosModificar($id) {
          if($this->permisos[3]) {  
            $SQL = "SELECT user.nom_usuario, CONCAT(per.nombres, ' ', per.apellidos) AS nombre_completo, rol.id AS rolID FROM usuarios user, personal per, roles rol WHERE user.personal_id=per.id AND user.status=1 AND per.status=1 AND user.roles_id=rol.id AND user.id=".$id;
            $con = $this->bd->un_registro($SQL);
            
            $respuesta = array(
                    'error' => false,
                    user => $con["nom_usuario"],
                    nombre => $con["nombre_completo"],
                    rol => $con["rolID"],
                );
            
            return json_encode($respuesta, JSON_FORCE_OBJECT);
          } else {
            $respuesta = array(
                'error' => true,
                'tipo' => 'privilegios'
            );
            
            return json_encode($respuesta, JSON_FORCE_OBJECT);
          }
        }
        
        public function modificar($id) {
          if($this->permisos[2]) {  
            // pass_usuario => $this->objLogin->getHashProtectPasword($_POST["txtPass"]),
            $dat = array(
                    nom_usuario => $_POST["txtUser"],
                    roles_id => $_POST["opRol"]
              );
              
            if(isset($_POST["txtPass"]) && $_POST["txtPass"] != "") {
                $dat[pass_usuario] = $this->objLogin->getHashProtectPasword($_POST["txtPass"]);
            }
            
            $WHERE = "WHERE id=".$id;
            $this->bd->insert_update("usuarios", $dat, "UPDATE ", $WHERE);
            
            $respuesta = array(
                'error' => false,
            );
            return json_encode($respuesta, JSON_FORCE_OBJECT);
          } else {
            $respuesta = array(
                'error' => true,
                'tipo' => 'privilegios'
            );
            return json_encode($respuesta, JSON_FORCE_OBJECT);
          }
        }
        
        public function bajaLogica() {
            if($this->permisos[1]) {
              // código para eliminar
                
                $dato = $this->bd->un_registro("SELECT status FROM usuarios WHERE id=".$_POST[mydata]);
                
                $dat = array(
                    status => !$dato[status]
                );
                $WHERE = "WHERE id=".$_POST[mydata];
                $this->bd->insert_update("usuarios", $dat, "UPDATE ", $WHERE);
              
                $respuesta = array(
                    'error' => false
                );
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            } else {
                $respuesta = array(
                    'error' => true,
                    'tipo' => 'privilegios'
                );
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            }
        }
        
        /*
         *      Acciones generales para usuarios en perfil
         */
        
        public function getDatosGenerales($idUsuario) {
            $consulta = $this->bd->un_registro("SELECT CONCAT(per.nombres, ' ', per.apellidos) AS nombreCompleto, per.direccion, per.tel_casa, per.tel_cel, per.correo, user.nom_usuario FROM personal per, usuarios user WHERE per.id=user.personal_id AND user.id=".$idUsuario);
            return $consulta;
        }
        
        public function modificarDatosPerfil($idUsuario, $idPersonal) {
            
            $dat = array(
                tel_casa => $_POST["txtTelefono"],
                tel_cel => $_POST["txtCelular"],
                correo => $_POST["txtCorreo"]
              );
              
            $WHERE = "WHERE id=".$idPersonal;
            $this->bd->insert_update("personal", $dat, "UPDATE ", $WHERE);
            
            $dat = array(
                    nom_usuario => $_POST["txtUser"],
              );
            
            $_SESSION["user"] = $_POST["txtUser"];
            
            if(isset($_POST["txtPass"]) && $_POST["txtPass"] != "") {
                $dat[pass_usuario] = $this->objLogin->getHashProtectPasword($_POST["txtPass"]);
            }
            
            $WHERE = "WHERE id=".$idUsuario;
            $this->bd->insert_update("usuarios", $dat, "UPDATE ", $WHERE);
            
            $respuesta = array(
                'error' => false,
            );
            return json_encode($respuesta, JSON_FORCE_OBJECT);
        }
        
        public function verificarContraseña($pass) {
            $user = $_SESSION["user"];
            $pass = $this->objLogin->getHashProtectPasword($pass);
            $q = "SELECT status FROM usuarios WHERE nom_usuario='".$user."' AND pass_usuario='".$pass."'";

            if($this->bd->num_rows($q) >= 1) {
                $respuesta = array(
                    'error' => false
                );
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            } else {
                $respuesta = array(
                    'error' => true,
                    'tipo' => 'contraseña-incorrecta'
                );
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            }
        }
        
    }
?>