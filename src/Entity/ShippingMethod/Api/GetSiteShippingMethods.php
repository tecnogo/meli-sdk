<?php

namespace Tecnogo\MeliSdk\Entity\ShippingMethod\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetSiteShippingMethods
 *
 * @package Tecnogo\MeliSdk\Entity\ShippingMethod\Api
 */
final class GetSiteShippingMethods extends AbstractTemplateAction
{
    /**
     * @var SiteId
     */
    private $siteId;

    public function __construct(SiteId $siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->siteId . '/shipping_methods';
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
