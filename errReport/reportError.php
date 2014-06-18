<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_error_handler('displayErrorHandler');

function displayErrorHandler($error, $error_string, $filename, $line, $symbols)
{
 $error_no_arr = array(1=>'ERROR', 2=>'WARNING', 4=>'PARSE', 8=>'NOTICE', 
     16=>'CORE_ERROR', 32=>'CORE_WARNING', 64=>'COMPILE_ERROR', 128=>'COMPILE_WARNING', 
     256=>'USER_ERROR', 512=>'USER_WARNING', 1024=>'USER_NOTICE', 
     2047=>'ALL', 2048=>'STRICT');
    if(in_array($error,array(1,2,8))){       
        $msg=" warning or notice occured";
        dieByError($msg);
    }
    
}

function dieByError($msg)
{
   echo $msg;
   exit();
}