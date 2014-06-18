<?php

/*
 *  
*/
class SMTP{
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
        $this->smtp_conn = @stream_context_create(
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
            
        }
        while(is_resource($this->smtp_conn)&&!feof($this->smtp_conn)){
            $str = @fgets($this->smtp_conn,515);
            if($this->do_debug>=4){
                $this->edebug("SMTP->getline():\$data was \"$data\"");
                $this->edebug("SMTP->getline():\$str is \"$str\"");
            }
            $data.=$str;
            if($this->do_debug>=4){
                $this->edebug("SMTP->getline():\$data is \"$data\"");
            }
            //if 4th character is a space, we are done reading,break the loop, micro-optimisation over strlen
            if(isset($str[3]) and $str[3]==''){
                break;
            }
            $info = stream_get_meta_data($this->smtp_conn);
            if($this->do_debug>=4){
                $this->edebug(
                        'SMTP->get_lines():timed-out('.$this->Timeout.'sec)'
                        );
            }
            break;
        }
        
    }
    
    
    public function connected(){
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
    
}
