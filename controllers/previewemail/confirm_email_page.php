<?php
include_once '../../utilities/model.php';
include_once '../../utilities/mydb.php';
include_once '../../utilities/managetemplate.php';
include_once '../../utilities/View.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//get all columns(parameters) from db
//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
//define table name
$user = "Users";
$model->listAllColumn($user);
$column_list = array();
while($column = $model->getAllColumn()){
    //print_r($column);
    //$column['column_name'];
    array_push($column_list, $column['column_name']);
}
//$dao->closeDb();

$select_template = $_POST['select_template'];
//whether exist mismatch parameter
$rec_mismatch=0;

if($select_template=="old_template"){
    $template_name = $_POST["template_version"];
    $filename = "../../templates/".$template_name;
    $file = new managetemplate($filename);
    $template_content = $file->preview_template_content();

    $content = $template_content;
    $content = $file->replace_php_to_brace($content);
    //get all parameters from template content
    $record_paras=array();
    $para = array();
    preg_match_all('/\{[A-Za-z\s]+\}/',$content,$para);
    //echo $para[0][1];
    $cou = count($para[0]);
    for($i=0;$i<$cou;$i++){
        array_push($record_paras, $para[0][$i]);
    }
    
    
        //***************************************************************************
    
    foreach ($record_paras as $p){
        $diff = $file->macth_parameter_with_column($column_list, $p);
        if($diff==1){
            $highten = "<font color=green>".$p."</font>";
            $content = str_replace($p, $highten, $content);
        }
        else{
            $highten = "<font color=red>".$p."</font>";
            $content = str_replace($p, $highten, $content);
            $rec_mismatch = 1;
        }
    }
    //**************************************************************************
    //$template_content = html_entity_decode($template_content);
}   
else{
    $template_name = $_POST['template_name'];
    $template_content = $_POST['wysiwyg'];
    //$template_content = htmlentities($template_content);
    //make a copy of template_content 
    $content = $template_content;
    $content = html_entity_decode($content);
    
    $filename = "../../templates/".$template_name."latte";
    $file = new managetemplate($filename);
    //echo $template_content;
    //exit();
   // $template_content = str_replace("\r\n", "<br/>", $template_content);
    //check no filename
    if($template_name==""){
         echo "<a href='#' onclick=window.close()> please try again</a><br>";
         exit("please input filename!");
    }
    
    $record_paras=array();
    $para = array();
    preg_match_all('/\{[A-Za-z\s]+\}/',$content,$para);
    //echo $para[0][1];
    $con = count($para[0]);
    for($i=0;$i<$con;$i++){
        array_push($record_paras, $para[0][$i]);
    }
    
        //***************************************************************************
    
    foreach ($record_paras as $p){
        $diff = $file->macth_parameter_with_column($column_list, $p);
        
        if($diff==1){
            $highten = "<font color=green>".$p."</font>";
            $content = str_replace($p, $highten, $content);
        }
        else{
            $highten = "<font color=red>".$p."</font>";
            $content = str_replace($p, $highten, $content);
            $rec_mismatch = 1;
        }
    }
    
    //**************************************************************************
}

//no campaign_name
$campaign_name = $_POST['campaign_name'];
if($campaign_name==""){
     echo "<a href='#' onclick=window.close()> please try again</a><br>";
     exit("please input campaign name!");
}

if($rec_mismatch==1){
    $con = "<h5><font color='red'> (the parameter you used is probably mismatched)<font></h5>";
}
else{
    $con = "";
}

//transfor to html
$template_content = htmlentities($template_content);

$select_group = $_POST['select_users'];
$select_method = $_POST['select_method'];
$filepath = "../../views/preview_email_view/confirm_email_view.php";
$vi = new View($filepath);
$vi->setdata("template_name", $template_name);
$vi->setdata("template_content", $template_content);
$vi->setdata("content_view", $content);

$vi->setdata("select_group", $select_group);
$vi->setdata("select_method", $select_method);
$vi->setdata("select_template", $select_template);
$vi->setdata("campaign_name", $campaign_name);

$vi->setdata("rec_mismatch", $con);
$vi->output();