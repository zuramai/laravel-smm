<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS
{
    const ACTION_INCOMING = 'incoming';
    const ACTION_FORWARD_SENT = 'forward_sent';
    const ACTION_SEND_STATUS = 'send_status';
    const ACTION_DEVICE_STATUS = 'device_status';
    const ACTION_TEST = 'test';
    const ACTION_OUTGOING = 'outgoing';
    const ACTION_AMQP_STARTED = 'amqp_started';
        // ACTION_OUTGOING should probably be const ACTION_POLL = 'poll', 
        // but 'outgoing' maintains backwards compatibility between new phone versions with old servers    
    const STATUS_QUEUED = 'queued';
    const STATUS_FAILED = 'failed';
    const STATUS_SENT = 'sent';
    const STATUS_CANCELLED = 'cancelled';
    
    const EVENT_SEND = 'send';
    const EVENT_CANCEL = 'cancel';
    const EVENT_CANCEL_ALL = 'cancel_all';
    const EVENT_LOG = 'log';
    const EVENT_SETTINGS = 'settings';
    
    const DEVICE_STATUS_POWER_CONNECTED = "power_connected";
    const DEVICE_STATUS_POWER_DISCONNECTED = "power_disconnected";
    const DEVICE_STATUS_BATTERY_LOW = "battery_low";
    const DEVICE_STATUS_BATTERY_OKAY = "battery_okay";
    const DEVICE_STATUS_SEND_LIMIT_EXCEEDED = "send_limit_exceeded";
    
    const MESSAGE_TYPE_SMS = 'sms';
    const MESSAGE_TYPE_MMS = 'mms';    
    const MESSAGE_TYPE_CALL = 'call';
    
    // power source constants same as from Android's BatteryManager.EXTRA_PLUGGED
    const POWER_SOURCE_BATTERY = 0;
    const POWER_SOURCE_AC = 1;
    const POWER_SOURCE_USB = 2;
    
    static function escape($val)
    {
        return htmlspecialchars($val, ENT_COMPAT, 'UTF-8');
    }    
    
    private static $request;
    
    static function get_request()
    {
        if (!isset(self::$request))
        {
            $version = @$_POST['version'];     
            if (isset($_POST['action']))
            {
                self::$request = new EnvayaSMS_ActionRequest();
            }
            else
            {
                self::$request = new EnvayaSMS_Request();
            }
            
        }
        return self::$request;
    }                 
}

 ?>