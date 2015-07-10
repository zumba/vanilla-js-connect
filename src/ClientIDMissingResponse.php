<?php

namespace Zumba\VanillaJsConnect;

class ClientIDMissingResponse extends Response
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    protected $error = 'invalid_client';

    /**
     * Error message
     *
     * @var string
     */
    protected $message = 'The client_id parameter is missing.';
}
