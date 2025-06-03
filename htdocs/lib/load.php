<?php
include_once "lib/include/database.class.php";
include_once "lib/include/user.class.php";
include_once "lib/include/session.class.php";
include_once "lib/include/auth.class.php";
session_start();
function get_template($name){
    include $_SERVER['DOCUMENT_ROOT']."/lib/template/_$name.php";
}
?>