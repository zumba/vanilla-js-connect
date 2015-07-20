<?php

namespace Zumba\VanillaJsConnect\ErrorResponse;

class AccessDenied extends \Zumba\VanillaJsConnect\ErrorResponse
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
}
