<?php
include_once '../../utilities/managetemplate.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//echo $r = $_GET['id'];
//remove file
$filename = $_GET['id'];
$path_to_file="../../templates/".$filename;
$file = new managetemplate($path_to_files);
$file->remove_template($path_to_file);

//forward to new page
header("Location: http://localhost/more/controllers/edit_templates/edit_templates.php");
