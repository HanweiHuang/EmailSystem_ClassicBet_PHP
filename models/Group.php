<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Group{
    var $groupname;
    
    var $users= array();
    
    function userslist($user){
        array_push($this->users, $user);
    }
    
    function getUsers(){
        return $this->users;
    }
}