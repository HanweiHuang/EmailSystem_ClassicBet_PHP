<?php
include_once '../../utilities/managetemplate.php';
include_once '../../utilities/model.php';
include_once '../../utilities/mydb.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    
//get filename exclude postfix
$filetitle = $_POST['filename'];
//add postfix
$filename = $filetitle.".latte";
//get content of textarea
$content = $_POST['wysiwyg'];


////////////////////// get all columns from one table
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
//////////////////////////////////
//get all parameters in new template content
////////////////////////////////////////////////////////
$record_paras=array();
$para = array();
preg_match_all('/\{[A-Za-z]+\}/',$content,$para);
//echo $para[0][1];
$cou = count($para[0]);
for($i=0;$i<$cou;$i++){
    array_push($record_paras, $para[0][$i]);
}
////////////////////////////////////////////////////////////
    
$file = new managetemplate("../../templates/");
foreach ($record_paras as $p){
        $diff = $file->macth_parameter_with_column($column_list, $p);
        if($diff==1){
            $file->replace_brace_to_php_with_one_parameter($content, $p);
        }
        else{
            
        }
    }

//////////////////////////////////////////////////////////


// filetitle is empty
if($filetitle){
    $path = "../../templates/";
    $path_to_file="../../templates/".$filename;
    //exist file
    if(is_file($path_to_file)){
        echo "the file has existed<br> please return";
        echo "<button onClick='history.go(-1);'>back</button>";
        exit();
    }
    else{
       //new 
        $file = new managetemplate($path);
        
        $para = array();
        //
        $content = htmlentities($content);
        
        //echo $textarea;
        preg_match_all('#color=green.*?\{[a-zA-Z]+\}#',$content,$para);
        $content = $file->replace_green_with_parameter($content,$para);
//        echo $content;
//        exit();
        $content = html_entity_decode($content);
        $file->add_new_template($content, $filename);
        echo "<script type='text/javascript'>window.opener.location.reload();</script>";
        echo "<script type='text/javascript'>document.onload=window.close();</script>";
    }
}
else{
    echo "please input filename!";
    echo "<button onClick='history.go(-1);'>back</button>";
    exit();
    
}