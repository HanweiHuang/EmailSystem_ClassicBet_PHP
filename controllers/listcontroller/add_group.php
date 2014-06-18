<?php
include '../../utilities/View.php';
include '../../utilities/mydb.php';
include '../../utilities/model.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$filename="../../views/edit_list_view/add_group_view.php";
$view = new View($filename);


//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
$model->listUsers();

$users = array();
while($user = $model->getUser()){
    array_push($users, $user);
}

$view->setdata("users", $users);
try{
$view->output();
}  catch (Exception $e){
   echo $e->getMessage();
}
//$dao->closeDb();