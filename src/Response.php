<?php

namespace Zumba\VanillaJsConnect;

use Firebase\JWT\JWT;
use Zumba\VanillaJsConnect\Contracts\ErrorResponseInterface;
use Zumba\VanillaJsConnect\Contracts\VanillaUser;

class Response
{
    const VERSION = 'php:3';

    const TOKEN_DURATION = 60 * 10; // max 10 minutes
    const FIELD_CLIENT_ID = 'kid';
    const FIELD_REDIRECT_URL = 'rurl';
    const FIELD_STATE = 'st';
    const FIELD_USER = 'u';

    const USER_FIELD_ID = 'id';
    const USER_FIELD_NAME = 'name';
    const USER_FIELD_EMAIL = 'email';
    const USER_FIELD_PHOTO = 'photo';
    const USER_FIELD_ROLES = 'roles';

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
     * @var VanillaUser
     */
    protected $user;

    /**
     * Additonal properties to be added to the user object
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Re-use decoded token across response methods
     *
     * @var array
     */
    protected static $runtimeDecodedToken = [];

    /**
     * Sets request, config, and user objects
     *
     * @param Request $request
     * @param VanillaUser $user
     * @param Config $config
     */
    public function __construct(Request $request, VanillaUser $user = null, Config $config = null)
    {
        $this->request = $request;
        $this->config = $config;
        $this->user = $user;
    }

    /**
     * Generate user information to send to Vanilla forum
     *
     * @return array
     */
    protected function getUserInfo() : array
    {
        if ($this->user === null || ($this->user !== null && empty($this->user->getUid()))) {
            // guest request
            $payload = [
                static::FIELD_USER => new \stdClass(),
            ];
        } else {
            // Generate the response token.
            $payload = [
                static::FIELD_USER => [
                    static::USER_FIELD_ID => $this->user->getUid(),
                    static::USER_FIELD_NAME => $this->user->getName(),
                    static::USER_FIELD_EMAIL => $this->user->getEmail(),
                    static::USER_FIELD_PHOTO => $this->user->getPhotoUrl(),
                ],
            ];

            //add extra user fields here
            $payload[static::FIELD_USER] += $this->properties;
        }

        return $payload;
    }

    /**
     * Signs new token with signature and user information
     *
     * @return string
     */
    protected function encodeResponse()
    {
        return $this->jwtEncode($this->getUserInfo());
    }

    /**
     * Wrap a payload in a JWT.
     *
     * @param array $payload
     * @return string
     */
    protected function jwtEncode(array $payload)
    {
        // validate and decode the token from request
        $decodedRequest = $this->decodeToken($this->request->getToken());

        $payload += [
            'v' => static::VERSION,
            'iat' => $this->getTimestamp(),
            'exp' => $this->getTimestamp() + static::TOKEN_DURATION,
            static::FIELD_STATE => $decodedRequest[static::FIELD_STATE] ?? [],
        ];

        $jwt = JWT::encode(
            $payload,
            $this->config->getSecret(),
            $this->config->getSignAlgorithm(),
            null,
            [
                static::FIELD_CLIENT_ID => $this->config->getClientID(),
            ]
        );

        return $jwt;
    }

    /**
     * Generates the timestamp used for encoding
     *
     * @return integer
     */
    protected function getTimestamp() : int
    {
        return time();
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
     * Generates the URL required for Vanilla forums to authenticate the user.
     *
     * @return string
     */
    public function getRedirectUrl() : string
    {
        $decodedToken = $this->decodeToken($this->request->getToken());
        $signedToken = $this->encodeResponse();

        return $decodedToken[static::FIELD_REDIRECT_URL] . '#' . http_build_query(['jwt' => $signedToken]);
    }

    /**
     * Allows response to be type cast into a string when handling
     *
     * @return string
     */
    public function __toString()
    {
        /**
         * Keep responding with a json if and error occurred
         */
        if ($this instanceof ErrorResponseInterface) {
            return json_encode($this->responseData());
        } else {
            return $this->getRedirectUrl();
        }
    }

    /**
     * Decodes the token used in the request
     *
     * @param string $requestToken
     * @return array
     */
    protected function decodeToken(string $requestToken) : array
    {
        if (empty(static::$runtimeDecodedToken)) {
            $payload = JWT::decode(
                $requestToken,
                $this->config->getSecret(),
                Config::ALLOWED_ALGORITHMS
            );

            static::$runtimeDecodedToken = $this->stdClassToArray($payload);
        }

        return static::$runtimeDecodedToken;
    }

    /**
     * Convert an object to an array, recursively.
     *
     * @param array|object $o
     * @return array
     */
    protected function stdClassToArray($o) : array
    {
        if (!is_array($o) && !($o instanceof \stdClass)) {
            throw new \InvalidArgumentException("Object or array expected, scalar given.", 400);
        }

        $o = (array)$o;
        $r = [];
        foreach ($o as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $r[$key] = $this->stdClassToArray($value);
            } else {
                $r[$key] = $value;
            }
        }
        return $r;
    }
}
