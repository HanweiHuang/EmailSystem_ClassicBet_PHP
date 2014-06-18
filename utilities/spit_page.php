<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class spit_page{
    
    var $adjacents = 1;
    
    var $targetpage;
    
    public function __construct($targetpage) {
        
        $this->targetpage = $targetpage;
        
    }
    
    public function page_information($total_page, $limit, $page){
        if($page = 0){
            $page = 1;
        }
        $prev = $page-1;
        $next = $page+1;
        
        $lastpage = ceil($total_page/$limit);
        $lpm1 = $lastpage -1;
        $pagination = "";
        if($lastpage>=1){
        $pagination .= "<div class=\"\">";
        
            if ($page > 1){
                $pagination.= "<a href=\"$this->targetpage?page=$prev\">previous</a>";
            }else{
                $pagination.= "<span class=\"disabled\">previous</span>";   
            }
            
             //pages 
            if ($lastpage < 7 + ($this->adjacents * 2))   //not enough pages to bother breaking it up
            {   
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"current\">$counter</span>";
                    else
                        $pagination.= "<a href=\"$this->targetpage?page=$counter\">$counter</a>";                 
                }
            }
            elseif($lastpage > 5 + ($this->adjacents * 2))    //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if($page < 1 + ($this->adjacents * 2))        
                {
                    for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$this->targetpage?page=$counter\">$counter</a>";                 
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$this->targetpage?page=$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"$this->targetpage?page=$lastpage\">$lastpage</a>";       
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                    $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$this->targetpage?page=$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"$this->targetpage?page=$lastpage\">$lastpage</a>";       
                }
                //close to end; only hide early pages
                else
                {
                    $pagination.= "<a href=\"$this->targetpage?page=1\">1</a>";
                    $pagination.= "<a href=\"$this->targetpage?page=2\">2</a>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$this->targetpage?page=$counter\">$counter</a>";                 
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
        
        
        return $pagination;
    }
}













