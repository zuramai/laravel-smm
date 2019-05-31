<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Event_Cancel extends EnvayaSMS_Event
{
    public $id;
    
    function __construct($id /* id of previously created EnvayaSMS_OutgoingMessage object (string) */)
    {
        $this->event = EnvayaSMS::EVENT_CANCEL;
        $this->id = $id;
    }
}


 ?>