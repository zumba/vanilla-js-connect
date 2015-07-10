<?php

namespace Zumba\VanillaJsConnect;

class UnsignedResponse extends Response
{
    /**
     * Stores the usersname
     *
     * @var string
     */
    protected $name;

    /**
     * Stores url to photo for user
     *
     * @var string
     */
    protected $photoUrl;

    /**
     * Boolean whether the user is signed in
     *
     * @var boolean
     */
    protected $signedIn;

    /**
     * Sets variables. Default is ''
     *
     * @param Request $request
     * @param User    $user
     * @param Config  $config
     */
    public function __construct(Request $request, User $user, Config $config = null)
    {
        parent::__construct($request, $user);
        $this->name = $user->getName();
        $this->photoUrl = $user->getPhotoUrl();
        $this->signedIn = $this->isSignedIn();
    }

    /**
     * Sets signedin key in array if true
     *
     * @return boolean
     */
    private function isSignedIn()
    {
        return !(empty($this->name) ?: empty($this->photoUrl));
    }

    /**
     * Overwrites parent. Shouldn't show signedin when false, but still does
     *
     * @return array
     */
    public function toArray()
    {
        if ($this->signedIn) {
            return [
            'name' => $this->name,
            'photourl' => $this->photoUrl,
            'signedin' => $this->signedIn
            ];
        } else {
            return [
            'name' => $this->name,
            'photourl' => $this->photoUrl
            ];
        }

    }
}
