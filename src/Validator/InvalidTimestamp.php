<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class InvalidTimestamp implements \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validator($request) {
    if (!is_numeric($request->getTimestamp())) {
        return new Response\InvalidTimestamp($request);
    }
  }
}
