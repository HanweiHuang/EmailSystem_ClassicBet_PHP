<?php
include_once 'class.smtp.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mailer{
    
    /**
     * the MIME Content-type of the message
     * could be text/plain, text/html
     * @var type 
     */
    public $ContentType = 'text/plain';
    /**
     *the character set of the message
     * @var type 
     */
    public $CharSet = 'iso-8859-1';
    
    /**
     * which method to use to send mail
     * Option:"mail","sendmail","smtp"
     * @var type string
     */
    public $Mailer = 'smtp';
    ///////////////////////////////////////
    /**
     * SMTP hosts
     * Either a single hostname or multiple semicolon-delimited hostname
     * you can also specify a different port
     * (e.g "smtp1.example.com:25;smtp2.example.com").
     * will be tried in order
     */
    public $Host = 'ssl://smtp.gmail.com';
    /**
     * default smtp server port 25
     * @var type 
     */
    public $Port = 465;
    
    /**
     * The default SMTP server port
     * default is $Hostname
     */
    public $Helo = '';
    /**
     * the secure connection prefix
     * Options "","ssl","tls"
     * @var type 
     */
    public $SMTPSecure='';
    
    /**
     * The hostname to use in Message-id and received heraders 
     * and as default HELO string
     * if empty, the value returned 
     * by SERVER_NAME is used or 'localhost.localdomain'.
     * @var type 
     */
    public $Hostname ='';
    
    //////////////////////////////
    /**
     * whether to use SMTP authentication
     * Users the Username and Password properties
     * @var type 
     */
    public $SMTPAuth = true;
    
    /**
     * SMTP username
     */
    public $Username = 'wei2215038@gmail.com';
    
    /**
     * SMTP password 
     */
    public $password = 'sally19870627';
    
    /**
     * SMTP auth type
     * Options are LOGIN PLAIN (NTLM CRAM-MD5)
     */
    public $AuthType='LOGIN';
    
    /**
     * whether use VERP
     * @var type 
     */
    public $do_Verp = false;

    
    /**
     * The SMTP server timeout in seconds
     * @var type 
     */
    public $Timeout = 10;
    
    /**
     * SMTP calss debug output model.
     * Options:
     *   0:no output
     *   1:commands
     *   2:data and commands
     *   3:as 2 plus connection status
     *   4:low level data output
     * @var type integer
     */
    public $SMTPDebug = 4;
    /**
     * how to handle debug output
     * Options 
     *   'echo':output plain-text approciated for CLI
     *   'html':approciated for browser
     *   'error_log':output to error log as configured in php.ini
     * @var type string
     */
    public $Debugoutput = 'html';
    
    
    
    /**
     *an instance of the smtp sender class
     * @var type 
     */
    protected $smtp = null;

    /**
     *the array of to addresses
     * @var type 
     */
    protected $to = array();
    /**
     *the array of cc addresses
     * @var type 
     */
    protected $cc = array();
    /**
     *the array of bcc addresses
     * @var type 
     */
    protected $bcc = array();
    /**
     * the array of reply-to names and addresses;
     * @var type 
     */
    protected $ReplayTo = array();
    
    /**
     * the array of the attachments
     * @var type 
     */
    protected $attachment = array();
    
    /**
     * output debug info 
     * @param type $str
     * @return type
     */
    protected function edebug($str){
        if(!$this->SMTPDebug){
            return;
            //0:dont need debug
        }
        switch($this->Debugoutput){
            case 'error_log':
                error_log($str);//recored error in error_log
                break;
            case 'html':
                echo htmlentities(preg_replace('/[\r\n]+/', '', $str),ENT_QUOTES,$this->CharSet);
                break;
            case 'echo':
            default:
                echo $str."\n";
        }
    }
    
    /**
     * set messages type HTML or plain
     * @param type $isHTML
     */
    public function isHTML($isHTML = true){
        if($isHTML){
            $this->ContentType = 'text/html';
        }else{
            $this->ContentType = 'text/plain';
        }
    }
    
    /**
     * Send message using SMTP
     */
    public function isSMTP(){
        $this->Mailer = 'smtp';
    }
    
    
    /**
     * send email
     * @return boolean
     */
    public function send(){
        try{
            if(!$this->preSend()){
                return false;
            }
            //send
            return $this->postSend();
        }
        catch(phpmailerException $exc){
            $this->mailHeader = '';
            
        }
    }
   
    //prepare send a message
    public function preSend(){
        try{
            $this->mailHeader='';
            if((count($this->to)+count($this->cc)+count($this->bcc))<1){
                throw new phpmailerException($this->lang);
            }
        }catch(phpmailerException $exc){
            $this->setError($exc->getMessage());
        }
    }    public $do_verp = false;
    
    
    public function getSMTPInstance(){
        if(!is_object($this->smtp)){
            $this->smtp = new SMTPH();
        }
        return $this->smtp;
    }
    
    /**
     * send email via SMTP
     * return false if there is a bad MAIL FROM DATA input
     * @see PHPMailer::getSMTPInstance() to use a different class
     */
    protected function smtpSend($header,$body){
        $bar_rcpt = array();
        
        if(!$this->smtpConnect()){
            throw new phpmailerException($this->lang('smtp_connection_failed'),self::STOP_CRITICAL);
        }
        $smtp_from = ($this->Sender =='');
    }
    /**
     * connect smtpserver
     * 1.make sure instance of smtp exits or not
     * 2.make sure connection exits or not
     * 3.set port
     * 4.connect 
     * 5.send helo
     * 6.autheniation 
     * 7.close smtp if all operation finishs
     */
    public function smtpConnect($options=array()){
        //if no instance
        if(is_null($this->smtp)){
            $this->smtp=$this->getSMTPInstance();
        }
        //already connected
        if($this->smtp->connected()){
            return true;
        }
        $this->smtp->setTimeout($this->Timeout);
        $this->smtp->setDebugLevel($this->SMTPDebug);
        $this->smtp->setDebugOutput($this->Debugoutput);
        $this->smtp->setVerp($this->do_Verp);
        $hosts = explode(';',$this->Host);
        $lastexception = null;
       
        foreach($hosts as $hostentry){
            
            //record host info from match
            $hostinfo =array();
            if(!preg_match('/^((ssl|tls):\/\/)*([a-zA-Z0-9\.-]*):?([0-9]*)$/',trim($hostentry), $hostinfo)){
                continue;
            }
            //the host string prefix can temporarily override the current setting for SMTPSecure
            $prefix='';
            $tls = ($this->SMTPSecure == 'tls');
            if($hostinfo[2] == 'ssl' or ($hostinfo[2]=='' and $this->SMTPSecure =='ssl')){
                $prefix = 'ssl://';
                $tls=false;
            }
            elseif($hostinfo[2]=='tls'){
                $tls = true;//tls doesnt use prefix
            }
            $host = $hostinfo[3];
            $port = $this->Port;
            $tport = (integer)$hostinfo[4];
            if($tport >0 and $tport < 65536){
                $port = $tport;
            }
            if($this->smtp->connect($prefix.$host,$port,$this->Timeout,$options)){
                if($this->Helo){
                    $hello = $this->Helo;
                }else{
                    $hello = $this->serverHostname();
                }
                $this->smtp->hello($hello);
                if($tls){
                    if(!$this->smtp->startTLS()){
                        throw new phpmailerException($this->lang('connect_host'));
                    }
                    //resend HELO after tls negotiation
                    $this->smtp->hello($hello);
                }
                if($this->SMTPAuth){
                    if(!$this->smtp->authenticate($this->Username,$this->password,$this->AuthType)){
                        throw new phpemailerException();
                    }
                }
                return true;
            }
        }
        $this->smtp->close();
        return false;
    }
    //get serverhostname
    public function serverHostname(){
        $result = 'localhost.localdomain';
        if(!empty($this->Hostname)){
            $result = $this->Hostname;
        }elseif(isset($_SERVER) and array_key_exists('SERVER_NAME', $_SERVER) and !empty ($_SERVER['SERVER_NAME'])){
            $result = $_SERVER['SERVER_NAME'];
        }elseif(function_exists('gethostname')&&  gethostname()!=false){
            $result = gethostname();
        }elseif(php_uname('n')!==false){
            $result = php_uname('n');
        }
        return $result;
    }
}











