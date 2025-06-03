<?php
include_once "lib/load.php";
include_once __DIR__."/../traits/SQLgettersetter.trait.php";
class user{
    use SQLgettersetter;
    public $table;
    public $conn;
    public $id;
    public $element;
    public function __construct($id){
        $this->id=null;
        $this->table="user";
        $this->element="id";
        $this->conn=database::get_conn();
        $conn=$this->conn;
        $sql="SELECT * FROM `user` WHERE `username` = '$id' OR `email` = '$id' OR `id` = '$id'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->id=$row['id'];
        }else{
            throw new Exception("user class contruct error");
            
        }
    }
    public static function signup($name,$email,$phone,$pass){
      try{
          $conn=database::get_conn();
        $pass=password_hash($pass,PASSWORD_BCRYPT);
        $sql="INSERT INTO `user` (`username`, `email`, `phone`, `password`)
VALUES ('$name', '$email', '$phone', '$pass');";
        if($conn->query($sql)==true){
            // session::$id=mysqli_insert_id($conn);
            return true;
        }else{
            throw new Exception("can not signup");
        }
      }catch(Exception $e){
        return false;
      }
    }
    public static function login($name,$pass){
        try{
            $conn=database::get_conn();
        $sql="SELECT * FROM `user` WHERE `username` = '$name'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            if(password_verify($pass,$row['password'])){
                $_SESSION['token']=true;
                // session::set_id($row['id']);
                return $row['username'];
            }else{
                return false;
            }
        }else{
            throw new Exception("can not login");
        }
        }catch(Exception $e){
            return false;
        }

    }
}
?>