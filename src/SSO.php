<?php

namespace Zumba\VanillaJsConnect;

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
     * @var User
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
     * @param User    $user
     * @param Config  $config
     */
    public function __construct(Request $request, User $user, Config $config)
    {
        $this->request = $request;
        $this->config = $config;
        $this->user = $user;

        $this->addValidator(new Validator\MissingClientID);
        $this->addValidator(new Validator\InvalidClientID);
        $this->addValidator(new Validator\UnsignedRequest);
        $this->addValidator(new Validator\InvalidTimestamp);
        $this->addValidator(new Validator\MissingSignature);
        $this->addValidator(new Validator\ExpiredTimestamp);
        $this->addValidator(new Validator\InvalidSignature);

    }

    /**
     * Adds custom external validation functions to run in addition to the Vanilla core
     *
     * @param function
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
            if (is_object($result) && $result instanceof Response) {
                return $result;
            }
        }

        return new Response($this->request, $this->user, $this->config);
    }
}
