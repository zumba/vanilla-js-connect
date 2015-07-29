<?php

namespace Zumba\VanillaJsConnect\Response;

class MissingClientID extends \Zumba\VanillaJsConnect\Response
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
