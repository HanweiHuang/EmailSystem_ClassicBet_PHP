<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User{

 private $first_Name;
 private $last_Name;
 private $data_of_Birth;
 private $client_Rating;
 private $email;
 private $username;
 
 public function SendTxt(){
     
 }
    
 public function SendEmail(){
     
 }
 
 public function setfirstname($a){
     $this->first_Name = $a;
     
 }
 public function getfirstname(){
     return $this->first_Name;
 }
 
 public function setlastname($a){
     $this->last_Name = $a;
 }
 
 public function getlastname(){
     return $this->last_Name;
 }
 
 public function setdataofbirth($a){
     $this->data_of_Birth = $a;
 }
 
 public function getdataofbirth($a){
     return $this->data_of_Birth;
 }
 
 public function setclientrating($a){
     $this->client_Rating = $a;
 }
 
 public function getclientrating(){
     return $this->client_Rating;
 }
 
 public function setemail($a){
     $this ->email = $a;
 }
 
 public function getemail(){
     return $this->email;
 }
// public function testarray($input){
//     echo $input[0];
// }
 
 public function setusername($a){
     $this-> username = $a;
 }
 
 public function getusername(){
     return $this->username;
 }
}