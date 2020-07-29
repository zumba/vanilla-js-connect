<?php

namespace Zumba\VanillaJsConnect\Response;

use Zumba\VanillaJsConnect\Config;
use Zumba\VanillaJsConnect\Contracts\ErrorResponseInterface;
use Zumba\VanillaJsConnect\Contracts\VanillaUser;
use Zumba\VanillaJsConnect\Request;
use Zumba\VanillaJsConnect\Response;

class UnsignedRequest extends Response implements ErrorResponseInterface
{
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
     * @param VanillaUser $user
     * @param Config $config
     */
    public function __construct(Request $request, VanillaUser $user, Config $config)
    {
        parent::__construct($request, $user, $config);
    }

    /**
     * Sets signedin key in array if true
     *
     * @return boolean
     */
    private function isSignedIn()
    {
        return !empty($this->user) && !empty($this->user->getUid());
    }

    /**
     * Response data being returned when unsigned
     *
     * @return array
     */
    public function responseData() : array
    {
        return $this->getUserInfo();
    }
}
