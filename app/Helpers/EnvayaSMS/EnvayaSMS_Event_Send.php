<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Event_Send extends EnvayaSMS_Event
{    
    public $messages;
    
    function __construct($messages /* array of EnvayaSMS_OutgoingMessage objects */)
    {
        $this->event = EnvayaSMS::EVENT_SEND;
        $this->messages = $messages;
    }
}


 ?>