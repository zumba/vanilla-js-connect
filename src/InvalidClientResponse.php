<?php

namespace Zumba\VanillaJsConnect;

class InvalidClientResponse extends Response {

	private $error = 'invalid_client';
	private $clientID;
	private $message = "Unknown client %s.";

	public function setClientID($clientID) {
		$this->clientID = $clientID;
	}
}
