<?php

namespace Zumba\VanillaJsConnect\Response;

class MissingSignature extends \Zumba\VanillaJsConnect\Response
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
