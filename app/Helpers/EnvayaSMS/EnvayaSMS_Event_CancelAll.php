<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Event_CancelAll extends EnvayaSMS_Event
{
    function __construct()
    {
        $this->event = EnvayaSMS::EVENT_CANCEL_ALL;
    }
}


 ?>