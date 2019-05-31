<?php 
namespace App\Helpers\EnvayaSMS;

abstract class EnvayaSMS_Action_Forward extends EnvayaSMS_Action
{    
    public $message;        // The message body of the SMS, or the content of the text/plain part of the MMS.
    public $message_type;   // EnvayaSMS::MESSAGE_TYPE_MMS or EnvayaSMS::MESSAGE_TYPE_SMS
    public $mms_parts;      // array of EnvayaSMS_MMS_Part instances
    public $timestamp;      // timestamp of incoming message (added in version 12)
    function __construct($request)
    {
        parent::__construct($request);
        $this->message = @$_POST['message'];
        $this->message_type = $_POST['message_type'];
        $this->timestamp = @$_POST['timestamp'];
        
        if ($this->message_type == EnvayaSMS::MESSAGE_TYPE_MMS)
        {
            $this->mms_parts = array();
            foreach (json_decode($_POST['mms_parts'], true) as $mms_part)
            {
                $this->mms_parts[] = new EnvayaSMS_MMS_Part($mms_part);
            }
        }               
    }
}


 ?>