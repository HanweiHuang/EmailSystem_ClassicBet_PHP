<?php
include 'class.mailer.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$hostinfo =array();
//
//$hostentry = 'ssl://smtp.gmail.com';
//preg_match('/^((ssl|tls):\/\/)*([a-zA-Z0-9\.-]*):?([0-9]*)$/',trim($hostentry), $hostinfo);
//
//
//print_r($hostinfo);

//$he = 'd';
//if($he){
//    echo "hahah";
//}
//else{
//    echo "dsds";
//}

$te = new Mailer();
//connect smtp server
echo $te->smtpConnect();
//authentiation