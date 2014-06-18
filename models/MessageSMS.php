<?php
include("User.php");
include("Template.php");
include("Message.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MessageSMS extends Message{
    
    
    public function sendMessage(\User $user, \Template $template) {
        echo "hello!";
    }

}