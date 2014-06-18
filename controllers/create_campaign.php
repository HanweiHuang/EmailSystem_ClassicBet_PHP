<?php
include_once '../utilities/model.php';
include_once '../utilities/mydb.php';
//include_once '../utilities/DataAccess.php';
include_once '../utilities/View.php';
include_once '../utilities/managetemplate.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//connect mysql
//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//search users but havent get
//$model = new model($dao);
$model = model::getInstance();
$model->listUsers();
//define output of listusers
$output = "";

//get users and assign a value
while($user=$model->getUser()){
    $output .= "<tr><td>"
            ."<input type='checkbox' name='prikey[]' id= 'prikey[]' value="
            .$user['id']
            ."></input></td><td>"
            .$user['firstname']
            ."</td><td>"
            .$user['email']
            ."</td></tr>";
    
}

//define a output for selection of templates
$option_output="";
//find all templates
$file = new managetemplate("../templates/");
$files = $file->get_all_files();

//$file->add_new_template("this is template");
//display all templates
foreach($files as $values){
    $option_output .="<option value='$values'>".$values."</option>";
}

$groups = array();
$model->listGroups();
while($group = $model->getAllGroups()){
    $groupname = $group['groupname'];
    array_push($groups, $groupname);
}

//view 
//$vi = new View("../view/showusers.php");
$vi = new View("../views/create_Message.php");
//set up values for outputing
$vi->setdata("output", $output);
$vi->setdata("option_output",$option_output);

$vi->setdata("groups", $groups);
//output
$vi->output();
//close connection
//$dao->closeDb();
