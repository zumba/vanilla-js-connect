<?php

namespace Zumba\VanillaJsConnect;

class User
{
    /**
     * Holds the username
     *
     * @var string
     */
    protected $name = '';

    /**
     * Stores the url to users image
     *
     * @var string
     */
    protected $photoUrl = '';

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
    protected $uniqueId = '';

    /**
     * User email
     *
     * @var string
     */
    protected $email = '';

    public function __construct(array $args)
    {
        foreach (['name', 'photoUrl', 'uniqueId', 'email'] as $attr) {
            if (isset($args[$attr])) {
                $this->$attr = $args[$attr];
            }
        }
    }

    /**
     * Returns the user's name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns user's photoUrl
     *
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
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
