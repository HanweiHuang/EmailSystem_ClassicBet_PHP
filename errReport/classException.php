<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class classException extends Exception{
    public function errorMessage(){
        $errorMsg = 'error on line'.$this->getline().' in '.$this->getFile().'<br>'.$this->getMessage();
        return $errorMsg;
    }
}