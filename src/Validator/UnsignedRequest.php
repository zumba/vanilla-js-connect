<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class UnsignedRequest implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validator($request) {
    $requestTimestamp = $request->getTimestamp();
    $requestSignature = $request->getSignature();

    if(!isset($requestTimestamp) && !isset($requestSignature)) {
      return new Response\UnsignedRequest($request);
    }
  }
}
