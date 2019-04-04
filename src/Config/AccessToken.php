<?php

namespace Tecnogo\MeliSdk\Config;

/**
 * Class AccessToken
 *
 * @package Tecnogo\MeliSdk\Client
 *
 * @internal
 */
final class AccessToken
{
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var string
     */
    private $refreshToken;
    /**
     * @var string
     */
    private $tokenType;
    /**
     * @var string
     */
    private $scope;
    /**
     * Expiration date in Epoch time
     *
     * @var int
     *
     * @see https://en.wikipedia.org/wiki/Unix_time
     */
    private $expires;

    /**
     * Creates a token from a MELI auth response:
     *
     * {
     *  "access_token" : "APP_USR-6092-3246532-cb45c82853f6e620bb0deda096b128d3-8035443",
     *  "token_type" : "bearer",
     *  "expires_in" : 10800,
     *  "scope" : "write read"
     * }
     *
     * @param $source
     * @return AccessToken
     */
    public static function from($source)
    {
        if (is_string($source)) {
            return new static($source);
        } else if (is_array($source)) {
            $accessToken = new static($source['access_token']);

            $accessToken->tokenType = $source['token_type'];
            $accessToken->scope = $source['scope'];
            $accessToken->expires = time() + $source['expires_in'];
            $accessToken->refreshToken = $source['refresh_token'] ?? null;

            return $accessToken;
        } else if ($source instanceof AccessToken) {
            return $source;
        }

        return new static('');
    }

    /**
     * AppId constructor.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->accessToken = trim($token);
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->accessToken;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->expires && (time() < $this->expires);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    public function isEmpty()
    {
        return !$this->get();
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return bool
     */
    public function hasRefreshToken()
    {
        return !!$this->refreshToken;
    }
}
