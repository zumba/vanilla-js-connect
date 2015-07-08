<?php

namespace Zumba\VanillaJsConnect;

class InvalidClientResponse extends Response
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     *  @var string
     */
    private $error = 'invalid_client';

    /**
     * ClientID that gets passed in for over riding toArray
     *
     * @var [type]
     */
    private $clientID;

    /**
     * Error message with format code
     *
     * @var string
     */
    private $message = "Unknown client %s.";

    /**
     * Sets the client id for toArray
     *
     * @param  string $clientID
     * @return void
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    /**
     * Overrides parent toArray function to include client id
     *
     * @return array
     */
    protected function toArray()
    {
        $message = sprintf($this->message, $this->clientID);
        $error = $this->error;
        return compact('error', 'message');
    }
}
