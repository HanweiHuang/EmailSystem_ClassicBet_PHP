<?php
include_once '../utilities/View.php';
include_once '../utilities/mydb.php';
include_once '../utilities/model.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$model = new model($dao);
$model = model::getInstance();
$model->listGroups();

$groups = array();
while($group=$model->getAllGroups()){
    //echo $group['groupname'];
    $groupname=$group['groupname'];
    array_push($groups, $groupname);
//    $model->listAllUsersInOneGroup($groupname);
//    while($user=$model->getAllUsersInOneGroup()){
//        echo $user['lastname'];
//        echo "<br>";
//    }
}
$output="";
foreach ($groups as $values){
    $output .=" <div class='row'>
		    <div class='col-md-12'>
			<div class='widget box'>
			    <div class='widget-header'>
				<h4><i class='icon-reorder'></i> ".$values." </h4>
				    <div class='toolbar no-padding'>
					<div class='btn-group>
					    <span class='btn btn-xs widget-collapse'><i class='icon-angle-down'></i></span>
						</div>
						    </div>
							</div>
							<div class='widget-content no-padding'>
								<table data-display-length='15' data-default-order='1' class='table table-striped table-bordered '>
									

                                                                        <thead>
										<tr>
											<th class='checkbox-column'>
												<i class='icon-plus'></i>
											</th>											
											<th>Group name</th>
                                                                                        <th>first name</th>
                                                                                        <th>last name</th>
										</tr>
									</thead   
<tbody>";
                                        
    $model->listAllUsersInOneGroup($values);
    while($user=$model->getAllUsersInOneGroup()){
    $output .="<tr>
                    <td class='checkbox-column'>
                            <i class='icon-folder-open'></i>
                    </td>
                    <td>".$values."</td>
                    <td>".$user['firstname']."</td>
                    <td>".$user['lastname']."</td>
                    
            </tr> ";                                                                             
									
    }
    $output .="</tbody></table></div></div></div></div>  ";
}
//$model->listAllUsersInOneGroup($groupname)

$filepath = "../view/edit_list_view.php";
$view = new View($filepath);
$view->setdata("output", $output);
$view->output();

