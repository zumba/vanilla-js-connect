<?php

namespace Zumba\VanillaJsConnect\Response;

class InvalidTimestamp extends \Zumba\VanillaJsConnect\Response
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    protected $error = 'invalid_request';
    /**
     * Error Message
     *
     * @var string
     */
    protected $message = 'The timestamp parameter is missing or invalid.';
}
