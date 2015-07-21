<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response,
    Zumba\VanillaJsConnect as Vanilla;

class MissingClientID implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null) {
    if (empty($request->getClientID())) {
        return new Response\MissingClientID($request);
    }
  }

}
