<?php

namespace Zumba\VanillaJsConnect\ErrorResponse;

class InvalidTimeStamp extends \Zumba\VanillaJsConnect\ErrorResponse
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    protected $error = 'invalid_request';

    /**
     * Error message
     *
     * @var string
     */
    protected $message = 'The timestamp is invalid.';
}
