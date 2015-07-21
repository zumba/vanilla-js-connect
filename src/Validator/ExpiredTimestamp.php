<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;

class ExpiredTimestamp implements \Zumba\VanillaJsConnect\ValidatorInterface {

  /**
   * Returns current time. Used for mocking
   *
   * @return time
   */
  protected function getTime()
  {
      return time();
  }

  public function validator($request, $config) {
    if (($this->getTime() - $request->getTimestamp()) > $config->getJsTimeout()) {
        return new Response\ExpiredTimestamp($request);
    }

  }

}
