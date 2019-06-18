<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Action_Outgoing extends EnvayaSMS_Action
{    
    function __construct($request)
    {
        parent::__construct($request);
        $this->type = EnvayaSMS::ACTION_OUTGOING;        
    }
}




 ?>