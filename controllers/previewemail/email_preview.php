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
//find all columns in table
//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
$user = "Users";
$model->listAllColumn($user);
$column_list = array();
while($column = $model->getAllColumn()){
    //print_r($column);
    //$column['column_name'];
    array_push($column_list, $column['column_name']);
}
//$dao->closeDb();
echo "ssss";
echo $select_template = $_POST['select_template'];

//record mismatch parameter
$rec_mismatch=0;

if($select_template=="old_template"){
    $template_name= $_POST['template_version'];
    //content
    $filename = "../../templates/".$template_name;
    $file = new managetemplate($filename);
    $template_content = $file->preview_template_content();
    $template_content = $file->replace_php_to_brace($template_content);
    
    $record_paras=array();
    $para = array();
    preg_match_all('/\{[A-Za-z]+\}/',$template_content,$para);
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
            $template_content = str_replace($p, $highten, $template_content);
        }
        else{
            $highten = "<font color=red>".$p."</font>";
            $template_content = str_replace($p, $highten, $template_content);
            $rec_mismatch = 1;
        }
    }
    
    //**************************************************************************
    //print_r($para);
    
    //echo $template_content;
    
}
else{
    $template_name = $_POST['template_name'];
    $template_content = $_POST['wysiwyg'];
    //<br> display in html 
    $template_content = str_replace("\r\n", "<br/>", $template_content);
    //check no filename
    if($template_name==""){
         echo "<a href='#' onclick=window.close()> please try again</a><br>";
         exit("please input filename!");
    }
    
    $record_paras=array();
    $para = array();
    preg_match_all('/\{[A-Za-z]+\}/',$template_content,$para);
    //echo $para[0][1];
    $con = count($para[0]);
    for($i=0;$i<$con;$i++){
        array_push($record_paras, $para[0][$i]);
    }
    
    $filename = "../../templates/".$template_name."latte";
    $file = new managetemplate($filename);
    //***************************************************************************
    foreach ($record_paras as $p){
        $diff = $file->macth_parameter_with_column($column_list, $p);
        if($diff==1){
            $highten = "<font color=green>".$p."</font>";
            $template_content = str_replace($p, $highten, $template_content);
        }
        else{
            $highten = "<font color=red>".$p."</font>";
            $template_content = str_replace($p, $highten, $template_content);
            $rec_mismatch = 1;
        }
    }
    
    //**************************************************************************
    //print_r($para);
}

if($rec_mismatch==1){
    $con = "<h4><font color='red'> (the parameter you used is probably mismatched)<font></h4>";
}
else{
    $con = "";
}


$filepath = "../../views/preview_email_view/preview_email_view.php";
$vi = new View($filepath);

$vi->setdata("template_content", $template_content);
$vi->setdata("template_name", $template_name);
$vi->setdata("rec_mismatch", $con);

$vi->output();