<?php

namespace Zumba\VanillaJsConnect\Response;

use Zumba\VanillaJsConnect\Contracts\ErrorResponseInterface;
use Zumba\VanillaJsConnect\Response;

class InvalidSignature extends Response implements ErrorResponseInterface
{
    /**
     * Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    protected $error = 'access_denied';

    /*
     * Error message returned for Access Denied
     *
     * @var string
     */
    protected $message = 'Signature invalid.';

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
