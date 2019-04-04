<?php

namespace Tecnogo\MeliSdk\Config;

/**
 * Class RedirectUrl
 *
 * @package Tecnogo\MeliSdk\Config
 */
final class RedirectUrl
{
    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * AppId constructor.
     *
     * @param string $redirectUrl
     */
    public function __construct($redirectUrl = '')
    {
        $this->redirectUrl = trim($redirectUrl);
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->redirectUrl;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->redirectUrl);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}
