<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_ActionRequest extends EnvayaSMS_Request
{   
    private $request_action;
    
    public $settings_version; // integer version of current settings (as provided by server)
    public $phone_number;   // phone number of Android phone 
    public $log;            // app log messages since last successful request
    public $now;            // current time (ms since Unix epoch) according to Android clock
    public $network;        // name of network, like WIFI or MOBILE (may vary depending on phone)
    public $battery;        // battery level as percentage   
    public $power;          // power source integer, see EnvayaSMS::POWER_SOURCE_*
   
    function __construct()
    {
        parent::__construct();
        
        $this->phone_number = $_POST['phone_number'];
        $this->log = $_POST['log'];
        $this->network = @$_POST['network'];
        $this->now = @$_POST['now'];
        $this->settings_version = @$_POST['settings_version'];
        $this->battery = @$_POST['battery'];
        $this->power = @$_POST['power'];
    }
               
    function get_action()
    {
        if (!$this->request_action)
        {
            $this->request_action = $this->_get_action();
        }
        return $this->request_action;
    }
    
    private function _get_action()
    {
        switch (@$_POST['action'])
        {
            case EnvayaSMS::ACTION_INCOMING:
                return new EnvayaSMS_Action_Incoming($this);
            case EnvayaSMS::ACTION_FORWARD_SENT:
                return new EnvayaSMS_Action_ForwardSent($this);                
            case EnvayaSMS::ACTION_OUTGOING:            
                return new EnvayaSMS_Action_Outgoing($this);                
            case EnvayaSMS::ACTION_SEND_STATUS:
                return new EnvayaSMS_Action_SendStatus($this);
            case EnvayaSMS::ACTION_TEST:
                return new EnvayaSMS_Action_Test($this);
            case EnvayaSMS::ACTION_DEVICE_STATUS:
                return new EnvayaSMS_Action_DeviceStatus($this);                
            case EnvayaSMS::ACTION_AMQP_STARTED:
                return new EnvayaSMS_Action_AmqpStarted($this);
            default:
                return new EnvayaSMS_Action($this);
        }
    }            
    
    function is_validated($correct_password)
    {
        $signature = @$_SERVER['HTTP_X_REQUEST_SIGNATURE'];        
        if (!$signature)
        {
            return false;
        }
        
        $is_secure = (!empty($_SERVER['HTTPS']) AND filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN));
        $protocol = $is_secure ? 'https' : 'http';
        $full_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];    
        
        $correct_signature = $this->compute_signature($full_url, $_POST, $correct_password);           
        
        //error_log("Correct signature: '$correct_signature'");
        
        return $signature === $correct_signature;
    }
    function compute_signature($url, $data, $password)
    {
        ksort($data);
        
        $input = $url;
        foreach($data as $key => $value)
            $input .= ",$key=$value";
        $input .= ",$password";
        
        return base64_encode(sha1($input, true));            
    }
}



 ?>