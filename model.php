<?php

// Db Model

class DB {

    private $conn = null, $servername = 'localhost', $username = 'root', $password = '1234',$dbname = 'slackapp';

    public function getConnection(){
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function fetchAll($table){
        
        $sql = "SELECT * FROM $table"; 
        $result=$this->conn->prepare($sql);
        $result->execute();
        $response = $result->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($response)){
            return $response;
        }else{
            return false;
        }
    }

    public function fetch($where,$table){
        $whereStr = "";
        foreach($where as $key => $val){
            $whereStr .= "`$key` = '$val' AND ";
        }
        $whereStr = substr($whereStr, 0, -4);
        $sql = "SELECT * FROM $table WHERE $whereStr";
        $result=$this->conn->prepare($sql);
        $result->execute();
        $response = $result->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($response)){
            return $response;
        }else{
            return false;
        }
    }

    public function insert($insertArr,$table){
        
        $colStr = ""; $valStr = "";
        foreach($insertArr as $key => $val){
            $colStr .= "`$key`, ";
            $valStr .= "'".$val."', ";
        }
        $colStr = substr($colStr, 0, -2);
        $valStr = substr($valStr, 0, -2);
        $sql = "INSERT INTO `$table` ( $colStr ) VALUES ( $valStr )";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute();
        if($stmt->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function update($updateArr,$whereArr,$table){
        
        
        $setStr = ""; $whereStr = "";
        foreach($updateArr as $key => $val){
            $setStr .= "`$key` = $val, ";
        }
        $setStr = substr($setStr, 0, -2);
        
        foreach($whereArr as $key => $val){
            $whereStr .= " $key = $val AND ";
        }
        $whereStr = substr($whereStr, 0, -4);
        $sql = "UPDATE `todo` SET $setStr WHERE $whereStr ";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute();
        if($stmt->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function remove($where,$table){
        
        $whereStr = "";
        foreach($where as $key => $val){
            $whereStr .= "`$key` = '$val' AND ";
        }
        $whereStr = substr($whereStr, 0, -4);
        $sql = "DELETE FROM `$table` WHERE $whereStr"; 
        $result = $this->conn->prepare($sql);
        $response = $result->execute();
        if($result->rowCount()){
            return true;
        }else{
            return false;
        }
    }
}

?>