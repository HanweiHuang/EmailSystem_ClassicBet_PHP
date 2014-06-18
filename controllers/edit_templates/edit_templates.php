<?php
include_once '../../utilities/managetemplate.php';
include_once '../../utilities/View.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$file = new managetemplate("../../templates/");
$files = $file->get_all_files();
//$output="";
//foreach($files as $values){
//    $output .="<tr><td class='checkbox-column'><i class='icon-folder-open'></i></td><td>"
//            .$values."</td><td><button "
//            ."onClick=jvascript:del_sure('".$values."');>remove</button>"
//            ." <button onClick=window."
//            ."open('http://localhost/megsys/controller/edit_template_content.php?id=".$values."','','modal=yes,width=500,height=500,resizable=no,scrollbars=no')>edit</button>"
//            
//            ."</td></tr>";
//}
//echo $output;

$filearray = array();

if($files==""){
    
}else{
foreach($files as $file){
    array_push($filearray, $file);
}
}
$vi = new View("../../views/edit_templates_view/edit_template_view.php");
//$vi->setdata("output", $output);

$vi->setdata("files", $filearray);
$vi->output();
