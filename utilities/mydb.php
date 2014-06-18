<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class mydb{
    private $host = '127.0.0.1';
    private $name = 'root';
    private $pass = 'root';
    private $dbname = 'mcs';
    
    public $query;
    
    private $conn;
    private static $instance;
    private function __construct() {
        $this->conn = mysql_connect($this->host, $this->name, $this->pass);
        $this->select_db('mcs');
        return $this->conn;
    }
    
    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function select_db($dbname){
        $this->result = mysql_select_db($dbname);
        return $this->result;
       
    }
    
    public function __clone() {
        trigger_error("not allowed clone");
    }
    
    //sql 
    function fetch($sql){
        //echo $sql;
        $this->query = mysql_query($sql,$this->conn);
        //echo $this->query;
        //echo $this->query;
    }
    
    function fetch_unbuffered($sql){
        //echo $sql;
        $this->query = mysql_unbuffered_query($sql,$this->conn);
        //echo $this->query;
       
    }
    
    function getRow(){
       
        if($row = mysql_fetch_array($this->query,MYSQLI_ASSOC)){
            //echo "getRow false";
            
            return $row;
        }
        else{
            //echo "getRow false";
            print_r($row);
            return false;
        }
    }
    
    function fetch_insert($sql){
       $re = mysql_query($sql,$this->conn);
       if($re==1){
           //echo "yes 1";
           return true;
       }
       else{
           //echo "yes 2";
           return false;
       }
    }
    
    function closeDb(){
        mysql_close($this->conn);
    }
}