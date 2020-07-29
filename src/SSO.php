<?php

namespace Zumba\VanillaJsConnect;

use Zumba\VanillaJsConnect\Contracts\ErrorResponseInterface;
use Zumba\VanillaJsConnect\Contracts\ValidatorInterface;
use Zumba\VanillaJsConnect\Contracts\VanillaUser;
use \Zumba\VanillaJsConnect\Validator as Validator;

class SSO
{
    /**
     * Request Object
     *
     * @var Request
     */
    protected $request;

    /**
     * Config Object
     *
     * @var Config
     */
    protected $config;

    /**
     * User Object
     *
     * @var VanillaUser
     */
    protected $user;

    /**
     * Array of validation functions for the request
     *
     * @var array
     */
    protected $validators = [];

    /**
     * Constructor
     *
     * @param Request $request
     * @param VanillaUser $user
     * @param Config $config
     */
    public function __construct(Request $request, VanillaUser $user, Config $config)
    {
        $this->request = $request;
        $this->config = $config;
        $this->user = $user;

        $this->addValidator(new Validator\InvalidClientID);
        $this->addValidator(new Validator\InvalidJwt);
    }

    /**
     * Adds custom external validation functions to run in addition to the Vanilla core
     *
     * @param callable
     * @throws \InvalidArgumentException
     */
    public function addValidator($validator)
    {
        if (is_callable($validator)) {
            $this->validators[] = new Validator\Closure($validator);
        } elseif (is_object($validator) && $validator instanceof ValidatorInterface) {
            $this->validators[] = $validator;
        } else {
            throw new \InvalidArgumentException("Not a function or ValidatorInterface object");
        }
    }

    /**
     * Validates Request object and returns a response object based on the error
     *
     * @return \Zumba\VanillaJsConnect\Response
     */
    public function getResponse()
    {
        foreach ($this->validators as $validator) {
            $result = $validator->validate($this->request, $this->user, $this->config);
            if (is_object($result) && $result instanceof ErrorResponseInterface) {
                return $result;
            }
        }

        return new Response($this->request, $this->user, $this->config);
    }
}
