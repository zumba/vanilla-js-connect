<?php

namespace Zumba\VanillaJsConnect;

class Config
{
    const DEFAULT_JS_TIMEOUT = 1440;

    /**
     * Client ID
     *
     * @var string
     */
    protected $clientID;

    /**
     * Secret used for hashing signatures
     *
     * @var string
     */
    protected $secret;

    /**
     * Timeout for session to be valid
     *
     * @var integer
     */
    protected $jsTimeout;

    /**
     * Array of user roles allowed to access the forum
     *
     * @var array
     */
    protected $allowedRoles;

    /**
     * Takes in an array with clientID, secret, and optional jsTimeout
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (empty($options)) {
            throw new \LogicException('Config expects array of configuration options.');
        }

        if (!isset($options['clientID']) || !isset($options['secret'])) {
            throw new \DomainException('Config expects clientID and secret keys.');
        }

        if (isset($options['jsTimeout'])) {
            $this->jsTimeout = $options['jsTimeout'];
        }

        if (isset($options['allowedRoles'])) {
            $this->allowedRoles = $options['allowedRoles'];
        }

        $this->clientID = $options['clientID'];
        $this->secret = $options['secret'];
    }

    /**
     * Returns Client ID
     *
     * @return string
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * Returns Secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Returns timeout for requests. Defaults to 1440
     *
     * @return integer
     */
    public function getJsTimeout()
    {
        return $this->jsTimeout ?: static::DEFAULT_JS_TIMEOUT;
    }

    public function getAllowedRoles()
    {
        return $this->allowedRoles ?: [];
    }
}
