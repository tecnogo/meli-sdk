<?php

namespace Tecnogo\MeliSdk\Config;

/**
 * Class AppId
 *
 * @package MeliSdk\Client
 *
 * @internal
 */
final class AppId
{
    /**
     * @var string
     */
    private $appId;

    /**
     * AppId constructor.
     *
     * @param string $appId
     */
    public function __construct($appId = '')
    {
        $this->appId = trim($appId);
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->appId;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->appId);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}
