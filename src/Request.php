<?php

namespace Zumba\VanillaJsConnect;

class Request
{
    /**
     * JWT sent by Vanilla
     *
     * @var string
     */
    protected $jwt;

    /**
     * Saves items from args array to object
     *
     * @param string $jwt
     */
    public function __construct(string $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Returns the token provided by Vanilla request
     *
     * @return string
     */
    public function getToken() : string
    {
        return $this->jwt;
    }

}
