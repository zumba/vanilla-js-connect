<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response,
    Zumba\VanillaJsConnect as Vanilla;

class InvalidSignature implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null) {
    $signature = md5($request->getTimestamp().$config->getSecret());
    if($request->getSignature() != $signature) {
      return new Response\InvalidSignature($request);
    }
  }

}
