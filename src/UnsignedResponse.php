<?php

namespace Zumba\VanillaJsConnect;

class UnsignedResponse extends Response {

	protected $name;

	protected $photoUrl;

	protected $signedIn;

	public function __construct(Request $request, User $user, Config $config=null) {
		parent::__construct($request, $user);
		$this->name = $user->getName() ?: '';
		$this->photoUrl = $user->getPhotoUrl() ?: '';
		$this->signedIn = $this->isSignedIn();
	}

	/**
	 * Sets signedin key in array if true
	 *
	 * @return boolean
	 */
	private function isSignedIn() {
		return !(empty($this->name) ?: empty($this->photoUrl));
	}

	public function toArray() {
		return [
			'name' => $this->name,
			'photourl' => $this->photoUrl,
			'signedin' => $this->signedIn
		];
	}
}
