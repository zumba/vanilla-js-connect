<?php

namespace Zumba\VanillaJsConnect;

class ClientIDMissingResponse extends Response
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    private $error = 'invalid_client';

    /**
     * Error message
     *
     * @var string
     */
    private $message = 'The client_id parameter is missing.';
}
