<?php
    class Login {
        // Tipo de usuario 1, activo
        // Tipo de usuario 2, baja logica
        
        private $bd;
        private $objFun;
        public function __construct(){
            $this->bd = new DB();
            $this->objFun = new MisFunciones();
        }
        
        public function iniciarSesion($user, $pass) { // prueba mipassword123
            if($this->estaLogeado()) {
                $user = $_SESSION["user"];
            }
            $pass = $this->hashProtectPasword($pass);
            $q = "SELECT user.id, user.nom_usuario, user.personal_id, user.roles_id, per.foto FROM usuarios user, personal per WHERE user.personal_id=per.id AND per.status=1 AND user.status=1 AND user.nom_usuario='$user' AND user.pass_usuario='$pass';";
            if($this->bd->num_rows($q) >= 1) {
                session_start();
                if($this->getTipoLogeo() == 2) {
                    $_SESSION["status"] = 1;
                } else {
                    $r = $this->bd->fetch_array($q);
                    $_SESSION["idUsuario"] = $r['id'];
                    $_SESSION["idPersonal"] = $r['personal_id'];
                    $_SESSION["idRol"] = $r['roles_id'];
                    $_SESSION["user"] = $r['nom_usuario'];
                    $_SESSION["cadenaLogin"] = $this->generarCadenaLogueo();
                    $_SESSION["status"] = 1;
                    $_SESSION["foto"] = $r['foto'];
                }
                
                $respuesta = array(
                    'error' => false,
                );
                
                return json_encode($respuesta, JSON_FORCE_OBJECT);
            } else {
                $respuesta = array(
                'error' => true,
            );
            return json_encode($respuesta, JSON_FORCE_OBJECT);
            }
            
        }
        
        private function hashProtectPasword($password) {
            $salt = "$2a$" . PASSWORD_BCRYPT_COST . "$" . PASSWORD_SALT;
            $password = crypt($password, $salt);      
            return $password;
        }
        
        public function getHashProtectPasword($pass) {
            return $this->hashProtectPasword($pass);
        }
        
        function generarCadenaLogueo() {
            $ip = $_SERVER['REMOTE_ADDR'];
            $navegador = $_SERVER['HTTP_USER_AGENT'];
            return hash('sha512',$ip.$navegador);
            
        }
        
        public function estaLogeado() {
            session_start();
            if($_SESSION["idUsuario"] == null) {
                 return false;
            }
            $cadenaLogueo  = $this->generarCadenaLogueo();
            $cadenaLogueoActual  = $_SESSION["cadenaLogin"];
            
            if($cadenaLogueoActual == null && $cadenaLogueoActual != $cadenaLogueo) {
                session_destroy();
                return false;   
            }
            
            return true;        
        }
        
        public function getTipoLogeo() {
            return $_SESSION["status"];
        }
        
    }
?>