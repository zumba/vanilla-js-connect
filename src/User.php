<?php

namespace Zumba\VanillaJsConnect;

class User {

	protected $name;

	protected $photoUrl;

	public function getName() {
		return $this->name ?: '';
	}

	public function getPhotoUrl(){
		return $this->photoUrl ?: '';
	}

	public function toArray() {
		return [
			'name' => $this->name,
			'photourl' => $this->photoUrl
		];
	}


}
