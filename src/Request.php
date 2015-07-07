<?php

namespace Zumba\VanillaJsConnect;

class Request
{
		/**
		 * Holds the client ID
		 *
		 * @var string
		 */
    protected $clientID;

    public function __construct(array $args)
    {
        if(isset($args['client_id'])) {
            $this->clientID = $args['client_id'];
        }

        if(isset($args['timestamp'])) {
            $this->timestamp = $args['timestamp'];
        }

        if(isset($args['signature'])) {
            $this->signature = $args['signature'];
        }

        if(isset($args['callback'])) {
            $this->callback = $args['callback'];
        }
    }

		/**
		 * Gets client ID
		 *
		 * @return string
		 */
    public function getClientID()
    {
        return $this->clientID;
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
        return $this->callback;
    }
}
