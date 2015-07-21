<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class InvalidClientID implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validator($request, $config) {
    if ($request->getClientID() !== $config->getClientID()) {
        $clientID = $request->getClientID();
        $clientResponse =  new Response\InvalidClient($request);
        $clientResponse->setClientID($clientID);
        return $clientResponse;
    }
  }
}
