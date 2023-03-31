<?php

namespace Zumba\VanillaJsConnect\Validator;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Zumba\VanillaJsConnect as Vanilla;
use Zumba\VanillaJsConnect\Contracts\ValidatorInterface;
use Zumba\VanillaJsConnect\Contracts\VanillaUser;
use Zumba\VanillaJsConnect\Response as Response;

class InvalidJwt implements ValidatorInterface
{
    public function validate(Vanilla\Request $request, VanillaUser $user = null, Vanilla\Config $config = null)
    {
        try {
            JWT::decode(
                $request->getToken(),
                new Key($config->getSecret(), Vanilla\Config::ALG_HS256)
            );
        } catch (\Firebase\JWT\ExpiredException $ex) {
            return new Response\ExpiredTimestamp($request, $user, $config);
        } catch (\Firebase\JWT\SignatureInvalidException $ex) {
            return new Response\InvalidSignature($request);
        }
    }
}
