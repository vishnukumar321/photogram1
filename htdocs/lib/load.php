<?php
include_once "lib/include/database.class.php";
include_once "lib/include/user.class.php";
include_once "lib/include/session.class.php";
include_once "lib/include/auth.class.php";
session_start();
function get_template($name){
    include $_SERVER['DOCUMENT_ROOT']."/lib/template/_$name.php";
}
global $conf;
$conf=file_get_contents($_SERVER['DOCUMENT_ROOT']."/../project/app3config.json");
function get_conf($name){
    global $conf;
    $conf1=json_decode($conf,true);
    if(isset($conf1[$name])){
        return $conf1[$name];
    }else{
        throw new Exception($name."is not exist in conf file".__LINE__);
    }
}
?>