<?php

namespace Zumba\VanillaJsConnect;

class SSO {

	protected $request;

	protected $config;

	protected $user;

	public function __construct(Request $request, Config $config, User $user) {
		$this->request = $request;
		$this->config = $config;
		$this->user = $user;
	}

	protected function isInvalidClientID() {
		return $this->request->getClientID() !== $this->config->getClientID();
	}

	protected function isSetTimestampSignature() {
		$responseTimestamp = $this->request->getTimestamp();
		$responseSignature = $this->request->getSignature();

		return !isset($responseTimestamp) && !isset($responseSignature);
	}

	protected function isSignatureValid() {
		$timestamp = $this->request->getTimestamp();
		$secret = $this->config->getSecret();
		$signature = md5($timestamp.$secret);
		return $this->request->getSignature() === $signature;
	}

	public function getResponse() {
		if(empty($this->request->getClientID())) {
			return new ClientIDMissingResponse();
		}
		if($this->isInvalidClientID()) {
			$clientID = $this->request->getClientID();
			return new InvalidClientResponse();
		}
		if($this->isSetTimestampSignature()){
			return new UnsignedResponse($this->user);
		}
		if(!is_numeric($this->request->getTimestamp())) {
			return new InvalidOrMissingTimeStampResponse();
		}
		if(empty($this->request->getSignature())) {
			return new MissingSignatureResponse();
		}
		if((time() - $this->request->getTimestamp()) > $this->config->getJsTimeout()) {
			return new InvalidTimestampResponse();
		}
		if(!$this->isSignatureValid()) {
			return new AccessDeniedResponse();
		}


		return new Response();
	}
}
