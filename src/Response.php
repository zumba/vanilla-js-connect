<?php

namespace Zumba\VanillaJsConnect;

class Response {
	protected $request;

	protected $config;

	protected $user;

	protected $properties = [];

	public function __construct(Request $request, User $user = null, Config $config = null) {
		$this->request = $request;
		$this->config = $config;
		$this->user = $user;
	}

	/**
	 * Translates Error or User object to an Array for JSON serialization
	 * Is overwritten by some child response classes that have custom array formats
	 *
	 * @return array
	 */
	protected function toArray() {
		if(isset($this->error)) {
			return ['error' => $this->error, 'message' => $this->message];
		} else {
			return $this->signJsConnect();
		}
	}

  /**
   * Adds client id and signature to the User object array
   *
   * @return array
   */
	protected function signJsConnect() {
		$userArray = $this->user->toArray();
		$queryString = http_build_query($userArray, NULL, '&');
		$signature = md5($queryString.$this->config->getSecret());
		$userArray['client_id'] = $this->config->getClientID();
		$userArray['signature'] = $signature;
		return $userArray;

	}

	public function addProperties(array $props) {
		$this->properties = array_merge($this->properties, $props);
	}
	/**
	 * Allows response to be type cast into a string when handling
	 *
	 * @return string
	 */
	public function __toString() {
		$resultArray = array_merge($this->toArray(), $this->properties);
		$resultJSON = json_encode($resultArray);
		$callback = $this->request->getCallback();
		if(isset($callback)) {
			return "$callback($resultJSON)";
		} else {
			return $resultJSON;
		}
	}


}
