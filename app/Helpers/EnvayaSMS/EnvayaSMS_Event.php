<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Event
{
    public $event;
    
    /*
     * Formats this event as the body of an AMQP message.
     */
    function render()
    {
        return json_encode($this);    
    }
}



 ?>