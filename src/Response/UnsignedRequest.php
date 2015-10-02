<?php

namespace Zumba\VanillaJsConnect\Response;

use Zumba\VanillaJsConnect\Request;
use Zumba\VanillaJsConnect\User;
use Zumba\VanillaJsConnect\Config;

class UnsignedRequest extends \Zumba\VanillaJsConnect\Response
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

    /**
     * 'Error' responses do not return added properties
     *
     * @return string
     */
    protected function encodeResponse()
    {
        return json_encode($this->toArray());
    }
}