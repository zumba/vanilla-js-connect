<?php

namespace Zumba\VanillaJsConnect\Validator;

use Firebase\JWT\JWT;
use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect as Vanilla;
use Zumba\VanillaJsConnect\Contracts\ValidatorInterface;
use Zumba\VanillaJsConnect\Contracts\VanillaUser;

class InvalidClientID implements ValidatorInterface
{
    public function validate(Vanilla\Request $request, VanillaUser $user = null, Vanilla\Config $config = null)
    {
        list($tokenHeader) = explode('.', $request->getToken());
        $tokenHeaderData = json_decode(JWT::urlsafeB64Decode($tokenHeader), true);

        if (
            empty($tokenHeaderData[Response::FIELD_CLIENT_ID]) ||
            $tokenHeaderData[Response::FIELD_CLIENT_ID] !== $config->getClientID()
        ) {
            $clientResponse =  new Response\InvalidClientID($request);
            $clientResponse->setClientID($tokenHeaderData[Response::FIELD_CLIENT_ID] ?? '');
            return $clientResponse;
        }
    }
}
