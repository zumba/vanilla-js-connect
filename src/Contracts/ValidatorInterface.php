<?php

namespace Zumba\VanillaJsConnect\Contracts;

use Zumba\VanillaJsConnect\Config;
use Zumba\VanillaJsConnect\Request;
use Zumba\VanillaJsConnect\Contracts\VanillaUser;

interface ValidatorInterface
{
    /**
     * Interface for validators. Returns a Response object or nothing
     *
     * @param Request $request
     * @param VanillaUser $user
     * @param Config $config
     * @return Response
     */
    public function validate(Request $request, ?VanillaUser $user = null, ?Config $config = null);
}
