<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class managetemplate{
    
    var $path_to_files;
    
    function __construct($path_to_files) {
        $this->path_to_files = $path_to_files;
    }
    
    function get_all_files(){
        $handler = opendir($this->path_to_files);
        $files = array();
       while (($filename = readdir($handler)) !== false) {
        if ($filename != "." && $filename != "..") {  
                $files[] = $filename ;  
           }  
       }
       closedir($handler);
       return $files;
    }  
    
    //add new template
    function add_new_template($content_template,$filename){
        echo $content_template;
        
        $path_create_file = $this->path_to_files.$filename;
        echo $path_create_file;
        //set chmod
        //chmod($this->path_to_files, 0777);
        if(($text_ref = fopen($path_create_file, "w+"))===FALSE){
            echo "fail to create file ".$filename;
            exit();
        }
        
        //echo "create file success";
//        
        if(!fwrite($text_ref, $content_template)){
            echo "fail to write content to file ".$filename;
            fclose($text_ref);
            exit();
        }
        echo $filename." write successful";
         fclose($text_ref);
         
    }
    
    function replace_brace_to_php($text_content){
        $text_content = str_replace("{", "<?=$", $text_content);
        $text_content = str_replace("}","?>",$text_content);
        //$text_content = html_entity_decode($text_content);
        return $text_content;
    }
    
    function replace_php_to_brace($text_content){
        $text_content = str_replace("<?=$", "{", $text_content);
        $text_content = str_replace("?>", "}", $text_content);
        return $text_content;
    }
    
    
    function remove_template($filename){
        if(file_exists($filename)){
            unlink($filename);
        }
    }
    
    function edit_template_content(){
        $content="";
       // $handle = fopen($this->path_to_files, 'r');
        if(!file_exists($this->path_to_files)){
            return false;
        }else{
            $content = file_get_contents($this->path_to_files);
            return $content;
        }
        //content = str_replace("\r\n", "<br/>", $content);
        //echo strlen($content);
        //$content = htmlentities($content);
        //print_r($content);
        //fclose($handle);
        //echo $content;
        
    }
    
    function preview_template_content(){
        $content="";
       // $handle = fopen($this->path_to_files, 'r');
        $content = file_get_contents($this->path_to_files);
        
        $content = str_replace("\r\n", "<br/>", $content);
        //$content = htmlentities($content);
        //$content = html_entity_decode($content);
        //echo strlen($content);
        //$content = htmlentities($content);
        //print_r($content);
        //fclose($handle);
        //echo $content;
        return $content;
    }
    
    function update_template_content($content){
        file_put_contents($this->path_to_files,$content);
    }
    
    
    function edit_pretemplate_content(){
        //echo $content = file_get_contents($this->path_to_files);
        $file = @fopen($this->path_to_files, "r");
        if($file){
            while(!feof($file)){
                echo fgets($file);
            }
        }
        fclose($file);
    }
    
    function macth_parameter_with_column($columns,$parameter){
        $diff = 0;
        foreach($columns as $column){
            $addbracecolumn = "{".$column."}";
            if($addbracecolumn == $parameter){
                $diff =1 ;
            }
        }
        
        return $diff;
    }
    
    
    
    function replace_green_with_parameter($content,$para){
       // $hahah = "fuckyou";
        foreach($para[0] as $p){
            $p = str_replace("color=green&gt;{", "", $p);
            $p = str_replace("}", "", $p);        
//            echo $p;
//            exit();
            $str = "green&gt;{".$p."}";
            $replace = "green&gt;&lt;?=$".$p."?&gt;";
            $content = str_replace($str, $replace, $content);
        }
        //exit();
        
        
        
        //$content = preg_replace("#color=green.*?\{[a-zA-Z]+\}#", "", $content);
        //$content = str_replace("}","?&gt;",$content);
        //$text_content = html_entity_decode($text_content);
        
        return $content;
    }
    
    
    function replace_brace_to_php_with_one_parameter($content,$parameter){
        $parameter = str_replace("{", "", $parameter);
        $parameter = str_replace("}", "", $parameter);
//        echo $parameter;
//        exit();
        $search = "{".$parameter."}";
        $replace = "&lt;?=$".$parameter."?&gt;";
//        echo $search."<br>";
//        echo $replace;
//        exit();
        $content = str_replace($search, $replace, $content);
        return $content;
    }
   
}