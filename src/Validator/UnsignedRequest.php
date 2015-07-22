<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect as Vanilla;

class UnsignedRequest implements \Zumba\VanillaJsConnect\ValidatorInterface
{

    public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null)
    {
        $requestTimestamp = $request->getTimestamp();
        $requestSignature = $request->getSignature();

        if (empty($requestTimestamp) && empty($requestSignature)) {
            return new Response\UnsignedRequest($request, $user);
        }
    }
}
