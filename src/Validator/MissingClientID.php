<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class MissingClientID extends \Zumba\VanillaJsConnect\ValidatorInterface {

  public function validator ($request) {
    if (empty($request->getClientID())) {
        return new Response\MissingClientID($request);
    }
  }

}
