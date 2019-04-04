<?php

namespace Tecnogo\MeliSdk\Config;

/**
 * Class AppSecret
 *
 * @package MeliSdk\Client
 *
 * @internal
 */
final class AppSecret
{
    /**
     * @var string
     */
    private $appSecret;

    /**
     * AppId constructor.
     *
     * @param string $appSecret
     */
    public function __construct($appSecret)
    {
        $this->appSecret = trim($appSecret);
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->appSecret;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->appSecret);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}
