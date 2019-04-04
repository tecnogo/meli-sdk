<?php

namespace Tecnogo\MeliSdk\Config;

/**
 * Class ApiUrl
 *
 * @package Tecnogo\MeliSdk\Config
 */
final class ApiUrl
{
    /**
     * @var string
     */
    private $apiUrl;

    /**
     * AppId constructor.
     *
     * @param string $apiUrl
     */
    public function __construct($apiUrl = '')
    {
        $this->apiUrl = trim($apiUrl);
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->apiUrl;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->apiUrl);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}
