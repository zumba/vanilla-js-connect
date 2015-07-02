<?php

namespace Zumba\VanillaJsConnect;

class Config {

	const DEFAULT_JS_TIMEOUT = 1440;

	protected $clientID;

	protected $secret;

	protected $jsTimeout;

	public function __construct(array $options) {
		if(empty($options)) {
			throw new \LogicException('Config expects array of configuration options.');
		}

		if(!isset($options['clientID']) || !isset($options['secret'])) {
			throw new \DomainException('Config expects clientID and secret keys.');
		}

		if(isset($options['jsTimeout'])) {
			$this->jsTimeout = $options['jsTimeout'];
		}

		$this->clientID = $options['clientID'];
		$this->secret = $options['secret'];
	}

	public function getClientID() {
		return $this->clientID;
	}

	public function getSecret() {
		return $this->secret;
	}

	public function getJsTimeout() {
		return $this->jsTimeout || static::DEFAULT_JS_TIMEOUT;
	}

};
