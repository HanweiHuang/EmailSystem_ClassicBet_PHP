<?php
include '../../utilities/model.php';
include '../../utilities/mydb.php';
include '../../utilities/View.php';
include_once("../../errReport/reportError.php");
include_once("../../errReport/classException.php");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$filename = $_POST['id'];
//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
$model->deleteGroupById($filename);

//$dao->closeDb();
header("Location: http://localhost/more/controllers/listcontroller/edit_list.php");