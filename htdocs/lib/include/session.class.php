<?php
include_once "lib/load.php";
class session{
    public static $conn;

//    this isautherize() will check that user is real or not

   public static function isautherize(){
    if(isset($_SESSION['token'])){
        try{
            auth::autherize($_SESSION['token']);
        }catch(Exception $e){
            session::session_des();
        }
    }
   }

//    session_des() will delete the user session account and redirect to index.php

   public static function session_des(){
    if(isset($_SESSION['token'])){
        $auth=new auth($_SESSION['token']);
        if(!session::$conn){
            session::$conn=database::get_conn();
        }
        $conn=session::$conn;
        $id=$auth->getuid();
        $sql="DELETE FROM `user_session` WHERE `uid` = '$id';";
        if($conn->query($sql)==true){
            session_destroy();
            ?><script>window.location.href="/"</script><?php
        }else{
            throw new Exception("can not delete the user account");
        }
    }
   }

//    this get_user() will return the user object

   public static function get_user(){
    return new user(session::get_session_user()->getuid());
   }

//    this get_session_user() will return the auth object

   public static function get_session_user(){
    return new auth($_SESSION['token']);
   }
}