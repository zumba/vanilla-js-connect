<?php

namespace Zumba\VanillaJsConnect;

class Request
{
    /**
    * Identifying cliet id from Vanilla js
    *
    * @var integer
    */
    protected $client_id;

    /**
    * Timestamp of the request
    *
    * @var string
    */
    protected $timestamp;

    /**
    * Security signature
    *
    * @var string
    */
    protected $signature;

    /**
    * Callback for JSONP
    *
    * @var string
    */
    protected $callback;


    /**
     * Saves items from args array to object
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        foreach (['client_id', 'timestamp', 'signature', 'callback'] as $attr) {
            if (isset($args[$attr])) {
                $this->$attr = $args[$attr];
            }
        }
    }

    /**
     * Gets client ID
     *
     * @return string
     */
    public function getClientID()
    {
        return $this->client_id;
    }

    /**
     * Returns timestamp on Request
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns Request signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Returns request callback name
     *
     * @return string
     */
    public function getCallback()
    {
        return $this->callback ?: '';
    }
}
