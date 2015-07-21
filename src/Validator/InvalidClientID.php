<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response,
    Zumba\VanillaJsConnect as Vanilla;

class InvalidClientID implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null) {
    if ($request->getClientID() !== $config->getClientID()) {
        $clientID = $request->getClientID();
        $clientResponse =  new Response\InvalidClientID($request);
        $clientResponse->setClientID($clientID);
        return $clientResponse;
    }
  }
}
