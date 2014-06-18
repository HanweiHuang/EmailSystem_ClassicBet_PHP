<?php
 require_once '../utilities/model.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MessageLog{
    
    var $dao;
    
    function __construct($dao) {
        $this->dao = $dao;
    }
    
    public function addEntry($event,$user,$template,$templateversion){
//        echo $user->getfirstname();
//        echo "<br>";
//        echo $template;
//       $dao = new DataAccess("127.0.0.1","root","root","mcs");
       $model = new model($this->dao);
       $username = $user['username'];
       $firstname = $user['firstname'];
       $lastname = $user['lastname'];
       $model->addmessagelog($event, $username, $firstname, $lastname, $template, $templateversion);
    }
    
    function add_general_entry($campaign,$template,$group,$status){
        $model = new model($this->dao);
        $model->addCampaign($campaign, $template, $group, $status);
    }
}