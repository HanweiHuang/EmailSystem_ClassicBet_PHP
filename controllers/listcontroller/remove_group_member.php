<?php
include_once '../../utilities/View.php';
include_once '../../utilities/mydb.php';
include_once '../../utilities/model.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$group = $_GET['group'];
$member = $_GET['member'];

//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();

$model->deleteGroupMemberById($member);
$dao->closeDb();

$str = "Location: http://localhost/more/controllers/listcontroller/edit_group.php?id=".$group;
header($str);
