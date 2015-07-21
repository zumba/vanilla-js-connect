<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect as Vanilla;

class ExpiredTimestamp implements \Zumba\VanillaJsConnect\ValidatorInterface
{

    /**
   * Returns current time. Used for mocking
   *
   * @return time
   */
    protected function getTime()
    {
        return time();
    }

    public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null)
    {
        if (($this->getTime() - $request->getTimestamp()) > $config->getJsTimeout()) {
            return new Response\ExpiredTimestamp($request);
        }

    }
}
