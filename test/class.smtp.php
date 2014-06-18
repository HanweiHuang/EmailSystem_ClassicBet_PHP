<?php

/*
 *  
*/
class SMTPH{
    const VERSION = '1.0';
    
    const CRLF = "\r\n";
    
    const DEFAULT_SMTP_PORT = 25;
    
    const MAX_LINE_LENGTH = 998;
    
    public $Version = '5.2.8';
    
    public $SMTP_PORT = 25;
    
    public $CRLF = "\r\n";
    
     /**
     * Debug output level.
     * Options:
     * * `0` No output
     * * `1` Commands
     * * `2` Data and commands
     * * `3` As 2 plus connection status
     * * `4` Low-level data output
     * @type integer
     */
    public $do_debug = 4;

    /**
     * How to handle debug output.
     * Options:
     * * `echo` Output plain-text as-is, appropriate for CLI
     * * `html` Output escaped, line breaks converted to <br>, appropriate for browser output
     * * `error_log` Output to error log as configured in php.ini
     * @type string
     */
    public $Debugoutput = 'html';

    /**
     * Whether to use VERP.
     * @link http://en.wikipedia.org/wiki/Variable_envelope_return_path
     * @link http://www.postfix.org/VERP_README.html Info on VERP
     * @type boolean
     */
    public $do_verp = false;

    /**
     * The timeout value for connection, in seconds.
     * Default of 5 minutes (300sec) is from RFC2821 section 4.5.3.2
     * This needs to be quite high to function correctly with hosts using greetdelay as an anti-spam measure.
     * @link http://tools.ietf.org/html/rfc2821#section-4.5.3.2
     * @type integer
     */
    public $Timeout = 300;

    /**
     * The SMTP timelimit value for reads, in seconds.
     * @type integer
     */
    public $Timelimit = 30;

    /**
     * The socket for the server connection.
     * @type resource
     */
    protected $smtp_conn;

    /**
     * Error message, if any, for the last call.
     * @type array
     */
    protected $error = array();

    /**
     * The reply the server sent to us for HELO.
     * If null, no HELO string has yet been received.
     * @type string|null
     */
    protected $helo_rply = null;

    /**
     * The most recent reply received from the server.
     * @type string
     */
    protected $last_reply = '';

    
  
    
    /**
     * Output debugging info via a user-selected method.
     * @param string $str Debug string to output
     * @return void
     */
    
    protected function edebug($str){
        switch($this->Debugoutput){
            //log, no output
            case 'error_log':
                error_log($str);
                break;
            case 'html':
              echo htmlentities(
                    preg_replace('/[\r\n]+/', '', $str),
                    ENT_QUOTES,
                    'UTF-8')
                . "<br>\n";
                break;
            case 'echo':
            default :echo gmdate('Y-m-d H:i:s')."\t".trim($str)."\n";
        }
    }
    
    public function connect($host,$port=null,$timeout=30,$options=array()){
        //clear errors
        $this->error = array();
        //make sure connected or not
        if($this->connected()){
            $this->error = array('error'=>'Already connected to a server');
            return false;
        }
        //port is empty or not
        if(empty($port)){
            $port = self::DEFAULT_SMTP_PORT;
        }
        //connect to the smtp server
        if($this->do_debug>=3){
            $this->edebug("Connection:opening to $host:$port,t=$timeout,opt=".var_export($options,true));
        }
        $errno = 0;
        $errstr='';
        $socket_context = stream_context_create($options);
        //create socket stream
        $this->smtp_conn = stream_socket_client(
                $host.":".$port,
                $error,
                $errstr,
                $timeout,
                STREAM_CLIENT_CONNECT,
                $socket_context
                );
        //whether we has connected
        if(!is_resource($this->smtp_conn)){
            //set error message
            $this->error = array(
                'error' => 'Fail to connecte to server',
                'errno' => $errno,
                'errstr' => $errstr
            );
            if($this->do_debug>=1){
                $this->edebug(
                        'SMTP ERROR:',$this->error['error'].":$errstr($errno))"
                        );
            }
            //connection fails
            return false;
        }
        if($this->do_debug>=3){
            $this->edebug("Conection Opened");
        }
        /////////////////////////////////////////////////////////
        //smtp will take longtime to response, give more timeout for first use
        //windows dont support for this timeout function.
        if(substr(PHP_OS, 0,3)!='WIN'){
            //get max timeout from config file
            $max = ini_get('max_execution_time');
            if($max!=0 && $timeout>$max){//0 means unlimit time
                @set_time_limit($timeout);
            }
            stream_set_timeout($this->smtp_conn,$timeout,0);
        }
        //get announce ment smtp response
        $announce = $this->get_lines();
        if($this->do_debug>=2){
            $this->edebug('SERVER->CLIENT:'.$announce);
        }
        return true;
    }
    
    //read smtp response
    protected function get_lines(){
        //if connection is fail
        if(!is_resource($this->smtp_conn)){
            return '';
        }
        $data = '';
        $endtime = 0;
        //connection run time = timeout
        stream_set_timeout($this->smtp_conn, $this->Timeout);
        if($this->Timelimit>0){
            //Timelimit for read
            $endtime = time() + $this->Timelimit;
            //$endtime = time() + 5;
        }
        while(is_resource($this->smtp_conn)&&!feof($this->smtp_conn)){
            
            $str = fgets($this->smtp_conn,515);
            if($this->do_debug>=4){
                $this->edebug("SMTP->getline():\$data was \"$data\"");
                $this->edebug("SMTP->getline():\$str is \"$str\"");
            }
            $data.=$str;
            if($this->do_debug>=4){
                $this->edebug("SMTP->getline():\$data is \"$data\"");
            }
            //if 4th character is a space, we are done reading,break the loop, micro-optimisation over strlen
            if(isset($str[3]) and ($str[3]==' ')){
                break;
            }
            $info = stream_get_meta_data($this->smtp_conn);
            if($info['timed_out']){
                if($this->do_debug>=4){
                    $this->edebug(
                            'SMTP->get_lines():timed-out('.$this->Timeout.'sec)'
                            );
                }
                break;
            }
            //check read take too long
            if($endtime and time()>$endtime){
                if($this->do_debug>=4){
                    $this->edebug('SMTP->get_lines():timelimit reached('.$this->Timelimit.'secs)');
                }
                break;
            }
            //break;
            //break;
        }
        return $data;
    }
    
    //authentication 
    /*smtp need authentication there are three different methods:
     *PLAIN, LOGIN, CRAM-MD5
     * code 235 authenticat success
     * code 334 wait for user input authentication
     */
    public function authenticate(
        $username,
        $password,
        $authtype = 'LOGIN',
        $realm ='',
        $workstation = '')
        {
        
        if(empty($authtype)){
            $authtype='LOGIN';
        }
        switch($authtype){
            case 'PLAIN':
                if(!$this->sendCommand('AUTH','AUTH PLAIN',334)){
                    return false;
                }
                if(!$this->sendCommand('User & Password', base64_encode("\0".$username."\0".$password), 235)){
                    return false;
                }
                break;
            case 'LOGIN':
                //start
                if(!$this->sendCommand('AUTH','AUTH LOGIN',334)){
                    return false;
                }
                if(!$this->sendCommand('Username',base64_encode($username), 334)){
                    return false;
                }
                if(!$this->sendCommand('Password',base64_encode($password), 235)){
                    return false;
                }
                break;
            case 'CRAM-MD5':
                if(!$this->sendCommand('AUTH CRAM-MD5', 'AUTH CRAM-MD5', 334)){
                    return false;
                }
                //build the challenge
                $challenge = base64_decode(substr($this->last_reply,4));
                //dosent work
        }
        return true;
    }
    /*
     * send a command to a smtp server and check its return code;
     * @param string $commend  The command name not sent to the server
     * @param string $commendstring the actually command to send
     * @param integer|array $expert   One or more experted integer success codes
     * @access protected
     * @return boolean True on success
     */
    protected function sendCommand($command,$commandstring,$expect){
        if(!$this->connected()){
            $this->error = array(
                'error' => "Called $command without being connected"
            );
            return false;
        }
        $this->client_send($commandstring.self::CRLF);
        $reply = $this->get_lines();
        //reply code like 200 400
        $code = substr($reply,0,3);
        if($this->do_debug>=2){
            $this->edebug('SERVER->CLIENT:'.$reply);
        }
        //find $code in $expect
        if(!in_array($code, (array)$expect)){
            $this->last_reply = null;
            $this->error = array('error'=>"$command command failed",'smtp_code'=>$code,'detail'=>substr($reply,4));
            if($this->do_debug>=1){
                $this->edebug('SMTP ERROR:'.$this->error['error'].':'.$reply);
            }
            return false;
        }
        $this->last_reply = $reply;
        $this->error = array();
        return true;
    }
    
    //send raw data to the server
    public function client_send($data){
        if($this->do_debug>=1){
            $this->edebug("CLIENT->SERVER:$data");
        }
        return fwrite($this->smtp_conn, $data);
    }
    
    
    public function connected(){
        //echo "haha";
        if(is_resource($this->smtp_conn)){
            $sock_status = stream_get_meta_data($this->smtp_conn);
            //if end of the file,return false
            if($sock_status['eof']){
                if($this->do_debug>=1){
                    $this->edebug('EOF caught while checking if connected');
                }
                $this->close();
                //return false means not connect
                return false;
            }
        //return true means connected
        return true;
        }
        return false;//no connection
    }
    
    public function close(){
        //clean error 
        $this->error = array();
        $this->helo_rply = null;
        if(is_resource($this->smtp_conn)){
            fclose($this->smtp_conn);
            if($this->do_debug>=3){
                $this->edebug("Connection:closed");
            }
        }
    }
    
    
    public function hello($host=''){
        //echo "hhhhhhhhhhhhhhhhhhhhhhhhhhhhh";
        return (boolean)($this->sendHello('EHLO',$host) or $this->sendHello('HELO', $host));
    }
    
    public function sendHello($hello,$host){
        $noerror = $this->sendCommand($hello, $hello.' '.$host, 250);
        $this->helo_rply = $this->last_reply;
        return $noerror;
    }
    
    /**
     * send a email commend 
     * send sender email address to smtp server
     * smtp will send ok as a response
     * implements rfc :
     * MAIL FROM:<reverse-path> [sp<mail-parameters>]<CRLF>
     * @param type $from
     * @return type
     */
    public function mail($from){
        $useVerp = ($this->do_verp?'XVERP':'');
        return $this->sendCommand('MAIL FROM', 'MAIL FROM:<'.$from.'>'.$useVerp, 250);
    }
    /**
     * after send sender's email address to smtp server and get response from it as well
     * client should send receiver address to smtp server
     * implement rfc:
     * RCPT <SP> TO:<forward-path><CRLF>
     * @param type $toaddr
     * @return type
     */
    public function recipient($toaddr){
        return $this->sendCommand('RCPT TO', 'RCPT TO:<'.$toaddr.'>', array(250,251));
    }
    //get the lastest error
    public function getError(){
        return $this->error;
    }
    
    public function setTimeout($timeout=0){
        $this->Timeout = $timeout;
    }
    
    public function setDebugLevel($level=0){
        $this->do_debug = $level;
    }
    public function setDebugOutput($method='echo'){
        $this->Debugoutput = $method;
    }
    public function setVerp($enabled=false){
        $this->do_verp = $enabled;
    }
}
