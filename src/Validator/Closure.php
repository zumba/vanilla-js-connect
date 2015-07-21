<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class Closure implements \Zumba\VanillaJsConnect\ValidatorInterface {

  protected $validator;

  public function __construct(callable $validator) {
    $this->validator = $validator;
  }

  public function validator($request, $config, $user) {
    return $this->validator($request, $config, $user);
  }
}
