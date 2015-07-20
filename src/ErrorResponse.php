<?php

namespace Zumba\VanillaJsConnect;

class ErrorResponse extends Response
{
    protected $error;

    protected $message;

    public function setError($error)
    {
        $this->$error = $error;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}
