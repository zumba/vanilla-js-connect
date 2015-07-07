<?php

namespace Zumba\VanillaJsConnect;

class User
{
		/**
		 * Holds the username
		 *
		 * @var string
		 */
    protected $name;

		/**
		 * Stores the url to users image
		 *
		 * @var string
		 */
    protected $photoUrl;

		/**
		 * Returns the name
		 *
		 * @return string
		 */
    public function getName()
    {
        return $this->name ?: '';
    }

		/**
		 * Returns the photourl
		 * @return string
		 */
    public function getPhotoUrl()
    {
        return $this->photoUrl ?: '';
    }

		/**
		 * Overrwites parent method
		 *
		 * @return array
		 */
    public function toArray()
    {
        return [
        'name' => $this->name,
        'photourl' => $this->photoUrl
        ];
    }


}
