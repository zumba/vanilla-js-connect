<?php

namespace Zumba\VanillaJsConnect;

use Zumba\VanillaJsConnect\Contracts\VanillaUser;

class User implements VanillaUser
{
    /**
     * Returns the name
     *
     * @return string
     */
    protected $name = '';

    /**
     * Stores the url to users image
     *
     * @var string
     */
    protected $photoUrl = '';

    /**
    * Unique identifier
    *
    * @var string
    */
    protected $uniqueId = '';

    /**
     * User email
     *
     * @var string
     */
    protected $email = '';

    /**
     * Constructor
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        foreach (['name', 'photoUrl', 'uniqueId', 'email'] as $attr) {
            if (isset($args[$attr])) {
                $this->$attr = $args[$attr];
            }
        }
    }

    /**
     * Get user unique identifier
     *
     * @return string
     */
    public function getUid() : string
    {
        return $this->uniqueId;
    }

    /**
     * Returns the user's name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * Returns user's photoUrl
     *
     * @return string
     */
    public function getPhotoUrl() : string
    {
        return $this->photoUrl;
    }

    /**
     * Overrwites parent method. Get's the user information needed.
     * Conside using \Zumba\VanillaJsConnect\Contracts\VanillaUser instead.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'photourl' => $this->photoUrl,
            'uniqueid' => $this->uniqueId
        ];
    }
}
