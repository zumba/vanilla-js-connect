<?php

namespace Zumba\VanillaJsConnect;

class Response
{
    /**
     * Request object
     *
     * @var Request
     */
    protected $request;

    /**
     * Config object
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
     * Additonal properties to be added to the user object
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Sets request, config, and user objects
     *
     * @param Request $request
     * @param User    $user
     * @param Config  $config
     */
    public function __construct(Request $request, User $user = null, Config $config = null)
    {
        $this->request = $request;
        $this->config = $config;
        $this->user = $user;
    }

    /**
     * Translates Error or User object to an Array before JSON encode
     *
     * @return array
     */
    protected function toArray()
    {
        if (property_exists($this, 'error')) {
            return ['error' => $this->error, 'message' => $this->message];
        } else {
            return $this->signJsConnect();
        }
    }

    /**
   * Adds client id and signature to the User object array
   *
   * @return array
   */
    protected function signJsConnect()
    {
        $queryArray = array_merge($this->user->toArray(), $this->properties);
        ksort($queryArray);
        $queryString = http_build_query($queryArray, null, '&');
        $signature = md5($queryString.$this->config->getSecret());
        $queryArray['client_id'] = $this->config->getClientID();
        $queryArray['signature'] = $signature;
        return $queryArray;

    }

    /**
     * Only the 'valid' response should send added properties
     *
     * @return string
     */
    protected function encodeResponse()
    {
        return json_encode($this->toArray());
    }

    /**
     * Saves an array that will be merged with the User object array
     *
     * @param  array $props
     * @return void
     */
    public function addProperties(array $props)
    {
        $this->properties = array_merge($this->properties, $props);
    }

    /**
     * Allows response to be type cast into a string when handling
     *
     * @return string
     */
    public function __toString()
    {
        $resultJSON = $this->encodeResponse();

        $callback = $this->request->getCallback();
        if (!empty($callback)) {
            return "$callback($resultJSON)";
        } else {
            return $resultJSON;
        }
    }
}
