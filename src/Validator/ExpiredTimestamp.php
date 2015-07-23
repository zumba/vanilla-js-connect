<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect as Vanilla;

class ExpiredTimestamp implements \Zumba\VanillaJsConnect\ValidatorInterface
{

    public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null)
    {
        if ((time() - $request->getTimestamp()) > $config->getJsTimeout()) {
            return new Response\ExpiredTimestamp($request);
        }

    }
}
