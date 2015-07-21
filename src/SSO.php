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
    }

    /**
     * Adds custom external validation functions to run in addition to the Vanilla core
     *
     * @param function
     */
    public function addCustomValidator($validator)
    {
        if(is_callable($validator)) {
          $this->validators[] = new Validator\Closure($validator);
        } elseif ($validator instanceof $Validator) {
          $this->validators[] = $validator;
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
        $result = $validator($this->request, $this->config, $this->user);
          if (is_object($result) && $result instanceof Response) {
            return $result;
          }
      }

      return new Response($this->request, $this->user, $this->config);
    }
}
