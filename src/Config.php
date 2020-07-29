<?php

namespace Zumba\VanillaJsConnect;

class Config
{
    const DEFAULT_JS_TIMEOUT = 1440;
    const ALG_HS256 = 'HS256';

    const ALLOWED_ALGORITHMS = [
        'ES256', 'HS256', 'HS384', 'HS512', 'RS256', 'RS384', 'RS512'
    ];

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
     * Algorithm to decode/encode data with Vanilla
     *
     * @var string
     */
    protected $signAlgorithm;

    /**
     * Timeout for session to be valid
     *
     * @var integer
     */
    protected $jsTimeout;

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

        $this->signAlgorithm = $options['signAlgorithm'] ?? static::ALG_HS256;

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

    /**
     * Returns the hash algorithm used to encode/decode the JWT
     *
     * @return string
     */
    public function getSignAlgorithm() : string
    {
        return $this->signAlgorithm;
    }
}
