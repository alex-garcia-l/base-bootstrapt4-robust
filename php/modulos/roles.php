<?php
    class Roles {
        
        private $bd;
        private $objFun;
        private $permisos;
        private $SQL_PRIVILEGIOS = "SELECT nombre_modulo FROM privilegios WHERE roles_id=1 ORDER BY nombre_modulo ASC;";
        public function __construct(){
            $this->bd = new DB;
            $this->objFun = new MisFunciones;
            if(isset($_SESSION["idRol"])) {
              $this->permisos = explode("|", $this->objFun->getPermisos($_SESSION["idRol"], "Roles")["permisos"]);
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
                        <div class="modal-dialog modal-lg" role="document">
                            <form class="form" id="form-alta">
                                <fieldset id="fieldset-form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel18">Nuevo privilegio</h4>
                                        </div>
                                        <input type="hidden" id="action" name="action" value="nuevo-roles">
                                        <div class="modal-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="txtNombre" class="control-label">Nombre del rol</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtNombre" class="form-control" placeholder="Nombre del rol" name="txtNombre" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-font2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="txtDescripcion" class="control-label">Descripción</label>
                                                            <div class="input-group">
                                                            	<input id="txtDescripcion" class="form-control" placeholder="Descripción" name="txtDescripcion" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-pencil-square-o"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group contenedor-tabla-privilegios-modal">
                                                            <table id="tabla-privilegios-modal" class="table table-xs table-stripe table-hover table-bordered row-borde" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                    <tr class="text-xs-center">
                                                                        <th>Nombre del módulo</th>
                                                                        <th>Alta</th>
                                                                        <th>Baja</th>
                                                                        <th>Módif.</th>
                                                                        <th>Consulta</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-xs-center">
                                                                    ';
            $res =  $this->bd->fetch_object($this->SQL_PRIVILEGIOS);
            $complementoSQL = "";
            $cont = 0;
            foreach($res as $row) {
                $complementoSQL .= '<tr>
                                        <td>'.utf8_decode($row->nombre_modulo).'</td>
                                        <td><input class="form-check-input" type="checkbox" value="0" name="'.$row->nombre_modulo.'[]" id="alta-'.$cont.'"></td>
                                        <td><input class="form-check-input" type="checkbox" value="1" name="'.$row->nombre_modulo.'[]" id="baja-'.$cont.'"></td>
                                        <td><input class="form-check-input" type="checkbox" value="2" name="'.$row->nombre_modulo.'[]" id="modificar-'.$cont.'"></td>
                                        <td><input class="form-check-input" type="checkbox" value="3" name="'.$row->nombre_modulo.'[]" id="consulta-'.$cont.'"></td>
                                    </tr>';
                $cont++;
            }
            
            $html .=
                                                                    $complementoSQL.'
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <span class="text-danger float-sm-left"><i class="icono-campos-obligatorios icon-asterisk2"></i> Campos obligatorios</span>
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
                        <div class="modal-dialog modal-lg" role="document">
                            <form class="form" id="form-modificar">
                                <fieldset id="fieldset-form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel18">Nuevo privilegio</h4>
                                        </div>
                                        <input type="hidden" id="action" name="action" value="modificar-roles">
                                        <input type="hidden" id="txtNombreActual" name="txtNombreActual" value="">
                                        <input type="hidden" id="xDato" name="xDato" value="">
                                        <div class="modal-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="txtNombre" class="control-label">Nombre del rol</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtNombre" class="form-control" placeholder="Nombre del rol" name="txtNombre" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-font2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="txtDescripcion" class="control-label">Descripción</label>
                                                            <div class="input-group">
                                                            	<input id="txtDescripcion" class="form-control" placeholder="Descripción" name="txtDescripcion" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-pencil-square-o"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group contenedor-tabla-privilegios-modal">
                                                            <table id="tabla-privilegios-modal" class="table table-xs table-stripe table-hover table-bordered row-borde" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                    <tr class="text-xs-center">
                                                                        <th>Nombre del módulo</th>
                                                                        <th>Alta</th>
                                                                        <th>Baja</th>
                                                                        <th>Módif.</th>
                                                                        <th>Consulta</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-xs-center">
                                                                    ';
            $res =  $this->bd->fetch_object($this->SQL_PRIVILEGIOS);
            $complementoSQL = "";
            $cont = 0;
            foreach($res as $row) {
                $complementoSQL .= '<tr>
                                        <td>'.$row->nombre_modulo.'</td>
                                        <td><input class="form-check-input" type="checkbox" value="0" name="'.$row->nombre_modulo.'[]" id="alta-'.$cont.'"></td>
                                        <td><input class="form-check-input" type="checkbox" value="1" name="'.$row->nombre_modulo.'[]" id="baja-'.$cont.'"></td>
                                        <td><input class="form-check-input" type="checkbox" value="2" name="'.$row->nombre_modulo.'[]" id="modificar-'.$cont.'"></td>
                                        <td><input class="form-check-input" type="checkbox" value="3" name="'.$row->nombre_modulo.'[]" id="consulta-'.$cont.'"></td>
                                    </tr>';
                $cont++;
            }
            
            $html .=
                                                                    $complementoSQL.'
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <span class="text-danger float-sm-left"><i class="icono-campos-obligatorios icon-asterisk2"></i> Campos obligatorios</span>
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
                nombre => $_POST[txtNombre], 
                descripcion => $_POST[txtDescripcion], 
            );
            $idNuevo = $this->bd->insert_update("roles", $dat, "INSERT INTO ");
               
            $res = $this->bd->fetch_object($this->SQL_PRIVILEGIOS);

            foreach($res as $row) {
                $nombreModulo = $row->nombre_modulo;
                if(isset($_POST[$nombreModulo])) {
                    $permisos = $this->getCadenaPermiso($_POST[$nombreModulo]);
                } else {
                    $permisos = "0|0|0|0";
                }
                
                $dat = array(
                    nombre_modulo => $nombreModulo, 
                    permisos => $permisos,
                    roles_id => $idNuevo
                );
                $this->bd->insert_update("privilegios", $dat, "INSERT INTO ");
            }
            
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
                /* END of POST variables */
                
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
                        $where[]="$column like '%".$_POST['search']['value']."%'";
                    }
                    $where = "WHERE ".$complementoWhere." AND (".implode(" OR " , $where).")";// id like '%searchValue%' or name like '%searchValue%' ....
                    /* End WHERE */
            
                    $sql = sprintf($SQL." %s" , $where);//Search query without limit clause (No pagination)
            
                    //$recordsFiltered = count(getData($sql));//Count of search result
                    $recordsFiltered = $this->bd->num_rows($sql);;
            
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
                        nombre => ""
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
            $SQL = "SELECT nombre, descripcion FROM roles WHERE id=".$id;
            $con = $this->bd->un_registro($SQL);
            
            $htmlTable = $this->getDatosTable($id);
            
            $respuesta = array(
                    'error' => false,
                    nombre => $con["nombre"],
                    descripcion => $con["descripcion"],
                    bodyTable => $htmlTable
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
            
            $dat = array(
                    nombre => $_POST[txtNombre], 
                    descripcion => $_POST[txtDescripcion], 
              );
            
            $WHERE = "WHERE id=".$id;
            $this->bd->insert_update("roles", $dat, "UPDATE ", $WHERE);
            
            $res = $this->bd->fetch_object($this->SQL_PRIVILEGIOS);
            
            $SQL="SELECT nombre_modulo, id FROM privilegios WHERE roles_id=".$id." ORDER BY nombre_modulo ASC;";
            $resUser =  $this->bd->fetch_object($SQL);
            
            foreach($res as $row) {
                $nombreModulo = $row->nombre_modulo;
                
                if(isset($_POST[$nombreModulo])) {
                    $permisos = $this->getCadenaPermiso($_POST[$nombreModulo]);
                } else {
                    $permisos = "0|0|0|0";
                }
                
                $idPrivilegio = 0;
                foreach($resUser as $rowUser) {
                    if($row->nombre_modulo == $rowUser->nombre_modulo) {
                        $idPrivilegio = $rowUser->id;
                        break;
                    }
                }
                
                if($idPrivilegio != 0) {
                    $datos = array(
                        permisos => $permisos,
                    );
                    $WHERE = "WHERE id=".$idPrivilegio;
                    $this->bd->insert_update("privilegios", $datos, "UPDATE ", $WHERE);
                } else {
                    $datos = array(
                        nombre_modulo => $nombreModulo, 
                        permisos => $permisos,
                        roles_id => $id
                    );
                    $this->bd->insert_update("privilegios", $datos, "INSERT INTO ");
                }
                
            }
            
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
        
        public function bajaFisica($id) {
            if($this->permisos[1]) {
              // código para eliminar
                
                $SQL = "SELECT * FROM usuarios WHERE roles_id=".$id;
                $noUsuariosRol = $this->bd->num_rows($SQL);
                
                if($noUsuariosRol == 0) {
                    $SQL_DELETE = "DELETE FROM privilegios WHERE roles_id=".$id.";";
                    $this->bd->query($SQL_DELETE);
                    $SQL_DELETE = "DELETE FROM roles WHERE id=".$id.";";
                    $this->bd->query($SQL_DELETE);
                    $respuesta = array(
                    'error' => false
                );
                } else {
                    $respuesta = array(
                        'error' => true,
                        'tipo' => "no-eliminar"
                    );
                }
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            } else {
                $respuesta = array(
                    'error' => true,
                    'tipo' => 'privilegios'
                );
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            }
        }
        
        private function getCadenaPermiso($arrayValores) {
            $cadPermiso = "";
            $permisosTMP = [0, 0, 0 , 0];
            foreach($arrayValores as $valor) {
                $permisosTMP[$valor] = 1;
            }
            
            for($i=0 ; $i<4 ; $i++) {
                $cadPermiso .= $permisosTMP[$i];
                if($i<3) {
                    $cadPermiso.="|";
                }
            }
            return $cadPermiso;
        }
        
        private function getDatosTable($id) {
            $SQL="SELECT nombre_modulo, permisos FROM privilegios WHERE roles_id=".$id." ORDER BY nombre_modulo ASC;";
            $resAdmin =  $this->bd->fetch_object($this->SQL_PRIVILEGIOS);
            $resUser =  $this->bd->fetch_object($SQL);
            $html = "";
            $cont = 0;
            //var_dump($resUser);
            
            foreach($resAdmin as $row) {
                $permisos = ["", "", "", ""];
                foreach($resUser as $rowUser) {
                    if($row->nombre_modulo == $rowUser->nombre_modulo) {
                        $permisos = explode("|", $rowUser->permisos);
                        break;
                    }
                }
                
                $permisoAlta = "";
                $permisoBaja = "";
                $permisoModificar = "";
                $permisoConsulta = "";
                
                if($permisos[0]) {
                    $permisoAlta = "checked";
                }
                
                if($permisos[1]) {
                    $permisoBaja = "checked";
                }
                
                if($permisos[2]) {
                    $permisoModificar = "checked";
                }
                
                if($permisos[3]) {
                    $permisoConsulta = "checked";
                }
                
                $html .= '<tr>
                            <td>'.$row->nombre_modulo.'</td>
                            <td><input class="form-check-input" type="checkbox" value="0" name="'.$row->nombre_modulo.'[]" id="alta-'.$cont.'" '.$permisoAlta.'></td>
                            <td><input class="form-check-input" type="checkbox" value="1" name="'.$row->nombre_modulo.'[]" id="baja-'.$cont.'" '.$permisoBaja.'></td>
                            <td><input class="form-check-input" type="checkbox" value="2" name="'.$row->nombre_modulo.'[]" id="modificar-'.$cont.'" '.$permisoModificar.'></td>
                            <td><input class="form-check-input" type="checkbox" value="3" name="'.$row->nombre_modulo.'[]" id="consulta-'.$cont.'" '.$permisoConsulta.'></td>
                        </tr>';
                $cont++;
            }
            
            return $html;
        }
        
    }
?>