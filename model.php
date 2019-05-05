<?php

// Db Class to server as Model

// $table -> name of schema (default to todo in controller)
// $where,$whereArr -> key (column name) => value(value of field) to generate where clause conditions seperate by AND
// $insertArr -> key (column name) => value( value w.r.t column) to insert in a schema
// $updateArr -> key (column name) => value( updated value ) to set in a schema

class DB {

    private $conn = null, $servername = 'localhost', $username = 'root', $password = 'anant@13',$dbname = 'slackapp';

    // Get PDO connection, return false in case of any error else true
    public function getConnection(){
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    // fetch all the data from a table irrespective of any condition 
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

    // fetch all the data from a table with respect to the condition
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

    // Insert new record to the table
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

    // Update a record to the table 
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

    // Remove a record from the table
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