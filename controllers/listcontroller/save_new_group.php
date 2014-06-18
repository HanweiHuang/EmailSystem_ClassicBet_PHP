<?php
include_once '../../utilities/model.php';
include_once '../../utilities/mydb.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//for empty users
if(!isset($_POST['prikey'])){
    echo "<a href='../../controllers/listcontroller/add_group.php'> please try again</a><br>";
    exit("please select users");
}
//get users_id
$users_id = $_POST['prikey'];
$groupname = $_POST['filename'];
if((!isset($groupname))||$groupname==""){
    echo "<a href='../../controllers/listcontroller/add_group.php'> please try again</a><br>";
    exit("no groupname here");
}

//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
$model->listGroups();
while($group = $model->getAllGroups()){
    if($groupname == $group['groupname']){
        echo "<a href='../../controllers/listcontroller/add_group.php'> please try again</a><br>";
        
        exit("$groupname has existed");
        
    }
}

$users = array();
foreach ($users_id as $id) {
    $model->findUserbyid($id);
    $user=$model->getUserbyid();
    array_push($users, $user);
}

foreach($users as $user){
    
    $re = $model->addOneUserInGroup($user, $groupname);
    if($re==false){
       echo "fail to create a group";
    }else{
       echo "<script type='text/javascript'>window.opener.location.reload();</script>";
       echo "<script type='text/javascript'>document.onload=window.close();</script>";
    }
}

//$dao->closeDb();