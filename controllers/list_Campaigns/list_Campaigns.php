<?php
include_once '../../utilities/View.php';
include_once '../../utilities/mydb.php';
include_once '../../utilities/model.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$dao = new DataAccess("127.0.0.1","root","root","mcs");
//$dao = mydb::getInstance();
//$dao->select_db('mcs');
//$model = new model($dao);
$model = model::getInstance();
$adjacents = 1;
$tablename = "complist";
$total_pages = $model->total_records_of_one_table($tablename);

$targetpage = "list_Campaigns.php";
$limit = 10;

if(!isset($_GET['page'])){
    $page=1;
}
else{
    $page = $_GET['page'];
}
if($page){
    
    $start = ($page-1)*$limit;
}else{
    $start = 0;
}

$complists = array();
$complists = $model->listAllCampaignsByLimit($start,$limit);

if($page == 0){
    $page = 1;
}
$prev = $page -1;

$next = $page+1;
$lastpage = ceil($total_pages/$limit);
//echo $lastpage;
$lpm1 = $lastpage -1;// last page minus 1

$pagination = "";
//echo $lastpage."fff";
if($lastpage >= 1)
{   
    //$pagination .= "<div class=\"pagination\">";
    $pagination .= "<div class=\"\">";
    //previous button
    if ($page > 1){
        $pagination.= "<a href=\"$targetpage?page=$prev\">previous </a>";
    }else{
        $pagination.= "<span class=\"disabled\">previous </span>";   
    }
    //pages 
    if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
    {   
        for ($counter = 1; $counter <= $lastpage; $counter++)
        {
            if ($counter == $page)
                $pagination.= "<span class=\"current\">$counter </span>";
            else
                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter </a>";                 
        }
    }
    elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
    {
        //close to beginning; only hide later pages
        if($page < 1 + ($adjacents * 2))        
        {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class=\"current\">$counter </span>";
                else
                    $pagination.= "<a href=\"$targetpage?page=$counter\">$counter </a>";                 
            }
            $pagination.= "...";
            $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1 </a>";
            $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage </a>";       
        }
        //in middle; hide some front and some back
        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
        {
            $pagination.= "<a href=\"$targetpage?page=1\">1 </a>";
            $pagination.= "<a href=\"$targetpage?page=2\">2 </a>";
            $pagination.= "...";
            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class=\"current\">$counter </span>";
                else
                    $pagination.= "<a href=\"$targetpage?page=$counter\">$counter </a>";                 
            }
            $pagination.= "...";
            $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1 </a>";
            $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage </a>";       
        }
        //close to end; only hide early pages
        else
        {
            $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
            $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
            $pagination.= "...";
            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class=\"current\">$counter </span>";
                else
                    $pagination.= "<a href=\"$targetpage?page=$counter\">$counter </a>";                 
            }
        }
    }

    //next button
    if ($page < $counter - 1) 
        $pagination.= "<a href=\"$targetpage?page=$next\">next </a>";
    else
        $pagination.= "<span class=\"disabled\">next </span>";
    $pagination.= "</div>\n";       
}

$output = "";
foreach ($complists as $camp){
    $output .= "<tr>"
            . "<td class='checkbox-column'><i class='icon-folder-open'></i></td>"
            . "<td>".$camp['campaigns']."</td>"
            . "<td>".$camp['template']."</td>"
            . "<td>".$camp['group']."</td>"
            . "<td>".$camp['status']."</td>"
            . "<td><button>Edit</button>"
            . "<button>Reports</button></td>";
}

//$dao->closeDb();

//echo $pagination."dsadsa";
//exit();
$view = new View("../../views/display_Campaigns_view.php");
$view->setdata("output", $output);

$view->setdata("pageination", $pagination);
$view->output();