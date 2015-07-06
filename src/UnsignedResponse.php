<?php

namespace Zumba\VanillaJsConnect;

class UnsignedResponse extends Response {

	protected $name;

	protected $photoUrl;

	protected $signedIn;

	public function __construct(User $user){
		$this->name = $user->getName() || '';
		$this->photoUrl = $user->getPhotoUrl() || '';
		$this->signedIn = $this->isSignedIn();
	}

	private function isSignedIn() {
		return !(empty($this->name) || empty($this->photoUrl));
	}
}
