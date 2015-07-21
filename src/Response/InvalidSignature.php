<?php

namespace Zumba\VanillaJsConnect\Response;

class InvalidSignature extends \Zumba\VanillaJsConnect\Response
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
