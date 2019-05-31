<?php 

namespace App\Helpers\EnvayaSMS;



class EnvayaSMS_Request
{
    public $version;
    
    public $version_name;
    public $sdk_int;
    public $manufacturer;
    public $model;        
    
    function __construct()
    {
        $this->version = (int)@$_POST['version'];
        
        if (preg_match('#/(?P<version_name>[\w\.\-]+) \(Android; SDK (?P<sdk_int>\d+); (?P<manufacturer>[^;]*); (?P<model>[^\)]*)\)#', 
            @$_SERVER['HTTP_USER_AGENT'], $matches))
        {
            $this->version_name = $matches['version_name'];            
            $this->sdk_int = $matches['sdk_int'];
            $this->manufacturer = $matches['manufacturer'];
            $this->model = $matches['model'];
        }        
    }
    function supports_json()
    {
        return $this->version >= 28;
    }
    
    function supports_update_settings()
    {
        return $this->version >= 29;
    }
    
    function get_response_type()
    {
        if ($this->supports_json())
        {
            return 'application/json';
        }
        else
        {
            return 'text/xml';
        }
    }
    
    function render_response($events = null /* optional array of EnvayaSMS_Event objects */) 
    {
        if ($this->supports_json())
        {
            return json_encode(array('events' => $events));
        }
        else
        {        
            ob_start();
            echo "<?xml version='1.0' encoding='UTF-8'?>\n";
            echo "<response>";
            
            if ($events)
            {
                foreach ($events as $event)
                {            
                    echo "<messages>";            
                    if ($event instanceof EnvayaSMS_Event_Send)
                    {
                        if ($event->messages)
                        {
                            foreach ($event->messages as $message)
                            {       
                                $type = isset($message->type) ? $message->type : EnvayaSMS::MESSAGE_TYPE_SMS;
                                $id = isset($message->id) ? " id=\"".EnvayaSMS::escape($message->id)."\"" : "";
                                $to = isset($message->to) ? " to=\"".EnvayaSMS::escape($message->to)."\"" : "";        
                                $priority = isset($message->priority) ? " priority=\"".$message->priority."\"" : "";        
                                echo "<$type$id$to$priority>".EnvayaSMS::escape($message->message)."</$type>";
                            }
                        }
                    }
                    echo "</messages>";        
                }
            }
            echo "</response>";
            return ob_get_clean();            
        }
    }
    
    function render_error_response($message)    
    {
        if ($this->supports_json())
        {
            return json_encode(array('error' => array('message' => $message)));
        }
        else
        {
            ob_start();
            echo "<?xml version='1.0' encoding='UTF-8'?>\n";
            echo "<response>";
            echo "<error>";
            echo EnvayaSMS::escape($message);
            echo "</error>";
            echo "</response>";
            return ob_get_clean();
        }
    }
}
 ?>