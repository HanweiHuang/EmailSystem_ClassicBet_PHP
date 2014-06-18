<?php
//include_once '../utilities/model.php';
//include_once '../utilities/DataAccess.php';
include_once '../../utilities/View.php';
include_once '../../utilities/managetemplate.php';
include_once '../../errReport/checkData.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo $r = $_GET['id'];
$name = $_GET['id'];
$check = new checkData();
$name = $check->str_check($name);

$filename = "../../templates/".$name; 

$file = new managetemplate($filename);
$content = $file->edit_template_content();
if(!$content){
    echo "<a href='#' onclick=window.close()> please try again</a><br>";
    exit("can not find this file");
}

$content = $file->replace_php_to_brace($content);


//clean the html color
$content = htmlentities($content);

//$content = str_replace("&lt;/font&gt;", "", $content);
//$content = str_replace("&lt;font", "", $content);
//$content = str_replace("color=&quot;red&quot;&gt;", "", $content);
//$content = str_replace("color=&quot;green&quot;&gt;", "", $content);
//$content = str_replace("color=red&gt;","",$content);
//$content = str_replace("color=green&gt;","",$content);
/////////////////////////

//print_r($ci);
//var_dump($ci);
//print_r($ci);
//echo $content;
//$name = $_GET['id'];
//$name = $_GET['id']; 
$vi = new View("../../views/edit_templates_view/edit_template_content_view.php");
$vi->setdata("content", $content);
$vi->setdata("name", $name);
$vi->output();