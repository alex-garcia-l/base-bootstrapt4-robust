<?php
    class Empleado {
        
        private $bd;
        private $objFun;
        private $permisos;
        public function __construct(){
            $this->bd = new DB;
            $this->objFun = new MisFunciones;
            if(isset($_SESSION["idRol"])) {
              $this->permisos = explode("|", $this->objFun->getPermisos($_SESSION["idRol"], "Empleados")["permisos"]);
            }
            /*
            Alta: $permisos[0]
            Baja: $permisos[1]
            Modificar: $permisos[2]
            Consulta: $permisos[3] */
        }
        
        public function getModalVerFoto() {
          $html = "";
          if($this->permisos[3]) {
              $html = '<div class="modal fade text-xs-left" id="modal-foto" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-sm" role="document">
                            <form class="form" id="form-foto">
                                <fieldset id="fieldset-form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel18">Foto del empleado</h4>
                                        </div>
                                        <input type="hidden" id="action" name="action" value="nuevo-empleado">
                                        <div class="modal-body text-xs-center">
                                            <div class="form-body">
                                                <img src="img/loading.gif" id="foto-mostrar" class="img-fluid img-thumbnail" width="200px"/>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>';
            }
            echo $html;
        }
        
        public function getModalAlta() {
          $html = "";
          if($this->permisos[0]) {
            $html = '<div class="modal fade text-xs-left" id="modal-alta" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form class="form" id="form-alta">
                                <fieldset id="fieldset-form">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel18">Nuevo empleado</h4>
                                        </div>
                                        <input type="hidden" id="action" name="action" value="nuevo-empleado">
                                        <div class="modal-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtNombres" class="control-label">Nombre (s)</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtNombres" class="form-control" placeholder="Nombre (s)" name="txtNombres" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtApellidos" class="control-label">Apellidos</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtApellidos" class="form-control" placeholder="Apellidos" name="txtApellidos" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtDireccion" class="control-label">Dirección</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtDireccion" class="form-control" placeholder="Dirección" name="txtDireccion" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-map-marker"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtTelefono" class="control-label">Teléfono</label>
                                                            <div class="input-group">
                                                            	<input id="txtTelefono" class="form-control" placeholder="Teléfono" name="txtTelefono" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-phone2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtCelular" class="control-label">Celular</label>
                                                            <div class="input-group">
                                                            	<input id="txtCelular" class="form-control" placeholder="Celular" name="txtCelular" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-mobile2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtCorreo">Correo</label>
                                                            <div class="input-group">
                                                            	<input id="txtCorreo" class="form-control" placeholder="Correo" name="txtCorreo" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-envelope"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        
                                                        <div class="form-group">
                                                            <label for="foto">Correo</label>
                                                            <div class="input-group">
                                                            	<input id="foto" class="form-control" placeholder="Correo" name="foto" type="file">
                                                            </div>
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
                                        <input type="hidden" id="action" name="action" value="modificar-empleado">
                                        <input type="hidden" id="xDato" name="xDato" value="">
                                        <div class="modal-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtNombres" class="control-label">Nombre (s)</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtNombres" class="form-control" placeholder="Nombre (s)" name="txtNombres" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtApellidos" class="control-label">Apellidos</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtApellidos" class="form-control" placeholder="Apellidos" name="txtApellidos" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-user4"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtDireccion" class="control-label">Dirección</label> <i class="icono-campos-obligatorios text-danger icon-asterisk2"></i>
                                                            <div class="input-group">
                                                            	<input id="txtDireccion" class="form-control" placeholder="Dirección" name="txtDireccion" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-map-marker"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtTelefono" class="control-label">Teléfono</label>
                                                            <div class="input-group">
                                                            	<input id="txtTelefono" class="form-control" placeholder="Teléfono" name="txtTelefono" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-phone2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" class="control-label">
                                                            <label for="txtCelular">Celular</label>
                                                            <div class="input-group">
                                                            	<input id="txtCelular" class="form-control" placeholder="Celular" name="txtCelular" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-mobile2"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtCorreo" class="control-label">Correo</label>
                                                            <div class="input-group">
                                                            	<input id="txtCorreo" class="form-control" placeholder="Correo" name="txtCorreo" type="text">
                                                            	<span class="input-group-addon" id="basic-addon8"><i class="icon-envelope"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="foto" class="control-label">Foto</label>
                                                            <div class="input-group">
                                                            	<input id="foto" class="form-control border-rigth-input-group" placeholder="Foto" name="foto" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <span class="text-danger float-sm-left"><i class="icono-campos-obligatorios icon-asterisk2"></i> Campos obligatorios</span>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-green" id="btnModificar">Modificar</button>
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
            
            $foto = $this->objFun->subirImagen($_FILES[foto]);
            $dat = array(
                  nombres => $_POST[txtNombres], 
                  apellidos => $_POST[txtApellidos], 
                  direccion => $_POST[txtDireccion], 
                  tel_cel => $_POST[txtCelular],
                  tel_casa => $_POST[txtTelefono],
                  correo => $_POST[txtCorreo],
                  foto => $foto,
              );
              $idNuevo = $this->bd->insert_update("personal", $dat, "INSERT INTO ");
               
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
                    $complementoWhere .= " AND status=1";
                } else if($opSelect == 2) {
                    $complementoWhere .= " AND status=0";
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
                        nombres => "",
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
            $SQL = "SELECT * FROM personal WHERE id=".$id;
            $con = $this->bd->un_registro($SQL);
            
            $respuesta = array(
                    'error' => false,
                    nombres => $con["nombres"],
                    apellidos => $con["apellidos"],
                    direccion => $con["direccion"],
                    telefono => $con["tel_casa"],
                    celular => $con["tel_cel"],
                    correo => $con["correo"],
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
        
        public function modificar() {
          if($this->permisos[2]) {  
            
            $dat = array(
                  nombres => $_POST[txtNombres], 
                  apellidos => $_POST[txtApellidos], 
                  direccion => $_POST[txtDireccion], 
                  tel_cel => $_POST[txtCelular],
                  tel_casa => $_POST[txtTelefono],
                  correo => $_POST[txtCorreo],
              );
            
            if($_FILES[foto][name] != "") {
                $img = $this->bd->uncampo("personal", "foto", "id", $_POST[xDato]);
                $this->objFun->eliminarImagen($img);
                $foto = $this->objFun->subirImagen($_FILES[foto]);
                $dat[foto] = $foto;
            }
            
            $WHERE = "WHERE id=".$_POST[xDato];
            $this->bd->insert_update("personal", $dat, "UPDATE ", $WHERE);
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
            //$this->bd->query("DELETE FROM usuarios WHERE id=".$_POST[x]);   /* baja fisica */
            /*$dat = array(
                status => 0
            );
            $WHERE = "WHERE id=".$_POST[x];
            $this->bd->insert_update("usuarios", $dat, "UPDATE ", $WHERE);*/  /* Baja lógica */ 
            
            if($this->permisos[1]) {
              // código para eliminar
                
                $dato = $this->bd->un_registro("SELECT status FROM personal WHERE id=".$_POST[mydata]);
                
                $dat = array(
                    status => !$dato[status]
                );
                $WHERE = "WHERE id=".$_POST[mydata];
                $this->bd->insert_update("personal", $dat, "UPDATE ", $WHERE);
              
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
        
        public function getCarteraCliente($id) {
            return $this->objFun->getOptionSelect("SELECT * FROM clientes WHERE id!=1 AND personal_id=".$id." ORDER BY nombre", "nombre");
        }
        
    }
?>