<?php

namespace Zumba\VanillaJsConnect\Response;

use Zumba\VanillaJsConnect\Contracts\ErrorResponseInterface;
use Zumba\VanillaJsConnect\Response;

class ExpiredTimestamp extends Response implements ErrorResponseInterface
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
    protected $message = 'The timestamp has expired.';

    /**
     * Response data being returned when and error occurred
     *
     * @return array
     */
    public function responseData() : array
    {
        return [
            'error' => $this->error,
            'message' => $this->message,
        ];
    }
}
