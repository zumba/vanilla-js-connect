<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class MissingSignature implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validator($request) {
    if(empty($request->getSignature())) {
      return new Response\MissingSignature($request);
    }
  }

}
