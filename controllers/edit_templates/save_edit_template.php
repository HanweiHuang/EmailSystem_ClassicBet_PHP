<?php
include_once '../../utilities/managetemplate.php';
//include_once("../errReport/reportError.php");
//include_once("../errReport/classException.php");
include_once '../../utilities/model.php';
include_once '../../utilities/mydb.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo $C=$_POST['filename'];
$filename = $_POST['filename'];
//echo $filename;
$path_to_file="../../templates/".$filename;
$content = $_POST['wysiwyg'];

///////////////////////////////////////////////////////
//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
//define table name
$user = "Users";
$model->listAllColumn($user);

$column_list = array();
while($column = $model->getAllColumn()){
    
    array_push($column_list, $column['column_name']);
}
//$dao->closeDb();
//////////////////////////////////////////////////////

/////////////////////////////////////////////////////
$record_paras=array();
$para = array();
preg_match_all('/\{[A-Za-z]+\}/',$content,$para);
//echo $para[0][0];
//exit();
$cou = count($para[0]);
for($i=0;$i<$cou;$i++){
    array_push($record_paras, $para[0][$i]);
}
////////////////////////////////////////////////////



$file = new managetemplate($path_to_file);
foreach ($record_paras as $p){
    $diff = $file->macth_parameter_with_column($column_list, $p);
    if($diff==1){
         
          $content = $file->replace_brace_to_php_with_one_parameter($content,$p);
//        $highten = "<font color=green>".$p."</font>";
//        $content = str_replace($p, $highten, $content);
    }
    else{
//        $highten = "<font color=red>".$p."</font>";
//        $content = str_replace($p, $highten, $content);
        //$rec_mismatch = 1;
    }
}

//$content = $file->replace_brace_to_php($content);
try {
    //echo 'dddd'.is_file("1.latte");
    if(is_file($path_to_file)){
        $content = html_entity_decode($content);
        $file->update_template_content($content);
        echo "<script type='text/javascript'>document.onload=window.close();</script>";
    }
    else{
        throw new classException("the file does not exist");
    }
} catch (classException $exc) {
   // echo $exc->getMessage();
    echo $exc->errorMessage();
}


//echo is_file($path_to_file);
//echo "<script type='text/javascript'>document.onload=window.close();</script>";


