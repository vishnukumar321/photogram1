<?php
include_once "lib/load.php";
class database{
    public static $conn;
    public static function get_conn(){
        if(!database::$conn){
            $sname=get_conf("servername");
            $uname=get_conf("susername");
            $pass=get_conf("password");
            $db=get_conf("dbname");
            $conn= new mysqli($sname,$uname,$pass,$db);
            if($conn->connect_error){
                die("connection error".$conn->connect_error);
            }else{
                return database::$conn=$conn;
            }
        }else{
            return database::$conn;
        }
    }
}
?>