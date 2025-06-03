<?php

use function Adminer\escape_key;

include_once "lib/load.php";
include_once __DIR__."/../traits/SQLgettersetter.trait.php";
class auth{
    use SQLgettersetter;
    public $table;
    public $conn;
    public $id;
    public $element;
    public function __construct($token){
        $this->table="user_session";
        $this->element="uid";
        if(!$this->conn){
            $this->conn=database::get_conn();
        }
        $conn=$this->conn;
        $sql="SELECT * FROM `user_session` WHERE `token` = '$token'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->id=$row['uid'];
        }else{
            throw new Exception("auth construct error".__CLASS__.__LINE__);
        }
    }
    public static function authenticate($name,$pass){
        try{
            $username=user::login($name,$pass);
        if($username){
            $user=new user($username);
            $conn=database::get_conn();
            $ip=$_SERVER['REMOTE_ADDR'];
            $agent=$_SERVER['HTTP_USER_AGENT'];
            $token=md5(rand(0,9999).$ip.$agent.time());
            date_default_timezone_set('asia/kolkata');
            $time=time();
            $sql="INSERT INTO `user_session` (`uid`, `ip`, `agent`, `token`, `time`, `active`)
VALUES ('$user->id', '$ip', '$agent', '$token', '$time', '1');";
if($conn->query($sql)==true){
    $_SESSION['token']=$token;
    return true;
}else{
    throw new Exception("authentication error".__CLASS__.__LINE__);
}

}else{
            throw new Exception("there are no username in ".__CLASS__.__LINE__);
        }
        }catch(Exception $e){
            return false;
        }
    }
    public static function autherize($token){
        $auth=new auth($token);
            if($token==$auth->gettoken()){
                if($_SERVER['REMOTE_ADDR']==$auth->getip()){
                    if($_SERVER['HTTP_USER_AGENT']==$auth->getagent()){
                        if($auth->getactive()==1){
                            if($auth->isexpire($auth->gettime())){
                                return true;
                            }else{
                                throw new Exception("login time expired".__CLASS__.__LINE__);
                            }
                        }else{
                            throw new Exception("login time expired".__CLASS__.__LINE__);
                        }
                    }else{
                        throw new Exception("different user agent".__CLASS__.__LINE__);
                    }
                }else{
                    throw new Exception("different ip".__CLASS__.__LINE__);
                }
            }else{
                throw new Exception("different user token".__CLASS__.__LINE__);
            }
        
    }
    private  function isexpire($time){
        date_default_timezone_set('asia/kolkata');
        if($time<time()){
            $dif=time()-$time;
        }elseif($time>time()){
            $dif=$time-time();
        }
        if($dif<=3600){
            return true;
        }else{
            return false;
        }
    }
}