<?php

namespace Tecnogo\MeliSdk\Config;

use Tecnogo\MeliSdk\Site\Site;

/**
 * Class SiteId
 *
 * @package MeliSdk\Client
 *
 * @internal
 */
final class SiteId
{
    /**
     * @var string
     */
    private $siteId;

    /**
     * AppId constructor.
     *
     * @param string $siteId
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function __construct($siteId)
    {
        $this->siteId = trim($siteId);
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->siteId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}
