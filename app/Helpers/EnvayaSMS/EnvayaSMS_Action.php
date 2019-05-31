<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Action
{
    public $type;    
    public $request;
    
    function __construct($request)
    {
        $this->request = $request;
    }
}



 ?>