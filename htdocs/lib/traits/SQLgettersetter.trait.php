<?php
include_once "lib/load.php";
trait SQLgettersetter{
    public function __call($name,$arg){
        if(substr($name,0,3)=="get"){
            $name=substr($name,3);
            return $this->get_data($name);
        }elseif(substr($name,0,3)=="set"){
            $name=substr($name,3);
            return $this->set_data($name,$arg[0]);
        }
    }
    private function get_data($name){
        if(!$this->conn){
            $this->conn=database::get_conn();
        }
        $conn=$this->conn;
        $sql="SELECT * FROM `$this->table` WHERE `$this->element` = '$this->id'";
        $result=$conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            return $row[$name];
        }else{
            throw new Exception("data unavailable".__CLASS__.__LINE__);
        }
    }
    private function set_data($name,$arg){
        if(!$this->conn){
            $this->conn=database::get_conn();
        }
        $conn=$this->conn;
        $sql="UPDATE `$this->table` SET `$name` = '$arg' WHERE `$this->element` = '$this->id';";
        if($conn->query($sql)==true){
            return true;
        }else{
            throw new Exception("data unavailable".__CLASS__.__LINE__);
        }
    }
}