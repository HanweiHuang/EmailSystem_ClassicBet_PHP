<?php
include_once '../../utilities/mydb.php';
include_once '../../utilities/model.php';
include_once '../../utilities/View.php';
include_once '../../errReport/checkData.php';
include_once '../../utilities/spit_page.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$dao = new DataAccess("","","","");
//$model = new model($dao);
$model = model::getInstance();
//get groupname
$groupname = $_GET['id'];




///////////////////
$check = new checkData();
$groupname = $check->str_check($groupname);

$model->listAllUsersInOneGroup($groupname);

$groupusers = array();
while($user=$model->getAllUsersInOneGroup()){
    array_push($groupusers, $user);
}
//$dao->closeDb();

$filepath = "../../views/edit_list_view/edit_group_view.php";
$vi = new View($filepath);

$vi->setdata("groupusers", $groupusers);
$vi->setdata("groupname", $groupname);
$vi->output();

