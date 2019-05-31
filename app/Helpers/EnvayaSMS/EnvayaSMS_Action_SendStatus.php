<?php 

namespace App\Helpers\EnvayaSMS;

class EnvayaSMS_Action_SendStatus extends EnvayaSMS_Action
{    
    public $status;     // EnvayaSMS::STATUS_* values
    public $id;         // server ID previously used in EnvayaSMS_OutgoingMessage
    public $error;      // textual description of error (if applicable)
    
    function __construct($request)
    {
        parent::__construct($request);   
        $this->type = EnvayaSMS::ACTION_SEND_STATUS;        
        $this->status = $_POST['status'];
        $this->id = $_POST['id'];
        $this->error = $_POST['error'];
    } 
}



 ?>