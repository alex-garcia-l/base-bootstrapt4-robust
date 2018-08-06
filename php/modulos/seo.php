<?php 
    
    class SEO {
        
        public function __construct() {

        }
        
        public function getTitlePage($page) {
            
            switch($page) {
                case "empleados":
                    $title = "Empleados";
                    break;
                case "roles":
                    $title = "Roles";
                    break;
                case "usuarios":
                    $title = "Usuarios";
                    break;
                case "home":
                    $title = "Inicio";
                    break;
                case "perfil":
                    $title = "Mi cuenta";
                    break;
                default:
                    $title = "Error 404";
            }
            
            return $title." | SBE 298";
        }
    }
    
?>