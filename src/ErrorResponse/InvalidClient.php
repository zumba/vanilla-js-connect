<?php

namespace Zumba\VanillaJsConnect\ErrorResponse;

class InvalidClient extends ErrorResponse
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     *  @var string
     */
    protected $error = 'invalid_client';

    /**
     * ClientID that gets passed in for overriding toArray
     *
     * @var string
     */
    protected $clientID;

    /**
     * Error message with format code
     *
     * @var string
     */
    protected $message = "Unknown client %s.";

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
