<?php

namespace Zumba\VanillaJsConnect\Response;

use Zumba\VanillaJsConnect\Contracts\ErrorResponseInterface;
use Zumba\VanillaJsConnect\Response;

class InvalidClientID extends Response implements ErrorResponseInterface
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
     * Response data being returned when and error occurred
     *
     * @return array
     */
    public function responseData() : array
    {
        return [
            'error' => $this->error,
            'message' => sprintf($this->message, $this->clientID),
        ];
    }
}
