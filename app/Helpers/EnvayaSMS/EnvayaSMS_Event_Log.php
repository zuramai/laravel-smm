<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Event_Log extends EnvayaSMS_Event
{
    public $message;
    
    function __construct($message)
    {
        $this->event = EnvayaSMS::EVENT_LOG;
        $this->message = $message;
    }
}


 ?>