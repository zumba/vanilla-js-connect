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

    /**
    * Unique identifier
    *
    * @var string
    */
    protected $uniqueId;

    /**
     * User email
     *
     * @var string
     */
    protected $email;

    public function __construct(array $args)
    {
        if (isset($args['name'])) {
            $this->name = $args['name'];
        }

        if (isset($args['photoUrl'])) {
            $this->photoUrl = $args['photoUrl'];
        }

        if (isset($args['uniqueId'])) {
            $this->uniqueId = $args['uniqueId'];
        }
        if (isset($args['email'])) {
            $this->email = $args['email'];
        }
    }
    public function getName()
    {
        return $this->name ?: '';
    }

    /**
     * Returns the photourl
     *
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl ?: '';
    }

    /**
    * Returns username if present
    *
    * @return string
    */
    public function getUniqueId()
    {
        return $this->uniqueId ?: '';
    }

    /**
    * Returns email if set
    *
    * @return string
    */
    public function getEmail()
    {
        return $this->email ?: '';
    }
    /**
     * Overrwites parent method
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
