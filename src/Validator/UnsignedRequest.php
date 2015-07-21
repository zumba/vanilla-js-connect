<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response,
    Zumba\VanillaJsConnect as Vanilla;

class UnsignedRequest implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null) {
    $requestTimestamp = $request->getTimestamp();
    $requestSignature = $request->getSignature();

    if(!isset($requestTimestamp) && !isset($requestSignature)) {
      return new Response\UnsignedRequest($request, $user);
    }
  }
}
