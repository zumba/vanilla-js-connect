<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response,
    Zumba\VanillaJsConnect as Vanilla;

class InvalidTimestamp implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null) {
    if (!is_numeric($request->getTimestamp())) {
        return new Response\InvalidTimestamp($request);
    }
  }
}
