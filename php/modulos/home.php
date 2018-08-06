<?php
    class Home {
        
        private $bd;
        private $objFun;
        private $permisos;
        public function __construct(){
            $this->bd = new DB;
            $this->objFun = new MisFunciones;
            if(isset($_SESSION["idRol"])) {
              $this->permisos = explode("|", $this->objFun->getPermisos($_SESSION["idRol"], "Home")["permisos"]);
            }
            /*
            Alta: $permisos[0]
            Baja: $permisos[1]
            Modificar: $permisos[2]
            Consulta: $permisos[3] */
        }
        
        public function getCardEmpleados() {
            if($this->permisos[0]) {
                $SQL = "SELECT * FROM personal WHERE id>1 AND status=1";
                $total = $this->bd->num_rows($SQL);
                return $this->getCardHTML('Empleados', $total, 'user4');
            } else {
                return "";
            }
        }
        
        public function getCardUsuarios() {
            if($this->permisos[0]) {
                $SQL = "SELECT * FROM usuarios WHERE id>1 AND status=1";
                $total = $this->bd->num_rows($SQL);
                return $this->getCardHTML('Usuarios', $total, 'users3');
            } else {
                return "";
            }
        }
        
        public function getCardHTML($titulo, $cantidad, $icono) {
            $html = "";
            if($this->permisos[0]) {
                $html = '<div class="col-xl-6 col-lg-6 col-xs-12">
                	        <div class="card">
                	            <div class="card-body">
                	                <div class="card-block">
                	                    <div class="media">
                	                        <div class="media-body text-xs-left">
                	                            <h3 class="blue">'.$cantidad.'</h3>
                	                            <span class="text-danger">'.$titulo.'</span>
                	                        </div>
                	                        <div class="media-right media-middle">
                	                            <i class="icon-'.$icono.' green font-large-2 float-xs-right"></i>
                	                        </div>
                	                    </div>
                	                </div>
                	            </div>
                	        </div>
                	    </div>';
                /*$html .= '<div class="col-xl-3 col-lg-6 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="p-2 text-xs-center bg-amber media-left media-middle">
                                            <i class="icon-'.$icono.' font-large-2 white"></i>
                                        </div>
                                        <div class="p-2 bg-green white media-body">
                                            <h5 class="">'.$titulo.'</h5>
                                            <h5 class="text-bold-400">'.$cantidad.'</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';*/
            }
            return $html;
        }
        
    }
?>