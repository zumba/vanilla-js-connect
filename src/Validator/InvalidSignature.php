<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class InvalidSignature implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validator($request, $config) {
    $signature = md5($request->getTimestamp().$config->getSecret());
    if($request->getSignature() === $signature) {
      return new Response\InvalidSignature($request);
    }
  }

}
