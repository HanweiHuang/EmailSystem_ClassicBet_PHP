<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class model{
    
    var $dao;
    private static $instance;
    function __construct($dao){
        $this->dao = $dao;
    }
    
     //return a new object
    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            $conn = mydb::getInstance();
            self::$instance = new self($conn);
        }
        return self::$instance;
    }
    
    
    
    function listUsers(){
        $this->dao->fetch("select * from Users");
        
    }
    function getUser(){
        if($user = $this->dao->getRow()){
            //echo "getUser true   ";    
            return $user;
                
        }
        else{
            //echo "getUser false";
            return false;   
        }
    }
    
    function listUserbyRating($rating){
        $sql = "select * from Users where clientrating = '".$rating."'";
        $this->dao->fetch($sql);
    }
    function getUserbyRating(){
        if($user = $this->dao->getRow()){
                return $user;
        }
        else{
                return false;   
        }
    }
    
    function findUserbyid($id){
        //echo $id;
        $sql = "select * from Users where id= '".$id."'";
        $this->dao->fetch($sql);
    }
    
    function getUserbyid(){
        if($user = $this->dao->getRow()){
                return $user;
        }
        else{
                return false;   
        }
    }
    
    
    function addmessagelog($event,$username,$firstname,$lastname,$template,$templateversion){
        $t=  date("Y-m-d",time());
        
        $sql = "INSERT INTO `messagelog`(username,firstname,lastname,template,templateversion,date,event) "
                . "VALUES('$username','$firstname','$lastname','$template','$templateversion','$t','$event')";
        //
        $this->dao->fetch_insert($sql);
    }
    
    function addCampaign($campaign,$template,$group,$status){
        $sql = "INSERT INTO `complist`(`campaigns`,`template`,`group`,`status`) VALUES('$campaign','$template','$group','$status')";
        $this->dao->fetch_insert($sql);
    }
    
    
    function listAllCampaigns(){
        $sql = "select * from complist";
        $this->dao->fetch($sql);
    }
    function listAllCampaignsByLimit($start,$limit){
        $records = array();
        $sql = "select * from complist limit ".$start.", ".$limit;
        $this->dao->fetch($sql);
        
        while($record = $this->dao->getRow()){
        array_push($records, $record);
        }
        return $records;
    }
    
    function getAllCampaigns(){
        if($campaign = $this->dao->getRow()){
            //echo "getUser true   ";    
            return $campaign;
                
        }
        else{
            //echo "getUser false";
            return false;   
        }
    }
    
    
    function listGroups(){
        $sql = "select * from grouplist g1 where not exists(select 1 from grouplist g2 where g2.groupname = g1.groupname and g2.id<g1.id)";
        $this->dao->fetch($sql);
    }
    
    function getAllGroups(){
        if($group = $this->dao->getRow()){
            return $group;
        }
        else{
            return false;
        }
    }
    
    
    function listAllUsersInOneGroup($groupname){
        $sql = "select * from grouplist where groupname='".$groupname."'";
        $this->dao->fetch($sql);
    }
    
    public function getAllUsersInOneGroup(){
        if($guser = $this->dao->getRow()){
            return $guser;
        }
        else{
            return false;
        }
    }
    
    
    public function deleteGroupById($id){
        $sql = "delete from grouplist where groupname='".$id."'";
        $this->dao->fetch($sql);
    }
    
    public function deleteGroupMemberById($id){
        $sql = "delete from grouplist where id='".$id."'";
        $this->dao->fetch($sql);
    }
    
    public function addOneUserInGroup($user,$groupname){
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $email = $user['email'];
        $username = $user['username'];
        $sql = "INSERT INTO `grouplist`(`groupname`,`firstname`,`lastname`,`username`,`email`) VALUES('$groupname','$firstname','$lastname','$username','$email')";
        
        $re = $this->dao->fetch_insert($sql);
        return $re;
    }
    
    
    public function listAllColumn($table_name){
        $sql = "select column_name from information_schema.columns where table_name='".$table_name."'";
        $this->dao->fetch($sql);
    }
    public function getAllColumn(){
        if($getColumn = $this->dao->getRow()){
            return $getColumn;
        }
        else{
            return false;
        }
    }
    
    public function total_records_of_one_table($tablename){
        $sql = "select count(*) as num from ".$tablename;
        $this->dao->fetch($sql);
        //echo $sql;
       // exit();
        if($total_pages = $this->dao->getRow()){
        $total_pages = $total_pages['num'];
        return $total_pages;
        }
        else{
            return false;
        }
    }
    
    public function total_records_of_one_group($tablename,$groupname){
        $sql = "select count(*) as num from ".$tablename." where groupname='".$groupname."'";
        //echo $sql;
        //exit();
    }
    
    
    function getAllUsersFromUsersTable($start,$limit){
        $records = array();
        $sql = "select * from Users limit ".$start.", ".$limit;
        //echo $sql;
        $this->dao->fetch($sql);
        while($record = $this->dao->getRow()){
            array_push($records, $record);
        }
        return $records;
    }
}