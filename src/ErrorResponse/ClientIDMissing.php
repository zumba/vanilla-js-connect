<?php

namespace Zumba\VanillaJsConnect\ErrorResponse;

class ClientIDMissing extends \Zumba\VanillaJsConnect\ErrorResponse
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
