<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Message{
    public function setUser(){}
    
    public function setTemplate(){}
    
    abstract public function sendMessage($user, $template); 
}