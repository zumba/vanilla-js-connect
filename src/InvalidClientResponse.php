<?php

namespace Zumba\VanillaJsConnect;

class InvalidClientResponse extends Response
{

    private $error = 'invalid_client';
    private $clientID;
    private $message = "Unknown client %s.";

    public function setClientID($clientID) 
    {
        $this->clientID = $clientID;
    }
    
    protected function toArray() 
    {
        $message = sprintf($this->message, $this->clientID);
        $error = $this->error;
        return compact('error', 'message');
    }

}
