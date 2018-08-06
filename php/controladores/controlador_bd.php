<?php

class DB{
    var $dbhost;
    var $dbuser;
    var $dbpass;
    var $dbweb;
    var $conexion;
    var $con;

    public function __construct() {
        $this->dbhost = "localhost";
        $this->dbuser = "alexdeveloped";
        $this->dbpass = "";
        $this->dbweb = "bd_estetica_original";
    }
    
        function connect() {
        
         $r=$this->con = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbweb);
            if ($this->con->connect_error) {
            die('No se puede conectar al Server: ' . $link->connect_error);
            }
            return $r;


        }

    
    function query($string, $option = "") {
        $this->connect();
        $result = $this->con->query($string) or die("Error en Query: " . $string . mysqli_error());
        if ($option == "INSERT INTO ") {
            $result = $this->con->insert_id;
         }
        return $result;
        mysqli_free_result($result);
        mysqli_close($this->con);
    }

    public function fetch_array($string) {
        $result = $this->query($string) or die("Error en Fetch Array: " . $string);       
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            return $row;
        }
    }

   public function uncampo($tabla,$campo,$key,$valor){
        $query = $this->query("SELECT $campo FROM $tabla WHERE $key='$valor'");
        $row = mysqli_fetch_array($query);
        return $row[$campo];
   }
   
   public function un_registro($SQL){
        $query = $this->query($SQL);
        $row = mysqli_fetch_array($query);
        return $row;
   }

    public function num_rows($result) {
        return mysqli_num_rows($this->query($result));
    }

    public function fetch_object($string) {
        $result = $this->query($string) or die("Error en Fetch Objects: " . $string);
        $list=array();
        while ($row = mysqli_fetch_object($result)) {
            array_push($list, $row);
        }
        return $list;
    }

    public function insert_update($table, $array, $method, $where = "", $db = "") {
        foreach ($array as $key => $value) {
            $new_array[] = "`" . $this->protect($key) . "`='" . $this->protect($value) . "'";
        }
        $q = implode(",", $new_array);

        if ($db == "") {
            $db = $this->dbweb;
        }
        $query = $method . $db . "." . $table . " SET " . $q . $where;
        return $this->query($query, $method);
    }
    
        public function protect($value) {

        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $value = addslashes($value);

        return $value;
    }

    
    public function sqli($val){
        return mysqli_real_escape_string($this->connect(), $val);
    }
    
    public function fetch_assoc($string) {
        $result = $this->query($string) or die("Error en Fetch Assoc: " . $string);
        //$listData["data"] = [];
        while ($data = mysqli_fetch_assoc($result)) {
            $listData[] = $data;
        }
        return $listData;
    }

}

/*
    user: root_galo
    pass: admGaLo34
*/

?>
