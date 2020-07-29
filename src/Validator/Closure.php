<?php

namespace Zumba\VanillaJsConnect\Validator;

use Zumba\VanillaJsConnect\Contracts\VanillaUser;
use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect as Vanilla;

class Closure implements Vanilla\Contracts\ValidatorInterface
{

    /**
     * Function to execute for validator
     *
     * @var callable
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param callable $validator
     */
    public function __construct(callable $validator)
    {
        $this->validator = $validator;
    }

    public function validate(Vanilla\Request $request, VanillaUser $user = null, Vanilla\Config $config = null)
    {
        $validator = $this->validator;
        return $validator($request, $user, $config);
    }
}
