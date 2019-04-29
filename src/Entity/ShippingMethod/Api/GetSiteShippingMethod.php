<?php

namespace Tecnogo\MeliSdk\Entity\ShippingMethod\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetSiteShippingMethod
 *
 * @package Tecnogo\MeliSdk\Entity\ShippingMethod\Api
 */
final class GetSiteShippingMethod extends AbstractTemplateAction
{
    /**
     * @var SiteId|string
     */
    private $siteId;
    private $id;

    public function __construct($siteId, $id)
    {
        $this->siteId = $siteId;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->siteId . '/shipping_methods/' . $this->id;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    public function getCacheStrategy()
    {
        return CacheStrategy::FOREVER;
    }
}
