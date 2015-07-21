<?php

namespace Zumba\VanillaJsConnect\Response;

class ExpiredTimestamp extends \Zumba\VanillaJsConnect\Response
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
