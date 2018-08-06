<?php 
    
    class MisFunciones {
        private $bd;
        
        public function __construct() {
            $this->bd = new DB;
        }
        
        public function getPermisos($idUser, $modulo) {
            $res = $this->bd->un_registro("SELECT permisos FROM privilegios WHERE roles_id=".$idUser." AND nombre_modulo='".$modulo."'");
            return $res;
        }

        public function getPermisosModulo($idUser, $modulo) {

            $misModulos = array(
                'modulo-empleado' => 'Empleados',
                'modulo-usuarios' => 'Usuarios',
                'modulo-roles' => 'Roles'
            );

            $res = $this->bd->un_registro("SELECT permisos FROM privilegios WHERE roles_id=".$idUser." AND nombre_modulo='".$misModulos[$modulo]."'");
            $res = explode("|", $res[permisos]);
            $respuesta = array(
                    0 => $res[0],
                    1 => $res[1],
                    2 => $res[2],
                    3 => $res[3]
                );
            return json_encode($respuesta, JSON_FORCE_OBJECT);
        }
        
        public function existeRegistro($nuevoValor, $actual, $tabla, $campo) {
            $existe = "false";
            if($nuevoValor == $actual) {
              $existe = "true";
            } else {
              $SQL = "SELECT * FROM ".$tabla." WHERE ".$campo."='".$nuevoValor."'";
              $con = $this->bd->un_registro($SQL);
              if(count($con) == 0) {
                  $existe = "true";
              }
            }
            return $existe;
        }
    	
    	function subirImagen($imagen) {
            $output_dir = "img/uploads/";
            if(isset($imagen))
            {
                if($imagen[name] == "") {
                    return "";
                } else {
                
                    $ret = array();
                
                    $error =$imagen["error"];
                    //You need to handle  both cases
                    //If Any browser does not support serializing of multiple files using FormData() 
                    if(!is_array($imagen["name"])) //single file
                    {
                        $fileName = $imagen["name"];
                
                        $img = substr(strrchr($fileName, "."), 1); 
                        $fileName = md5(rand() * time()) . ".$img";
                
                        move_uploaded_file($imagen["tmp_name"],$output_dir.$fileName);
                    }
                    
                   return $fileName;
                }
             }
        }
        
        function eliminarImagen($nombre) {
            $dir = "img/uploads/";
            unlink($dir.$nombre);
        }
        
        function getOptionSelect($SQL, $nombre_campo) {
            $res = $this->bd->fetch_object($SQL);
            foreach($res as $row) {
               $html .= '<option value="'.$row->id.'">'.$row->$nombre_campo.'</option>';
            }
            return $html;
        }
    	
    }
    
?>