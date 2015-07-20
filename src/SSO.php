<?php

namespace Zumba\VanillaJsConnect;

use Zumba\VanillaJsConnect\ErrorResponse as ErrorResponse;

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
     * Checks if the request client id is equal to the config client id
     *
     * @return boolean
     */
    protected function isInvalidClientID()
    {
        return $this->request->getClientID() !== $this->config->getClientID();
    }

    /**
     * Checks that the request timestamp and signature are set
     *
     * @return boolean
     */
    protected function isUnsigned()
    {
        $requestTimestamp = $this->request->getTimestamp();
        $requestSignature = $this->request->getSignature();

        return !isset($requestTimestamp) && !isset($requestSignature);
    }

    /**
     * Signature is valid if the request and new hash are equal
     *
     * @return boolean
     */
    protected function isSignatureValid()
    {
        $timestamp = $this->request->getTimestamp();
        $secret = $this->config->getSecret();
        $signature = md5($timestamp.$secret);
        return $this->request->getSignature() === $signature;
    }

    /**
     * Returns current time. Used for mocking
     *
     * @return time
     */
    protected function getTime()
    {
        return time();
    }


    /**
     * Loops through array of validator callbacks
     *
     * @return ErrorResponse
     */
    protected function handleValidators() {
      foreach ($this->validators as $validateFn) {;
        $response = $validateFn();
        if($response instanceof ErrorResponse) {
          return $response;
        }
      }
    }

    public static function errorResponse() {
      return new ErrorResponse();
    }

    /**
     * Adds custom external validation functions to run in addition to the Vanilla core
     *
     * @param function
     */
    public function addCustomValidator($fn) {
      $this->validators[] = $fn;
    }

    /**
    * Validates Request object and returns a response object based on the error
    *
    * @return \Zumba\VanillaJsConnect\Response
    */
    public function getResponse()
    {

        if (empty($this->request->getClientID())) {
            return new ErrorResponse\ClientIDMissing($this->request);
        }
        if ($this->isInvalidClientID()) {
            $clientID = $this->request->getClientID();
            $clientResponse =  new ErrorResponse\InvalidClient($this->request);
            $clientResponse->setClientID($clientID);
            return $clientResponse;
        }
        if ($this->isUnsigned()) {
            return new ErrorResponse\Unsigned($this->request, $this->user);
        }
        if (!is_numeric($this->request->getTimestamp())) {
            return new ErrorResponse\InvalidOrMissingTimeStamp($this->request);
        }
        if (empty($this->request->getSignature())) {
            return new ErrorResponse\MissingSignature($this->request);
        }
        if (($this->getTime() - $this->request->getTimestamp()) > $this->config->getJsTimeout()) {
            return new ErrorResponse\InvalidTimeStamp($this->request);
        }
        if (!$this->isSignatureValid()) {
            return new ErrorResponse\AccessDenied($this->request);
        }

        $customError = $this->handleValidators();

        if(isset($customError)) {
          return $customError;
        }

        return new Response($this->request, $this->user, $this->config);
    }
}
