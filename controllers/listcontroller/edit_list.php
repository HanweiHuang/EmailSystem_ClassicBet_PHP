<?php
include_once '../../utilities/View.php';
include_once '../../utilities/mydb.php';
include_once '../../utilities/model.php';
include_once '../../errReport/classException.php';
include_once '../../utilities/spit_page.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();

$tablename = "grouplist";
$groupname = "";
$total_pages = $model->total_records_of_one_group($tablename,$groupname);
$limit = 5;
//page
if(!isset($_GET['page'])){
    $page=1;
}
else{
    $page = $_GET['page'];
}

if($page){
    
    $start = ($page-1)*$limit;
}else{
    $start = 0;
}

$targetpage = "edit_group.php";
$spit_page = new spit_page($targetpage);
//$pageination = $spit_page->page_information($total_page, $limit, $page);

//exit();

$model->listGroups();


$groups = array();
while($group=$model->getAllGroups()){
    //echo $group['groupname'];
    $groupname=$group['groupname'];
    array_push($groups, $groupname);
//    $model->listAllUsersInOneGroup($groupname);
//    while($user=$model->getAllUsersInOneGroup()){
//        echo $user['lastname'];
//        echo "<br>";
//    }
}
//$output="";
$groupusers = array();
$grouparrays = array();
foreach ($groups as $values){
    $model->listAllUsersInOneGroup($values);
    while($user=$model->getAllUsersInOneGroup()){
        array_push($groupusers, $user);
 
    }
    array_push($grouparrays, $groupusers);
    //empty array
    $groupusers=array();
       
}
//$model->listAllUsersInOneGroup($groupname)

$filepath = "../../views/edit_list_view/edit_list_view.php";
$view = new View($filepath);

//$view->setdata("output", $output);
$view->setdata("groups", $groups);
$view->setdata("grouparrays", $grouparrays);
try{
$view->output();
}catch(Exception $e){
    echo $e->getMessage();
}

//$dao->closeDb();
