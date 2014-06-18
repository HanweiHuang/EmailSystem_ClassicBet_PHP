<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class checkData{
    
    function inject_check($sql_str){
        
        return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile',$sql_str);
    }
    
    
    
    function verify_id($id=NULL){
        if(!$id){exit('no parameter');}
        elseif(inject_check($id)){
            exit('illegal parameter');
        }
        elseif(!is_numeric($id)){
            exit('illegal parameter');
        }
        $id= intval($id);
        return $id;
    }
    
    function str_check($str){
        if(!get_magic_quotes_gpc()){
            $str = addslashes($str);
        }
        
        $str = str_replace("_", "\_",$str);
        $str = str_replace("%","\%",$str);
        return $str;
    }
    
    function post_check($post){
        if(!get_magic_quotes_gpc()){
            $post = addslashes($post);
        }
        $post = str_replace("_", "\_", $post);
        $post = str_replace("%","\%",$post);
        $post = nl2br($post);
        $post = htmlspecialchars($post);
        
        return $post;
    }
}