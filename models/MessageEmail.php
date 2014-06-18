<?php
include_once "Message.php";
include_once "email.class.php";
include_once "User.php";
include_once "MessageLog.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MessageEmail extends Message{
    var $smtpserver ;
    var $smtpserverport;
    var $smtpusermail;
    //$smtpemailto = $_POST['toemail'];//send to
    var $smtpemailto;//send to
    var $smtpuser;
    var $smtppass;
    //$mailtitle = $_POST['title'];
    var $mailtitle;
    //$mailcontent = "<h1>".$_POST['content']."</h1>";
    var $mailcontent;
    var $mailtype;
     
    public function __construct() {
       $this->smtpserver = "ssl://smtp.gmail.com";
       $this->smtpserverport =465;
       $this->smtpusermail = "wei2215038@gmail.com";
    //$smtpemailto = $_POST['toemail'];//send to
       //$this->smtpemailto = " wei2215038@gmail.com";//send to
       $this->smtpuser = "wei2215038@gmail.com";
       $this->smtppass = "sally19870627";
    //$mailtitle = $_POST['title'];
       $this->mailtitle = "ClassicBet";
    //$mailcontent = "<h1>".$_POST['content']."</h1>";
      // $this->mailcontent = "<h1>hello this is test</h1>";
       $this->mailtype = "HTML";
    }


    public function sendMessage($user, $template) {
        //$username = $user['firstname']." ".$user['lastname'];
        $username = $user['username'];
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $password = $user['password'];
        $birthday = $user['birthday'];
        $email = $user['email'];
        $address = $user['address'];
      
       // echo $password;
        
        //set template parameters here 
        $template->setText("username", $username); 
        $template->setText("firstname", $firstname);
        $template->setText("lastname",$lastname);
        $template->setText("password",$password);
        $template->setText("birthday",$birthday);
        $template->setText("email",$email);
        $template->setText("address",$address);
        /////////////////////////
        //get template content
        $email_content = $template->getText();
        //$textarea = $file->replace_brace_to_php($textarea);
        //$file = new managetemplate("../templates/");
        //$email_content = $file->replace_brace_to_php($email_content);
        $email_content = str_replace("\r\n", "<br/>", $email_content);
        
        //$email_content = html_entity_decode($email_content);
       // echo $email_content;
       // exit();
        $html_email_content = "<html><body><div>".$email_content."</div></body></html>";
        
       
        
        $smtp = new smtp($this->smtpserver,$this->smtpserverport,true,$this->smtpuser,$this->smtppass);
        $smtp->debug = false;
        $state = $smtp->sendmail($user['email'], $this->smtpusermail, $this->mailtitle, $html_email_content, $this->mailtype);
        //$state="";
        /////message log
        //echo $state;
//        $mes_log = new MessageLog();
//        
//        $ob_user = new User();
//        $ob_user->setfirstname($user['firstname']);
//        $ob_user->setlastname($user['lastname']);
//        $ob_user->setusername($user['username']);

        //echo "<div style='width:500px; margin:36px auto;'>";
        if($state==""){
//                echo "sorry";
//                echo "<a href='index.html'>return</a>";
                
                return false;
//                $text = "fail to send";
//                $mes_log->addEntry($text, $ob_user, $template->getText(), $template_version);
//                exit();
        }else{
                return true;
       
        }
    }
}