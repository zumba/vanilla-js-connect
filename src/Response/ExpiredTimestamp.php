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

    /**
     * 'Error' responses do not return added properties
     *
     * @return string
     */
    protected function encodeResponse()
    {
        return json_encode($this->toArray());
    }
}
