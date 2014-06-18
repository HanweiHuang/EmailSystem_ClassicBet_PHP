<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class mysql{
    private static $conn;
    
    private function __construct() {
        $this->conn = mysqli_connect('localhost', 'root', 'root', 'mcs');
    }
    public static function getInstance(){
        if(!self::$conn){
            new self();
        }
        else{
            return self::$conn;
        }
    }
    public function __clone() {
        trigger_error('Clone is not allowed');
    }
}