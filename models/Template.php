<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Template{
    protected $variables = array();
    protected $path_to_file;
    
    function __construct($path_to_file) {
        // echo $path_to_file;
         if(!file_exists($path_to_file)){
            throw new Exception("Template".$path_to_file."doesn't exist.");
        }
        $this->path_to_file = $path_to_file;
    }
    
    public function getText(){
        ob_start();
        extract($this->variables);
        include $this->path_to_file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    public function setText($key,$value){
        $this->variables[$key] = $value;
    }
}