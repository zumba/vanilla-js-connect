<?php

namespace Zumba\VanillaJsConnect;

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

    protected function isAllowedUserRole()
    {
        $allowedRoles = $this->config->getAllowedRoles();
        $userRoles = $this->user->getRoles();
        //if one of the user roles is in the allowed
        return count(array_intersect($allowedRoles, $userRoles)) > 0 ? true : false;
    }

    /**
    * Validates Request object and returns a response object based on the error
    *
    * @return \Zumba\VanillaJsConnect\*Response
    */
    public function getResponse()
    {

        if (empty($this->request->getClientID())) {
            return new ClientIDMissingResponse($this->request);
        }
        if ($this->isInvalidClientID()) {
            $clientID = $this->request->getClientID();
            $clientResponse =  new InvalidClientResponse($this->request);
            $clientResponse->setClientID($clientID);
            return $clientResponse;
        }
        if ($this->isUnsigned()) {
            return new UnsignedResponse($this->request, $this->user);
        }
        if (!is_numeric($this->request->getTimestamp())) {
            return new InvalidOrMissingTimeStampResponse($this->request);
        }
        if (empty($this->request->getSignature())) {
            return new MissingSignatureResponse($this->request);
        }
        if (($this->getTime() - $this->request->getTimestamp()) > $this->config->getJsTimeout()) {
            return new InvalidTimeStampResponse($this->request);
        }
        if (!$this->isSignatureValid()) {
            return new AccessDeniedResponse($this->request);
        }
        if (!$this->isAllowedUserRole()) {
            return new NotAllowedUserRole($this->request, $this->user);
        }
        return new Response($this->request, $this->user, $this->config);
    }
}
