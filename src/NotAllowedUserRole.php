<?php

namespace Zumba\VanillaJsConnect;

class NotAllowedUserRole extends Response
{
    /**
     * Holds the error type. Corresponds with the array key in toArray
     *
     * @var string
     */
    protected $error = 'access_denied';

    /**
     * Error message returned for Access Denied
     *
     * @var string
     */
    protected $message = 'You do not have permission to access this forum.';
}
