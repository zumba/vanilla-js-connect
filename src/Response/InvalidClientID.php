<?php

namespace Zumba\VanillaJsConnect\Response;

class InvalidClientID extends \Zumba\VanillaJsConnect\Response
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
     * 'Error' responses do not return added properties
     *
     * @return string
     */
    protected function encodeResponse()
    {
        return json_encode($this->toArray());
    }

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