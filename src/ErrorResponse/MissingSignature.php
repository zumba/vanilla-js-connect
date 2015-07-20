<?php

namespace Zumba\VanillaJsConnect\ErrorResponse;

class MissingSignatureResponse extends ErrorResponse
{
    /**
     *  Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    protected $error = 'invalid_request';

    /**
     * Error message. Intentional double space to follow original library
     *
     * @var string
     */
    protected $message = 'Missing  signature parameter.';
}