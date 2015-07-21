<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect as Vanilla;

class Closure implements \Zumba\VanillaJsConnect\ValidatorInterface
{

    protected $validator;

    public function __construct(callable $validator)
    {
        $this->validator = $validator;
    }

    public function validate(Vanilla\Request $request, Vanilla\User $user = null, Vanilla\Config $config = null)
    {
        return call_user_func($this->validator, $request, $user, $config);
    }
}
